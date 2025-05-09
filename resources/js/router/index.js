import { createRouter, createWebHistory } from "vue-router";

// Importa tus componentes
import AppLayout from "@/components/Layouts/AppLayout.vue";
import ClientsSoporteTi from "../views/SoporteTi/Clients/ClientsSoporteTi.vue";

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

            // EMPRESA DEL ROL ADMINISTRADOR
            {
                path: "company-admin",
                name: "Clientes - Empresa - Administrador",
                component: () => import("@/views/Admin/CompanyAdmin.vue"),
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

            // PERSONA NATURAL DEL ROL ADMINISTRADOR
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

            // RUTAS DE LA VISTA SOPORTE TI DEL ROL ADMINISTRADOR
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
                        path: "clients-micro",
                        name: "Clientes - Microempresa - Soporte TI",
                        component: () =>
                            import(
                                "@/views/SoporteTi/Clients/ClientsMicro.vue"
                            ),
                        meta: {
                            navbarConfig: {
                                clientsSoporteTi: true,
                                clientMicro: true,
                            },
                        },
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
                path: "historialtickets",
                name: "Historial de Tickets",
                component: () =>
                    import("@/views/SoporteTi/Tickets/HistorialTickets.vue"),
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
                component: () =>
                    import("@/views/SoporteTi/Tickets/TicketsActivos.vue"),
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
                    import("@/views/SoporteTi/Tickets/TicketsUrgentes.vue"),
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

            // Rutas para la vista EMPRESA - Soporte TI
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
                        path: "company-micro",
                        name: "Empresa - Microempresa - Soporte TI",
                        component: () =>
                            import(
                                "@/views/SoporteTi/Company/CompanyMicro.vue"
                            ),
                        meta: {
                            navbarConfig: {
                                companySoporteTi: true,
                                companyMicro: true,
                            },
                        },
                        // Añadimos rutas hijas para mostrar equipos de microempresas
                        // children: [
                        //     {
                        //         path: ":id/equipments",
                        //         name: "Equipos de Microempresa",
                        //         component: () =>
                        //             import(
                        //                 "@/views/SoporteTi/Company/CompanyEquipment.vue"
                        //             ),
                        //         props: (route) => ({
                        //             id: route.params.id,
                        //             type: "micro",
                        //         }),
                        //         meta: {
                        //             navbarConfig: {
                        //                 companySoporteTi: true,
                        //                 companyMicro: true,
                        //                 companyEquipment: true,
                        //             },
                        //         },
                        //     },
                        // ],
                    },
                    {
                        path: "company-company",
                        name: "Empresa - Empresa - Soporte TI",
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
                        // Añadimos rutas hijas para mostrar equipos de empresas
                        // children: [
                        //     {
                        //         path: ":id/equipments",
                        //         name: "Equipos de Empresa",
                        //         component: () =>
                        //             import(
                        //                 "@/views/SoporteTi/Company/CompanyEquipment.vue"
                        //             ),
                        //         props: (route) => ({
                        //             id: route.params.id,
                        //             type: "company",
                        //         }),
                        //         meta: {
                        //             navbarConfig: {
                        //                 companySoporteTi: true,
                        //                 companyCompany: true,
                        //                 companyEquipment: true,
                        //             },
                        //         },
                        //     },
                        // ],

                    },
                    {
                        path: "company-person",
                        name: "Empresa - Persona Natural - Soporte TI",
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
                        // Añadimos rutas hijas para mostrar equipos de personas naturales
                        // children: [
                        //     {
                        //         path: ":id/equipments",
                        //         name: "Equipos de Persona Natural",
                        //         component: () =>
                        //             import(
                        //                 "@/views/SoporteTi/Company/CompanyEquipment.vue"
                        //             ),
                        //         props: (route) => ({
                        //             id: route.params.id,
                        //             type: "person",
                        //         }),
                        //         meta: {
                        //             navbarConfig: {
                        //                 companySoporteTi: true,
                        //                 companyPerson: true,
                        //                 companyEquipment: true,
                        //             },
                        //         },
                        //     },
                        // ],
                    },
                    // Ruta para detalles de equipo - compartida por todos los tipos
                    {
                        path: "equipment/:equipmentId",
                        name: "Detalles de Equipo",
                        component: () =>
                            import(
                                "@/views/SoporteTi/Company/CompanyEquipmentDetails.vue"
                            ),
                        meta: {
                            navbarConfig: {
                                companySoporteTi: true,
                                companyEquipment: true,
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
                meta: {
                    navbarConfig: {
                        companySoporteTi: true,
                        companyEquipment: true,
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
                        companyEquipment: true,
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

// // Rutas para la vista EMPRESA - Soporte TI
// {
//     path: "company-soporte-ti",
//     name: "Empresa - Soporte TI",
//     component: () =>
//         import("@/views/SoporteTi/Company/CompanySoporteTi.vue"), // Usa la capitalización correcta
//     meta: {
//         navbarConfig: {
//             companySoporteTi: true,
//         },
//     },
//     children: [
//         {
//             path: "company-micro",
//             name: "Empresa - Microempresa - Soporte TI",
//             component: () =>
//                 import(
//                     "@/views/SoporteTi/Company/CompanyMicro.vue"
//                 ),
//             meta: {
//                 navbarConfig: {
//                     companySoporteTi: true,
//                     companyMicro: true,
//                 },
//             },
//             // children: [
//             //     {
//             //         path: ":id/equipments",
//             //         name: "Equipos de Microempresa",
//             //         component: () => import("@/views/SoporteTi/Company/CompanyEquipment.vue"),
//             //         props: (route) => ({
//             //             id: route.params.id,
//             //             type: 'micro'
//             //         }),
//             //         meta: {
//             //             navbarConfig: {
//             //                 companySoporteTi: true,
//             //                 companyMicro: true,
//             //                 companyEquipment: true,
//             //             },
//             //         },
//             //     }
//             // ],
//         },
//         {
//             path: "company-company",
//             name: "Empresa - Empresa - Soporte TI",
//             component: () =>
//                 import(
//                     "@/views/SoporteTi/Company/CompanyCompany.vue"
//                 ),
//             meta: {
//                 navbarConfig: {
//                     companySoporteTi: true,
//                     companyCompany: true,
//                 },
//             },
//             // children: [
//             //     {
//             //         path: ":id/equipments",
//             //         name: "Equipos de Empresa",
//             //         component: () => import("@/views/SoporteTi/Company/CompanyEquipment.vue"),
//             //         props: (route) => ({
//             //             id: route.params.id,
//             //             type: 'company'
//             //         }),
//             //         meta: {
//             //             navbarConfig: {
//             //                 companySoporteTi: true,
//             //                 companyCompany: true,
//             //                 companyEquipment: true,
//             //             },
//             //         },
//             //     }
//             // ]
//         },
//         {
//             path: "company-person",
//             name: "Empresa - Persona Natural - Soporte TI",
//             component: () =>
//                 import(
//                     "@/views/SoporteTi/Company/CompanyPerson.vue"
//                 ),
//             meta: {
//                 navbarConfig: {
//                     companySoporteTi: true,
//                     companyPerson: true,
//                 },
//             },
//             // children: [
//             //     {
//             //         path: ":id/equipements",
//             //         name: "Equipos de Persona Natural",
//             //         component: () => import("@/views/SoporteTi/Company/CompanyEquipment.vue"),
//             //         props: (route) => ({
//             //             id: route.params.id,
//             //             type: 'person'
//             //         }),
//             //         meta: {
//             //             navbarConfig: {
//             //                 companySoporteTi: true,
//             //                 companyPerson: true,
//             //                 companyEquipment: true,
//             //             },
//             //         },
//             //     }
//             // ]
//         },
//         // {
//         //     path: "equipment/:equipmentId",
//         //     name: "Detalles de Equipo",
//         //     component: () => import("@/views/SoporteTi/Company/CompanyEquipmentDetails.vue"),
//         //     meta: {
//         //         navbarConfig: {
//         //             companySoporteTi: true,
//         //             companyEquipment: true,
//         //         },
//         //     },
//         // },
//     ],
// },
// {
//     path: "company-equipment/:id/:type",
//     name: "Equipos de Empresa",
//     component: () => import("@/views/SoporteTi/Company/CompanyEquipment.vue"),
//     meta: {
//         navbarConfig: {
//             companySoporteTi: true,
//             companyEquipment: true,
//         },
//     },
// },
// {
//     path: "equipment-details/:companyId/:equipmentId",
//     name: "Detalles de Equipo",
//     component: () => import("@/views/SoporteTi/Company/CompanyEquipmentDetails.vue"),
//     meta: {
//         navbarConfig: {
//             companySoporteTi: true,
//             companyEquipment: true,
//         },
//     },
// },
