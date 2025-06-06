import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/auth";

// Importa tus componentes
import AppLayout from "@/components/Layouts/AppLayout.vue";
import AuthLayout from "@/components/Layouts/AuthLayout.vue";

// Constantes de roles
const ROLES = {
    ADMIN: "admin",
    CLIENT: "client",
    TI_SUPPORT: "TiSupport",
};

// Rutas del administrador
const adminRoutes = [
    {
        path: "home-admin",
        name: "AdminDashboard",
        component: () => import("@/views/Admin/HomeAdmin.vue"),
        meta: {
            title: "Panel de Administración",
            roles: [ROLES.ADMIN],
        },
    },
    {
        path: "clients",
        name: "AdminClients",
        component: () => import("@/views/Admin/ClientsAdmin.vue"),
        meta: {
            title: "Gestión de Clientes",
            roles: [ROLES.ADMIN],
            navbarConfig: { clientes: true },
        },
        children: [
            {
                path: "",
                name: "AdminClientsDefault",
                redirect: { name: "AdminClientsCompanies" },
            },
            {
                path: "companies",
                name: "AdminClientsCompanies",
                component: () => import("@/views/Admin/CompanyAdmin.vue"),
                meta: {
                    title: "Empresas",
                    roles: [ROLES.ADMIN],
                    navbarConfig: {
                        clientes: true,
                        labelRuc: "RUC: ",
                        labelEmpresa: "Empresa:",
                        labelSearch: "Buscar en la Empresa",
                    },
                },
            },
            {
                path: "natural-persons",
                name: "AdminClientsPersons",
                component: () => import("@/views/Admin/PersonaClientes.vue"),
                meta: {
                    title: "Personas Naturales",
                    roles: [ROLES.ADMIN],
                    navbarConfig: {
                        persona: true,
                        labelDni: "DNI:",
                        labelNombre: "Nombre:",
                    },
                },
            },
        ],
    },
    {
        path: "support",
        name: "AdminSupport",
        component: () => import("@/views/Admin/SoporteView.vue"),
        meta: {
            title: "Soporte Técnico",
            roles: [ROLES.ADMIN],
            navbarConfig: { soporte: true },
        },
    },
    {
        path: "tickets",
        name: "AdminTickets",
        component: () => import("@/views/Admin/AdminTickets.vue"),
        meta: {
            title: "Administrar Tickets",
            roles: [ROLES.ADMIN],
            navbarConfig: {
                tickets: true,
                labelArea: "Área:",
                labelIncidente: "Tipo de incidente:",
                labelFecha: "Rango de fecha",
                labelEstado: "Estado",
            },
        },
    },
];

// Rutas del soporte técnico
const tiSupportRoutes = [
    {
        path: "home-support",
        name: "TiSupportDashboard",
        component: () => import("@/views/SoporteTi/HomeSupport.vue"),
        meta: {
            title: "Panel de Soporte TI",
            roles: [ROLES.TI_SUPPORT],
        },
    },
    {
        path: "clients",
        name: "TiSupportClients",
        component: () =>
            import("@/views/SoporteTi/Clients/ClientsSoporteTi.vue"),
        meta: {
            title: "Clientes - Soporte TI",
            roles: [ROLES.TI_SUPPORT],
            navbarConfig: { clientsSoporteTi: true },
        },
        children: [
            {
                path: "",
                name: "TiSupportClientsDefault",
                redirect: { name: "TiSupportClientsCompanies" },
            },
            {
                path: "companies",
                name: "TiSupportClientsCompanies",
                component: () =>
                    import("@/views/SoporteTi/Clients/ClientsCompany.vue"),
                meta: {
                    title: "Empresas",
                    roles: [ROLES.TI_SUPPORT],
                    navbarConfig: {
                        clientsSoporteTi: true,
                        clientCompany: true,
                        labelRuc: "RUC: ",
                        labelEmpresa: "Empresa:",
                        labelSearch: "Buscar en la Empresa",
                    },
                },
            },
            {
                path: "persons",
                name: "TiSupportClientsPersons",
                component: () =>
                    import("@/views/SoporteTi/Clients/ClientsPerson.vue"),
                meta: {
                    title: "Personas Naturales",
                    roles: [ROLES.TI_SUPPORT],
                    navbarConfig: {
                        clientsSoporteTi: true,
                        clientPerson: true,
                        labelDni: "DNI:",
                        labelNombre: "Nombre:",
                    },
                },
            },
        ],
    },
    {
        path: "tickets",
        name: "TiSupportTickets",
        component: () => import("@/views/SoporteTi/Tickets/TicketsView.vue"),
        meta: {
            title: "Gestión de Tickets",
            roles: [ROLES.TI_SUPPORT],
            navbarConfig: {
                tickets: true,
                labelEstado: "Estado",
                labelIncidente: "Tipo de incidente:",
                labelArea: "Área:",
                labelFecha: "Rango de fecha",
            },
        },
        children: [
            {
                path: "history",
                name: "TiSupportTicketsHistory",
                component: () =>
                    import("@/views/SoporteTi/Tickets/HistorialTickets.vue"),
                meta: {
                    title: "Historial de Tickets",
                    roles: [ROLES.TI_SUPPORT],
                },
            },
            {
                path: "active",
                name: "TiSupportTicketsActive",
                component: () =>
                    import("@/views/SoporteTi/Tickets/TicketsActivos.vue"),
                meta: {
                    title: "Tickets Activos",
                    roles: [ROLES.TI_SUPPORT],
                },
            },
            {
                path: "urgent",
                name: "TiSupportTicketsUrgent",
                component: () =>
                    import("@/views/SoporteTi/Tickets/TicketsUrgentes.vue"),
                meta: {
                    title: "Tickets Urgentes",
                    roles: [ROLES.TI_SUPPORT],
                },
            },
        ],
    },
    {
        path: "companies",
        name: "TiSupportCompanies",
        component: () =>
            import("@/views/SoporteTi/Company/CompanySoporteTi.vue"),
        meta: {
            title: "Gestión de Empresas",
            roles: [ROLES.TI_SUPPORT],
            navbarConfig: { companySoporteTi: true },
        },
        children: [
            {
                path: "",
                name: "TiSupportCompaniesDefault",
                redirect: { name: "TiSupportCompaniesView" },
            },
            {
                path: "view",
                name: "TiSupportCompaniesView",
                component: () =>
                    import("@/views/SoporteTi/Company/CompanyCompany.vue"),
                meta: {
                    title: "Vista de Empresas",
                    roles: [ROLES.TI_SUPPORT],
                },
            },
            {
                path: "persons",
                name: "TiSupportCompaniesPersons",
                component: () =>
                    import("@/views/SoporteTi/Company/CompanyPerson.vue"),
                meta: {
                    title: "Personal de Empresas",
                    roles: [ROLES.TI_SUPPORT],
                },
            },
        ],
    },
    {
        path: "equipment/:id/:type",
        name: "TiSupportEquipment",
        component: () =>
            import("@/views/SoporteTi/Company/CompanyEquipment.vue"),
        props: true,
        meta: {
            title: "Equipos",
            roles: [ROLES.TI_SUPPORT],
            navbarConfig: {
                equipment: true,
                companySoporteTi: true,
                dateRange: "Rango de fecha",
            },
        },
    },
    {
        path: "equipment-details/:companyId/:equipmentId",
        name: "TiSupportEquipmentDetails",
        component: () =>
            import("@/views/SoporteTi/Company/CompanyEquipmentDetails.vue"),
        meta: {
            title: "Detalles de Equipo",
            roles: [ROLES.TI_SUPPORT],
            navbarConfig: {
                companySoporteTi: true,
                equipmentDetails: true,
            },
        },
    },
];

