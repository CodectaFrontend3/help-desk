<script>
import PopCliente from "../Commons/PopCliente.vue";
import Paginator from "primevue/paginator";

export default {
    name: "TableComponent",
    components: {
        PopCliente,
        Paginator,
    },
    props: {
        columns: Array,
        data: Array,
    },
    data() {
        return {
            showPopup: false,
            first: 0,
            rows: 10,
            rowsPerPageOptions: [5, 10, 20, 50], // <-- NUEVO
        };
    },
    computed: {
        paginatedData() {
            return this.data.slice(this.first, this.first + this.rows);
        },
    },
    methods: {
        onPageChange(event) {
            this.first = event.first;
            this.rows = event.rows;
        },
    },
};
</script>

<template>
    <div class="table-container">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th v-for="(col, index) in columns" :key="index">
                            {{ col.label }}
                        </th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Usa paginatedData en lugar de data -->
                    <tr
                        v-for="(row, rowIndex) in paginatedData"
                        :key="rowIndex"
                    >
                        <td v-for="(col, colIndex) in columns" :key="colIndex">
                            {{ row[col.key] }}
                        </td>
                        <td class="acciones">
                            <button
                                class="pi pi-eye"
                                title="Ver registro"
                                @click="showPopup = !showPopup"
                            ></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Paginador funcional -->
        <Paginator
            :rows="rows"
            :totalRecords="data.length"
            :first="first"
            :rowsPerPageOptions="rowsPerPageOptions"
            @page="onPageChange"
            class="paginator"
        />

        <!-- Popup -->
        <PopCliente
            :visible="showPopup"
            :cliente-id="123"
            @close="showPopup = false"
        />
    </div>
</template>

<style scoped>
.table-container {
    display: flex;
    flex-direction: column;
}
table {
    width: 100%;
    height: 100%;
    border-collapse: collapse;
    text-align: center;
    table-layout: fixed;
    border-radius: 10px;
}
thead {
    display: table-row;
    background-color: #ccc;
}
tr {
    display: table-row;
    display: flex;
    align-items: center;
}
td,
th {
    text-overflow: ellipsis;
    flex: 1;
    padding: 16px;
}
tbody {
    display: table-row;
}
tbody tr:nth-child(odd) {
    background-color: #fff;
}

tbody tr:nth-child(even) {
    background-color: #eee;
}   
.paginator {
    position: sticky;
    bottom: 0;
    padding: 30px 10px;
    background-color: #fff;
}
</style>
