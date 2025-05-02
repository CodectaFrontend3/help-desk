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
        // Propiedad para indicar el tipo de entidad (micro, company, person)
        entityType: {
            type: String,
            default: "company"
        }
    },
    data() {
        return {
            showPopup: false,
            first: 0,
            rows: 10,
            rowsPerPageOptions: [5, 10, 20, 50],
            selectedClientId: null,
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
        showButtons() {
            return this.$route.meta.navbarConfig.companySoporteTi === true;
        },
        viewEquipment(row) {
            // Verificar que el ID exista
            const id = row.id || row._id;

            if (!id) {
                console.error("Error: No se pudo obtener el ID del registro", row);
                return;
            }

            console.log("Navegando a detalles de equipos para:", row);
            console.log("ID:", id, "Tipo:", this.entityType);

            // Navegar a la ruta de detalles de equipos con el ID
            this.$router.push({
                name: "Equipos de Empresa",
                params: {
                    id: id,
                    type: this.entityType
                }
            });
        },
        viewClient(row) {
            this.selectedClientId = row.id || row._id;
            this.showPopup = true;
        }
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
                    <tr
                        v-for="(row, rowIndex) in paginatedData"
                        :key="rowIndex"
                    >
                        <td v-for="(col, colIndex) in columns" :key="colIndex">
                            {{ row[col.key] }}
                        </td>
                        <td class="acciones">
                            <button
                                v-if="!showButtons()"
                                class="pi pi-eye"
                                title="Ver registro"
                                @click="viewClient(row)"
                            ></button>
                            <button
                                v-if="showButtons()"
                                class="pi pi-file"
                                title="Ver equipos"
                                @click="viewEquipment(row)"
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
            :cliente-id="selectedClientId"
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
    background-color: #ccc;
}
tr {
    display: flex;
    align-items: center;
}
td,
th {
    text-overflow: ellipsis;
    flex: 1;
    padding: 16px;
}
tbody tr:nth-child(odd) {
    background-color: #fff;
}

tbody tr:nth-child(even) {
    background-color: #eee;
}
button.pi {
    padding: 8px;
    border: none;
    border-radius: 4px;
    background-color: #f0f0f0;
    cursor: pointer;
    margin: 0 4px;
}
button.pi:hover {
    background-color: #e0e0e0;
}
.paginator {
    position: sticky;
    bottom: 0;
    padding: 30px 10px;
    background-color: #fff;
}
</style>