// Rutas del cliente
const clientRoutes = [
    {
        path: "",
        name: "ClientDashboard",
        component: () => import("@/views/HomeClients.vue"),
        meta: {
            title: "Panel de Cliente",
            roles: [ROLES.CLIENT],
        },
    },
    {
        path: "tickets",
        name: "ClientTickets",
        component: () => import("@/views/manager/tickets/TicketManager.vue"),
        meta: {
            title: "Mis Tickets",
            roles: [ROLES.CLIENT],
            navbarConfig: {
                tickets: true,
                labelIncidente: "Tipo de incidente:",
                labelFecha: "Rango de fecha",
                labelEstado: "Estado",
            },
        },
    },
    {
        path: "equipment",
        name: "ClientEquipment",
        component: () =>
            import("@/views/manager/equipments/EquipmentManager.vue"),
        meta: {
            title: "Mis Equipos",
            roles: [ROLES.CLIENT],
        },
    },
];

// Rutas de autenticación
const authRoutes = [
    {
        path: "/auth",
        component: AuthLayout,
        meta: { requiresGuest: true },
        children: [
            {
                path: "",
                redirect: { name: "Login" } // Redirige automáticamente a login
            },
            {
                path: "login",
                name: "Login",
                component: () => import("@/views/Auth/LoginView.vue"),
                meta: { title: "Iniciar Sesión" },
            },
            {
                path: "forgot-password",
                name: "ForgotPassword",
                component: () => import("@/views/Auth/ForgotPassword.vue"),
                meta: { title: "Recuperar Contraseña" },
            },
        ],
    },
];

// Definir todas las rutas
const routes = [
    // Rutas de autenticación
    ...authRoutes,

    // Rutas de la aplicación principal
    {
        path: "/",
        component: AppLayout,
        meta: { requiresAuth: true },
        children: [
            // Redireccionamiento inicial basado en rol
            {
                path: "",
                name: "Home",
                component: () => import("@/components/Commons/HomeRedirect.vue"),
                meta: { requiresAuth: true },
            },

            // Rutas agrupadas por rol
            {
                path: "admin",
                meta: { roles: [ROLES.ADMIN] },
                children: adminRoutes,
            },
            {
                path: "support",
                meta: { roles: [ROLES.TI_SUPPORT] },
                children: tiSupportRoutes,
            },
            {
                path: "client",
                meta: { roles: [ROLES.CLIENT] },
                children: clientRoutes,
            },
        ],
    },

    // Rutas de error
    {
        path: "/unauthorized",
        name: "Unauthorized",
        component: () => import("@/views/Auth/UnAuthorized.vue"),
        meta: { title: "No Autorizado" },
    },
    {
        path: "/:pathMatch(.*)*",
        name: "NotFound",
        component: () => import("@/components/Commons/NotFound.vue"),
        meta: { title: "Página no encontrada" },
    },
];

// Crear el router
const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Guards de navegación
router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    // Verificar si la ruta requiere autenticación
    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        return next({ name: 'Login', query: { redirect: to.fullPath } });
    }

    // Si está autenticado pero trata de acceder a rutas de invitado
    if (to.meta.requiresGuest && authStore.isAuthenticated) {
        return next({ name: 'Home' });
    }

    // Verificar roles
    if (to.meta.roles && !to.meta.roles.includes(authStore.user?.role)) {
        return next({ name: 'Unauthorized' });
    }

    // Establecer título de página
    document.title = to.meta.title ? `${to.meta.title} - Mi App` : 'Mi App';

    next();
});

export default router;
