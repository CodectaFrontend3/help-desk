export default [
    {
        path: "",
        name: "ClientDashboard",
        component: () => import("@/views/HomeClients.vue"),
        meta: { title: "Panel de Cliente", roles: ["client"] },
    },
    // **** RUTA MODIFICADA PARA LOS TICKETS GENERALES BAJO EL PERFIL DE CLIENTE ****
    {
        path: "tickets",
        name: "ClientTickets",
        component: () => import("@/views/Admin/HistorialTickets.vue"), // <--- CAMBIADO: Ahora apunta a HistorialTickets.vue
        meta: { title: "Mis Tickets", roles: ["client"] },
    },
    {
        path: "equipment",
        name: "ClientEquipment",
        component: () => import("@/views/manager/equipments/EquipmentManager.vue"),
        meta: { title: "Mis Equipos", roles: ["client"] },
    },
];
