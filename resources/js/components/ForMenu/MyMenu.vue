<script>
import MenuItem from "./MenuItem.vue";
import { mapState } from "vuex";

export default {
    name: "MyMenu",
    components: { MenuItem },
    computed: {
        ...mapState(["userType"]),
        model() {
            return [
                { label: "Home", icon: "pi pi-fw pi-home", to: "/" },
                {
                    label: "Administrador - Clientes",
                    icon: "pi pi-fw pi-user",
                    to: "/clients-admin",
                },
                {
                    label: "Administrador - Plan de soporte",
                    icon: "pi pi-fw pi-users",
                    to: "/admin-support",
                },
                {
                    label: "Soporte TI - Tickets",
                    icon: "pi pi-fw pi-ticket",
                    to: "/tickets",
                },
                {
                    label: "Soporte TI - Clientes",
                    icon: "pi pi-fw pi-users",
                    to: "/clients-soporte-ti",
                },
                {
                    label: "Soporte TI - Plan de soporte",
                    icon: "pi pi-fw pi-users",
                    to: "/soporte-ti",
                },
                {
                    label: "Soporte TI - Empresa",
                    icon: "pi pi-fw pi-users",
                    to: "/company-soporte-ti",
                },
            ];
        },
    },
};
</script>

<template>
    <div class="menu-container">
        <div class="profile">
            <div class="profile-img">
                <img src="../assets/user.png" width="120px" alt="" />
            </div>
            <p class="profile-name">Beto Ortiz</p>
            <h4 class="profile-especialization">Administrador</h4>
        </div>
        <ul class="layout-menu">
            <template v-for="(item, i) in model" :key="i">
                <menu-item :item="item" :index="i"></menu-item>
            </template>
        </ul>
        <div class="options">
            <button>
                <span class="pi pi-user"></span>
                <span>Perfil</span>
            </button>
            <button class="logout">
                <span class="pi pi-sign-out"></span>
                <span>Cerrar Sesión</span>
            </button>
        </div>
    </div>
</template>

<style scoped>
.menu-container {
    display: flex;
    flex-direction: column;
    background-color: #fff;
}
.layout-menu {
    flex: 1;
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    height: 100vh;
    width: var(--my_menu_width);
    min-width: var(--my_menu_width);
    max-width: var(--my_menu_width);
    background-color: #fff;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    overflow: auto;
}

.profile {
    background-color: var(--main-color);
    color: #fff;
    display: flex;
    align-items: center;
    flex-direction: column;
    padding: 30px;
    gap: 6px;
}
.profile-img {
    border-radius: 50%;
}
.options {
    display: flex;
    flex-direction: column;
    align-items: start;
    padding: 10px 20px;
    gap: 10px;
    font-weight: 500;
}
.options button {
    font-weight: inherit;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 1rem;
}
</style>
