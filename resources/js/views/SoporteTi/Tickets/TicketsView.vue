<template>
    <div class="tickets">
        <table-component :data="tickets" :columns="columns" :available-actions="['chat']" entity-type="ticket"
            @chat="handleChatAction">
            <!-- Slot para dar color según el estado -->
            <template #state="{ value }">
                <span class="status" :class="stateClass(value)">
                    {{ value }}
                </span>
            </template>
        </table-component>
    </div>
</template>

<script>
import tableComponent from "@/components/Commons/TableComponent.vue";
import apiServices from "../../../services/ApiServices";

export default {
    name: "TicketsView",
    components: { tableComponent },
    data() {
        return {
            columns: [
                { label: "ID", key: "id" },
                { label: "ID del equipo", key: "machine_id" },
                { label: "Tipo de incidente", key: "incident_type" },
                { label: "Nombre", key: "client_name" },
                { label: "Empresa", key: "company" },
                { label: "Área", key: "area" },
                { label: "Sucursal", key: "branch" },
                { label: "Estado", key: "state" },
                { label: "Fecha de registro", key: "registration_date" },
            ],
            tickets: [],
        };
    },
    async created() {
        await this.fetchAllTickets();
    },
    methods: {
        async fetchAllTickets() {
            try {
                this.tickets = await apiServices.get("tickets");
                console.log("Tickets cargados:", this.tickets);
            } catch (error) {
                console.error("Error al cargar tickets:", error);
            }
        },
        handleChatAction(ticket) {
            console.log("Manejando chat para ticket:", ticket);
            this.$router.push({
                name: "TicketChat",
                params: {
                    ticketId: ticket.id,
                    machineId: ticket.machine_id,
                },
            });
        },
        // Agrega colores CSS según el estado
        stateClass(state) {
            switch ((state || "").toLowerCase()) {
                case "abierto":
                case "open":
                    return "estado-abierto";
                case "cerrado":
                case "closed":
                    return "estado-cerrado";
                case "pendiente":
                case "pending":
                    return "estado-pendiente";
                case "en proceso":
                case "in progress":
                    return "estado-en-progreso";
                default:
                    return "estado-desconocido";
            }
        },
    },
};
</script>

<style scoped>
.status {
    padding: 8px 12px;
    border-radius: 12px;
    font-weight: 600;
    color: #fff;
    text-wrap-mode:nowrap;
    text-transform: uppercase;
}

.estado-abierto {
    background-color: rgba(84,167,48,255);
    border: 1px solid rgb(75, 150, 43);
}

.estado-cerrado {
    background-color: rgba(210,13,14,255);
    border: 1px solid rgb(184, 12, 12);
}

.estado-en-progreso {
    background-color: rgba(255,221,1,255);
    border: 1px solid rgb(231, 201, 2);
    color: #000;

}

.estado-pendiente {
    color: orange;
    font-weight: bold;
}

.estado-desconocido {
    color: black;
    font-style: italic;
}
</style>
