<script>
import PopCliente from "../Commons/PopCliente.vue";
import PopCompany from "../Commons/PopCompany.vue";
import Paginator from "primevue/paginator";

export default {
    name: "TableComponent",
    components: {
        PopCliente,
        PopCompany,
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
            rowsPerPageOptions: [5, 10, 20, 50],
            selectedClientId: null,
        };
    },
    computed: {
        paginatedData() {
            return this.data.slice(this.first, this.first + this.rows);
        },
        entityType() {
        const routeName = this.$route.name;
        if (routeName === "Clientes - Persona natural") return "person";
        if (routeName === "Clientes - Empresa - Administrador") return "company";
        return "company"; // valor por defecto
    },
    },
    methods: {
        onPageChange(event) {
            this.first = event.first;
            this.rows = event.rows;
        },
        showButtons() {
            return this.$route.meta.navbarConfig?.companySoporteTi === true;
        },
        viewEquipment(row) {
            const id = row.id || row._id;
            if (!id) {
                console.error("Error: No se pudo obtener el ID del registro", row);
                return;
            }

            if (this.entityType === "equipment") {
                const companyId = this.$route.params.id;
                this.$router.push({
                    name: "Detalles de Equipo",
                    params: {
                        companyId: companyId,
                        equipmentId: id,
                    },
                });
            } else {
                let type = this.entityType;
                if (this.$route.name === "CompanyMicro") type = "micro";
                else if (this.$route.name === "CompanyPerson") type = "person";
                else type = "person";

                this.$router.push({
                    name: "Equipos de Empresa",
                    params: { id: id, type: type },
                });
            }
        },
        viewClient(row) {
            const id = row.id || row._id;
            if (!id) {
                console.error("No se pudo obtener el ID del cliente", row);
                return;
            }

            console.log("Mostrando detalles del cliente ID:", id);

            console.log("--------------------------------------------------------------------------------------s")
            this.selectedClientId = id;
            this.showPopup = true;
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
                    <tr v-for="(row, rowIndex) in paginatedData" :key="rowIndex">
                        <td v-for="(col, colIndex) in columns" :key="colIndex">
                            {{ row[col.key] }}
                        </td>
                        <td class="acciones">
                            <button
                                v-if="!showButtons()"
                                class="pi pi-eye"
                                title="Ver cliente"
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

        <!-- Paginador -->
        <Paginator
            :rows="rows"
            :totalRecords="data.length"
            :first="first"
            :rowsPerPageOptions="rowsPerPageOptions"
            @page="onPageChange"
            class="paginator"
        />

        <!-- Popup cliente -->
        <PopCliente
            v-if="entityType === 'person'"
            :visible="showPopup"
            :cliente-id="selectedClientId"
            @close="showPopup = false"
        />
        <PopCompany
            v-if="entityType === 'company'"
            :visible="showPopup"
            :cliente-id="selectedClientId"
            @close="showPopup = false" />
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
