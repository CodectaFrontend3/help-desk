<template>
  <div class="container">
    <div class="icon">
      <img :src="iconSrc" alt="Icono" width="50" height="50">
    </div>
    <h1>{{ titulo }}</h1>
    <div class="separator">
      <div class="company-info">
        <p>{{ empresa }}</p>
        <p>{{ direccion }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    titulo: {
      type: String,
      required: true
    },
    iconSrc: {
      type: String,
      default: "" // Aquí puedes poner una URL por defecto si no hay imagen
    },
    empresa: {
      type: String,
      required: true
    },
    direccion: {
      type: String,
      required: true
    }
  }
};
</script>

<style scoped>
body {
  background-color: rgb(151, 151, 151);
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
}

.container {
  background-color: white;
  border-radius: 16px;
  width: 1572px;
  height: 111px;
  position: absolute;
  top: 83px;
  left: 288px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  text-align: center;
  box-shadow: 2px 2px 10px rgba(255, 255, 255, 0.2);
  padding: 0 20px;
}

.container h1 {
  font-family: 'Inter', sans-serif;
  font-weight: 800;
  font-size: 36px;
  line-height: 100%;
  letter-spacing: 0;
  color: black;
  text-align: left;
  margin: 0;
}

.icon {
  margin-right: 10px;
}

.separator {
  display: flex;
  align-items: center;
}

.separator::before {
  content: "";
  width: 1px;
  height: 50px;
  background-color: black;
  margin-right: 20px;
}

.company-info {
  text-align: left;
}

.company-info p {
  margin: 0;
}
</style>
