<script>
export default {
    name: "AdminClients",
    data() {
        return {
            // ... (tus datos existentes)
        };
    },
    methods: {
        // Centraliza la lógica de redirección para evitar repeticiones
        ensureDefaultClientView(route) {
            // Verifica si la ruta actual es el padre sin un hijo específico ya activo
            if (route.name === 'AdminClients' && !['AdminClientsCompanies', 'AdminClientsPersons'].includes(route.name)) {
                this.$router.replace({ name: 'AdminClientsCompanies' });
            }
        }
    },
    watch: {
        // Observa cambios en el objeto $route
        '$route': {
            // `immediate: true` hace que el handler se ejecute inmediatamente al iniciar el watcher (cubriendo el primer clic/carga)
            immediate: true,
            // `handler` es la función que se ejecuta cuando $route cambia
            handler(to, from) {
                this.ensureDefaultClientView(to); // Pasa el nuevo objeto de ruta
            }
        }
    }
    // No necesitas el mounted() hook para esta lógica si usas immediate: true en el watcher
};
</script>

<template>
    <router-view />
</template>

<style scoped></style>
