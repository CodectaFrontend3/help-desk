<script>
import TableComponent from "../../../components/Commons/TableComponent.vue";
import PopCliente from "../../../components/Commons/PopCliente.vue";
import apiServices from "../../../services/ApiServices";
export default {
    name: "PersonaClientes",
    components: { TableComponent, PopCliente },
    data() {
        return {
            showPopup: false,
            columns: [ // Asegúrate de definir las columnas
                { label: "Nombre", key: "name" },
                { label: "DNI", key: "dni" },
                { label: "Teléfono", key: "phone" },
                { label: "Correo", key: "email" },
            ],
            naturalPerson: [],
            plan: [],
        };
    },
    async created() {
        await this.fetchNaturalPerson(); // Llamada a la API cuando el componente se crea
        await this.fetchPlan(); // Llamada a la API cuando el componente se crea
    },
    methods: {
        async fetchNaturalPerson() {
            // Obtener los datos de microempresas desde la API
            this.naturalPerson = await apiServices.get("natural-person");
            console.log(this.naturalPerson); // Verifica los datos que se reciben
        },
        async fetchPlan() {
            // Obtener los datos de microempresas desde la API
            this.plan  = await apiServices.get("plan");
            console.log(this.plan); // Verifica los datos que se reciben
        },
    },
};
</script>

<template>
    <div class="natural-person">
        <table-component :data="naturalPerson" :columns="columns" :available-actions="['view']"/>
    </div>
</template>

<style scoped>
    .natural-person {
        flex: 1;
        display: flex;
    }
</style>
