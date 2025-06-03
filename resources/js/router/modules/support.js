export default [
    {
        path: "home-support",
        name: "TiSupportDashboard",
        component: () => import("@/views/SoporteTi/HomeSupport.vue"),
        meta: { title: "Panel de Soporte TI", roles: ["TiSupport"] },
    },
    {
        path: "clients",
        name: "TiSupportClients",
        component: () =>
            import("@/views/SoporteTi/Clients/ClientsSoporteTi.vue"),
        meta: {
            title: "Clientes - Soporte TI",
            roles: ["TiSupport"],
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
                    roles: ["TiSupport"], // Cambiado de ROLES.TI_SUPPORT a "TiSupport"
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
                    roles: ["TiSupport"], // Cambiado de ROLES.TI_SUPPORT a "TiSupport"
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
            roles: ["TiSupport"], // Cambiado de ROLES.TI_SUPPORT a "TiSupport"
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
                    roles: ["TiSupport"], // Cambiado de ROLES.TI_SUPPORT a "TiSupport"
                },
            },
            {
                path: "active",
                name: "TiSupportTicketsActive",
                component: () =>
                    import("@/views/SoporteTi/Tickets/TicketsActivos.vue"),
                meta: {
                    title: "Tickets Activos",
                    roles: ["TiSupport"], // Cambiado de ROLES.TI_SUPPORT a "TiSupport"
                },
            },
            {
                path: "urgent",
                name: "TiSupportTicketsUrgent",
                component: () =>
                    import("@/views/SoporteTi/Tickets/TicketsUrgentes.vue"),
                meta: {
                    title: "Tickets Urgentes",
                    roles: ["TiSupport"], // Cambiado de ROLES.TI_SUPPORT a "TiSupport"
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
            roles: ["TiSupport"], // Cambiado de ROLES.TI_SUPPORT a "TiSupport"
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
                    roles: ["TiSupport"], // Cambiado de ROLES.TI_SUPPORT a "TiSupport"
                },
            },
            {
                path: "persons",
                name: "TiSupportCompaniesPersons",
                component: () =>
                    import("@/views/SoporteTi/Company/CompanyPerson.vue"),
                meta: {
                    title: "Personal de Empresas",
                    roles: ["TiSupport"], // Cambiado de ROLES.TI_SUPPORT a "TiSupport"
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
            roles: ["TiSupport"], // Cambiado de ROLES.TI_SUPPORT a "TiSupport"
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
            roles: ["TiSupport"], // Cambiado de ROLES.TI_SUPPORT a "TiSupport"
            navbarConfig: {
                companySoporteTi: true,
                equipmentDetails: true,
            },
        },
    },
    // Agrega más rutas aquí...
];
