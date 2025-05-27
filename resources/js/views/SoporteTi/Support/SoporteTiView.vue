<script>
import TableComponent from "@/components/Commons/TableComponent.vue";
import apiServices from "../../../services/ApiServices";

export default {
    name: "SoporteView",
    components: { TableComponent},
    data() {
        return {
            showPopup: false,
            columns: [
                // Asegúrate de definir las columnas
                { label: "Número de plan", key: "plan_number" },
                { label: "Nombre del plan", key: "name" },
                { label: "Descripción", key: "description" },
            ],
            plan: [],
        };
    },
    async created() {
        await this.fetchPlan(); // Llamada a la API cuando el componente se crea
    },
    methods: {
        async fetchPlan() {
            // Obtener los datos de microempresas desde la API
            this.plan  = await apiServices.get("plan");
            console.log(this.plan); // Verifica los datos que se reciben
        },
    },
};
</script>

<template>
    <div class="soporte">
        <table-component :data="plan" :columns="columns" :available-actions="['']"/>
    </div>

</template>

<style scoped></style>
