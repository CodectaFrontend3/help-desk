<template>
    <div class="title-container">
        <i class="pi pi-home title-icon"></i>
        <h1>{{ $route.name }}</h1>
        <div class="divider"></div>
        <div class="company-info">
            <span class="company-name">Mi Empresa</span>
            <span class="company-district">Distrito XYZ</span>
        </div>
    </div>
</template>
  
<script>
  export default {
    props: {
      title: {
        type: String,
        required: true
      }
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