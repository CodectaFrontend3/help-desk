<script>
export default {
  name: "NavBar",
  data() {
    return {
      sekker: true,
    };
  },
  computed: {
    // Obtenemos la configuración del navbar desde la ruta actual
    navbarConfig() {
      return this.$route.meta.navbarConfig || {};
    },
    showButtonsTi() {
      // Solo mostrar los botones en estas rutas (puedes personalizarlas)
      return this.$route.meta.navbarConfig.TiEmpresa === true;
    },
    showButtons() {
      // Solo mostrar los botones en estas rutas (puedes personalizarlas)
      return this.$route.name === 'Yo' || this.$route.meta.navbarConfig.persona === true || this.$route.meta.navbarConfig.clientes === true;
    },
    showAdd() {
      // Solo mostrar los botones en estas rutas (puedes personalizarlas)
      return this.$route.meta.role === 'admin';
    },
    isTicketActive() {
      return this.$route.name === 'Tickets activos';
    }
  }
}
</script>

<template>
  <nav class="search-container">
    <div v-if="showButtons" class="buttons">
      <button :class="{'active': navbarConfig.clientes === true}" title="Seleccionar empresa">Empresa</button>
      <button :class="{'active': navbarConfig.persona === true}" title="Seleccionar persona natural">Persona Natural</button>
    </div>

    <!--Buttons - Soporte TI-->

    <div v-if="showButtonsTi" class="buttons-ti">
      <button :class="{'active': navbarConfig.TiEmpresa === true}" title="Seleccionar empresa">Microempresa</button>
      <button :class="{'active': navbarConfig.clientes === true}" title="Seleccionar empresa">Empresa</button>
      <button :class="{'active': navbarConfig.persona === true}" title="Seleccionar persona natural">Persona Natural</button>
    </div>


    <div class="search">
<!-- Tickets-->
        <div v-if="navbarConfig.tickets" class="tickets-container">
          <div v-if="navbarConfig.labelIncidente" class="seeker seeker__tickets" :class="{'width__sekker': isTicketActive}">
            <label for="empresa">{{ navbarConfig.labelIncidente }}</label>
            <input type="text" title="Buscar empresa" placeholder="Ingrese el incidente">
          </div>
          <div v-if="navbarConfig.labelArea" class="seeker seeker__tickets" :class="{'width__sekker': isTicketActive}">
            <label for="empresa">{{ navbarConfig.labelArea }}</label>
            <select v-if="navbarConfig.labelArea">
              <option disabled selected id="empresa">Elegir área</option>
              <option value="1">Área 1</option>
              <option value="2">Área 2</option>
              <option value="3">Área 3</option>
            </select>
          </div>

          <div v-if="navbarConfig.labelFecha" class="seeker seeker__tickets" :class="{'width__sekker': isTicketActive}">
            <label for="fecha" class="date-label">{{ navbarConfig.labelFecha }}</label>
            <div class="date">
              <input id="date" type="date" title="Fecha de inicio" class="date-input" placeholder="Desde">
              <p class="date-separator">al</p>
              <input type="date" title="Fecha de fin" class="date-input" placeholder="Hasta">
            </div>
          </div>
          <div v-if="navbarConfig.labelEstado" class="seeker seeker__tickets" :class="{'width__sekker': isTicketActive}">
            <label  class="seeker__label" for="empresa">{{ navbarConfig.labelEstado }}</label>
            <div class="select-wrapper">
              <select v-if="navbarConfig.labelEstado" class="seeker__select">
                <option disabled selected id="empresa">Elegir estado del incidente</option>
                <option value="1">Urgente</option>
                <option value="2">Medio</option>
                <option value="3">Tranquilo</option>
              </select>
            </div>
          </div>
        </div>

      <!--CLIENTES - Empresa-->
      <div v-if="navbarConfig.clientes" class="clientes-container">
        <div v-if="navbarConfig.labelRuc" class="seeker seeker__clientes">
          <label title="Buscar RUC" for="ruc">{{ navbarConfig.labelRuc }}</label>
          <input id="ruc" type="number" title="Buscar RUC" placeholder="Ingrese su RUC">
        </div>
        <div v-if="navbarConfig.labelEmpresa" class="seeker seeker__clientes">
          <label for="empresa">{{ navbarConfig.labelEmpresa }}</label>
          <input id="empresa" type="text" title="Buscar empresa" placeholder="Ingrese nombre de la empresa">
        </div>
      </div>

      <!--Clientes - Persona Natural-->
      <div v-if="navbarConfig.persona" class="persona-container">
        <div v-if="navbarConfig.labelDni" class="seeker seeker__clientes">
          <label for="dni">{{ navbarConfig.labelDni }}</label>
          <input id="dni" type="text" title="Buscar empresa" placeholder="Ingrese su DNI">
        </div>
        <div v-if="navbarConfig.labelNombre" class="seeker seeker__clientes">
          <label for="nombre">{{ navbarConfig.labelNombre }}</label>
          <input id="nombre" type="text" title="Buscar empresa" placeholder="Ingrese su nombre">
        </div>
      </div>

