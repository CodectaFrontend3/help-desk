import HomeAdmin from "@/views/Admin/HomeAdmin.vue";
import ClientsAdmin from "@/views/Admin/ClientsAdmin.vue";
import CompanyAdmin from "@/views/Admin/CompanyAdmin.vue";
import PersonaClientes from "@/views/Admin/PersonaClientes.vue";
import SoporteView from "@/views/Admin/SoporteView.vue";
import AdminTickets from "@/views/Admin/AdminTickets.vue";

export default [
    {
        path: "dashboard",
        name: "AdminDashboard",
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
    {
        path: "tickets",
        name: "AdminTickets",
        component: AdminTickets,
        meta: { title: "Administrar Tickets", roles: ["admin"] },
    },
];
