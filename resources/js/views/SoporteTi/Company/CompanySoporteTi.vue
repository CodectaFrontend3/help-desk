<script>
import tableComponent from "@/components/Commons/TableComponent.vue";
import apiServices from "../../../services/ApiServices";

export default {
    name: "EmpresaSoporteTi", // Asegúrate de que este nombre sea consistente con tu router
    components: { tableComponent },
    data() {
        return {
            columns: [
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
        ensureDefaultCompanyTiView(route) {
            // Verifica si la ruta actual es el padre sin un hijo específico ya activo
            if (route.name === 'TiSupportCompanies' && !['TiSupportCompaniesView', 'TiSupportCompaniesPersons'].includes(route.name)) {
                this.$router.replace({ name: 'TiSupportCompaniesView' });
            }
        }
    },
    watch: {
        '$route': {
            immediate: true,
            handler(to, from) {
                this.ensureDefaultCompanyTiView(to);
            }
        }
    }
};
</script>

<template>
    <router-view />
</template>

<style scoped></style>
