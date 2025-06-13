<script>
import HomeComponent from "../../components/Commons/HomeComponent.vue";
import { roleConfigurations } from "@/utils/roleConfigs";
import TicketService from "../../services/TicketServices";
import { useAuthStore } from "@/stores/auth";

export default {
    name: "HomeSupport",
    components: { HomeComponent },
    data() {
        return {
            dashboardData: {
                ticketsCount: 0,
                openTickets: 0,
                processingTickets: 0,
                closedTickets: 0,
                hardwareTickets: 0,
                softwareTickets: 0,
                networkTickets: 0,
                satisfactionRating: 4,
                equipmentCount: 0, // Asegúrate de que esto se pase correctamente
            },
            isLoading: false,
            authStore: useAuthStore(),
        };
    },
    computed: {
        currentUser() {
            return this.authStore.user || {
                nombre: "Cargando...",
                rol: "guest",
                empresa: "",
                direccion: ""
            };
        },
        userRoleConfig() {
            // Asegúrate de que roleConfigurations tiene la clave 'TiSupport'
            return roleConfigurations[this.currentUser.rol] || roleConfigurations.client;
        },
        ticketTypeDistribution() {
            const total = this.dashboardData.hardwareTickets +
                            this.dashboardData.softwareTickets +
                            this.dashboardData.networkTickets;

            if (total === 0) return { hardware: 0, software: 0, network: 0 };

            return {
                hardware: Math.round((this.dashboardData.hardwareTickets / total) * 100),
                software: Math.round((this.dashboardData.softwareTickets / total) * 100),
                network: Math.round((this.dashboardData.networkTickets / total) * 100)
            };
        },

        configuredCards() {
            const config = JSON.parse(JSON.stringify(this.userRoleConfig));
            if (config && config.cards) {
                config.cards = config.cards.map(card => {
                    let numberToShow = 0;
                    switch (card.text) {
                        case "Tickets Abiertos":
                            numberToShow = this.dashboardData.openTickets;
                            break;
                        case "Tickets En Proceso":
                            numberToShow = this.dashboardData.processingTickets;
                            break;
                        case "Tickets Cerrados":
                            numberToShow = this.dashboardData.closedTickets;
                            break;
                        case "Tickets Totales Generales": // <-- Asegúrate de que esta tarjeta se llame así en roleConfigs
                            numberToShow = this.dashboardData.ticketsCount;
                            break;
                        case "Cantidad de Equipos": // <-- Asegúrate de que esta tarjeta se llame así en roleConfigs
                            numberToShow = this.dashboardData.equipmentCount;
                            break;
                        // Para "Tickets Generados" en HomeSupport, ya se maneja en HomeComponent.vue
                        // si rolConfig.cards incluye una tarjeta con ese texto y HomeSupport no la sobrescribe aquí.
                        default:
                            numberToShow = card.number; // Usa el número predeterminado si no hay coincidencia
                            break;
                    }
                    return { ...card, number: numberToShow };
                });
            }
            return config;
        }
    },
    methods: {
        async updateDashboardData() {
            try {
                this.isLoading = true;
                console.log("Actualizando datos del dashboard para soporte...");

                const tickets = await TicketService.getAllTickets();
                console.log("Tickets recibidos:", tickets);

                this.dashboardData.ticketsCount = tickets.length;
                this.dashboardData.openTickets = tickets.filter(ticket =>
                    ticket.state === 'Abierto'
                ).length;
                this.dashboardData.processingTickets = tickets.filter(ticket =>
                    ticket.state === 'En Proceso'
                ).length;
                this.dashboardData.closedTickets = tickets.filter(ticket =>
                    ticket.state === 'Cerrado'
                ).length;
                this.dashboardData.hardwareTickets = tickets.filter(ticket =>
                    ticket.incident_type === 'Hardware'
                ).length;
                this.dashboardData.softwareTickets = tickets.filter(ticket =>
                    ticket.incident_type === 'Software'
                ).length;
                this.dashboardData.networkTickets = tickets.filter(ticket =>
                    ticket.incident_type === 'Network' || ticket.incident_type === 'Red'
                ).length;

                try {
                    // Llama a getMachinesCount sin companyId para obtener el total de todos los equipos
                    this.dashboardData.equipmentCount = await TicketService.getMachinesCount();
                    console.log("Cantidad de equipos recibida:", this.dashboardData.equipmentCount);
                } catch (eqError) {
                    console.warn("No se pudo obtener la cantidad de equipos:", eqError);
                    this.dashboardData.equipmentCount = 0;
                }

                this.isLoading = false;
            } catch (error) {
                console.error("Error al actualizar datos del dashboard:", error);
                this.isLoading = false;
            }
        }
    },
    async mounted() {
        if (!this.authStore.user) {
            await this.authStore.checkAuthStatus();
        }

        await this.updateDashboardData();

        this.updateInterval = setInterval(this.updateDashboardData, 300000);
    },
    beforeUnmount() {
        clearInterval(this.updateInterval);
    }
};
</script>

