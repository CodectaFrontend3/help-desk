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
        style="width:1000px;height: 600px; background-color: #D9D9D9; border-radius: 15px;"
      >
        <template #header>
          <div class="custom-dialog-header">
            <span>Registrar Cliente</span>
            <button class="close-dialog-btn" @click="closeDialog">✖</button>
          </div>
        </template>

        <!-- Botones dinámicos -->
        <ButtonGroup :buttons="buttonData" @updateView="updateCurrentView" />

        <!-- Sección: Empresa -->
        <div v-if="currentView === 'empresa'" class="form-section empresa-grid">
            <div class="empresa-item">
              <label>Nombre Empresa:</label>
              <input type="text" placeholder="Ej. Corporación ABC S.A." />
            </div>

            <div class="empresa-item">
              <label>RUC:</label>
              <input type="text" placeholder="12345678901" />
            </div>

            <div class="empresa-item">
              <label>Dirección:</label>
              <input type="text" placeholder="Ej. Calle Falsa 123" />
            </div>

          <!-- Título para la tabla de contactos -->
          <div class="table-title">
            <h3>Empresa</h3>
          </div>

          <!-- Tabla: Contactos de referencia -->
          <div class="table-container_empresa">
            <table>
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Dirección</th>
                  <th>Correo</th>
                  <th>Teléfono</th>
                  <th>Cargo</th>
                  <th>Seleccionar</th> <!-- Checkbox -->
                </tr>
              </thead>
              <tbody>
                <tr v-for="(row, rowIndex) in rows" :key="'row-' + rowIndex">
                  <td>{{ row[0] }}</td>
                  <td>{{ row[1] }}</td>
                  <td>{{ row[2] }}</td>
                  <td>{{ row[3] }}</td>
                  <td>{{ row[4] }}</td>
                  <td><input type="checkbox" v-model="row[5]" /></td> <!-- Checkbox -->
                </tr>
              </tbody>
            </table>
          </div>
        </div>

              <!-- Sección: Contacto -->
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
                  <th>Agregar</th>

                </tr>
              </thead>
              <tbody>
                <tr v-for="(contacto, index) in contactos" :key="'contacto-' + index">
                  <td>{{ contacto.nombre }}</td>
                  <td>{{ contacto.direccion }}</td>
                  <td>{{ contacto.correo }}</td>
                  <td>{{ contacto.telefono }}</td>
                  <td>{{ contacto.cargo }}</td>
                  <td><Button icon="pi pi-plus" @click="addContactoRow" /></td>
                  <td><input type="checkbox" v-model="contacto.seleccionado" /></td>
                  <td><Button icon="pi pi-pencil" class="p-button-text" @click="editContacto(index)" /></td>
                  <td><Button icon="pi pi-trash" class="p-button-text" @click="deleteContacto(index)" /></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Sección: Sucursal -->
        <div v-if="currentView === 'sucursal'" class="form-section">
          <h3>Sucursal</h3>
          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th>Sucursal</th>
                  <th>Dirección</th>
                  <th>Contacto</th>
                  <th>Teléfono</th>
                  <th>Correo</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(sucursal, index) in sucursales" :key="'sucursal-' + index">
                  <td>{{ sucursal.nombre }}</td>
                  <td>{{ sucursal.direccion }}</td>
                  <td>{{ sucursal.contacto }}</td>
                  <td>{{ sucursal.telefono }}</td>
                  <td>{{ sucursal.correo }}</td>
                  <td><Button icon="pi pi-plus" @click="addSucursalRow" /></td>
                  <td><Button icon="pi pi-eye" class="p-button-text" @click="viewSucursal(index)" /></td>
                  <td><Button icon="pi pi-pencil" class="p-button-text" @click="editSucursal(index)" /></td>
                  <td><Button icon="pi pi-trash" class="p-button-text" @click="deleteSucursal(index)" /></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>


        <!-- Sección: Datos de Acceso -->
        <div v-if="currentView === 'acceso'" class="form-section acceso-grid">
          <div class="acceso-item">
            <label for="email">Modificar Correo electrónico:</label>
            <input id="email" type="email" placeholder="Correo Electrónico" />
          </div>

          <div class="acceso-item">
            <label for="password">Modificar Contraseña:</label>
            <input id="password" type="password" placeholder="********" />
          </div>

          <div class="acceso-item">
            <label for="confirm-password">Confirmar modificación de contraseña:</label>
            <input id="confirm-password" type="password" placeholder="********" />
          </div>
        </div>

        <!-- Botón de cierre -->
        <button class="close-btn" @click="closeDialog">Volver</button>
      </Dialog>
    </div>
  </template>

  <script>
  import Dialog from 'primevue/dialog';
  import Button from 'primevue/button';
  import ButtonGroup from '../Formulario/Assets/ButtonGroup.vue';

  export default {
    name: 'Tiregistrarcc',
    components: {
      Dialog,
      Button,
      ButtonGroup,
    },
    data() {
      return {
        visible: false,
        currentView: 'empresa',
        buttonData: [
          { label: 'Empresa', value: 'empresa' },
          { label: 'Contacto', value: 'contacto' },
          { label: 'Sucursal', value: 'sucursal' },
          { label: 'Datos de acceso', value: 'acceso' },
        ],
        rows: [
          ['Juan Pérez', 'Calle Falsa 123', 'juan@example.com', '555-1234', 'Gerente', false],
          ['Ana Gómez', 'Avenida Siempre Viva 742', 'ana@example.com', '555-5678', 'Secretaria', false],
          ['Carlos Rodríguez', 'Jr. Los Olivos 456', 'carlos@example.com', '555-9012', 'Contador', false],
          ['María Sánchez', 'Av. Principal 789', 'maria@example.com', '555-3456', 'Asistente', false],
        ],
        contactos: [
          { nombre: 'Luis Torres', direccion: 'Av. Las Palmeras 123', correo: 'luis@example.com', telefono: '555-7890', cargo: 'Director', seleccionado: false },
          { nombre: 'Diana Vargas', direccion: 'Calle Los Pinos 456', correo: 'diana@example.com', telefono: '555-2345', cargo: 'Gerente', seleccionado: false },
          { nombre: 'Roberto Díaz', direccion: 'Jr. Huallaga 789', correo: 'roberto@example.com', telefono: '555-6789', cargo: 'Supervisor', seleccionado: false },
          { nombre: 'Patricia Lima', direccion: 'Av. Arequipa 1010', correo: 'patricia@example.com', telefono: '555-0123', cargo: 'Coordinadora', seleccionado: false },
        ],
        sucursales: [
          { nombre: 'Sede Central', direccion: 'Av. Javier Prado 2000', contacto: 'Fernando Gomez', telefono: '555-4567', correo: 'central@example.com' },
          { nombre: 'Sucursal Norte', direccion: 'Av. Industrial 540', contacto: 'Carmen Velásquez', telefono: '555-8901', correo: 'norte@example.com' },
          { nombre: 'Sucursal Sur', direccion: 'Av. Benavides 1500', contacto: 'Javier Molina', telefono: '555-2345', correo: 'sur@example.com' },
          { nombre: 'Sucursal Este', direccion: 'Av. La Molina 300', contacto: 'Laura Figueroa', telefono: '555-6789', correo: 'este@example.com' },
        ],
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
      },
      addContactRow() {
        this.rows.push(['', '', '', '', '', false]);
      },
      addContactoRow() {
        this.contactos.push({ nombre: '', direccion: '', correo: '', telefono: '', cargo: '', seleccionado: false });
      },
      editContacto(index) {
        // Implementación de edición de contacto
        console.log('Editando contacto:', this.contactos[index]);
      },
      deleteContacto(index) {
        this.contactos.splice(index, 1);
      },
      addSucursalRow() {
        this.sucursales.push({ nombre: '', direccion: '', contacto: '', telefono: '', correo: '' });
      },
      viewSucursal(index) {
        // Implementación para visualizar una sucursal
        console.log('Visualizando sucursal:', this.sucursales[index]);
      },
      editSucursal(index) {
        // Implementación de edición de sucursal
        console.log('Editando sucursal:', this.sucursales[index]);
      },
      deleteSucursal(index) {
        this.sucursales.splice(index, 1);
      },
    },
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
    background-color: #FFE6C2;
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
    color: rgb(104, 104, 104);
    cursor: pointer;
  }

  .close-dialog-btn:hover {
    color: #ff0000;
  }

  /* Estilo para el título de la tabla */
  .table-title {
    width: 100%;
    margin: 30px 0 10px 0;
    text-align: left;
  }

  .table-title h3 {
    font-size: 18px;
    color: #333;
    margin: 0;
    padding: 0 0 5px 5px;
    border-bottom: 2px solid #ffcb87;
  }

  .table-container_empresa {
    display: flex;
    overflow-x: auto;
    width: 100%;
    position: relative;
    margin-top: 10px;
  }

  .table-container_empresa table {
    width: 100%;
    border-collapse: collapse;
    margin: 0 auto;
  }

  .table-container_empresa th,
  .table-container_empresa td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
    font-size: 14px;
    background-color: #fff;
  }

  .table-container_empresa th {
    background-color: #ffcb87;
    color: #333;
  }

  .table-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    overflow-x: auto;
    width: 100%;
    position: relative;
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
    background-color: #FF9602;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    width: 10%;
    position : absolute;
    bottom: 20px;
    margin-left: 20px;
  }

  .close-btn:hover {
    background-color: #ffb049;
  }

  .form-section {
    margin-top: 20px;
    font-size: 15px;
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

  .empresa-grid {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-top: 20px;
    flex-wrap: wrap;
  }

  .empresa-form {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .empresa-item {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-width: 200px;
    max-width: 300px;
  }

  .empresa-item label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
  }

  .empresa-item input {
    padding: 10px;
    border: none;
    border-radius: 8px;
    background-color: #ffeecc;
    font-size: 14px;
  }

  .acceso-grid {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-top: 20px;
    flex-wrap: wrap;
  }

  .acceso-item {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-width: 200px;
    max-width: 300px;
  }

  .acceso-item label {
    font-weight: bold;
    margin-bottom: 8px;
  }

  .acceso-item input {
    padding: 10px;
    border: none;
    border-radius: 8px;
    background-color: #ffeecc;
    font-size: 14px;
  }
  </style>
