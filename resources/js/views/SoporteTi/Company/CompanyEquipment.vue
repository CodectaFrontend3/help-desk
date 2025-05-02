<script>
import tableComponent from "@/components/Commons/TableComponent.vue";
import apiServices from "../../../services/ApiServices";

export default {
    name: "MicroEmpresa",
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
    methods: {
        // Métodos futuros para cargar datos
    },
};
</script>

<template>
    <table-component
        :data="microCompany"
        :columns="columns"
        entity-type="micro"
    />
</template>

<style scoped></style>
