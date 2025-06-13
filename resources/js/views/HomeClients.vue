<!-- HomeClients.vue -->
<script>
import HomeComponent from "../components/Commons/HomeComponent.vue";
import { roleConfigurations } from "../utils/roleConfigs";
import TicketService from "../services/TicketServices";

export default {
    name: "HomeClients",
    components: { HomeComponent },

    data() {
        return {
            // Información del usuario actual (cliente)
            currentUser: {
                nombre: "Alberto Pérez",
                rol: "client",
                empresa: "J&P PERIFÉRICOS S.A.C.",
                direccion: "Los Olivos",
                id: "client123",
            },

            // Estadísticas de tickets
            ticketsData: {
                total: 0,
                abiertos: 0,
                enProceso: 0,
                cerrados: 0,
                equipos: 0,
            },

            // Estados para manejo de carga y errores
            isLoading: false,
            error: null,

            // Intervalo de actualización automática
            updateInterval: null,
        };
    },

    computed: {
        // Obtiene la configuración del rol actual desde un archivo utilitario
        userRoleConfig() {
            return (
                roleConfigurations[this.currentUser.rol] ||
                roleConfigurations.client
            );
        },
    },

    methods: {
        // Filtra los tickets según la empresa del cliente
        filterTicketsByCompany(tickets) {
            return tickets.filter(
                (ticket) => ticket.company === this.currentUser.empresa
            );
        },

        // Calcula estadísticas de tickets para el dashboard
        calculateTicketStats(tickets) {
            const clientTickets = this.filterTicketsByCompany(tickets);

            this.ticketsData = {
                total: clientTickets.length,
                abiertos: clientTickets.filter(
                    (t) => t.state === "Abierto"
                ).length,
                enProceso: clientTickets.filter(
                    (t) => t.state === "En Proceso"
                ).length,
                cerrados: clientTickets.filter(
                    (t) => t.state === "Cerrado"
                ).length,
                equipos: clientTickets.filter(
                    (t) => t.incident_type === "Hardware"
                ).length,
            };
        },

        // Solicita datos de tickets al servicio y actualiza el dashboard
        async updateDashboardData() {
            try {
                this.isLoading = true;
                this.error = null;

                const tickets = await TicketService.getAllTickets();
                this.calculateTicketStats(tickets);
            } catch (err) {
                console.error("Error al actualizar datos del dashboard:", err);
                this.error = "Error al cargar datos. Intente nuevamente.";
            } finally {
                this.isLoading = false;
            }
        },

        // Redirecciona a la vista de creación de tickets
        handleCreateTicket() {
            this.$router.push("/tickets/create");
        },
    },

    mounted() {
        // Cargar datos inicialmente y programar actualización periódica
        this.updateDashboardData();
        this.updateInterval = setInterval(this.updateDashboardData, 300000); // cada 5 minutos
    },

    beforeUnmount() {
        // Limpiar el intervalo cuando se desmonte el componente
        clearInterval(this.updateInterval);
    },
};
</script>

