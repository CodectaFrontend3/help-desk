// src/components/MyMenu/MyMenu.vue

<script>
import MenuItem from "./MenuItem.vue";
import { computed } from "vue";
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

export default {
    name: "MyMenu",
    components: { MenuItem },
    setup() {
        const authStore = useAuthStore();
        const router = useRouter();

        const ROLES = {
            ADMIN: "admin",
            CLIENT: "client",
            TI_SUPPORT: "TiSupport",
        };

        const model = computed(() => {
            const allMenuItems = [
                // --- Menú para Administrador ---
                // Aquí podrías añadir exact: true si el dashboard de Admin solo debe activarse en su URL exacta
                { label: "Home - Administrador", icon: "pi pi-fw pi-home", to: { name: 'AdminDashboard' }, roles: [ROLES.ADMIN], exact: true },
                {
                    label: "Administrador - Tickets",
                    icon: "pi pi-fw pi-ticket",
                    to: { name: 'AdminTickets' },
                    roles: [ROLES.ADMIN],
                },
                {
                    label: "Administrador - Clientes",
                    icon: "pi pi-fw pi-user",
                    to: { name: 'AdminClients' },
                    roles: [ROLES.ADMIN],
                },
                {
                    label: "Administrador - Plan de soporte",
                    icon: "pi pi-fw pi-users",
                    to: { name: 'AdminSupport' },
                    roles: [ROLES.ADMIN],
                },

                // --- Menú para Soporte TI ---
                // Aquí podrías añadir exact: true si el dashboard de Soporte TI solo debe activarse en su URL exacta
                { label: "Home - Soporte Técnico", icon: "pi pi-fw pi-home", to: { name: 'TiSupportDashboard' }, roles: [ROLES.TI_SUPPORT], exact: true },
                {
                    label: "Soporte TI - Tickets",
                    icon: "pi pi-fw pi-ticket",
                    to: { name: 'TiSupportTickets' },
                    roles: [ROLES.TI_SUPPORT],
                },
                {
                    label: "Soporte TI - Clientes",
                    icon: "pi pi-fw pi-users",
                    to: { name: 'TiSupportClients' },
                    roles: [ROLES.TI_SUPPORT],
                },
                {
                    label: "Soporte TI - Empresa",
                    icon: "pi pi-fw pi-users",
                    to: { name: 'TiSupportCompanies' },
                    roles: [ROLES.TI_SUPPORT],
                },

                // --- Menú para Gerente y Empleados (rol 'client') ---
                { label: "Home - Clientes", icon: "pi pi-fw pi-home", to: { name: 'ClientDashboard' }, roles: [ROLES.CLIENT], exact: true }, // <--- ¡AQUÍ ESTÁ EL CAMBIO CLAVE PARA CLIENTES!
                {
                    label: "Gerente y Empleados - tickets",
                    icon: "pi pi-fw pi-ticket",
                    to: { name: 'ClientTickets' },
                    roles: [ROLES.CLIENT],
                },
                {
                    label: "Gerente y Empleados - Equipos",
                    icon: "pi pi-fw pi-desktop",
                    to: { name: 'ClientEquipment' },
                    roles: [ROLES.CLIENT],
                },
            ];

            return allMenuItems.filter(item => {
                if (!item.roles || item.roles.length === 0) {
                    return authStore.isAuthenticated;
                }
                return authStore.isAuthenticated && authStore.hasAnyRole(item.roles);
            });
        });

        const handleLogout = async () => {
            await authStore.logout();
            router.replace({ name: 'Login' });
        };

        return {
            model,
            user: computed(() => authStore.user),
            isAuthenticated: computed(() => authStore.isAuthenticated),
            userRole: computed(() => authStore.userRole),
            logout: handleLogout
        };
    },
};
</script>

<template>
    <div class="menu-container">
        <div class="profile">
            <div class="profile-img">
                <img src="../assets/user.png" width="120px" alt="" />
            </div>
            <p class="profile-name">{{ user?.name || 'Invitado' }}</p>
            <h4 class="profile-especialization">{{ userRole ? userRole.charAt(0).toUpperCase() + userRole.slice(1) : 'Sin rol' }}</h4>
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
            <button v-if="isAuthenticated" class="logout" @click="logout">
                <span class="pi pi-sign-out"></span>
                <span>Cerrar Sesión</span>
            </button>
        </div>
    </div>
</template>

<style scoped>
/* Tus estilos existentes para MyMenu.vue */
.menu-container {
    display: flex;
    flex-direction: column;
    background-color: #fff;
    height: 100vh;
}
.layout-menu {
    flex: 1;
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    width: var(--my_menu_width);
    min-width: var(--my_menu_width);
    max-width: var(--my_menu_width);
    background-color: #fff;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
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
    padding-bottom: 20px;
}
.options button {
    font-weight: inherit;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 1rem;
    background: none;
    border: none;
    cursor: pointer;
    color: inherit;
    width: 100%;
    text-align: left;
    padding: 5px 0;
}
.options button:hover {
    background-color: #f0f0f0;
}
.options button.logout {
    color: var(--danger-color, #ff4d4f);
}
</style>
