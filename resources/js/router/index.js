import { createRouter, createWebHistory } from "vue-router";

// Importa tus componentes
import AppLayout from "@/components/Layouts/AppLayout.vue";

// Define las rutas
const routes = [
    {
        path: "/",
        component: AppLayout,
        children: [
            {
                path: "",
                name: "Inicio",
                component: () => import("@/views/HomeView.vue"),
            },
            {
                path: "clientesempresa",
                name: "Empresa - Soporte TI",
                component: () => import("@/views/Admin/CompanyAdmin.vue"),
                meta: {
                    navbarConfig: {
                        clientes: true,
                        labelRuc: "RUC: ",
                        labelEmpresa: "Empresa:",
                        labelSearch: "Buscar en la Empresa",
                    },
                },
            },
            {
                path: "company-admin",
                name: "Empresa - Administrador",
                component: () => import("@/views/SoporteTi/CompanyTi.vue"),
                meta: {
                    role: "admin",
                    navbarConfig: {
                        clientes: true,
                        labelRuc: "RUC: ",
                        labelEmpresa: "Empresa:",
                        labelSearch: "Buscar en la Empresa",
                    },
                },
            },
            {
                path: "microempresa",
                name: "Microempresa - Soporte TI",
                component: () => import("@/views/SoporteTi/MicroCompany.vue"),
                meta: {
                    navbarConfig: {
                        TiEmpresa: true,
                    },
                },
            },
            
            {
                path: "historialtickets",
                name: "Historial de Tickets",
                component: () =>
                    import("@/views/SoporteTi/HistorialTickets.vue"),
                meta: {
                    navbarConfig: {
                        tickets: true,
                        labelEstado: "Estado",
                        labelIncidente: "Tipo de incidente:",
                        labelArea: "Área:",
                        labelFecha: "Rango de fecha",
                    },
                },
            },
            {
                path: "tickets-activos",
                name: "Tickets activos",
                component: () => import("@/views/SoporteTi/TicketsActivos.vue"),
                meta: {
                    navbarConfig: {
                        tickets: true,
                        labelIncidente: "Tipo de incidente:",
                        labelArea: "Área:",
                        labelFecha: "Rango de fecha",
                    },
                },
            },
            {
                path: "ticketsurgentes",
                name: "Tickets urgentes",
                component: () =>
                    import("@/views/SoporteTi/TicketsUrgentes.vue"),
                meta: {
                    navbarConfig: {
                        tickets: true,
                        labelEstado: "Estado",
                        labelIncidente: "Tipo de incidente:",
                        labelArea: "Área:",
                        labelFecha: "Rango de fecha",
                    },
                },
            },
            
            {
                path: "clientespersona",
                name: "Clientes - Persona natural",
                component: () => import("@/views/Admin/PersonaClientes.vue"),
                meta: {
                    role: "admin",
                    navbarConfig: {
                        persona: true,
                        labelDni: "DNI:",
                        labelNombre: "Nombre:",
                    },
                },
            },
            {
                path: "soporte",
                name: "Soporte técnico - Administrador",
                component: () => import("@/views/Admin/SoporteView.vue"),
                meta: {
                    role: "admin",
                    navbarConfig: {
                        soporte: true,
                    },
                },
            },
            {
                path: "soporte-ti",
                name: "Soporte técnico - Soporte TI",
                component: () => import("@/views/SoporteTi/SoporteTiView.vue"),
                meta: {
                    navbarConfig: {
                        soporteTi: true,
                        ruc: "RUC",
                        company: "Empresa",
                    },
                },
            },
        ],
    },

    // Redirección por defecto si la ruta no es válida
    {
        path: "/:pathMatch(.*)*",
        component: () => import("@/components/Commons/NotFound.vue"),
        name: "not-found",
        meta: {
            title: "Página no encontrada",
            icon: "pi pi-exclamation-circle", // Ícono para el 404
        },
    },
];

// Crea el router
const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Configurar título de la página basado en la meta de la ruta
router.beforeEach((to, from, next) => {
    // Cambiar el título de la página según la meta 'title' de la ruta
    document.title = to.meta.title || "Mi App"; // Si no hay un título, poner uno por defecto
    next();
});

export default router;
