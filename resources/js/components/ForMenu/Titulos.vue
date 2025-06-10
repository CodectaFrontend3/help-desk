<template>
    <div class="title-container">
        <i class="pi pi-home title-icon"></i>
        <h1>{{ pageTitle }}</h1>
        <div class="divider"></div>
        <div class="company-info">
            <span class="company-name">Mi Empresa</span>
            <span class="company-district">Distrito XYZ</span>
        </div>
    </div>
</template>

// src/components/ForMenu/Titulos.vue

<script>
export default {
  name: 'Titulos', // Asegúrate de que tenga un nombre si no lo tiene

  // ELIMINA la sección 'props' si solo tenías 'title' aquí,
  // O QUITA solo la prop 'title' y su 'required: true' si tenías otras props.
  /*
  props: {
    title: {
      type: String,
      required: true // <--- ¡Elimina esto!
    }
  },
  */

  computed: {
    // Esta propiedad computada leerá el título de los metadatos de la ruta actual
    pageTitle() {
      // Si $route.meta.title existe, lo usa; si no, usa un título por defecto
      return this.$route.meta.title || 'Mi Aplicación';
    },
    // Aquí puedes añadir otras propiedades computadas si el componente Titulos
    // también mostraba la empresa, dirección, etc. del usuario, si es que venían
    // directamente del store de autenticación (useAuthStore).
    // Ejemplo:
    // currentUser() {
    //   return useAuthStore().user; // Asegúrate de importar useAuthStore si lo usas aquí
    // }
  }
};
</script>

<style scoped>
.title-container {
  background-color: white;
  border-radius: 16px;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px;
}

.title-icon {
  font-size: 70px;
  color: #333;
}

h1 {
  font-family: 'Inter', sans-serif;
  font-weight: 800;
  font-size: 36px;
  line-height: 100%;
  letter-spacing: 0%;
  color: #333;
  margin: 0;
  flex-grow: 1;
  padding-left: 30px;
  text-align: left;
}

.divider {
  width: 1px;
  height: 60%;
  background-color: #ccc;
  margin: 0 20px;
}

.company-info {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  text-align: right;
}

.company-name {
  font-size: 16px;
  font-weight: bold;
  color: #333;
}

.company-district {
  font-size: 14px;
  color: #555;
}
</style>
