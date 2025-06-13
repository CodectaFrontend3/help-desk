<script>
import Titulo from "@/components/ForMenu/Titulos.vue";
import TicketService from "../../services/TicketServices";
import { useAuthStore } from "@/stores/auth";
import { watch } from 'vue';

export default {
    name: "HomeComponent",
    components: { Titulo },
    props: {
        rolConfig: {
            type: Object,
            required: true
        },
        // REMOVED: userData prop is no longer needed here as it's fetched from Pinia store.
    },
    data() {
        return {
            authStore: useAuthStore(),
            mensajes: [
                {
                    numero: 1,
                    intencion: "Consulta sobre facturación",
                    tiempo: "hace 5 minutos",
                },
                {
                    numero: 2,
                    intencion: "Reclamo por servicio",
                    tiempo: "hace 15 minutos",
                },
                {
                    numero: 3,
                    intencion: "Solicitud de información",
                    tiempo: "hace 30 minutos",
                },
            ],
            ticketsData: {
                active: 0,
                urgent: 0,
                history: 0,
                generated: 0, // <-- Asegurarse de que se use para soporte y cliente
                resolved: 0,
                inProcess: 0,
                closed: 0,
                equipment: 0, // <-- Asegurarse de que se use para cliente
                clients: 0,
                satisfaction: 0
            },
            isLoading: true,
            error: null
        };
    },
    computed: {
        currentRole() {
            return this.authStore.userRole;
        },
        currentUserDataFromStore() {
            return this.authStore.user || {
                nombre: "Usuario",
                empresa: "Mi Empresa", // Asegúrate de que esta propiedad exista en tu objeto de usuario para el cliente
                direccion: "Av. Principal 123",
                id: null
            };
        },
        cards() {
            const baseCards = this.rolConfig.cards || [];
            return baseCards.map(card => {
                const newCard = { ...card };
                switch(card.text) {
                    case "Tickets Activos": newCard.number = this.ticketsData.active; break;
                    case "Tickets Urgentes": newCard.number = this.ticketsData.urgent; break;
                    case "Tickets Abiertos": newCard.number = this.ticketsData.active; break;
                    case "Tickets En Proceso": newCard.number = this.ticketsData.inProcess; break;
                    case "Tickets Cerrados": newCard.number = this.ticketsData.closed; break;
                    case "Historial de Tickets": newCard.number = this.ticketsData.history; break;
                    case "Tickets Generados": newCard.number = this.ticketsData.generated; break; // <-- USAR ESTE
                    case "Tickets Resueltos": newCard.number = this.ticketsData.resolved; break;
                    case "Cantidad de equipos": newCard.number = this.ticketsData.equipment; break; // <-- USAR ESTE
                    case "Registrar clientes": newCard.number = this.ticketsData.clients; break;
                    case "Valorización de Satisfacción": newCard.number = this.ticketsData.satisfaction; break;
                    default: break;
                }
                return newCard;
            });
        },
        showComponents() {
            return this.rolConfig.components || {
                messages: true,
                charts: false,
                calendar: false
            };
        },
        themeStyles() {
            return {
                cardBackground: this.rolConfig.theme?.cardBackground || "#ffc676",
                messageBackground: this.rolConfig.theme?.messageBackground || "#fcd8a6",
            };
        }
    },
    methods: {
        async loadTicketsData() {
            try {
                this.isLoading = true;
                this.error = null;

                const role = this.currentRole;
                switch(role) {
                    case 'admin':
                        await this.loadAdminTicketsData();
                        break;
                    case 'TiSupport':
                        await this.loadSupportTicketsData();
                        break;
                    case 'client':
                        // Asegúrate de que currentUserDataFromStore.empresa o currentUserDataFromStore.id exista
                        await this.loadClientTicketsData(this.currentUserDataFromStore.id); // Usamos ID para el cliente
                        break;
                    default:
                        console.warn('Rol no reconocido (desde Store):', role);
                        break;
                }
                this.isLoading = false;
            } catch (error) {
                console.error('Error al cargar datos de tickets:', error);
                this.error = 'Error al cargar datos. Por favor, intente nuevamente.';
                this.isLoading = false;
            }
        },

        async loadAdminTicketsData() {
            const allTickets = await TicketService.getAllTickets();
            this.ticketsData.active = allTickets.filter(ticket => ticket.state === 'Abierto').length;
            this.ticketsData.inProcess = allTickets.filter(ticket => ticket.state === 'En Proceso').length;
            this.ticketsData.closed = allTickets.filter(ticket => ticket.state === 'Cerrado').length;
            this.ticketsData.urgent = this.ticketsData.active; // Considerar si urgente es igual a abierto o tiene otra lógica
            this.ticketsData.history = allTickets.length; // Total de tickets
            const uniqueClients = new Set(allTickets.map(ticket => ticket.client_name)); // Si `client_name` es el nombre de la empresa
            this.ticketsData.clients = uniqueClients.size;
            // Para admin, podrías querer el total de todos los equipos
            this.ticketsData.equipment = await TicketService.getMachinesCount();
        },

        async loadSupportTicketsData() {
            const allTickets = await TicketService.getAllTickets();
            this.ticketsData.active = allTickets.filter(ticket => ticket.state === 'Abierto').length;
            this.ticketsData.inProcess = allTickets.filter(ticket => ticket.state === 'En Proceso').length;
            this.ticketsData.closed = allTickets.filter(ticket => ticket.state === 'Cerrado').length;
            this.ticketsData.urgent = this.ticketsData.active;
            this.ticketsData.history = allTickets.length;
            this.ticketsData.satisfaction = 4;
            // **NUEVO:** Para Soporte TI, 'Tickets Generados' es el total de tickets.
            this.ticketsData.generated = allTickets.length;
            // Para Soporte TI, obtiene la cantidad total de equipos
            this.ticketsData.equipment = await TicketService.getMachinesCount();
        },

        async loadClientTicketsData(clientId) { // Cambiado a usar clientId
            const clientTickets = await TicketService.getFilteredTickets({ clientId: clientId }); // Filtra por clientID
            this.ticketsData.generated = clientTickets.length; // Total de tickets generados por este cliente
            this.ticketsData.resolved = clientTickets.filter(ticket => ticket.state === 'Cerrado').length;
            this.ticketsData.active = clientTickets.filter(ticket => ticket.state === 'Abierto').length;
            this.ticketsData.inProcess = clientTickets.filter(ticket => ticket.state === 'En Proceso').length;
            // **NUEVO:** Obtiene la cantidad de equipos para la empresa del cliente
            this.ticketsData.equipment = await TicketService.getMachinesCount(clientId); // Pasa el ID de la empresa del cliente
        },

        refreshTicketsData() {
            this.loadTicketsData();
        }
    },
    mounted() {
        watch(() => this.authStore.userRole, (newRole) => {
            if (newRole) {
                this.loadTicketsData();
            } else {
                console.log("Esperando a que el rol del usuario esté disponible en el store...");
            }
        }, { immediate: true });

        // Observa también los cambios en el objeto user del store para el clientId
        watch(() => this.authStore.user, (newUser) => {
            if (newUser && this.currentRole === 'client' && newUser.id) {
                this.loadTicketsData(); // Recargar si el usuario es cliente y su ID está disponible
            }
        }, { deep: true }); // Usar deep watch para objetos

        this.refreshInterval = setInterval(this.refreshTicketsData, 300000);
    },
    beforeUnmount() {
        clearInterval(this.refreshInterval);
    }
};
</script>
    <template>
        <div>
            <div class="card-container">
                <div v-if="isLoading" class="loading-container">
                    <div class="loading-spinner"></div>
                    <p>Cargando datos...</p>
                </div>

                <div v-else-if="error" class="error-container">
                    <p>{{ error }}</p>
                    <button @click="loadTicketsData" class="reload-button">Reintentar</button>
                </div>

                <template v-else>
                    <div v-for="(card, index) in cards" :key="index" class="card" :style="{ backgroundColor: themeStyles.cardBackground }">
                        <div class="top-section">
                            <i :class="card.icon" class="icon"></i>
                            <h2>{{ card.text }}</h2>
                        </div>
                        <div class="bottom-section">
                            <p class="number">{{ card.number }}</p>
                            <router-link :to="card.link" class="button">Ver</router-link>
                        </div>
                    </div>
                </template>
            </div>

            <div v-if="showComponents.messages" class="messages-wrapper">
                <div class="messages-container">
                    <div class="messages-header">
                        <i class="pi pi-comment message-icon"></i>
                        <h3>{{ rolConfig.messagesTitle || 'Mensajes de Tickets' }}</h3>
                    </div>
                    <ul class="messages-list" :style="{ backgroundColor: themeStyles.messageBackground }">
                        <li v-for="(msg, index) in mensajes" :key="index">
                            #{{ msg.numero }} - {{ msg.intencion }} - {{ msg.tiempo }}
                        </li>
                    </ul>
                </div>
            </div>

            <div v-if="showComponents.charts" class="charts-wrapper">
                <div class="charts-container">
                    <div v-if="currentUserDataFromStore.rol === 'admin'" class="ticket-summary">
                        <h3>Resumen de Tickets</h3>
                        <div class="summary-cards">
                            <div class="summary-card">
                                <span class="summary-title">Abiertos</span>
                                <span class="summary-number">{{ ticketsData.active }}</span>
                            </div>
                            <div class="summary-card">
                                <span class="summary-title">En Proceso</span>
                                <span class="summary-number">{{ ticketsData.inProcess }}</span>
                            </div>
                            <div class="summary-card">
                                <span class="summary-title">Cerrados</span>
                                <span class="summary-number">{{ ticketsData.closed }}</span>
                            </div>
                            <div class="summary-card">
                                <span class="summary-title">Total</span>
                                <span class="summary-number">{{ ticketsData.history }}</span>
                            </div>
                        </div>
                    </div>
                    <slot name="charts"></slot>
                </div>
            </div>

            <slot name="additional-content"></slot>
        </div>
    </template>

