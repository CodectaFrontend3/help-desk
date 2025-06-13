<script>
import tableComponent from "@/components/Commons/TableComponent.vue";
import apiServices from "../../../services/ApiServices";

export default {
    name: "ClientsSoporteTi",
    components: { tableComponent },
    data() {
        return {};
    },
    methods: {
        ensureDefaultClientsTiView(route) {
            // Verifica si la ruta actual es el padre sin un hijo específico ya activo
            if (route.name === 'TiSupportClients' && !['TiSupportClientsCompanies', 'TiSupportClientsPersons'].includes(route.name)) {
                this.$router.replace({ name: 'TiSupportClientsCompanies' });
            }
        }
    },
    watch: {
        '$route': {
            immediate: true,
            handler(to, from) {
                this.ensureDefaultClientsTiView(to);
            }
        }
    }
};
</script>

<template>
    <router-view />
</template>

<style scoped></style>
