<script>
import HomeComponent from "../../components/Commons/HomeComponent.vue";
import { roleConfigurations } from "../../utils/roleConfigs";
import TicketService from "../../services/TicketServices";
import { useAuthStore } from "@/stores/auth"; // 1. Importa el store de autenticación

export default {
    name: "HomeSupport",
    components: { HomeComponent },
    data() {
        return {
            // Ya no necesitas 'currentUser' aquí, se obtendrá del store de Pinia.
            // Si necesitas valores iniciales para 'dashboardData', mantenlos.
            dashboardData: {
                ticketsCount: 0,
                openTickets: 0,
                processingTickets: 0,
                closedTickets: 0,
                hardwareTickets: 0,
                softwareTickets: 0,
                networkTickets: 0,
                satisfactionRating: 4 // Valoración por defecto
            },
            isLoading: false,
            // 2. Instancia del store de autenticación para usar en el componente
            authStore: useAuthStore(),
        };
    },
    computed: {
        // 3. 'currentUser' ahora es una propiedad computada que obtiene los datos del store
        currentUser() {
            // Proporciona un objeto por defecto si el usuario aún no se ha cargado
            // Esto evita errores si intentas acceder a 'user.nombre' antes de que esté disponible
            return this.authStore.user || {
                nombre: "Cargando...",
                rol: "guest", // Rol por defecto, útil para evitar errores
                empresa: "",
                direccion: ""
            };
        },
        // Obtener la configuración basada en el rol del usuario actual
        userRoleConfig() {
            // Asegúrate de que el rol de 'currentUser' es válido para 'roleConfigurations'
            return roleConfigurations[this.currentUser.rol] || roleConfigurations.client;
        },
        // Distribución de tipos de tickets para mostrar en métricas
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
        }
    },
    methods: {
        // Método para actualizar datos en tiempo real
        async updateDashboardData() {
            try {
                this.isLoading = true;
                console.log("Actualizando datos del dashboard para soporte...");

                // 4. Se mantiene la lógica de filtrado del lado del cliente por ahora
                //    (Ver explicación de optimización backend más abajo)
                const tickets = await TicketService.getAllTickets();
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

                this.isLoading = false;
            } catch (error) {
                console.error("Error al actualizar datos del dashboard:", error);
                this.isLoading = false;
            }
        }
    },
    async mounted() {
        // 5. Asegúrate de que los datos del usuario estén cargados antes de usar 'currentUser.rol'
        // Esto es importante si el store no ha terminado de inicializarse o el usuario no está en localStorage
        if (!this.authStore.user) {
            await this.authStore.checkAuthStatus(); // Fuerza la carga del usuario si no está
        }

        // Cargar datos iniciales del dashboard
        await this.updateDashboardData();

        // Ejemplo de actualización periódica (cada 5 minutos)
        this.updateInterval = setInterval(this.updateDashboardData, 300000);
    },
    beforeUnmount() {
        // Limpiar el intervalo al desmontar el componente
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
            :rolConfig="userRoleConfig"
            :userData="currentUser"> <template v-slot:additional-content>
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
