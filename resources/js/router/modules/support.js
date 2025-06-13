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
                    roles: ["TiSupport"],
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
                name: "TiSupportCompaniesPersons",
                component: () =>
                    import("@/views/SoporteTi/Company/CompanyPerson.vue"),
                meta: {
                    title: "Personal de Empresas",
                    roles: ["TiSupport"],
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
            roles: ["TiSupport"],
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
            roles: ["TiSupport"],
            navbarConfig: {
                companySoporteTi: true,
                equipmentDetails: true,
            },
        },
    },
    // **** RUTA AÑADIDA/MODIFICADA PARA LOS TICKETS GENERALES BAJO EL PERFIL DE SOPORTE ****
    {
        path: "tickets", // Esta ruta se resolverá como /support/tickets
        name: "SupportTicketsGeneral", // Un nombre único para esta ruta
        component: () => import("@/views/Admin/HistorialTickets.vue"), // Asegúrate de que esta ruta sea correcta a tu componente HistorialTickets.vue
        meta: {
            title: "Gestión de Tickets",
            roles: ["TiSupport"], // Define los roles que pueden acceder a esta ruta
        },
    },
];
