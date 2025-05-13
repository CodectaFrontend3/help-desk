<script>
import Titulo from "@/components/ForMenu/Titulos.vue"; // Ajusta la ruta si es necesario

export default {
    name: "HomeView",
    components: { Titulo },
    data() {
        return {
            cards: [
                {
                    icon: "pi pi-ticket",
                    text: "Tickets Activos",
                    number: 60,
                    link: "tickets/activos",
                },
                {
                    icon: "pi pi-bell",
                    text: "Tickets Urgentes",
                    number: 45,
                    link: "tickets/urgentes",
                },
                {
                    icon: "pi pi-history",
                    text: "Historial de Tickets",
                    number: 30,
                    link: "/tickets/historial",
                },
                {
                    icon: "pi pi-star-fill",
                    text: "Valorización de Satisfacción",
                    number: 60,
                    link: "/tickets",
                },
            ],
            mensajes: [
                {
                    numero: 1,
                    intencion: "Consulta sobre facturación",
                    tiempo: "hace 5 minutos",
                },
                {
                    numero: 2,
                    intencion: "Reclamo por servicio",
                    tiempo: "hace 15 minutos",
                },
                {
                    numero: 3,
                    intencion: "Solicitud de información",
                    tiempo: "hace 30 minutos",
                },
            ],
        };
    },
};
</script>

<template>
    <div>
        <Titulo
            titulo="Inicio"
            iconSrc="/icono-home.png"
            empresa="Mi Empresa"
            direccion="Av. Principal 123"
        />

        <div class="card-container">
            <div v-for="(card, index) in cards" :key="index" class="card">
                <div class="top-section">
                    <i :class="card.icon" class="icon"></i>
                    <h2>{{ card.text }}</h2>
                </div>
                <div class="bottom-section">
                    <p class="number">{{ card.number }}</p>
                    <router-link :to="card.link" class="button"
                        >Ver</router-link
                    >
                </div>
            </div>
        </div>

        <!-- Contenedor de Mensajes -->
        <div class="messages-wrapper">
            <div class="messages-container">
                <div class="messages-header">
                    <i class="pi pi-comment message-icon"></i>
                    <h3>Mensajes de Tickets</h3>
                </div>
                <ul class="messages-list">
                    <li v-for="(msg, index) in messages" :key="index">
                        <!--            #{{ msg.number }} - {{ msg.intention }} - {{ msg.timeAgo }}        Falta backend para terminar esta llamada-->
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<style scoped>
.card-container {
    display: flex;
    justify-content: space-between;
    margin: 20px;
    gap: 20px;
}

.card {
    background-color: #ffc676;
    padding: 20px;
    width: 320px;
    height: 250px;
    border-radius: 10px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.top-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.icon {
    font-size: 60px;
    color: black;
}

h2 {
    font-size: 18px;
    color: black;
    margin: 0;
    text-align: right;
    flex-grow: 1;
}

.bottom-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.number {
    font-size: 24px;
    font-weight: bold;
    color: black;
}

.button {
    background-color: white;
    color: black;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
    text-decoration: none;
    transition: 0.3s;
}

.button:hover {
    background-color: rgba(255, 255, 255, 0.8);
}

.messages-wrapper {
    display: flex;
    justify-content: center;
    width: 100%;
    margin-top: 70px;
}

.messages-container {
    width: 500px;
    max-width: 90%;
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
}

.messages-header {
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 2px solid #ddd;
    padding-bottom: 10px;
}

.message-icon {
    font-size: 24px;
    color: #333;
}

.messages-list {
    list-style: none;
    background-color: #fcd8a6;
    padding: 0;
    margin: 15px 0 0;
}

.messages-list li {
    font-size: 16px;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.messages-list li:last-child {
    border-bottom: none;
}
</style>
