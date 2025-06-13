export default [
    {
        path: "",
        name: "ClientDashboard",
        component: () => import("@/views/HomeClients.vue"),
        meta: { title: "Panel de Cliente", roles: ["client"] },
    },
    {
        path: "tickets",
        name: "ClientTickets",
        component: () => import("@/views/manager/tickets/TicketManager.vue"),
        meta: { title: "Mis Tickets", roles: ["client"] },
    },
    {
        path: "equipment",
        name: "ClientEquipment",
        component: () => import("@/views/manager/equipments/EquipmentManager.vue"),
        meta: { title: "Mis Equipos", roles: ["client"] },
    },
];
