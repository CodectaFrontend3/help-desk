<template>
    <div class="inicio">
        <PageTitle title="Funciona" />
    </div>
</template>

<script>

import PageTitle from "@/components/ForMenu/Titulos.vue";

export default {
    name: "Inicio",
    components: { PageTitle }
};
</script>

<style scoped>
.inicio {
    background-color: rgba(255, 255, 255, 0);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    color: rgb(0, 0, 0);
}
</style>