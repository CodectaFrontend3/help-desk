<script>
import tableComponent from "@/components/Commons/TableComponent.vue";

export default {
    name: "EmpresaView",
    components: { tableComponent },
    data() {
        return {
            // Definir las columnas que quieres mostrar en la tabla
            columns: [
                { label: "Nombre", key: "name" },
                { label: "RUC", key: "ruc" },
                { label: "Dirección", key: "address" },
                { label: "Teléfono", key: "phone" },
                { label: "Email", key: "email" },
            ],
        };
    },
};
</script>

<template>
    <table-component :columns="columns" />
</template>

<style scoped></style>
