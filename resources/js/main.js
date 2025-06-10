// src/main.js

import { createApp } from "vue";
import { createPinia } from "pinia";
import "../css/style.css"; // Asegúrate de que esta ruta sea correcta
import App from "./App.vue";
import router from "./router/index.js"; // Importa la instancia del router
import { setupRouterGuards } from "./router/guards.js"; // Importa la función para configurar los guards

// Importa PrimeVue y sus componentes globales
import PrimeVue from "primevue/config";
import "primeicons/primeicons.css"; // Core PrimeIcons
import Paginator from "primevue/paginator"; // Ejemplo de componente PrimeVue
import Button from "primevue/button"; // Ejemplo de componente PrimeVue

const app = createApp(App); // Crea la aplicación Vue

const pinia = createPinia(); // Crea la instancia de Pinia
app.use(pinia); // Usa Pinia con la aplicación

// --- ¡IMPORTANTE! ---
// ELIMINADAS: Todas las llamadas explícitas a `authStore.initializeAuth()` o `authStore.checkAuthStatus()` aquí.
// La inicialización global de la autenticación se maneja ahora dentro de `setupRouterGuards()`
// a través del guard de navegación de Vue Router, ejecutándose una única vez en la carga inicial.

// 1. Configurar los guards de navegación y pasar la instancia del router.
//    Esto registrará el `router.beforeEach` que se encargará de la inicialización de autenticación
//    la primera vez que se intente navegar.
setupRouterGuards(router);

// 2. Usar el router con la aplicación.
app.use(router);

// 3. Configurar y usar PrimeVue.
app.use(PrimeVue);
app.component("Paginator", Paginator); // Registra componentes globales de PrimeVue
app.component("Button", Button); // Registra componentes globales de PrimeVue

// 4. Finalmente, montar la aplicación.
app.mount("#app");
