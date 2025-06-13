import HomeAdmin from "@/views/Admin/HomeAdmin.vue";
import ClientsAdmin from "@/views/Admin/ClientsAdmin.vue";
import CompanyAdmin from "@/views/Admin/CompanyAdmin.vue";
import PersonaClientes from "@/views/Admin/PersonaClientes.vue";
import SoporteView from "@/views/Admin/SoporteView.vue";
// import AdminTickets from "@/views/Admin/AdminTickets.vue"; // Comenta o elimina si HistorialTickets.vue es el nuevo componente

// Importa HistorialTickets si es el componente que se utilizará para la gestión general de tickets
import HistorialTickets from "@/views/Admin/HistorialTickets.vue";

export default [
    {
        path: "home-admin",
        name: "HomeAdmin",
        component: HomeAdmin,
        meta: { title: "Panel de Administración", roles: ["admin"] },
    },
    {
        path: "clients",
        name: "AdminClients",
        component: ClientsAdmin,
        meta: { title: "Gestión de Clientes", roles: ["admin"] },
        children: [
            { path: "", redirect: { name: "AdminClientsCompanies" } },
            {
                path: "companies",
                name: "AdminClientsCompanies",
                component: CompanyAdmin,
                meta: { title: "Empresas", roles: ["admin"] },
            },
            {
                path: "natural-persons",
                name: "AdminClientsPersons",
                component: PersonaClientes,
                meta: { title: "Personas Naturales", roles: ["admin"] },
            },
        ],
    },
    {
        path: "support",
        name: "AdminSupport",
        component: SoporteView,
        meta: { title: "Soporte Técnico", roles: ["admin"] },
    },
    // **** RUTA MODIFICADA PARA LOS TICKETS GENERALES BAJO EL PERFIL DE ADMINISTRADOR ****
    {
        path: "tickets",
        name: "AdminTickets",
        component: HistorialTickets, // <--- CAMBIADO: Ahora apunta a HistorialTickets.vue
        meta: { title: "Administrar Tickets", roles: ["admin"] },
    },
];
