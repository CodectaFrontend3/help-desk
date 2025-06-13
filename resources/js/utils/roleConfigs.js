// src/utils/roleConfigs.js

export const roleConfigurations = {
    admin: {
        titulo: "Panel de Administración",
        iconSrc: "/icono-admin.png",
        cards: [
            {
                icon: "pi pi-ticket",
                text: "Tickets Abiertos",
                number: 0,
                link: "/tickets?status=abiertos", // <--- MODIFICADO
            },
            {
                icon: "pi pi-sync",
                text: "Tickets En Proceso",
                number: 0,
                link: "tickets/en-proceso",
            },
            {
                icon: "pi pi-check-circle",
                text: "Tickets Cerrados",
                number: 0,
                link: "tickets/cerrados",
            },
            {
                icon: "pi pi-history",
                text: "Historial de Tickets", // Tarjeta para tickets totales generales (admin)
                number: 0,
                link: "/tickets/historial", // Si HistorialTickets.vue maneja /tickets, esta podría seguir siendo una sub-ruta específica si es necesario.
            },
            {
                icon: "pi pi-users",
                text: "Registrar clientes",
                number: 0,
                link: "/register-client",
            },
            {
                icon: "pi pi-desktop", // Icono para equipos
                text: "Cantidad de equipos", // <-- Nueva tarjeta para Admin (total de equipos)
                number: 0,
                link: "/equipos", // Define una ruta adecuada para ver todos los equipos
            },
        ],
        components: {
            messages: true,
            charts: true,
            calendar: true
        },
        messagesTitle: "Mensajes Recientes",
        theme: {
            cardBackground: "#ffc676",
            messageBackground: "#fcd8a6",
        },
    },

    TiSupport: {
        titulo: "Soporte Técnico",
        iconSrc: "/icono-support.png",
        cards: [
            {
                icon: "pi pi-ticket",
                text: "Tickets Asignados",
                number: 0,
                // Si 'tickets/asignados' es una sub-ruta de /support/tickets, deberías usar:
                link: "/support/tickets/asignados", // <--- MODIFICADO: Añade /support/
                // O si es un filtro en la misma vista HistorialTickets:
                // link: "/support/tickets?status=asignados",
            },
            {
                icon: "pi pi-exclamation-circle",
                text: "Tickets Abiertos",
                number: 0,
                link: "/support/tickets?status=abiertos", // <--- MODIFICADO CLAVE: Añade /support/
            },
            {
                icon: "pi pi-sync",
                text: "Tickets En Proceso",
                number: 0,
                // Si 'tickets/en-proceso' es una sub-ruta de /support/tickets, deberías usar:
                link: "/support/tickets/en-proceso", // <--- MODIFICADO: Añade /support/
                // O si es un filtro:
                // link: "/support/tickets?status=en-proceso",
            },
            {
                icon: "pi pi-check-circle",
                text: "Tickets Resueltos",
                number: 0,
                // Si 'tickets/resueltos' es una sub-ruta de /support/tickets, deberías usar:
                link: "/support/tickets/resueltos", // <--- MODIFICADO: Añade /support/
                // O si es un filtro:
                // link: "/support/tickets?status=resueltos",
            },
            {
                icon: "pi pi-users",
                text: "Gestión de Clientes",
                number: 0,
                link: "/support/clients/companies", // Esta ya estaba bien
            },
        ],
        components: {
            messages: true,
            charts: true,
            calendar: true
        },
        messagesTitle: "Mensajes de Tickets",
        theme: {
            cardBackground: "#a6d8fc",
            messageBackground: "#d0e8fa",
        },
    },

    client: {
        titulo: "Mi Panel",
        iconSrc: "/icono-client.png",
        cards: [
            {
                icon: "pi pi-ticket",
                text: "Tickets Generados", // <-- Tarjeta para tickets totales generados por el cliente
                number: 0,
                link: "/tickets", // Asumiendo que /tickets ahora carga HistorialTickets.vue y muestra todos si no hay filtro
            },
            {
                icon: "pi pi-exclamation-circle",
                text: "Tickets Abiertos",
                number: 0,
                link: "/tickets?status=abiertos", // <--- MODIFICADO
            },
            {
                icon: "pi pi-sync",
                text: "Tickets En Proceso",
                number: 0,
                link: "tickets/en-proceso",
            },
            {
                icon: "pi pi-check-circle",
                text: "Tickets Resueltos",
                number: 0,
                link: "tickets/mis-tickets", // O "tickets/resueltos"
            },
            {
                icon: "pi pi-desktop",
                text: "Cantidad de equipos", // <-- Nueva tarjeta para Cliente (total de equipos de su empresa)
                number: 0,
                link: "/client/equipment", // Define una ruta adecuada para la vista de equipos del cliente
            },
        ],
        components: {
            messages: true,
            charts: false,
            calendar: false,
        },
        messagesTitle: "Mis Notificaciones",
        theme: {
            cardBackground: "#d8fcb6",
            messageBackground: "#edfad0",
        },
    },
};
