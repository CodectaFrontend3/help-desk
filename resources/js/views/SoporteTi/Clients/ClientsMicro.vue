<script>
import tableComponent from "@/components/Commons/TableComponent.vue";
import apiServices from "../../../services/ApiServices";

export default {
    name: "CliensMicro",
    components: { tableComponent },
    data() {
        return {
            columns: [
                // Asegúrate de definir las columnas
                { label: "Nombre", key: "name" },
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
            // Obtener los datos de microempresas desde la API
            this.microCompany = await apiServices.get("micro-company");
            console.log(this.microCompany); // Verifica los datos que se reciben
        },
    },
};
</script>

<template>
    <table-component :data="microCompany" :columns="columns" />
</template>

<style scoped></style>
