<template>
    <MyMenu />
    <div class="main">
        <div class="main__head">
            <!-- El Título siempre se mostrará -->
            <Titulos />
            <!-- La barra de navegación (NavBar) se mostrará SOLO si $route.meta.hideNavbar NO es true -->
            <NavBar v-if="!$route.meta.hideNavbar" />
        </div>

        <div class="content">
            <router-view />
        </div>
    </div>
</template>

<script>
import MyMenu from "@/components/ForMenu/MyMenu.vue";
import Titulos from "@/components/ForMenu/Titulos.vue";
import NavBar from "@/components/Commons/NavBar.vue";

export default {
    name: "AppLayout",
    components: {
        MyMenu,
        Titulos,
        NavBar,
    },
    // Eliminamos 'data', 'watch' y 'mounted' porque ya no son necesarios
    // La lógica de visibilidad se maneja directamente en el template con $route.meta
};
</script>

<style scoped>
.main {
    flex: 1;
    display: flex;
    flex-direction: column;
    width: 100%;
    padding: 20px 20px 0 20px;
    gap: 20px;
    overflow: auto;
}
.main__head {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.content {
    flex: 1;
    display: flex;
    flex-direction: column;
}
</style>
