export default [
    {
        path: "dashboard",
        name: "TiSupportDashboard",
        component: () => import("@/views/SoporteTi/HomeSupport.vue"),
        meta: { title: "Panel de Soporte TI", roles: ["TiSupport"] },
    },
    // Agrega más rutas aquí...
];
