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
    computed: {
    hasChildRoute() {
        return this.$route.path !== "/company-soporte-ti";
    },
}


};
</script>

<template>
    <div class="content-area">
        <h1 v-if="!hasChildRoute">BIENVENIDO A LA SECCIÓN DE EMPRESA PARA SOPORTE TI, ELIJA UNA DE LAS OPCIONES QUE TIENE AL COSTADO DEL BUSCADOR</h1>
        <router-view />
        </div>
</template>

<style scoped></style>
