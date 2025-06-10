    <!-- HomeComponent.vue -->
    <script>
    import Titulo from "@/components/ForMenu/Titulos.vue";
    import TicketService from "../../services/TicketServices";

    export default {
        name: "HomeComponent",
        components: { Titulo },
        props: {
            // Configuración según el rol
            rolConfig: {
                type: Object,
                required: true
            },
            // Datos de usuario (nombre, rol, etc.)
            userData: {
                type: Object,
                default: () => ({
                    nombre: "Usuario",
                    rol: "Cliente",
                    empresa: "Mi Empresa",
                    direccion: "Av. Principal 123",
                    id: null // Agregar ID para filtrar tickets por cliente
                })
            }
        },
        data() {
            return {
                // Datos compartidos entre todos los roles
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
                // Datos de tickets dinámicos
                ticketsData: {
                    active: 0,
                    urgent: 0,
                    history: 0,
                    generated: 0,
                    resolved: 0,
                    inProcess: 0,
                    closed: 0,
                    equipment: 0,
                    clients: 0,
                    satisfaction: 0
                },
                isLoading: true,
                error: null
            };
        },
        computed: {
            // Obtener las tarjetas según la configuración del rol, con datos dinámicos
            cards() {
                const baseCards = this.rolConfig.cards || [];

                // Mapear las tarjetas con los datos dinámicos
                return baseCards.map(card => {
                    const newCard = { ...card };

                    // Reemplazar los números estáticos con datos dinámicos según el tipo de tarjeta
                    switch(card.text) {
                        case "Tickets Activos":
                            newCard.number = this.ticketsData.active;
                            break;
                        case "Tickets Urgentes":
                            newCard.number = this.ticketsData.urgent;
                            break;
                        case "Tickets Abiertos":
                            newCard.number = this.ticketsData.active;
                            break;
                        case "Tickets En Proceso":
                            newCard.number = this.ticketsData.inProcess;
                            break;
                        case "Tickets Cerrados":
                            newCard.number = this.ticketsData.closed;
                            break;
                        case "Historial de Tickets":
                            newCard.number = this.ticketsData.history;
                            break;
                        case "Tickets Generados":
                            newCard.number = this.ticketsData.generated;
                            break;
                        case "Tickets Resueltos":
                            newCard.number = this.ticketsData.resolved;
                            break;
                        case "Cantidad de equipos":
                            newCard.number = this.ticketsData.equipment;
                            break;
                        case "Registrar clientes":
                            newCard.number = this.ticketsData.clients;
                            break;
                        case "Valorización de Satisfacción":
                            newCard.number = this.ticketsData.satisfaction;
                            break;
                        default:
                            // Mantener el número estático si no hay equivalente dinámico
                            break;
                    }

                    return newCard;
                });
            },
            // Componentes adicionales a mostrar según el rol
            showComponents() {
                return this.rolConfig.components || {
                    messages: true,
                    charts: false,
                    calendar: false
                };
            },
            // Colores y estilos personalizados según el rol
            themeStyles() {
                return {
                    cardBackground: this.rolConfig.theme?.cardBackground || "#ffc676",
                    messageBackground: this.rolConfig.theme?.messageBackground || "#fcd8a6",
                    // Otros estilos personalizables...
                };
            }
        },
        methods: {
            async loadTicketsData() {
                try {
                    this.isLoading = true;
                    this.error = null;

                    // Cargar datos según el rol del usuario
                    switch(this.userData.rol) {
                        case 'admin':
                            await this.loadAdminTicketsData();
                            break;
                        case 'support':
                            await this.loadSupportTicketsData();
                            break;
                        case 'client':
                            await this.loadClientTicketsData();
                            break;
                        default:
                            console.warn('Rol no reconocido:', this.userData.rol);
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
                // Para administradores: obtener todos los tickets
                const allTickets = await TicketService.getAllTickets();

                // Contar tickets activos (abiertos)
                this.ticketsData.active = allTickets.filter(ticket =>
                    ticket.state === 'Abierto'
                ).length;

                // Contar tickets en proceso
                this.ticketsData.inProcess = allTickets.filter(ticket =>
                    ticket.state === 'En Proceso'
                ).length;

                // Contar tickets cerrados
                this.ticketsData.closed = allTickets.filter(ticket =>
                    ticket.state === 'Cerrado'
                ).length;

                // Contar tickets urgentes (suponiendo que los tickets urgentes son los abiertos)
                this.ticketsData.urgent = this.ticketsData.active;

                // Historial (todos los tickets)
                this.ticketsData.history = allTickets.length;

                // Número de clientes (para tarjeta "Registrar clientes")
                // Obtener número único de clientes basado en el campo client_name
                const uniqueClients = new Set(allTickets.map(ticket => ticket.client_name));
                this.ticketsData.clients = uniqueClients.size;
            },

            async loadSupportTicketsData() {
                // Para soporte técnico
                const allTickets = await TicketService.getAllTickets();

                // Tickets activos asignados a soporte (abiertos)
                this.ticketsData.active = allTickets.filter(ticket =>
                    ticket.state === 'Abierto'
                ).length;

                // Tickets en proceso
                this.ticketsData.inProcess = allTickets.filter(ticket =>
                    ticket.state === 'En Proceso'
                ).length;

                // Tickets cerrados
                this.ticketsData.closed = allTickets.filter(ticket =>
                    ticket.state === 'Cerrado'
                ).length;

                // Tickets urgentes (asumimos que son los tickets abiertos)
                this.ticketsData.urgent = this.ticketsData.active;

                // Historial
                this.ticketsData.history = allTickets.length;

                // Valorización de satisfacción (promedio de calificaciones)
                // Como no tenemos campo de rating en la DB actual, usamos un valor fijo de ejemplo
                this.ticketsData.satisfaction = 4; // De 1-5
            },

            async loadClientTicketsData() {
                // Para clientes
                // En un escenario real, filtrarías por el id del cliente
                // Aquí usaremos un enfoque simulado porque no tenemos un campo de cliente_id en la tabla

                // Simulamos obtener tickets por cliente con el nombre
                const clientTickets = await TicketService.getAllTickets();

                // Filtramos por company que coincide con la empresa del cliente (simulación)
                const filteredTickets = clientTickets.filter(ticket =>
                    ticket.company === this.userData.empresa
                );

                // Tickets generados (todos los del cliente)
                this.ticketsData.generated = filteredTickets.length;

                // Tickets resueltos (cerrados)
                this.ticketsData.resolved = filteredTickets.filter(ticket =>
                    ticket.state === 'Cerrado'
                ).length;

                // Tickets abiertos
                this.ticketsData.active = filteredTickets.filter(ticket =>
                    ticket.state === 'Abierto'
                ).length;

                // Tickets en proceso
                this.ticketsData.inProcess = filteredTickets.filter(ticket =>
                    ticket.state === 'En Proceso'
                ).length;

                // Cantidad de equipos (esto podría venir de otro endpoint en una implementación real)
                // Contamos la cantidad de tickets con incident_type Hardware como aproximación
                this.ticketsData.equipment = filteredTickets.filter(ticket =>
                    ticket.incident_type === 'Hardware'
                ).length;
            },

            // Método para actualizar los datos de los tickets (para llamadas periódicas)
            refreshTicketsData() {
                this.loadTicketsData();
            }
        },
        created() {
            // Cargar datos al crear el componente
            this.loadTicketsData();
        },
        mounted() {
            // Configurar actualización periódica (cada 5 minutos)
            this.refreshInterval = setInterval(this.refreshTicketsData, 300000);
        },
        beforeUnmount() {
            // Limpiar el intervalo al desmontar el componente
            clearInterval(this.refreshInterval);
        }
    };
    </script>

    <template>
        <div>

            <!-- Tarjetas de información -->
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

            <!-- Contenedor de Mensajes (condicional) -->
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

            <!-- Sección de gráficos (condicional) -->
            <div v-if="showComponents.charts" class="charts-wrapper">
                <div class="charts-container">
                    <!-- Resumen de estados de tickets para administrador -->
                    <div v-if="userData.rol === 'admin'" class="ticket-summary">
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
                    <!-- Aquí irían tus gráficos específicos por rol -->
                    <slot name="charts"></slot>
                </div>
            </div>

            <!-- Otras secciones específicas por rol usando slots -->
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
