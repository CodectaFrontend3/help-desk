<script>
import PopCliente from "../Commons/PopCliente.vue";

export default {
    name: "TableComponent",
    components: { PopCliente },
    data() {
        return {
            showPopup: false,
        };
    },
    props: {
        columns: Array, // Prop de columnas, que contiene las cabeceras y las claves para las filas
        data: Array, // Prop del array de datos
    },
    methods: {
        infoShow() {
            // Lógica para el botón de ver detalles (si es necesario)
        },
    },
};
</script>

<template>
    <div class="table-container">
        <!-- Tabla de los registros -->
        <table>
            <thead>
                <tr>
                    <!-- Iterar sobre las columnas para mostrar los encabezados -->
                    <th v-for="(col, index) in columns" :key="index">
                        {{ col.label }}
                    </th>
                    <th>Acciones</th>
                    <!-- Columna para la acción -->
                </tr>
            </thead>
            <tbody>
                <!-- Primero iterar sobre cada registro (fila) -->
                <tr v-for="(row, rowIndex) in data" :key="rowIndex">
                    <!-- Luego iterar sobre cada columna para la fila actual -->
                    <td v-for="(col, colIndex) in columns" :key="colIndex">
                        {{ row[col.key] }}
                        <!-- Usar col.key para acceder a la propiedad correcta del objeto row -->
                    </td>
                    <td class="acciones">
                        <button class="pi pi-eye" title="Ver registro" @click="showPopup = !showPopup"></button>
                    </td>
                </tr>
            </tbody>
        </table>
        <PopCliente :visible="showPopup" :cliente-id="123" @close="showPopup = false" />
        <!-- Paginador -->
        <Paginator></Paginator>
    </div>
</template>

<style scoped>
table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 10px;
    overflow: hidden;
    text-align: center;
    table-layout: fixed;
    text-overflow: ellipsis;
}
thead {
    background-color: #ccc;
}
tr {
    display: flex;
    align-items: center;
}
td,
th {
    flex: 1;
    padding: 16px;
}
tbody tr:nth-child(odd) {
    background-color: #fff;
}

tbody tr:nth-child(even) {
    background-color: #eee;
}

.pagination {
    margin-top: 20px;
    text-align: center;
}

.pagination button {
    padding: 5px 10px;
    margin: 0 5px;
    cursor: pointer;
}

.pagination button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}
</style>
