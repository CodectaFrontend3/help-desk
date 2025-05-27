import { createRouter, createWebHistory } from "vue-router";

// Importa tus componentes
import AppLayout from "@/components/Layouts/AppLayout.vue";

// Define las rutas
const routes = [
    {
        path: "/",
        component: AppLayout,
        children: [
            // VISTAS DE INICIO
            {
                path: "",
                name: "Inicio",
                component: () => import("@/views/HomeClients.vue"),
            },
            {
                path: "home-admin",
                name: "HomeAdmin",
                component: () => import("@/views/Admin/HomeAdmin.vue"),
            },
            {
                path: "home-support",
                name: "HomeSupport",
                component: () => import("@/views/SoporteTi/HomeSupport.vue"),
            },

            // CLIENTES - ADMINISTRADOR
            {
                path: "clients-admin",
                name: "Clientes - Administrador",
                component: () => import("@/views/Admin/ClientsAdmin.vue"),
                meta: {
                    role: "admin",
                    navbarConfig: {
                        clientes: true,
                    },
                },
                children: [
                    {
                        path: "",
                        name: "ClientesAdmin",
                        redirect: "/clients-admin/companies",
                    },
                    {
                        path: "companies",
                        name: "Clientes - Empresa",
                        component: () =>
                            import("@/views/Admin/CompanyAdmin.vue"),
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
                        path: "natural-person",
                        name: "Clientes - Persona natural",
                        component: () =>
                            import("@/views/Admin/PersonaClientes.vue"),
                        meta: {
                            role: "admin",
                            navbarConfig: {
                                persona: true,
                                labelDni: "DNI:",
                                labelNombre: "Nombre:",
                            },
                        },
                    },
                ],
            },

            // RUTAS DE LA VISTA SOPORTE TI DEL ROL ADMINISTRADOR
            {
                path: "admin-support",
                name: "Soporte técnico - Administrador",
                component: () => import("@/views/Admin/SoporteView.vue"),
                meta: {
                    role: "admin",
                    navbarConfig: {
                        soporte: true,
                    },
                },
            },

            // RUTAS DE LA VISTA CLIENTES - SOPORTE TI
            {
                path: "clients-soporte-ti",
                name: "Clientes - Soporte TI",
                component: () =>
                    import("@/views/SoporteTi/Clients/ClientsSoporteTi.vue"), // Usa la capitalización correcta
                meta: {
                    navbarConfig: {
                        clientsSoporteTi: true,
                    },
                },
                children: [
                    {
                        path: "",
                        name: "Clientes",
                        redirect: "/clients-soporte-ti/clients-company",
                    },
                    {
                        path: "clients-company",
                        name: "Clientes - Empresa - Soporte TI",
                        component: () =>
                            import(
                                "@/views/SoporteTi/Clients/ClientsCompany.vue"
                            ),
                        meta: {
                            navbarConfig: {
                                clientsSoporteTi: true,
                                clientCompany: true,
                                labelRuc: "RUC: ",
                                labelEmpresa: "Empresa:",
                                labelSearch: "Buscar     en la Empresa",
                            },
                        },
                    },
                    {
                        path: "clients-person",
                        name: "Clientes - Persona Natural - Soporte TI",
                        component: () =>
                            import(
                                "@/views/SoporteTi/Clients/ClientsPerson.vue"
                            ),
                        meta: {
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

            // TICKETS - SOPORTE TI
            {
                path: "tickets",
                name: "Vista de Tickets",
                component: () =>
                    import("@/views/SoporteTi/Tickets/TicketsView.vue"),
                meta: {
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
                        path: "historial",
                        name: "Historial de Tickets",
                        component: () =>
                            import(
                                "@/views/SoporteTi/Tickets/HistorialTickets.vue"
                            ),
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
                        path: "activos",
                        name: "Tickets Activos",
                        component: () =>
                            import(
                                "@/views/SoporteTi/Tickets/TicketsActivos.vue"
                            ),
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
                        path: "urgentes",
                        name: "Tickets urgentes",
                        component: () =>
                            import(
                                "@/views/SoporteTi/Tickets/TicketsUrgentes.vue"
                            ),
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
                ],
            },

            // RUTAS DE LA VISTA SOPORTE TI DEL ROL SOPORTE TI
            {
                path: "soporte-ti",
                name: "Soporte técnico - Soporte TI",
                component: () =>
                    import("@/views/SoporteTi/Support/SoporteTiView.vue"),
                meta: {
                    navbarConfig: {
                        soporteTi: true,
                        ruc: "RUC",
                        company: "Empresa",
                    },
                },
            },

            // Rutas para la vista EMPRESA y los EQUIPOS de estas- Soporte TI
            {
                path: "company-soporte-ti",
                name: "Empresa - Soporte TI",
                component: () =>
                    import("@/views/SoporteTi/Company/CompanySoporteTi.vue"),
                meta: {
                    navbarConfig: {
                        companySoporteTi: true,
                    },
                },
                children: [
                    {
                        path: "",
                        name: "Empresa",
                        redirect: "/company-soporte-ti/company-company",
                    },
                    {
                        path: "company-company",
                        name: "CompanyCompany",
                        component: () =>
                            import(
                                "@/views/SoporteTi/Company/CompanyCompany.vue"
                            ),
                        meta: {
                            navbarConfig: {
                                companySoporteTi: true,
                                companyCompany: true,
                            },
                        },
                    },
                    {
                        path: "company-person",
                        name: "CompanyPerson",
                        component: () =>
                            import(
                                "@/views/SoporteTi/Company/CompanyPerson.vue"
                            ),
                        meta: {
                            navbarConfig: {
                                companySoporteTi: true,
                                companyPerson: true,
                            },
                        },
                    },
                ],
            },
            {
                path: "company-equipment/:id/:type",
                name: "Equipos de Empresa",
                component: () =>
                    import("@/views/SoporteTi/Company/CompanyEquipment.vue"),
                props: true, // Pasar los params como props
                meta: {
                    navbarConfig: {
                        equipment: true,
                        companySoporteTi: true,
                        dateRange: "Rango de fecha",
                    },
                },
            },
            {
                path: "equipment-details/:companyId/:equipmentId",
                name: "Detalles de Equipo",
                component: () =>
                    import(
                        "@/views/SoporteTi/Company/CompanyEquipmentDetails.vue"
                    ),
                meta: {
                    navbarConfig: {
                        companySoporteTi: true,
                        equipmentDetails: true,
                    },
                },
            },

            // RUTAS DE LA VISTA DE GERENTES Y TRABAJADORES
            {
                path: "client-tickets",
                component: () => import("@/views/manager/tickets/TicketManager.vue"),
                name: "Tickets - Gerente y trabajadores",
                meta: {
                    role: "manager",
                    navbarConfig: {
                        tickets: true,
                        labelIncidente: "Tipo de incidente:",
                        labelFecha: "Rango de fecha",
                        labelEstado: "Estado",
                    },
                },
            },
            {
                path: "client-equipments",
                component: () => import("@/views/manager/equipments/EquipmentManager.vue"),
                name: "Equipos - Gerente y trabajadores",
                meta: {
                    role: "manager",
                    navbarConfig: {

                    },
                },
            },
            {
                path: "admin-tickets",
                component: () => import("@/views/Admin/AdminTickets.vue"),
                name: "Administrador - Tickets",
                meta: {
                    role: "admin-tickets",
                    navbarConfig: {
                        tickets: true,
                        labelArea: "Área:",
                        labelIncidente: "Tipo de incidente:",
                        labelFecha: "Rango de fecha",
                        labelEstado: "Estado",
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

