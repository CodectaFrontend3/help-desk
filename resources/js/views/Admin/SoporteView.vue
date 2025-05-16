<script>
import TableComponent from "@/components/Commons/TableComponent.vue";
import apiServices from "../../services/ApiServices";
import PopCliente from "../../components/Commons/PopCliente.vue";

export default {
    name: "SoporteView",
    components: { TableComponent, PopCliente },
    data() {
        return {
            showPopup: false,
            columns: [
                // Asegúrate de definir las columnas
                { label: "Número de plan", key: "plan_number" },
                { label: "Nombre del plan", key: "name" },
                { label: "Descripción", key: "description" },
                { label: "Id", key: "id" },
            ],
            branch: [],
        };
    },
    async created() {
        await this.fetchBranch(); // Llamada a la API cuando el componente se crea
    },
    methods: {
        async fetchBranch() {
            // Obtener los datos de microempresas desde la API
            this.branch = await apiServices.get("plan");
            console.log(this.branch); // Verifica los datos que se reciben
        },
    },
};
</script>

<template>
    <div class="soporte">
        <table-component :data="branch" :columns="columns" />
    </div>

</template>

<style scoped></style>
