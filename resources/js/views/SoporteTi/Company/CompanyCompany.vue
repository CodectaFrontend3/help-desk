<script>
import tableComponent from "@/components/Commons/TableComponent.vue";
import apiServices from "../../../services/ApiServices";

export default {
    name: "CompanyCompany",
    components: { tableComponent },
    data() {
        return {
            columns: [
                { label: "Nombre", key: "client_name" },
                { label: "RUC", key: "ruc" },
                { label: "Dirección", key: "address" },
                { label: "Teléfono", key: "phone" },
                { label: "Correo", key: "email" },
            ],
            companies: [],
        };
    },
    async created() {
        await this.fetchCompanies(); // Llamada a la API cuando el componente se crea
    },
    methods: {
        async fetchCompanies() {
            try {
                // Obtener los datos de empresas desde la API
                this.companies = await apiServices.get("company");
                console.log("Empresas cargadas:", this.companies);
            } catch (error) {
                console.error("Error al cargar empresas:", error);
            }
        },
    },
};
</script>

<template>
    <table-component
        :data="companies"
        :columns="columns"
        entityType="company"
    />
</template>

<style scoped></style>
