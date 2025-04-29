<template>
    <MyMenu />
    <div class="main">
        <div class="main__head">
            <Titulos v-if="showTitle" />
            <NavBar v-if="showNavBar" />
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
    data() {
        return {
            showTitle: true,
            showNavBar: true,
        };
    },
    watch: {
        // Observamos el objeto $route completo para cambios en la ruta
        $route(to, from) {
            if (to.name === "Inicio") {
                this.showTitle = false;
                this.showNavBar = false;
            } else {
                this.showTitle = true;
                this.showNavBar = true;
            }
        },
    },
    mounted() {
        // Inicia la lógica cuando se monta el componente
        if (this.$route.name === "Inicio") {
            this.showTitle = false;
            this.showNavBar = false;
        }
    },
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