<style scoped>
.card-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin: 20px;
    gap: 20px;
}

.card {
    padding: 20px;
    width: 320px;
    height: 250px;
    border-radius: 10px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.top-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.icon {
    font-size: 60px;
    color: black;
}

h2 {
    font-size: 18px;
    color: black;
    margin: 0;
    text-align: right;
    flex-grow: 1;
}

.bottom-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.number {
    font-size: 24px;
    font-weight: bold;
    color: black;
}

.button {
    background-color: white;
    color: black;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
    text-decoration: none;
    transition: 0.3s;
}

.button:hover {
    background-color: rgba(255, 255, 255, 0.8);
}

.messages-wrapper, .charts-wrapper {
    display: flex;
    justify-content: center;
    width: 100%;
    margin-top: 50px;
}

.messages-container, .charts-container {
    width: 500px;
    max-width: 90%;
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
}

.messages-header {
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 2px solid #ddd;
    padding-bottom: 10px;
}

.message-icon {
    font-size: 24px;
    color: #333;
}

.messages-list {
    list-style: none;
    padding: 10px;
    margin: 15px 0 0;
    border-radius: 5px;
}

.messages-list li {
    font-size: 16px;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.messages-list li:last-child {
    border-bottom: none;
}

/* Estilos para estados de carga y error */
.loading-container {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 30px;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-bottom: 15px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.error-container {
    width: 100%;
    text-align: center;
    padding: 20px;
    background-color: #ffeeee;
    border-radius: 10px;
}

.reload-button {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
}

/* Estilos responsivos */
@media (max-width: 1200px) {
    .card-container {
        justify-content: center;
    }
}
</style>
