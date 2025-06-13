<template>
    <div class="another-page">
      <!-- Botón que abre el modal -->
      <Button class="open-dialog-btn" label="Mostrar Modal" icon="pi pi-user" @click="openDialog" />
  
      <!-- El Dialog se muestra cuando `visible` es true -->
      <Dialog v-model:visible="visible" header="REGISTRAR CLIENTE" class="custom-dialog" :closable="false" :style="{ width: '900px', maxHeight: '550px', backgroundColor: 'white' }">
        <template #header>
          <div class="custom-dialog-header">
            <span>Registrar Agregar Plan de Soporte</span>
            <button class="close-dialog-btn" @click="closeDialog">✖</button>
          </div>
        </template>
  
        <!-- ButtonGroup con botones dinámicos -->
        <ButtonGroup :buttons="buttonData" @updateView="updateCurrentView" />
  
        <!-- Formulario -->
        <FormGroup label="Nombre:" placeholder="Nombre" />
        <FormGroup label="Descripción:" placeholder="..." />
  
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
      name: 'agregarplan',
      components: {
        Dialog,
        ButtonGroup,
        FormGroup,
        Button,
      },
      data() {
        return {
          buttonData: [],
          visible: false,
          currentView: '',
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
  /* Forzar fondo blanco para Dialog y aplicar borde redondeado */
  :deep(.p-dialog) {
    background-color: white !important;
    border-radius: 25px;
    padding: 20px;
  }
  
  /* Encabezado personalizado del diálogo */
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
  
  /* Botón "X" para cerrar */
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
  
  /* Botón inferior "Volver" */
  .close-btn {
    background-color: #ffcb87;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 15px;
  }
  
  .close-btn:hover {
    background-color: #ffb049;
  }
  
  /* Botón para abrir el modal */
  .open-dialog-btn {
    margin-top: 20px;
  }
  </style>
  