<!--Seeker General-->
      <div class="seeker seeker__general" :class="{'width__sekker': this.$route.name === 'Tickets activos'}">
        <input type="text" title="Buscar" placeholder="Search">
        <span class="icon pi pi-search"></span>
      </div>
      <button v-if="showAdd" title="Agregar registro" class="add">
        <span class="pi pi-plus"></span>
        <span>Agregar</span>
      </button>
    </div>




  </nav>
</template>

<style scoped>
.search-container {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
  text-align: center;
  font-weight: 600;
  gap: 20px;
}
.buttons {
  display: flex;
  align-items: center;
  gap: 2px;
  flex: 1;
  height: 100%;
}
.buttons button {
  font-weight: inherit;
  border-radius: 0;
  border: none;
  text-wrap: nowrap;
  padding: 20px 30px;
  background-color: var(--highlight-color);
  transition: .2s ease-in-out;
}
.buttons button:nth-child(1) {
  border-radius: 10px 0 0 10px;
}
.buttons button:nth-child(2) {
  border-radius: 0 10px 10px 0;
}
.buttons button:hover, .search button:hover {
  border: none;
  opacity: .8;
}

/*BUTONS DE LA VISTA SOPORTE TI*/
.buttons-ti {
  display: flex;
  align-items: center;
  gap: 2px;
  height: 100%;
}
.buttons-ti button {
  font-weight: inherit;
  border-radius: 0;
  border: none;
  text-wrap: nowrap;
  padding: 20px 30px;
  background-color: var(--highlight-color);
  transition: .2s ease-in-out;
}
.buttons-ti button:nth-child(1) {
  border-radius: 10px 0 0 10px;
}
.buttons-ti button:nth-child(3) {
  border-radius: 0 10px 10px 0;
}
.buttons-ti button:hover, .search button:hover {
  border: none;
  opacity: .8;
}
/*----------------------------------------*/

.search {
  overflow: auto;
  flex: 2;
  display: flex;
  align-items: end;
  justify-content: end;
  gap: 20px;
  background-color: var(--accent-color);
  border-radius: 15px;
  font-size: 1rem;
  padding: 10px 20px;
  }
  .seeker {
    flex: 1;
  }
select {
  color: #aaaaaa;
}
.seeker input, select {
  flex: 1;
  padding: 10px 12px;
  outline: none;
  border-radius: 10px;
  border: none;
}
.clientes-container, .persona-container {
  display: flex;
  align-items: center;
  gap: 20px ;
  flex: 1;
  height: 100%;
}
.seeker__clientes {
  flex: 1;
  position: relative;
  display: flex;
  align-items: center;
  gap: 10px;
}
.tickets-container {
   flex: 1;
   display: flex;
   gap: 20px;
 }
.search button {
  background: var(--main-color);
  border-radius: 10px;
  color: var(--highlight-color);
  font-weight: inherit;
}

.seeker__tickets {
  display: flex;
  flex-direction: column;
  text-align: left;
  gap: 6px;
}

.seeker__label {
  font-size: 14px;
  color: #333;
  margin-bottom: 8px;
}
.seeker__label:hover {
  cursor: pointer;
}
/* Estilo de la caja del select */
.select-wrapper {
  position: relative;
  width: 100%;
}
.seeker__select {
  padding: 10px 14px;
  font-size: 16px;
  background-color: #f8f8f8;
  color: #333;
  cursor: pointer;
  transition: 0.2s ease-in-out;
}
.seeker__select option {
  font-size: 14px;
  padding: 10px;
  color: #333;
  background-color: #fff;
  transition: .2s ease-in-out;
}
.seeker__select:focus option {
  background-color: #fff;
}
.date-label {
  width: 100%;
  font-size: 16px;
  text-align: left;
  flex: 1;
}
.date {
  display: flex;
  gap: 10px;
  align-items: center;
}
.date-input {
  flex: 1;
  padding: 10px;
  font-size: 14px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 150px;
  background-color: #fff;
  transition: border-color 0.3s ease;
  color: #aaaaaa;
}
.date-input:focus {
  outline: none;
}
p {
  margin: 0;
}
.seeker__general {
  flex: 1;
  position: relative;
  display: flex;
  align-items: center;
  max-width: 600px;
}
.seeker__general input {
  padding: 10px 30px;
 }
.width__sekker {
  max-width: 300px;
}
.icon {
    position: absolute;
    left: 8px;
    color: #aaa;
  }
.add {
  padding: 6px 16px;
  font-size: 1rem;
  display: flex;
  align-items: center;
  gap: 6px;
  transition: .2s ease-in-out;
}
.buttons .active {
  background-color: var(--accent-color); /* Cambia el color según lo que desees */
}
.buttons-ti .active {
  background-color: var(--accent-color); /* Cambia el color según lo que desees */
}
</style>