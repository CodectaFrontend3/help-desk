<script>
import tableComponent from "@/components/Commons/TableComponent.vue";
import apiServices from "../../../services/ApiServices";

export default {
    name: "HistorialTickets",
    components: { tableComponent },
    data() {
        return {
            columns: [
                { label: "ID", key: "id" },
                { label: "ID del equipo", key: "team_id" },
                { label: "Tipo de incidente", key: "incident_type" },
                { label: "Nombre", key: "client_name" },
                { label: "Empresa", key: "company" },
                { label: "Área", key: "area" },
                { label: "Sucursal", key: "branch" },
                { label: "Estado", key: "state" },
                { label: "Fecha de registro ", key: "registration_date" },
            ],
            tickets: [],
        };
    },
    async created() {
        await this.fetchCompanies(); // Llamada a la API cuando el componente se crea
    },
    methods: {
        async fetchCompanies() {
            try {
                // Obtener los datos de empresas desde la API
                this.tickets = await apiServices.get("tickets");
                console.log("Tickets cargados:", this.tickets);
            } catch (error) {
                console.error("Error al cargar tickets:", error);
            }
        },
    },
};
</script>

<template>
    <div class="tickets">
        <table-component :data="tickets" :columns="columns" />
        <router-view />
    </div>
</template>

<style scoped></style>