<template>
    <div>
        <div v-if="isLoading" class="main-loading">
            Actualizando datos...
        </div>

        <HomeComponent
            :rolConfig="configuredCards"
            >
            <template v-slot:additional-content>
                <div class="support-tools">
                    <h3>Herramientas de Soporte</h3>

                    <div class="ticket-distribution">
                        <h4>Distribución de tickets por tipo de incidente</h4>
                        <div class="distribution-bars">
                            <div class="bar-item">
                                <div class="bar-label">Hardware</div>
                                <div class="bar-container">
                                    <div class="bar hardware" :style="{ width: ticketTypeDistribution.hardware + '%' }"></div>
                                </div>
                                <div class="bar-percentage">{{ ticketTypeDistribution.hardware }}%</div>
                            </div>
                            <div class="bar-item">
                                <div class="bar-label">Software</div>
                                <div class="bar-container">
                                    <div class="bar software" :style="{ width: ticketTypeDistribution.software + '%' }"></div>
                                </div>
                                <div class="bar-percentage">{{ ticketTypeDistribution.software }}%</div>
                            </div>
                            <div class="bar-item">
                                <div class="bar-label">Red</div>
                                <div class="bar-container">
                                    <div class="bar network" :style="{ width: ticketTypeDistribution.network + '%' }"></div>
                                </div>
                                <div class="bar-percentage">{{ ticketTypeDistribution.network }}%</div>
                            </div>
                        </div>
                    </div>

                    <div class="support-metrics">
                        <div class="metric-card">
                            <div class="metric-title">Estado de tickets</div>
                            <div class="metric-content">
                                <div class="metric-item">
                                    <div class="metric-label">Abiertos:</div>
                                    <div class="metric-value open">{{ dashboardData.openTickets }}</div>
                                </div>
                                <div class="metric-item">
                                    <div class="metric-label">En proceso:</div>
                                    <div class="metric-value process">{{ dashboardData.processingTickets }}</div>
                                </div>
                                <div class="metric-item">
                                    <div class="metric-label">Cerrados:</div>
                                    <div class="metric-value closed">{{ dashboardData.closedTickets }}</div>
                                </div>
                                <div class="metric-item">
                                    <div class="metric-label">Total:</div>
                                    <div class="metric-value total">{{ dashboardData.ticketsCount }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="metric-card">
                            <div class="metric-title">Desglose por tipo</div>
                            <div class="metric-content">
                                <div class="metric-item">
                                    <div class="metric-label">Hardware:</div>
                                    <div class="metric-value">{{ dashboardData.hardwareTickets }}</div>
                                </div>
                                <div class="metric-item">
                                    <div class="metric-label">Software:</div>
                                    <div class="metric-value">{{ dashboardData.softwareTickets }}</div>
                                </div>
                                <div class="metric-item">
                                    <div class="metric-label">Red:</div>
                                    <div class="metric-value">{{ dashboardData.networkTickets }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="metric-card">
                            <div class="metric-title">Satisfacción del cliente</div>
                            <div class="satisfaction-rating">
                                <div class="stars">
                                    <i v-for="n in 5" :key="n" :class="['pi', n <= dashboardData.satisfactionRating ? 'pi-star-fill' : 'pi-star']"></i>
                                </div>
                                <div class="rating-value">{{ dashboardData.satisfactionRating }}/5</div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </HomeComponent>
    </div>
</template>
<style scoped>
.support-tools {
    margin: 20px;
    padding: 20px;
    background-color: #f5f5f5;
    border-radius: 10px;
}

.main-loading {
    position: fixed;
    top: 10px;
    right: 10px;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    z-index: 1000;
}

.ticket-distribution {
    margin-top: 20px;
}

.distribution-bars {
    margin-top: 15px;
}

.bar-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.bar-label {
    width: 80px;
}

.bar-container {
    flex-grow: 1;
    height: 20px;
    background-color: #e0e0e0;
    border-radius: 10px;
    overflow: hidden;
}

.bar {
    height: 100%;
    transition: width 0.5s ease;
}

.bar.hardware {
    background-color: #ff9a3c;
}

.bar.software {
    background-color: #4caf50;
}

.bar.network {
    background-color: #2196f3;
}

.bar-percentage {
    width: 50px;
    text-align: right;
    padding-left: 10px;
}

.support-metrics {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.metric-card {
    background-color: white;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.metric-title {
    font-weight: bold;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
    margin-bottom: 10px;
}

.metric-item {
    display: flex;
    justify-content: space-between;
    padding: 5px 0;
}

.metric-value {
    font-weight: bold;
}

.metric-value.open {
    color: #ff5252;
}

.metric-value.process {
    color: #ff9a3c;
}

.metric-value.closed {
    color: #4caf50;
}

.metric-value.total {
    color: #2196f3;
}

.satisfaction-rating {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 10px;
}

.stars {
    color: #ff9a3c;
    font-size: 24px;
}

.rating-value {
    margin-top: 10px;
    font-weight: bold;
}
</style>
