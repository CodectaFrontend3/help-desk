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
                { label: "Nombre", key: "branch_name" },
                { label: "Encargado", key: "manager" },
                { label: "Teléfono", key: "phone" },
                { label: "Correo", key: "email" },
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
            this.branch = await apiServices.get("branch");
            console.log(this.branch); // Verifica los datos que se reciben
        },
    },
};
</script>

<template>
    <div class="soporte">
        <h1>ESTA ES LA TABLA DE SUCURSALES DEL FORMULARIO CREAR EMPRESA</h1>
        <table-component :data="branch" :columns="columns" />
    </div>

</template>

<style scoped></style>
