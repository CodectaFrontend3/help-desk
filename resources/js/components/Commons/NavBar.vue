<template>
    <nav class="search-container">
        <div v-if="showButtons" class="buttons">
            <button
                :class="{ active: isActive('companies') }"
                title="Seleccionar empresa"
                @click="navigateToAdminChildren('companies')"
            >
                Empresa
            </button>
            <button
                :class="{ active: isActive('natural-person') }"
                title="Seleccionar persona natural"
                @click="navigateToAdminChildren('natural-person')"
            >
                Persona Natural
            </button>
        </div>

        <!--Buttons - Soporte TI-->

        <div v-if="showButtonsTi" class="buttons-ti">
            <button
                :class="{ active: isActive('company') }"
                title="Seleccionar empresa"
                @click="navigateToChildren(dynamicSegment('company'))"
            >
                Empresa
            </button>
            <button
                :class="{ active: isActive('person') }"
                title="Seleccionar persona natural"
                @click="navigateToChildren(dynamicSegment('person'))"
            >
                Persona Natural
            </button>
        </div>

        <div class="search">
            <!-- Tickets-->
            <div v-if="navbarConfig.tickets" class="tickets-container">
                <!-- Incidente-->
                <div v-if="navbarConfig.labelIncidente" class="seeker seeker__tickets" :class="{ width__sekker: isTicketActive }">
                    <label for="empresa">{{ navbarConfig.labelIncidente }}</label>
                    <input type="text" v-model="ticketIncidente" title="Buscar empresa" placeholder="Ingrese el incidente"/>
                </div>
                <!-- Área-->
                <div v-if="navbarConfig.labelArea" class="seeker seeker__tickets" :class="{ width__sekker: isTicketActive }">
                    <label for="empresa">{{ navbarConfig.labelArea }}</label>
                    <select v-if="navbarConfig.labelArea" v-model="ticketArea">
                        <option disabled selected id="empresa">
                            Elegir área
                        </option>
                        <option value="1">Área 1</option>
                        <option value="2">Área 2</option>
                        <option value="3">Área 3</option>
                    </select>
                </div>
                <!-- Fechas -->
                <div v-if="navbarConfig.labelFecha" class="seeker seeker__tickets" :class="{ width__sekker: isTicketActive }">
                    <label for="fecha" class="date-label">{{ navbarConfig.labelFecha }}</label>
                    <div class="date">
                          <VueDatePicker
                                v-model="range"
                                range
                                :multi-calendars="{ count: 2, solo: true }"
                                :format="'yyyy-MM-dd'"
                                class="date-input"
                                id="date"

                            />
                        <!-- <input id="date" type="date" title="Fecha de inicio" v-model="ticketFechaInicio" class="date-input" placeholder="Desde"/>
                        <p class="date-separator">al</p>
                        <input type="date" title="Fecha de fin" class="date-input" v-model="ticketFechaFin" placeholder="Hasta"/> -->
                    </div>
                </div>
                <!-- Estado-->
                <div v-if="navbarConfig.labelEstado" class="seeker seeker__tickets" :class="{ width__sekker: isTicketActive }">
                    <label class="seeker__label" for="empresa">{{ navbarConfig.labelEstado }}</label>
                    <div class="select-wrapper">
                        <select v-if="navbarConfig.labelEstado" class="seeker__select" v-model="ticketEstado">
                            <option disabled selected id="empresa">
                                Elegir estado del incidente
                            </option>
                            <option value="1">Urgente</option>
                            <option value="2">Medio</option>
                            <option value="3">Tranquilo</option>
                        </select>
                    </div>
                </div>
            </div>

            <!--CLIENTES - Empresa-->
            <div v-if="navbarConfig.clientes || navbarConfig.clientCompany" class="clientes-container">
                <div
                    v-if="navbarConfig.labelRuc"
                    class="seeker seeker__clientes"
                >
                    <label title="Buscar RUC" for="ruc">{{
                        navbarConfig.labelRuc
                    }}</label>
                    <input
                    id="ruc"
                    type="text"
                    v-model="searchTermRuc"
                    @input="activarBusquedaRuc"
                    :disabled="searchTermCompany.length > 0 || searchTerm.length > 0"
                    placeholder="Ingrese su RUC"
                    />
                </div>
                <div
                    v-if="navbarConfig.labelEmpresa"
                    class="seeker seeker__clientes"
                >
                    <label for="empresa">{{ navbarConfig.labelEmpresa }}</label>
                    <!--quitable el :disabled-->
                    <input
                    id="empresa"
                    type="text"
                    title="Buscar empresa"
                    v-model="searchTermCompany"
                    @input="activarBusquedaNombre"
                    :disabled="searchTerm.length > 0 || searchTermRuc.length > 0"
                    placeholder="Ingrese nombre de la empresa"
                    />
                </div>
            </div>

            <!--Clientes - Persona Natural-->
            <div v-if="navbarConfig.persona || navbarConfig.clientPerson" class="persona-container">
                <div
                    v-if="navbarConfig.labelDni"
                    class="seeker seeker__clientes"
                >
                    <label for="dni">{{ navbarConfig.labelDni }}</label>
                    <input
                        id="dni"
                        type="text"
                        v-model="searchTermDni"
                        @input="activarBusquedaDni"
                        :disabled="searchTerm.length > 0 || searchTermNombre.length > 0"
                        placeholder="Ingrese DNI"
                        />
                </div>
                <div
                    v-if="navbarConfig.labelNombre"
                    class="seeker seeker__clientes"
                >
                    <label for="nombre">{{ navbarConfig.labelNombre }}</label>
                    <input
                        id="nombre"
                        type="text"
                        title="Buscar por nombre de persona"
                        v-model="searchTermNombre"
                        @input="activarBusquedaNombrePersona"
                        :disabled="searchTerm.length > 0 || searchTermDni.length > 0"
                        placeholder="Ingrese su nombre"
                    />
                </div>
            </div>

            <!-- SOPORTE TI -->
            <div v-if="navbarConfig.soporteTi" class="soporte-container">
                <!-- RUC -->
                <div v-if="navbarConfig.ruc" class="seeker seeker__soporte" :class="{ width__sekker: isTicketActive }">
                    <label for="soporte-ruc">{{ navbarConfig.ruc }}</label>
                    <input id="soporte-ruc" type="text" title="Buscar empresa" placeholder="Ingrese el RUC" />
                </div>
                <!-- EMPRESA -->
                <div v-if="navbarConfig.company" class="seeker seeker__soporte" :class="{ width__sekker: isTicketActive }">
                    <label for="soporte-ruc">{{ navbarConfig.company }}</label>
                    <input id="soporte-ruc" type="text" title="Buscar empresa" placeholder="Ingrese el nombre de la empresa"/>
                </div>
            </div>

            <div v-if="navbarConfig.equipment" class="seeker seeker__equipment" :class="{ width__sekker: isTicketActive }">
                <label for="dateRange" class="dateRange__label">{{ navbarConfig.dateRange }}:</label>
                <div class="date">
                    <input id="dateRange" type="date" title="Fecha de inicio" class="date-input" placeholder="Desde"/>
                    <p class="date-separator">al</p>
                    <input type="date" title="Fecha de fin" class="date-input" placeholder="Hasta"/>
                </div>
            </div>

            <!--Seeker General-->
            <div class="seeker seeker__general" :class="{ width__sekker: this.$route.name === 'Tickets activos',}">
                    <!--quitable el disabled-->
                    <input
                    v-model="searchTerm"
                    @input="activarBusquedaGeneral"
                    :disabled="searchTermCompany.length > 0 || searchTermRuc.length > 0|| searchTermNombre.length > 0 || searchTermDni.length > 0"
                    placeholder="Buscar..."
                    />
                <span class="icon pi pi-search"></span>

            </div>

            <button v-if="showAdd" title="Agregar registro" class="add">
                <span class="pi pi-plus"></span>
                <span>Agregar</span>
            </button>

        </div>
        <div>
        <ProductSearch
            :searchTerm="searchTerm"
            :resultadosBusqueda="resultadosBusqueda"
            :productos="productos"
            :startDate="startDate"
            :endDate="endDate"
        /></div>
    </nav>
