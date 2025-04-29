import { createApp } from 'vue';
import '../css/style.css';
import App from './App.vue';
import router from './router/index.js';
import PrimeVue from 'primevue/config';
             // core
import 'primeicons/primeicons.css';     
import Paginator from 'primevue/paginator';              // Importa el componente Paginator
import Button from 'primevue/button';                    // Importa el componente Button

const app = createApp(App);

// Usa PrimeVue y el router
app.use(router);
app.use(PrimeVue); // Usa PrimeVue

// Registra los componentes globalmente
app.component('Paginator', Paginator);
app.component('Button', Button);

// Monta la aplicación
app.mount('#app');
