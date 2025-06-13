import { createApp } from "vue";
import { createPinia } from "pinia";
import "../css/style.css";
import App from "./App.vue";
import router from "./router/index.js";
import { setupRouterGuards } from "./router/guards.js";
import PrimeVue from "primevue/config";
// core
import "primeicons/primeicons.css";
import Paginator from "primevue/paginator"; // Importa el componente Paginator
import Button from "primevue/button"; // Importa el componente Button

const app = createApp(App);

const pinia = createPinia();
app.use(pinia);

// Ahora inicializar autenticación
import { useAuthStore } from "./stores/auth";
const authStore = useAuthStore();
authStore.initializeAuth();

// Configurar guards de navegación DESPUÉS de instalar Pinia
setupRouterGuards(router);

// Usa PrimeVue y el router
app.use(router);
app.use(PrimeVue);
app.component("Paginator", Paginator);
app.component("Button", Button);

// Inicializar autenticación antes de montar la app
const initApp = async () => {
    // Inicializar el store de autenticación
    const authStore = useAuthStore();

    // Cargar datos de autenticación guardados
    authStore.initializeAuth();

    // Si hay un token, verificar su validez
    if (authStore.token) {
        try {
            await authStore.checkAuthStatus();
        } catch (error) {
            console.error("Error verificando estado de autenticación:", error);
            authStore.logout();
        }
    }

    // Montar la aplicación
    app.mount("#app");
};

// Inicializar la aplicación
initApp().catch((error) => {
    console.error("Error inicializando la aplicación:", error);
    app.mount("#app");
});
