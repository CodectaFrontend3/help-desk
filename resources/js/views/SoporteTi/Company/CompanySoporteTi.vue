<script>
import tableComponent from "@/components/Commons/TableComponent.vue";
import apiServices from "../../../services/ApiServices";

export default {
    name: "EmpresaSoporteTi",
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

};
</script>

<template>
    <div class="content-area">
        <router-view />
    </div>
</template>

<style scoped></style>
