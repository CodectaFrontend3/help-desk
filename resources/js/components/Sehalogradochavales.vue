<template>
  <div class="container">
    <Button class="open-dialog-btn" label="SHOP" icon="pi pi-user" @click="currentView = 'register' " />
    <div v-if="currentView === 'register'" class="overlay"></div>

  <div class="container">
    <Dialog v-if="currentView === 'register'" v-model:visible="clientregister" header="REGISTRAR CLIENTE" class="custom-dialog"
            style="background-color: white; border-radius: 15px; padding-left: 0px; padding-right: 0px; width: 900px; max-height: 550px; "
            :closable="false">
      <template #header>
        <div class="custom-dialog-header">
          <span>Registrar Cliente</span>
          <button class="close-dialog-btn" @click="clientregister = false; currentView= ''">
            ✖
          </button>

        </div>
      </template>
      <div class="button-group">
        <button>Empresa</button>
        <button>Contacto</button>
        <button @click="currentView = 'shop'">Sucursal</button>
        <button>Datos de acceso</button>
      </div>
      <div class="form-group">
        <label class="subtitulo">Nombre empresa:</label>
        <input  type="text" placeholder="Nombre empresa">
      </div>
      <div class="form-group">
        <label class="subtitulo">RUC:</label>
        <input  type="text" placeholder="RUC">
      </div>
      <div class="form-group">
        <label class="subtitulo">Dirección:</label>
        <input  type="text" placeholder="Dirección">
      </div>
      <div class="form-group">
        <label class="subtitulo">Plan:</label>
        <input  type="text" placeholder="Plan">
      </div>
      <button class="close-btn">Volver</button>
    </Dialog>
  </div>
  </div>
</template>

<script>
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';

export default {
  name: 'Yo',
  components: {
    Dialog,
    Button,
  },
  data() {
    return {
      clientregister: true,
      currentView: '',
    };
  },
};
</script>

<style scoped>
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5); /* Gray overlay with transparency */
  z-index: 999; /* Ensure it is on top of other content */
}
.custom-dialog-header {
  background-color: #ffcb87;
  color: black;
  font-size: 25px;
  text-align: center;
  font-weight: bold;
  padding: 10px;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative; /* Para que la "X" se posicione sobre él */
  border-radius: 15px 15px 0 0;

}

.close-dialog-btn {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  font-size: 20px;
  color: white;
  cursor: pointer;
}

.close-dialog-btn:hover {
  color: #ff0000;
}


.container {
  display: flex;
  justify-content: center;
  margin-bottom: 1rem;
}

.open-dialog-btn {
  background-color: #ffcb87;
  color: white;
  border-radius: 5px;
  padding: 10px 15px;
}

.custom-dialog {
  padding: 20px !important;
  background-color: rgb(255, 255, 255);
  border: 3px solid #007ad9 !important;
  border-radius: 15px !important; /* Aumentado para mayor redondez */
  overflow: hidden !important; /* Evita que el contenido sobresalga */

}


.close-btn {
  background-color: #ffcb87;
  color: white;
  padding: 10px 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 15px;
  width: 10%;
  margin-left:15px;
  margin-right:15px;
  margin-bottom: 15px;
}

.close-btn:hover {
  background-color: #ffb049;
}

.button-group {
  display: flex;
  justify-content: space-between;
  gap: 30px;
  margin-top: 15px;
  margin-left:15px;
  margin-right:15px;

}

.button-group button {
  flex: 1;
  background-color: #ffcb87;
  color: rgb(46, 46, 46);
  padding: 8px 10px;
  border-radius: 5px;
  border: none;
  cursor: pointer;
  font-size: 13px;
}

.button-group button:hover {
  background-color: #ffb049;
}

.subtitulo{
  margin-left:15px;
  margin-right:15px;
  font-size: 15px;
}


.icon-btn {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 18px;
  margin-right: 5px;
}

.icon-btn:hover {
  color: #007ad9;
}

.icon-btn.delete {
  color: red;
}

.icon-btn.delete:hover {
  color: darkred;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-top: 10px;
  font-size: 20px;
}

.form-group label {
  font-weight: bold;
}

.form-group input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 95%;
  margin-left:15px;
  margin-right:15px;
  margin-bottom: 15px;
  font-size: 12px;
}

.dialog-content {
  padding: 10px;
}
</style>