<template>
    <div class="client-dashboard">
        <!-- Indicador de carga -->
        <div v-if="isLoading" class="loading-indicator">
            <div class="loading-spinner"></div>
            Actualizando datos...
        </div>

        <!-- Mensaje de error -->
        <div v-if="error" class="error-message">
            {{ error }}
        </div>

        <!-- Componente principal del dashboard -->
        <HomeComponent :rolConfig="userRoleConfig" :userData="currentUser">
            <!-- Slot para contenido adicional específico del cliente -->
            <template v-slot:additional-content>
                <div class="client-actions">
                    <h3>Acciones Rápidas</h3>
                    <div class="actions-container">
                        <button
                            @click="handleCreateTicket"
                            class="action-button create-ticket"
                        >
                            <i class="pi pi-plus-circle"></i>
                            Crear Nuevo Ticket
                        </button>

                        <router-link
                            to="/tickets/mis-tickets"
                            class="action-button view-tickets"
                        >
                            <i class="pi pi-list"></i>
                            Ver Mis Tickets
                        </router-link>

                        <router-link to="/perfil" class="action-button profile">
                            <i class="pi pi-user"></i>
                            Editar Perfil
                        </router-link>
                    </div>
                </div>

                <!-- Resumen de tickets del cliente -->
                <div class="client-ticket-summary">
                    <h3>Resumen de Mis Tickets</h3>
                    <div class="summary-grid">
                        <div class="summary-card">
                            <div class="summary-icon">
                                <i class="pi pi-ticket"></i>
                            </div>
                            <div class="summary-info">
                                <span class="summary-title">Total</span>
                                <span class="summary-value">
                                    {{ ticketsData.total }}
                                </span>
                            </div>
                        </div>

                        <div class="summary-card">
                            <div class="summary-icon warning">
                                <i class="pi pi-exclamation-circle"></i>
                            </div>
                            <div class="summary-info">
                                <span class="summary-title">Abiertos</span>
                                <span class="summary-value">
                                    {{ ticketsData.abiertos }}
                                </span>
                            </div>
                        </div>

                        <div class="summary-card">
                            <div class="summary-icon info">
                                <i class="pi pi-sync"></i>
                            </div>
                            <div class="summary-info">
                                <span class="summary-title">En Proceso</span>
                                <span class="summary-value">
                                    {{ ticketsData.enProceso }}
                                </span>
                            </div>
                        </div>

                        <div class="summary-card">
                            <div class="summary-icon success">
                                <i class="pi pi-check-circle"></i>
                            </div>
                            <div class="summary-info">
                                <span class="summary-title">Cerrados</span>
                                <span class="summary-value">
                                    {{ ticketsData.cerrados }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas visuales de resolución -->
                <div class="client-ticket-stats">
                    <h3>Estado de Resolución</h3>
                    <div class="stats-container">
                        <div class="progress-bar">
                            <div
                                class="progress-fill"
                                :style="`width: ${
                                    ticketsData.total > 0
                                        ? (ticketsData.cerrados / ticketsData.total) * 100
                                        : 0
                                }%`"
                            ></div>
                        </div>
                        <div class="progress-labels">
                            <span>
                                {{
                                    ticketsData.total > 0
                                        ? Math.round((ticketsData.cerrados / ticketsData.total) * 100)
                                        : 0
                                }}% resuelto
                            </span>
                            <span>{{ ticketsData.cerrados }} de {{ ticketsData.total }}</span>
                        </div>
                    </div>
                </div>
            </template>
        </HomeComponent>
    </div>
</template>


<style scoped>
.client-dashboard {
    position: relative;
}

.loading-indicator {
    position: fixed;
    top: 10px;
    right: 10px;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    z-index: 1000;
    display: flex;
    align-items: center;
    gap: 10px;
}

.loading-spinner {
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.error-message {
    background-color: #ffdddd;
    color: #ff0000;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
    text-align: center;
}

.client-actions {
    margin: 20px 0;
}

.actions-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: 15px;
}

.action-button {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.create-ticket {
    background-color: #4caf50;
    color: white;
    border: none;
}

.view-tickets {
    background-color: #2196f3;
    color: white;
}

.profile {
    background-color: #9c27b0;
    color: white;
}

.action-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.client-ticket-summary {
    margin: 30px 0;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 15px;
}

.summary-card {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.summary-icon {
    width: 50px;
    height: 50px;
    background-color: #ff9800;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.summary-icon.warning {
    background-color: #ff5722;
}

.summary-icon.info {
    background-color: #2196f3;
}

.summary-icon.success {
    background-color: #4caf50;
}

.summary-info {
    display: flex;
    flex-direction: column;
}

.summary-title {
    font-size: 14px;
    color: #666;
}

.summary-value {
    font-size: 22px;
    font-weight: bold;
    color: #333;
}

.client-ticket-stats {
    margin: 30px 0;
}

.stats-container {
    margin-top: 15px;
}

.progress-bar {
    width: 100%;
    height: 15px;
    background-color: #e0e0e0;
    border-radius: 10px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background-color: #4caf50;
    transition: width 0.3s ease;
}

.progress-labels {
    display: flex;
    justify-content: space-between;
    margin-top: 5px;
    font-size: 14px;
    color: #666;
}
</style>
