<template>

  <MyMenu />
  <div class="main">
    <Titulos title="Gestión de Registros" />
    <div class="content">
      <NavBar />
      <table-component />
    </div>

  </div>

</template>

<script>
import TableComponent from "@/components/Commons/TableComponent.vue";
import MyMenu from "@/components/ForMenu/MyMenu.vue";
import Titulos from "@/components/ForMenu/Titulos.vue";
import NavBar from "@/components/Commons/NavBar.vue";
export default {
    name: 'Testing',
    components: {
      NavBar,
      Titulos,
      MyMenu,
      TableComponent
    },
  data() {
      return {

      }
  }
}
</script>

<style scoped>
.main {
  display: flex;
  flex-direction: column;
  width: 100%;
  padding: 20px;
  gap: 20px;
}
</style>
