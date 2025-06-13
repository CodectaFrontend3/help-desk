<template>
  <div class="another-page">
    <!-- Botón que abre el modal -->
    <Button class="open-dialog-btn" label="Mostrar Modal" icon="pi pi-user" @click="openDialog" />

    <!-- Dialog con encabezado personalizado -->
    <Dialog
      v-model:visible="visible"
      header="REGISTRAR CLIENTE"
      class="custom-dialog"
      :closable="false"
      style="width:1000px; background-color: aliceblue; border-radius: 15px;"
    >
      <template #header>
        <div class="custom-dialog-header">
          <span>Registrar Cliente</span>
          <button class="close-dialog-btn" @click="closeDialog">✖</button>
        </div>
      </template>

      <!-- Botones dinámicos -->
      <ButtonGroup :buttons="buttonData" @updateView="updateCurrentView" />

      <!-- Vistas dinámicas -->
      <div v-if="currentView === 'datospersonales'" class="form-section">
        <h3>Datos Personales</h3>
        <form>
          <label>Nombre Completo:</label>
          <input type="text" placeholder="Ej. Juan Pérez" />

          <label>DNI:</label>
          <input type="text" placeholder="12345678" />

          <label>Fecha de Nacimiento:</label>
          <input type="date" />
        </form>
      </div>

      <div v-if="currentView === 'contacto'" class="form-section">
        <h3>Contacto</h3>
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Cargo</th>
                <th><button style="font-size: 15px;">+</button></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row, rowIndex) in rows" :key="'row-' + rowIndex">
                <td v-for="(cell, colIndex) in row" :key="'cell-' + rowIndex + '-' + colIndex">
                  <template v-if="colIndex === 5">
                    <input type="checkbox" v-model="row[colIndex]" />
                  </template>
                  <template v-else>
                    {{ cell }}
                  </template>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div v-if="currentView === 'acceso'" class="form-section">
        <h3>Datos de Acceso</h3>
        <form>
          <label>Correo Electrónico:</label>
          <input type="email" placeholder="correo@ejemplo.com" />

          <label>Nombre de Usuario:</label>
          <input type="text" placeholder="usuario123" />

          <label>Contraseña:</label>
          <input type="password" />
        </form>
      </div>

      <!-- Botón de cierre -->
      <button class="close-btn" @click="closeDialog">Volver</button>
    </Dialog>
  </div>
</template>

<script>
import Dialog from 'primevue/dialog';
import ButtonGroup from '../Formulario/Assets/ButtonGroup.vue';
import FormGroup from '../Formulario/Assets/FormGroup.vue';
import Button from 'primevue/button';
export default {
  name: 'tiregistrarcc',
  components: {
    Dialog,
    ButtonGroup,
    Button,
  },
  data() {
    return {
      buttonData: [
        { label: 'Datos Personales', value: 'datospersonales' },
        { label: 'Contacto', value: 'contacto' },
        { label: 'Datos de acceso', value: 'acceso' }
      ],
      visible: false,
      currentView: 'datospersonales',
      rows: [
        ['Juan Pérez', 'Calle Falsa 123', 'juan@example.com', '555-1234', 'Gerente', false],
        ['Ana Gómez', 'Avenida Siempre Viva 742', 'ana@example.com', '555-5678', 'Secretaria', false],
        ['Carlos López', 'Calle Real 456', 'carlos@example.com', '555-8765', 'Vendedor', false],
        ['María Díaz', 'Avenida Central 789', 'maria@example.com', '555-4321', 'Supervisor', false]
      ]
    };
  },
  methods: {
    openDialog() {
      this.visible = true;
    },
    closeDialog() {
      this.visible = false;
    },
    updateCurrentView(view) {
      this.currentView = view;
      console.log(`Vista seleccionada: ${this.currentView}`);
    }
  }
};
</script>

<style scoped>
.another-page {
  padding: 20px;
}

.open-dialog-btn {
  margin-top: 20px;
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
  position: relative;
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

.table-container {
  margin-top: 20px;
  overflow-x: auto;
}

.table-container table {
  width: 90%;
  border-collapse: collapse;
  margin: 0 auto;
}

.table-container th,
.table-container td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: center;
  font-size: 14px;
  background-color: #fff;
}

.table-container th {
  background-color: #ffcb87;
  color: #333;
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
  margin-left: 15px;
  margin-right: 15px;
  margin-bottom: 15px;
}

.close-btn:hover {
  background-color: #ffb049;
}

.form-section {
  margin-top: 20px;
  padding: 0 30px;
}

.form-section form {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.form-section input {
  padding: 8px;
  font-size: 14px;
  border-radius: 5px;
  border: 1px solid #ccc;
}
</style>