</template>
<script>
import axios from 'axios';
import ProductSearch from '../Tabla/iftura.vue'

import { ref } from 'vue'
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'


export default {

    name: "NavBar",
    props: {

    },
    components:{
        ProductSearch,
        VueDatePicker,
    },
    data() {

        return {
            searchTermCompany: '',      // para buscar sólo por compañia
            searchTermRuc: '', // para buscar por RUC
            searchTerm: '',
            searchTermNombre: '',
            searchTermDni: '',
            isCompanySearchDisabled: false, //
            isGeneralSearchDisabled: false, //
            isRucSearchDisabled: false, //
            sekker: true, // Probablemente una bandera para controlar el estado de algo en la barra de navegación (nombre no muy descriptivo)
            searchQuery: '',
            cliente: [],
            //buscar
            range: [],
            resultadosBusqueda: [],
            productos: [],
            ticketIncidente: '',
            ticketArea: '',
            ticketEstado: '',
    startDate: null,
    endDate: null,
        };
    },
    mounted() {

      let endpoint = '';

        // Puedes ajustar esto según las rutas de tu router
        const currentPath = this.$route.path;

        if (currentPath.includes('/natural-person')) {
            endpoint = '/api/natural-person'; // ejemplo para vista de clientes
        } else if (currentPath.includes('/company')) {
            endpoint = '/api/company'; // ejemplo para vista de empresas
        } else if (currentPath.includes('/soporte-ti')) {
            endpoint = '/api/soporte-clientes'; // ejemplo para soporte técnico
        } else {
            endpoint = '/api/clientes'; // por defecto
        }

        axios.get(endpoint)
            .then(response => {
            this.cliente = response.data;
            })
            .catch(error => {
            console.error('Error al cargar datos:', error);
            });

        this.cargarProductos()
    },
    computed: {
        entityType() {
        const routeName = this.$route.name;
        if (routeName === "Clientes - Persona natural") return "natural-person";
        if (routeName === "Clientes - Empresa - Administrador") return "company";
        if (routeName === "Clientes - Persona Natural - Soporte TI") return "natural-person";
        if (routeName === "Soporte técnico - Soporte TI") return "plan";
        if (routeName === "Soporte técnico - Administrador") return "plandmin";
        if (routeName === "Administrador - Tickets") return "plan";
        return "company";
        },
        apiBaseUrl() {
        // Devuelve la ruta base de la API según el tipo de entidad
        const map = {
            "natural-person": "/api/natural-person",
            "company": "/api/company",
            "plan": "/api/plan",
            "plandmin": "/api/plan",
            "admintickets": "/api/ticket"
        };
        return map[this.entityType] || "/api/company";
        },

        // Obtiene la configuración del navbar desde los metadatos de la ruta actual
        navbarConfig() {
            return this.$route.meta.navbarConfig || {};
        },

        // Muestra los botones relacionados con soporte TI si alguno de los flags en el meta de la ruta está activo
        showButtonsTi() {
            const config = this.$route.meta?.navbarConfig;
            return (
                config?.TiEmpresa === true ||
                config?.companySoporteTi === true ||
                config?.clientsSoporteTi === true ||
                config?.companyEquipment === true
            );
        },

        // Muestra botones si los metadatos de la ruta indican que estamos viendo personas o clientes
        showButtons() {
            const config = this.$route.meta?.navbarConfig;
            return config?.persona === true || config?.clientes === true;
        },

        // Solo muestra el botón "Agregar" si el usuario tiene el rol de "admin"
        showAdd() {
            return this.$route.meta?.role === "admin"|| this.$route.meta?.role === "manager" || this.$route.meta?.role === "worker";
        },

        // Verifica si estamos en una ruta de tickets activos o soporte técnico TI
        isTicketActive() {
            return (
                this.$route.name === "Tickets activos" || this.$route.name === "Soporte técnico - Soporte TI"
            );
        },
        datosFiltrados() {
            if (!this.searchQuery) return this.cliente;

            return this.cliente.filter(obj =>
            Object.values(obj).some(valor =>
                String(valor).toLowerCase().includes(this.searchQuery.toLowerCase())
            )
            );
        },
    },
    methods: {
        //buscar
        async buscarProductos() {
        if (!this.searchTerm) return;

        try {
            const response = await axios.get(`${this.apiBaseUrl}/buscar`, {
            params: { query: this.searchTerm },
            });
            this.resultadosBusqueda = response.data;
        } catch (error) {
            console.error('Error en la búsqueda:', error);
        }
        },
        async cargarProductos() {
        try {
            const res = await axios.get(this.apiBaseUrl)
            this.productos = res.data
        } catch (err) {
            console.error('Error al cargar:', err)
        }
        },
        //GRACIAS A ESTO LA BARRA DE BUSQUEDA FUNCIONA, NO LE MUEVAN PLOX :V
        async onInputBuscar(tipo = 'general') {
        let query = '';
        if (tipo === 'nombre') query = this.searchTermCompany;
        else if (tipo === 'ruc') query = this.searchTermRuc;
        else if (tipo === 'dni') query = this.searchTermDni;
        else if (tipo === 'nombrePersona') query = this.searchTermNombre;
        else query = this.searchTerm;

        console.log('Buscando con:', { query, tipo });
        if (this.range && this.range.length === 2) {
            const [start, end] = this.range;
            params.start_date = start.toISOString().split('T')[0];
            params.end_date = end.toISOString().split('T')[0];
        }
        if (!query && !params.start_date) {
            this.productos = await axios.get(this.apiBaseUrl).then(r => r.data);
            this.resultadosBusqueda = [];
            return;
        }

        try {
            const response = await axios.get(`${this.apiBaseUrl}/buscar`, {
            params: { query, tipo },
            });
            console.log('Resultados recibidos:', response.data);
            this.resultadosBusqueda = response.data;
        } catch (error) {
            console.error('Error en la búsqueda:', error);
        }
        },
        /**
         * Determina el tipo de entidad actualmente activa según la URL.
         * Retorna: "company", "person" o un tipo extraído de la URL si estamos en equipos.
         */
        currentType() {
            const path = this.$route.path;
            if (
                path.includes("company-company") ||
                path.includes("clients-company")
            )
                return "company";
            if (
                path.includes("company-person") ||
                path.includes("clients-person")
            )
                return "person";

            // Si estamos en la ruta de equipos, extrae el tipo del cuarto segmento de la URL
            if (path.includes("company-equipment")) {
                const pathParts = path.split("/");
                const typeIndex = pathParts.length > 3 ? 3 : 0;
                return pathParts[typeIndex] || "company";
            }

            return null;
        },

        /**
         * Determina la ruta base desde la cual se navega según el contexto actual.
         * Se utiliza para construir rutas hijas más adelante.
         */
        getBaseRoute() {
            // Si estamos en rutas de clientes
            if (
                this.$route.path.includes("clients-soporte-ti") ||
                this.$route.path.includes("clients-company") ||
                this.$route.path.includes("clients-person")
            ) {
                return "/clients-soporte-ti";
            }

            // Si estamos en rutas de equipos
            if (
                this.$route.path.includes("company-equipment") ||
                this.$route.path.includes("equipment-details")
            ) {
                return "/company-soporte-ti";
            }

            // Buscar una ruta padre con hijos
            const parentRoute = this.$route.matched
                .slice()
                .reverse()
                .find((r) => r.children && r.children.length > 0);

            if (!parentRoute) {
                console.warn("Ruta padre no encontrada.");
                return this.$route.path.includes("clients")
                    ? "/clients-soporte-ti"
                    : "/company-soporte-ti";
            }

            return parentRoute.path;
        },

        /**
         * Construye el segmento dinámico del tipo (micro, company, person) según si es cliente o empresa
         */
        dynamicSegment(type) {
            if (this.$route.path.includes("clients")) {
                return `clients-${type}`;
            } else {
                return `company-${type}`;
            }
        },

        /**
         * Navega a una subruta basada en el tipo de entidad.
         * Ej: /company-soporte-ti/company o /clients-soporte-ti/micro
         */
        navigateToChildren(typeSegment) {
            const basePath = this.getBaseRoute();
            const newPath = `${basePath}/${typeSegment}`;

            console.log("Navegando a:", newPath); // Para depuración

            if (this.$route.path !== newPath) {
                this.$router.push(newPath);
            }
        },

        /**
         * Navega a subrutas administrativas bajo `/clients-admin/`
         * Ej: /clients-admin/company
         */
        navigateToAdminChildren(typeSegment) {
            const basePath = "/clients-admin";
            const newPath = `${basePath}/${typeSegment}`;

            console.log("Navegando a:", newPath); // Para depuración

            if (this.$route.path !== newPath) {
                this.$router.push(newPath);
            }
        },

        /**
         * Verifica si un tipo está activo en la URL actual
         * Retorna true si la URL contiene el tipo indicado
         */
        isActive(type) {
            if (
                this.$route.path.includes(`company-${type}`) ||
                this.$route.path.includes(`clients-${type}`)
            ) {
                return true;
            }

            // Verificación para rutas administrativas
            if (this.$route.path.includes(`/clients-admin/${type}`)) {
                return true;
            }

            // Verificación especial para rutas de equipos
            if (this.$route.path.includes("company-equipment")) {
                const pathParts = this.$route.path.split("/");
                const typeIndex = pathParts.length > 3 ? 3 : 0;
                return pathParts[typeIndex] === type;
            }

            return false;
        },
        buscar() {
            console.log('Buscando:', this.searchQuery);
            this.$emit('filtro-aplicado', this.searchQuery); // enviar el filtro al padre
            // Aquí puedes ejecutar una API o usar `datosFiltrados`, etc.
        },
        activarBusquedaNombre() {
            console.log('Activando búsqueda por nombre:', this.searchTermCompany);
            this.searchTerm = '';
            this.searchTermRuc = '';
            this.onInputBuscar('nombre');

            if (!this.searchTermCompany) {
                this.isGeneralSearchDisabled = false;
                this.isRucSearchDisabled = false;
            } else {
                this.isGeneralSearchDisabled = true;
                this.isRucSearchDisabled = true;
            }
        },
        activarBusquedaGeneral() {
            this.searchTermCompany = ''; // limpia barra por nombre
            this.searchTermRuc = ''; // limpia RUC también
            this.onInputBuscar('general');

            // Si se borra el campo, reactivamos la otra barra
            if (!this.searchTerm) {
                this.isCompanySearchDisabled = false;
            }
        },
        activarBusquedaNombrePersona() {
            console.log('Activando búsqueda por nombre de persona:', this.searchTermNombre);

            // Limpiar otros campos para evitar conflictos
            this.searchTerm = '';
            this.searchTermRuc = '';
            this.searchTermCompany = '';
            this.searchTermDni = '';

            this.onInputBuscar('nombrePersona');

            // Control de habilitación de otros inputs
            if (!this.searchTermNombre) {
                this.isCompanySearchDisabled = false;
                this.isGeneralSearchDisabled = false;
                this.isRucSearchDisabled = false;
            } else {
                this.isCompanySearchDisabled = true;
                this.isGeneralSearchDisabled = true;
                this.isRucSearchDisabled = true;
            }
        },
        activarBusquedaRuc() {
        this.searchTerm = '';
        this.searchTermCompany = '';
        this.onInputBuscar('ruc');
            // Si se borra el campo, reactivamos la otra barra
            if (!this.searchTermRuc) {
                this.isCompanySearchDisabled = false;
                this.isGeneralSearchDisabled = false;
            } else {
                this.isCompanySearchDisabled = true;
                this.isGeneralSearchDisabled = true;
            }
        },
        activarBusquedaDni() {
        this.searchTerm = '';
        this.searchTermCompany = '';
        this.searchTermRuc = '';
        this.onInputBuscar('dni');
        if (!this.searchTermDni) {
            this.isCompanySearchDisabled = false;
            this.isGeneralSearchDisabled = false;
            this.isRucSearchDisabled = false;
        } else {
            this.isCompanySearchDisabled = true;
            this.isGeneralSearchDisabled = true;
            this.isRucSearchDisabled = true;
        }
        },
    },
    watch: {
  range(newVal) {
    if (newVal.length === 2) {
      this.startDate = newVal[0];
      this.endDate = newVal[1];
    }
  }
}
};
</script>



