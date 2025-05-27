<script>
import tableComponent from "@/components/Commons/TableComponent.vue";
import apiServices from "../../../services/ApiServices";

export default {
    name: "CompanyPerson",
    components: { tableComponent },
    data() {
        return {
            columns: [
                { label: "Nombre", key: "name" },
                { label: "DNI", key: "dni" },
                { label: "Teléfono", key: "phone" },
                { label: "Correo", key: "email" },
            ],
            person: [],
        };
    },
    async created() {
        await this.fetchNaturalPerson(); // Llamada a la API cuando el componente se crea
    },
    methods: {
        async fetchNaturalPerson() {
            try {
                // Obtener los datos de personas desde la API
                this.person = await apiServices.get("natural-person");
                console.log("Personas naturales cargadas:", this.person);
            } catch (error) {
                console.error("Error al cargar personas naturales:", error);
            }
        },
    },
};
</script>

<template>
    <div class="natural__person">
        <table-component
            :data="person"
            :columns="columns"
            entityType="person"
            :available-actions="['equipment']"
        />
        <router-view />
    </div>
</template>

<style scoped></style>
