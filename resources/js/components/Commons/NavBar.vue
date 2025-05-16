<script>
export default {
    name: "NavBar",
    data() {
        return {
            sekker: true, // Probablemente una bandera para controlar el estado de algo en la barra de navegación (nombre no muy descriptivo)
        };
    },
    computed: {
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
            return this.$route.meta?.role === "admin";
        },

        // Verifica si estamos en una ruta de tickets activos o soporte técnico TI
        isTicketActive() {
            return (
                this.$route.name === "Tickets activos" ||
                this.$route.name === "Soporte técnico - Soporte TI"
            );
        },
    },
    methods: {
        /**
         * Determina el tipo de entidad actualmente activa según la URL.
         * Retorna: "micro", "company", "person" o un tipo extraído de la URL si estamos en equipos.
         */
        currentType() {
            const path = this.$route.path;
            if (
                path.includes("company-micro") ||
                path.includes("clients-micro")
            )
                return "micro";
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
                this.$route.path.includes("clients-micro") ||
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
    },
};
</script>


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
                :class="{ active: isActive('micro') }"
                title="Seleccionar microempresa"
                @click="navigateToChildren(dynamicSegment('micro'))"
            >
                Microempresa
            </button>
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
                <div
                    v-if="navbarConfig.labelIncidente"
                    class="seeker seeker__tickets"
                    :class="{ width__sekker: isTicketActive }"
                >
                    <label for="empresa">{{
                        navbarConfig.labelIncidente
                    }}</label>
                    <input
                        type="text"
                        title="Buscar empresa"
                        placeholder="Ingrese el incidente"
                    />
                </div>
                <div
                    v-if="navbarConfig.labelArea"
                    class="seeker seeker__tickets"
                    :class="{ width__sekker: isTicketActive }"
                >
                    <label for="empresa">{{ navbarConfig.labelArea }}</label>
                    <select v-if="navbarConfig.labelArea">
                        <option disabled selected id="empresa">
                            Elegir área
                        </option>
                        <option value="1">Área 1</option>
                        <option value="2">Área 2</option>
                        <option value="3">Área 3</option>
                    </select>
                </div>

                <div
                    v-if="navbarConfig.labelFecha"
                    class="seeker seeker__tickets"
                    :class="{ width__sekker: isTicketActive }"
                >
                    <label for="fecha" class="date-label">{{
                        navbarConfig.labelFecha
                    }}</label>
                    <div class="date">
                        <input
                            id="date"
                            type="date"
                            title="Fecha de inicio"
                            class="date-input"
                            placeholder="Desde"
                        />
                        <p class="date-separator">al</p>
                        <input
                            type="date"
                            title="Fecha de fin"
                            class="date-input"
                            placeholder="Hasta"
                        />
                    </div>
                </div>
                <div
                    v-if="navbarConfig.labelEstado"
                    class="seeker seeker__tickets"
                    :class="{ width__sekker: isTicketActive }"
                >
                    <label class="seeker__label" for="empresa">{{
                        navbarConfig.labelEstado
                    }}</label>
                    <div class="select-wrapper">
                        <select
                            v-if="navbarConfig.labelEstado"
                            class="seeker__select"
                        >
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
            <div
                v-if="navbarConfig.clientes || navbarConfig.clientCompany"
                class="clientes-container"
            >
                <div
                    v-if="navbarConfig.labelRuc"
                    class="seeker seeker__clientes"
                >
                    <label title="Buscar RUC" for="ruc">{{
                        navbarConfig.labelRuc
                    }}</label>
                    <input
                        id="ruc"
                        type="number"
                        title="Buscar RUC"
                        placeholder="Ingrese su RUC"
                    />
                </div>
                <div
                    v-if="navbarConfig.labelEmpresa"
                    class="seeker seeker__clientes"
                >
                    <label for="empresa">{{ navbarConfig.labelEmpresa }}</label>
                    <input
                        id="empresa"
                        type="text"
                        title="Buscar empresa"
                        placeholder="Ingrese nombre de la empresa"
                    />
                </div>
            </div>

            <!--Clientes - Persona Natural-->
            <div
                v-if="navbarConfig.persona || navbarConfig.clientPerson"
                class="persona-container"
            >
                <div
                    v-if="navbarConfig.labelDni"
                    class="seeker seeker__clientes"
                >
                    <label for="dni">{{ navbarConfig.labelDni }}</label>
                    <input
                        id="dni"
                        type="text"
                        title="Buscar empresa"
                        placeholder="Ingrese su DNI"
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
                        title="Buscar empresa"
                        placeholder="Ingrese su nombre"
                    />
                </div>
            </div>

            <!-- SOPORTE TI -->
            <div v-if="navbarConfig.soporteTi" class="soporte-container">
                <!-- RUC -->
                <div
                    v-if="navbarConfig.ruc"
                    class="seeker seeker__soporte"
                    :class="{ width__sekker: isTicketActive }"
                >
                    <label for="soporte-ruc">{{ navbarConfig.ruc }}</label>
                    <input
                        id="soporte-ruc"
                        type="text"
                        title="Buscar empresa"
                        placeholder="Ingrese el RUC"
                    />
                </div>
                <!-- EMPRESA -->
                <div
                    v-if="navbarConfig.company"
                    class="seeker seeker__soporte"
                    :class="{ width__sekker: isTicketActive }"
                >
                    <label for="soporte-ruc">{{ navbarConfig.company }}</label>
                    <input
                        id="soporte-ruc"
                        type="text"
                        title="Buscar empresa"
                        placeholder="Ingrese el nombre de la empresa"
                    />
                </div>
            </div>

            <!--Seeker General-->
            <div
                class="seeker seeker__general"
                :class="{
                    width__sekker: this.$route.name === 'Tickets activos',
                }"
            >
                <input type="text" title="Buscar" placeholder="Search" />
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
.buttons-ti button:nth-child(1) {
    border-radius: 10px 0 0 10px;
}
.buttons-ti button:nth-child(3) {
    border-radius: 0 10px 10px 0;
}
.buttons-ti button:hover,
.search button:hover {
    border: none;
    opacity: 0.8;
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
</style>
