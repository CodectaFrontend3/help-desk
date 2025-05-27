<!-- HomeAdmin.vue -->
<script>
import HomeComponent from "../../components/Commons/HomeComponent.vue";
import { roleConfigurations } from "../../utils/roleConfigs";
import TicketService from "../../services/TicketServices";

export default {
    name: "HomeAdmin",
    components: { HomeComponent },
    data() {
        return {
            currentUser: {
                nombre: "Alberto Pérez",
                rol: "admin", // Este valor podría venir desde una autenticación
                empresa: "J&P PERIFÉRICOS S.A.C.",
                direccion: "Los Olivos"
            },
            dashboardData: {
                ticketsCount: 0,
                pendingTickets: 0,
                processingTickets: 0,
                closedTickets: 0,
                openTickets: 0
            },
            isLoading: false
        };
    },
    computed: {
        // Obtener la configuración basada en el rol del usuario actual
        userRoleConfig() {
            // Valor por defecto en caso de que el rol no exista en configuraciones
            return roleConfigurations[this.currentUser.rol] || roleConfigurations.client;
        },
        // Calcular el porcentaje de tickets en proceso
        processingPercentage() {
            return this.dashboardData.ticketsCount > 0
                ? Math.round((this.dashboardData.processingTickets / this.dashboardData.ticketsCount) * 100)
                : 0;
        },
        // Calcular el porcentaje de tickets resueltos (cerrados)
        resolvedPercentage() {
            return this.dashboardData.ticketsCount > 0
                ? Math.round((this.dashboardData.closedTickets / this.dashboardData.ticketsCount) * 100)
                : 0;
        }
    },
    methods: {
        // Método para actualizar datos en tiempo real
        async updateDashboardData() {
            try {
                this.isLoading = true;
                console.log("Actualizando datos del dashboard para admin...");

                const tickets = await TicketService.getAllTickets();
                this.dashboardData.ticketsCount = tickets.length;

                // Filtrar por estado
                this.dashboardData.openTickets = tickets.filter(ticket =>
                    ticket.state === 'Abierto'
                ).length;

                this.dashboardData.processingTickets = tickets.filter(ticket =>
                    ticket.state === 'En Proceso'
                ).length;

                this.dashboardData.closedTickets = tickets.filter(ticket =>
                    ticket.state === 'Cerrado'
                ).length;

                // Calcular tickets pendientes (abiertos + en proceso)
                this.dashboardData.pendingTickets = this.dashboardData.openTickets + this.dashboardData.processingTickets;

                this.isLoading = false;
            } catch (error) {
                console.error("Error al actualizar datos del dashboard:", error);
                this.isLoading = false;
            }
        }
    },
    async mounted() {
        // Cargar datos iniciales
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
        <!-- Spinner de carga principal si es necesario -->
        <div v-if="isLoading" class="main-loading">
            Actualizando datos...
        </div>

        <HomeComponent
            :rolConfig="userRoleConfig"
            :userData="currentUser">

            <!-- Contenido adicional para Admin -->
            <template v-slot:charts>
                <div class="admin-charts">
                    <h3>Estadísticas de Rendimiento</h3>
                    <div class="chart-container">
                        <!-- Gráficos dinámicos basados en datos reales -->
                        <div class="chart-placeholder">
                            <div class="chart-circle">
                                <span>{{ processingPercentage }}%</span>
                            </div>
                            <p>Tickets en Proceso</p>
                        </div>
                        <div class="chart-placeholder">
                            <div class="chart-circle">
                                <span>{{ resolvedPercentage }}%</span>
                            </div>
                            <p>Tickets Resueltos</p>
                        </div>
                    </div>

                    <!-- Estadísticas adicionales -->
                    <div class="stats-summary">
                        <div class="stat-item">
                            <div class="stat-label">Total de tickets:</div>
                            <div class="stat-value">{{ dashboardData.ticketsCount }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Tickets abiertos:</div>
                            <div class="stat-value">{{ dashboardData.openTickets }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Tickets en proceso:</div>
                            <div class="stat-value">{{ dashboardData.processingTickets }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Tickets cerrados:</div>
                            <div class="stat-value">{{ dashboardData.closedTickets }}</div>
                        </div>
                    </div>
                </div>
            </template>
        </HomeComponent>
    </div>
</template>

<style scoped>
.admin-charts {
    width: 100%;
    padding: 20px;
}

.chart-container {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
}

.chart-placeholder {
    text-align: center;
    width: 150px;
}

.chart-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(to right, #ff9a3c, #ff5252);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.chart-circle span {
    color: white;
    font-size: 24px;
    font-weight: bold;
}

.admin-tools {
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

.stats-summary {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-top: 20px;
}

.stat-item {
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stat-value {
    font-weight: bold;
    font-size: 18px;
    color: #ff5252;
}

.tools-summary {
    display: flex;
    justify-content: space-around;
    margin-top: 15px;
}

.tool-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    cursor: pointer;
    padding: 10px;
    transition: all 0.3s ease;
}

.tool-item:hover {
    background-color: #e9e9e9;
    border-radius: 8px;
}

.tool-item i {
    font-size: 24px;
    margin-bottom: 10px;
    color: #ff9a3c;
}
</style>
