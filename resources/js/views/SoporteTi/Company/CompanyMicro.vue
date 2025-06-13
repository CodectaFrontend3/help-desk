<script>
import tableComponent from "@/components/Commons/TableComponent.vue";
import apiServices from "../../../services/ApiServices";

export default {
    name: "CompanyMicro",
    components: { tableComponent },
    data() {
        return {
            columns: [
                // Columnas definidas
                { label: "Nombre", key: "client_name" },
                { label: "RUC", key: "ruc" },
                { label: "Dirección", key: "address" },
                { label: "Teléfono", key: "phone" },
                { label: "Correo", key: "email" },
            ],
            microCompany: [],
        };
    },
    async created() {
        await this.fetchMicroCompany(); // Llamada a la API cuando el componente se crea
    },
    methods: {
        async fetchMicroCompany() {
            try {
                // Obtener los datos de microempresas desde la API
                this.microCompany = await apiServices.get("micro_company");
                console.log("Microempresas cargadas:", this.microCompany);
            } catch (error) {
                console.error("Error al cargar microempresas:", error);
            }
        },
    },
};
</script>

<template>
    <div class="micro">
        <table-component
            :data="microCompany"
            :columns="columns"
            entityType="micro"
        />
        <router-view />
    </div>
</template>

<style scoped></style>
