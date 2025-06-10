<script setup>
import { computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();

const navbarConfig = computed(() => route.meta.navbarConfig || {});

// Mostrar botones de Cliente para Admin
// `navbarConfig.clientes` es true en AdminClients y sus hijos
const showAdminClientButtons = computed(() => navbarConfig.value.clientes);

// Mostrar botones de Cliente para Soporte TI
// `navbarConfig.clientsSoporteTi` es true en TiSupportClients y sus hijos
const showTiSupportClientButtons = computed(() => navbarConfig.value.clientsSoporteTi);

// Mostrar botones de Empresas para Soporte TI (si aplica)
// `navbarConfig.companySoporteTi` es true en TiSupportCompanies y sus hijos
const showTiSupportCompanyButtons = computed(() => navbarConfig.value.companySoporteTi);


const showAdd = computed(() => {
    return authStore.hasAnyRole(["admin", "manager", "worker"]);
});

const isTicketActive = computed(() => {
    return route.name === "Tickets activos" || route.name === "TiSupportTickets"; // Corregido a TiSupportTickets
});

/**
 * Función genérica para navegar a una ruta por su nombre.
 * @param {string} routeName El nombre de la ruta definida en Vue Router.
 */
const navigateToNamedRoute = (routeName) => {
    if (route.name !== routeName) {
        router.push({ name: routeName });
    }
};

/**
 * Función genérica para verificar si una ruta por su nombre está activa.
 * @param {string} routeName El nombre de la ruta definida en Vue Router.
 * @returns {boolean} True si la ruta actual coincide con routeName.
 */
const isRouteActive = (routeName) => {
    return route.name === routeName;
};
</script>

<template>
    <nav class="search-container">
        <div v-if="showAdminClientButtons" class="buttons">
            <button
                :class="{ active: isRouteActive('AdminClientsCompanies') }"
                title="Seleccionar empresa"
                @click="navigateToNamedRoute('AdminClientsCompanies')"
            >
                Empresa
            </button>
            <button
                :class="{ active: isRouteActive('AdminClientsPersons') }"
                title="Seleccionar persona natural"
                @click="navigateToNamedRoute('AdminClientsPersons')"
            >
                Persona Natural
            </button>
        </div>

        <div v-if="showTiSupportClientButtons" class="buttons-ti">
            <button
                :class="{ active: isRouteActive('TiSupportClientsCompanies') }"
                title="Seleccionar empresa"
                @click="navigateToNamedRoute('TiSupportClientsCompanies')"
            >
                Empresa
            </button>
            <button
                :class="{ active: isRouteActive('TiSupportClientsPersons') }"
                title="Seleccionar persona natural"
                @click="navigateToNamedRoute('TiSupportClientsPersons')"
            >
                Persona Natural
            </button>
        </div>

        <div v-if="showTiSupportCompanyButtons" class="buttons-ti">
            <button
                :class="{ active: isRouteActive('TiSupportCompaniesView') }"
                title="Ver empresas"
                @click="navigateToNamedRoute('TiSupportCompaniesView')"
            >
                Empresas
            </button>
            <button
                :class="{ active: isRouteActive('TiSupportCompaniesPersons') }"
                title="Ver personal de empresas"
                @click="navigateToNamedRoute('TiSupportCompaniesPersons')"
            >
                Personal
            </button>
            </div>


        <div class="search">
            <div
                v-if="navbarConfig.clientes || navbarConfig.clientCompany || navbarConfig.clientsSoporteTi"
                class="clientes-container"
            >
                <div v-if="navbarConfig.labelRuc || navbarConfig.clientCompany" class="seeker seeker__clientes">
                    <label title="Buscar RUC" for="ruc">{{
                        navbarConfig.labelRuc || 'RUC:'
                    }}</label>
                    <input
                        id="ruc"
                        type="number"
                        title="Buscar RUC"
                        placeholder="Ingrese su RUC"
                    />
                </div>
                <div
                    v-if="navbarConfig.labelEmpresa || navbarConfig.clientCompany"
                    class="seeker seeker__clientes"
                >
                    <label for="empresa">{{
                        navbarConfig.labelEmpresa || 'Empresa:'
                    }}</label>
                    <input
                        id="empresa"
                        type="text"
                        title="Buscar empresa"
                        placeholder="Ingrese nombre de la empresa"
                    />
                </div>
            </div>

            <div
                v-if="navbarConfig.persona || navbarConfig.clientPerson || navbarConfig.clientsSoporteTi"
                class="persona-container"
            >
                <div v-if="navbarConfig.labelDni || navbarConfig.clientPerson" class="seeker seeker__clientes">
                    <label for="dni">{{ navbarConfig.labelDni || 'DNI:' }}</label>
                    <input
                        id="dni"
                        type="text"
                        title="Buscar DNI"
                        placeholder="Ingrese su DNI"
                    />
                </div>
                <div
                    v-if="navbarConfig.labelNombre || navbarConfig.clientPerson"
                    class="seeker seeker__clientes"
                >
                    <label for="nombre">{{ navbarConfig.labelNombre || 'Nombre:' }}</label>
                    <input
                        id="nombre"
                        type="text"
                        title="Buscar nombre"
                        placeholder="Ingrese su nombre"
                    />
                </div>
            </div>

            <div v-if="navbarConfig.soporteTi" class="soporte-container">
                </div>

            <div v-if="navbarConfig.equipment" class="seeker seeker__equipment">
                </div>

            <div
                class="seeker seeker__general"
                :class="{ 'width__sekker': route.name === 'Tickets activos' }"
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
/* Tu CSS existente */
</style>

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
.seeker__equipment {
    display: flex;
    align-items: center;
    gap: 10px;
}
.seeker__equipment label {
    text-wrap: nowrap;
}
</style>
