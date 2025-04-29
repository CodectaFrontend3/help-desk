<script>
import tableComponent from "@/components/Commons/TableComponent.vue";
import apiServices from "../../services/ApiServices";

export default {
    name: "EmpresaClientes",
    components: { tableComponent },
    data() {
        return {
            columns: [
                // Asegúrate de definir las columnas
                { label: "Cliente", key: "client_name" },
                { label: "RUC", key: "ruc" },
                { label: "Dirección", key: "address" },
                { label: "Teléfono", key: "phone" },
                { label: "Correo", key: "email" },
            ],
            company: [],
        };
    },
    async created() {
        await this.fetchCompany(); // Llamada a la API cuando el componente se crea
    },
    methods: {
        async fetchCompany() {
            // Obtener los datos de microempresas desde la API

            this.company = await apiServices.get("company");

            console.log(this.company); // Verifica los datos que se reciben
        },
    },
};
</script>

<template>
    <table-component :data="company" :columns="columns" />
</template>

<style scoped></style>
