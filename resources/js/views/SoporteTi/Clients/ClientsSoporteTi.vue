<script>
import tableComponent from "@/components/Commons/TableComponent.vue";
import apiServices from "../../../services/ApiServices";

export default {
    name: "ClientsSoporteTi",
    components: { tableComponent },
    data() {
        return {

        };
    },
    computed: {
    hasChildRoute() {
        return this.$route.path !== "/clients-soporte-ti";
    },
}


};
</script>

<template>
    <div class="content-area">
        <h1 v-if="!hasChildRoute">BIENVENIDO A LA SECCIÓN DE CLIENTES PARA SOPORTE TI, ELIJA UNA DE LAS OPCIONES QUE TIENE AL COSTADO DEL BUSCADOR</h1>
        <router-view />
        </div>
</template>

<style scoped></style>
