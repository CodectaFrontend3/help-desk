// roleConfigs.js actualizado con nuevas tarjetas
export const roleConfigurations = {
    admin: {
        titulo: "Panel de Administración",
        iconSrc: "/icono-admin.png",
        cards: [
            {
                icon: "pi pi-ticket",
                text: "Tickets Abiertos",
                number: 0,
                link: "tickets/abiertos",
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
                text: "Historial de Tickets",
                number: 0,
                link: "/tickets/historial",
            },
            {
                icon: "pi pi-users",
                text: "Registrar clientes",
                number: 0,
                link: "/register-client",
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
    support: {
        titulo: "Soporte Técnico",
        iconSrc: "/icono-support.png",
        cards: [
            {
                icon: "pi pi-ticket",
                text: "Tickets Abiertos",
                number: 0,
                link: "tickets/abiertos",
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
                text: "Historial de Tickets",
                number: 0,
                link: "/tickets/historial",
            },
            {
                icon: "pi pi-star-fill",
                text: "Valorización de Satisfacción",
                number: 0,
                link: "/tickets",
            },
        ],
        components: {
            messages: true,
            charts: false,
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
                text: "Tickets Generados",
                number: 0,
                link: "tickets/generated",
            },
            {
                icon: "pi pi-exclamation-circle",
                text: "Tickets Abiertos",
                number: 0,
                link: "tickets/abiertos",
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
                link: "tickets/mis-tickets",
            },
            {
                icon: "pi pi-desktop",
                text: "Cantidad de equipos",
                number: 0,
                link: "/tickets/number-equipment",
            },
        ],
        components: {
            messages: true,
            charts: false,
            calendar: false
        },
        messagesTitle: "Mis Notificaciones",
        theme: {
            cardBackground: "#d8fcb6",
            messageBackground: "#edfad0",
        },
    }
};