<style scoped>
.search-container {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    text-align: center;
        flex-direction: column; /* <-- Agrega esta línea */
        align-items: stretch;   /* Opcional: hace que los hijos usen todo el ancho */
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
    transition: 0.2s ease-in-out;
}
.buttons button:nth-child(1) {
    border-radius: 10px 0 0 10px;
}
.buttons button:nth-child(2) {
    border-radius: 0 10px 10px 0;
}
.buttons button:hover,
.search button:hover {
    border: none;
    opacity: 0.8;
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
    transition: 0.2s ease-in-out;
}
.buttons-ti button:first-child {
    border-radius: 10px 0 0 10px;
}
.buttons-ti button:last-child {
    border-radius: 0 10px 10px 0;
}
.buttons-ti button:hover,
.search button:hover {
    border: none;
    opacity: 0.8;
}
/*----------------------------------------*/

.search {
    overflow: visible;
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
.seeker input,
select {
    flex: 1;
    padding: 10px 12px;
    outline: none;
    border-radius: 10px;
    border: none;
}
.clientes-container,
.persona-container {
    display: flex;
    align-items: center;
    gap: 20px;
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
    transition: 0.2s ease-in-out;
}
.seeker__select:focus option {
    background-color: #fff;
}
.date-label {
    width: 100%;
    font-size: 15.5px;
    text-align: left;
    flex: 1;
}
.date {
    display: flex;
    gap: 10px;
    align-items: center;
}
.date-input {
    z-index: 9999 !important; /* Asegura que el calendario se muestre encima */
    flex: 1;
    padding: 0px;
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
    max-width: 350px;
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
    transition: 0.2s ease-in-out;
}
.buttons .active {
    background-color: var(
        --accent-color
    ); /* Cambia el color según lo que desees */
}
.buttons-ti .active {
    background-color: var(
        --accent-color
    ); /* Cambia el color según lo que desees */
}

.soporte-container {
    flex: 1;
    display: flex;
    gap: 20px;
}
.seeker__soporte {
    display: flex;
    flex-direction: column;
    text-align: left;
    gap: 6px;
}
.seeker__equipment {
    display: flex;
    align-items: center;
    gap: 10px;
}
.seeker__equipment label {
    text-wrap: nowrap;
}
</style>
