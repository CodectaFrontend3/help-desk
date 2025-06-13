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
        entityType: {
            type: String,
            default: "company",
        },
        availableActions: {
            type: Array,
            default: () => ['view', 'equipment', 'chat']
        },
        showSelectionCheckbox: {
            type: Boolean,
            default: false
        },
        showPriorityColumn: {
            type: Boolean,
            default: false
        },
        currentUser: {
            type: Object,
            default: () => ({})
        },
        showTicketAdminColumns: {
            type: Boolean,
            default: false
        },
        showCompanySoporteTiButtons: {
            type: Boolean,
            default: false
        },
        // --- NUEVAS PROPS PARA PASAR EL CONTEXTO DEL PADRE (EMPRESA/PERSONA) ---
        parentId: { // ID de la empresa o persona que contiene los equipos
            type: [String, Number],
            default: null
        },
        parentType: { // Tipo de la entidad padre ('company' o 'person')
            type: String,
            default: null
        }
    },
    data() {
        return {
            showPopup: false,
            first: 0,
            rows: 10,
            rowsPerPageOptions: [5, 10, 20, 50],
            selectedClientId: null,
            selectedRows: [],
            selectAll: false,
            buttonConfig: {
                view: {
                    icon: 'pi pi-eye',
                    title: 'Ver registro',
                    action: 'viewClient',
                    show: true
                },
                equipment: {
                    icon: 'pi pi-file',
                    title: 'Ver equipos',
                    action: 'viewEquipment',
                    show: true
                },
                chat: {
                    icon: 'pi pi-comments',
                    title: 'Ir al chat',
                    action: 'viewChat',
                    show: true
                },
                edit: {
                    icon: 'pi pi-pencil',
                    title: 'Editar',
                    action: 'editRecord',
                    show: true
                },
                delete: {
                    icon: 'pi pi-trash',
                    title: 'Eliminar',
                    action: 'deleteRecord',
                    show: true
                },
                download: {
                    icon: 'pi pi-download',
                    title: 'Descargar',
                    action: 'downloadRecord',
                    show: true
                }
            }
        };
    },
    computed: {
        paginatedData() {
            return this.data.slice(this.first, this.first + this.rows);
        },
        visibleButtons() {
            if (!this.showButtons()) return [];
            return this.availableActions
                .filter(actionKey => this.buttonConfig[actionKey])
                .map(actionKey => ({
                    key: actionKey,
                    ...this.buttonConfig[actionKey]
                }));
        },
        isAdmin() {
            return this.currentUser && (this.currentUser.role === 'admin' || this.currentUser.isAdmin === true);
        },
        shouldShowCheckbox() {
            return this.showSelectionCheckbox && this.isAdmin;
        },
        isIndeterminate() {
            return this.selectedRows.length > 0 && this.selectedRows.length < this.paginatedData.length;
        }
    },
    watch: {
        selectedRows: {
            handler(newVal) {
                this.selectAll = newVal.length === this.paginatedData.length && this.paginatedData.length > 0;
                this.$emit('selection-change', newVal);
            },
            deep: true
        },
        paginatedData() {
            this.selectedRows = [];
            this.selectAll = false;
        }
    },
    methods: {
        onPageChange(event) {
            this.first = event.first;
            this.rows = event.rows;
        },
        showButtons() {
            if (this.availableActions && this.availableActions.length > 0) {
                return true;
            }
            return this.showCompanySoporteTiButtons;
        },
        executeAction(actionKey, row) {
            if (this[actionKey]) {
                this[actionKey](row);
            } else {
                console.warn(`Acción ${actionKey} no encontrada`);
            }
        },
        toggleSelectAll() {
            if (this.selectAll) {
                this.selectedRows = [...this.paginatedData];
            } else {
                this.selectedRows = [];
            }
        },
        toggleRowSelection(row) {
            const index = this.selectedRows.findIndex(selectedRow =>
                (selectedRow.id || selectedRow._id) === (row.id || row._id)
            );
            if (index === -1) {
                this.selectedRows.push(row);
            } else {
                this.selectedRows.splice(index, 1);
            }
        },
        isRowSelected(row) {
            return this.selectedRows.some(selectedRow =>
                (selectedRow.id || selectedRow._id) === (row.id || row._id)
            );
        },
        getPriorityColor(priority) {
            const priorityColors = {
                'alta': '#ff4444',
                'high': '#ff4444',
                'media': '#ffaa00',
                'medium': '#ffaa00',
                'baja': '#00aa00',
                'low': '#00aa00',
                'urgente': '#cc0000',
                'urgent': '#cc0000'
            };
            if (!priority) return '#999999';
            const normalizedPriority = priority.toString().toLowerCase();
            return priorityColors[normalizedPriority] || '#999999';
        },
        formatPriority(priority) {
            if (!priority) return 'N/A';
            const priorityMap = {
                'alta': 'Alta',
                'high': 'Alta',
                'media': 'Media',
                'medium': 'Media',
                'baja': 'Baja',
                'low': 'Baja',
                'urgente': 'Urgente',
                'urgent': 'Urgente'
            };
            const normalizedPriority = priority.toString().toLowerCase();
            return priorityMap[normalizedPriority] || priority;
        },

        // --- MÉTODO viewEquipment CORREGIDO ---
        viewEquipment(row) {
            const equipmentId = row.id || row._id; // ID del equipo específico

            if (!equipmentId) {
                console.error("Error: No se pudo obtener el ID del registro de equipo", row);
                return;
            }

            console.log("Navegando a detalles de equipos para:", row);
            console.log("Equipment ID:", equipmentId, "Table entityType (prop):", this.entityType);

            // Si entityType es 'equipment', estamos mostrando una lista de equipos,
            // y necesitamos el ID de la empresa/persona padre y su tipo
            if (this.entityType === "equipment") {
                const companyOrPersonId = this.parentId; // Usamos la nueva prop parentId
                const companyOrPersonType = this.parentType; // Usamos la nueva prop parentType

                if (!companyOrPersonId || !companyOrPersonType) {
                    console.error("Error: No se pudo determinar el ID de la entidad padre o el tipo (company/person).", { companyOrPersonId, companyOrPersonType, row });
                    return;
                }

                console.log("Navegando a detalles de equipo con companyId:", companyOrPersonId, "equipmentId:", equipmentId, "type:", companyOrPersonType);

                this.$router.push({
                    name: "TiSupportEquipmentDetails",
                    params: {
                        companyId: companyOrPersonId, // ID de la empresa o persona
                        equipmentId: equipmentId,      // ID del equipo específico
                        type: companyOrPersonType      // Tipo de la entidad padre ('company' o 'person')
                    },
                });
            } else {
                // Esta es la lógica para navegar a la lista de equipos de una empresa/persona desde
                // la vista de empresas o personas (TiSupportCompaniesView/TiSupportCompaniesPersons)
                const id = row.id || row._id;
                let type = this.entityType; // Usa la prop entityType que ya tienes

                // Si necesitas ajustar el 'type' basado en la ruta actual, manten esta lógica
                // (aunque lo ideal sería que 'entityType' ya refleje esto)
                if (this.$route.name === "TiSupportCompaniesPersons" || this.$route.name.includes("Persona")) {
                    type = "person";
                } else if (this.$route.name === "TiSupportCompaniesView" || this.$route.name.includes("Company")) {
                    type = "company";
                }

                console.log("Navegando a equipos de empresa con ID:", id, "Tipo:", type);

                this.$router.push({
                    name: "CompanyEquipments",
                    params: {
                        id: id,
                        type: type,
                    },
                });
            }
        },

        viewClient(row) {
            this.selectedClientId = row.id || row._id;
            this.showPopup = true;
        },
        viewChat(row) {
            const id = row.id || row._id;
            console.log('Ir al chat con ID:', id);
            this.$router.push({
                name: 'Chat',
                params: { id: id },
                query: { type: this.entityType || 'default' }
            });
        },
        editRecord(row) {
            console.log('Emitiendo evento de edición para:', row);
            this.$emit('edit', row);
        },
        deleteRecord(row) {
            console.log('Emitiendo evento de eliminación para:', row);
            this.$emit('delete', row);
        },
        downloadRecord(row) {
            console.log('Emitiendo evento de descarga para:', row);
            this.$emit('download', row);
        },
        formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return dateString;
            return date.toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        },
        getCellValue(row, column) {
            const value = row[column.key];
            if (column.format && value) {
                if (column.key === 'end_revision' || column.key === 'revision_scheduled') {
                    return this.formatDate(value);
                }
            }
            return value;
        }
    },
};
</script>

<template>
    <div class="table-container">
        <div v-if="shouldShowCheckbox && selectedRows.length > 0" class="selection-toolbar">
            <span class="selection-info">{{ selectedRows.length }} elemento(s) seleccionado(s)</span>
            <button class="btn-bulk-action" @click="$emit('bulk-delete', selectedRows)">
                <i class="pi pi-trash"></i> Eliminar seleccionados
            </button>
            <button class="btn-bulk-action" @click="$emit('bulk-export', selectedRows)">
                <i class="pi pi-download"></i> Exportar seleccionados
            </button>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th v-if="shouldShowCheckbox" class="checkbox-column">
                            <input type="checkbox" :checked="selectAll" :indeterminate="isIndeterminate"
                                @change="toggleSelectAll" title="Seleccionar todo" />
                        </th>

                        <th v-if="showPriorityColumn" class="priority-column">Prioridad</th>

                        <th v-for="(col, index) in columns" :key="index">
                            {{ col.label }}
                        </th>
                        <th v-if="showTicketAdminColumns">Prioridad</th>
                        <th v-if="visibleButtons.length > 0">Acciones</th>
                        <th v-if="showTicketAdminColumns">Soporte In Situ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, rowIndex) in paginatedData" :key="rowIndex"
                        :class="{ 'selected-row': isRowSelected(row) }">

                        <td v-if="shouldShowCheckbox" class="checkbox-column">
                            <input type="checkbox" :checked="isRowSelected(row)" @change="toggleRowSelection(row)" />
                        </td>

                        <td v-if="showPriorityColumn" class="priority-column">
                            <span class="priority-badge" :style="{
                                backgroundColor: getPriorityColor(row.priority || row.prioridad),
                                color: 'white'
                            }">
                                {{ formatPriority(row.priority || row.prioridad) }}
                            </span>
                        </td>

                        <td v-for="(col, colIndex) in columns" :key="colIndex">
                            <slot :name="col.key" :value="getCellValue(row, col)" :row="row">
                                {{ getCellValue(row, col) }}
                            </slot>
                        </td>

                        <td v-if="showTicketAdminColumns">
                            <button class="pi pi-arrow-down" title="Ver detalles de prioridad (ej.)"></button>
                        </td>

                        <td v-if="visibleButtons.length > 0" class="acciones">
                            <button v-for="button in visibleButtons" :key="button.key" :class="button.icon"
                                :title="button.title" @click="executeAction(button.action, row)"></button>
                        </td>

                        <td v-if="showTicketAdminColumns" class="acciones">
                            <label class="checkbox-container">
                                <input type="checkbox" title="Marcar como Soporte In Situ"
                                    :checked="row.inSituSupport || false"
                                    @change="$emit('toggle-in-situ-support', { row, value: $event.target.checked })">
                                <span class="checkmark"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Paginator :rows="rows" :totalRecords="data.length" :first="first" :rowsPerPageOptions="rowsPerPageOptions"
            @page="onPageChange" class="paginator" />

        <PopCliente :visible="showPopup" :cliente-id="selectedClientId" @close="showPopup = false" />
    </div>
</template>

<style scoped>
.table-container {
    display: flex;
    flex-direction: column;
    width: 100%;
    overflow: hidden;
}

.selection-toolbar {
    background-color: #f8f9fa;
    padding: 12px 16px;
    border: 1px solid #dee2e6;
    border-radius: 8px 8px 0 0;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.selection-info {
    font-weight: 500;
    color: #495057;
}

.btn-bulk-action {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.btn-bulk-action:hover {
    background-color: #0056b3;
}

.table-wrapper {
    overflow-x: auto;
    overflow-y: hidden;
    width: 100%;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    background-color: white;
}

table {
    width: 100%;
    min-width: 800px; /* Ancho mínimo para evitar que se comprima demasiado */
    border-collapse: collapse;
    text-align: center;
    table-layout: auto; /* Cambiado de fixed a auto para mejor responsive */
    background-color: white;
}

thead {
    background-color: #f8f9fa;
    position: sticky;
    top: 0;
    z-index: 10;
}

thead th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
    white-space: nowrap; /* Evita que el texto del header se rompa */
}

/* Eliminar display: flex de las filas */
tr {
    display: table-row; /* Comportamiento normal de tabla */
}

td, th {
    padding: 12px 16px;
    border-bottom: 1px solid #dee2e6;
    text-overflow: ellipsis;
    overflow: hidden;
    vertical-align: middle;
    min-width: 100px; /* Ancho mínimo para cada celda */
}

/* Columnas específicas con anchos mínimos */
.checkbox-column {
    width: 50px;
    min-width: 50px;
    text-align: center;
}

.priority-column {
    width: 120px;
    min-width: 120px;
}

.acciones {
    width: 120px;
    min-width: 120px;
    white-space: nowrap;
}

tbody tr {
    transition: background-color 0.2s ease;
}

tbody tr:nth-child(odd) {
    background-color: #fff;
}

tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}

tbody tr:hover {
    background-color: #e3f2fd;
}

.selected-row {
    background-color: #bbdefb !important;
}

/* Estilos para botones de acción */
button.pi {
    padding: 8px;
    border: none;
    border-radius: 4px;
    background-color: #f0f0f0;
    cursor: pointer;
    margin: 0 2px;
    font-size: 14px;
    min-width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

button.pi:hover {
    background-color: #e0e0e0;
    transform: translateY(-1px);
}

/* Estilos para badges de prioridad */
.priority-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

/* Estilos para checkboxes */
.checkbox-container {
    display: inline-block;
    position: relative;
    cursor: pointer;
}

.checkbox-container input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 18px;
    width: 18px;
    background-color: #eee;
    border-radius: 3px;
    pointer-events: none;
}

/* Paginador */
.paginator {
    position: sticky;
    bottom: 0;
    padding: 16px;
    background-color: #fff;
    border-top: 1px solid #dee2e6;
    z-index: 5;
}

/* Media queries para pantallas pequeñas */
@media (max-width: 768px) {
    .table-wrapper {
        border-radius: 0;
    }

    td, th {
        padding: 8px 12px;
        font-size: 14px;
        min-width: 80px;
    }

    .checkbox-column {
        width: 40px;
        min-width: 40px;
    }

    .priority-column {
        width: 100px;
        min-width: 100px;
    }

    .acciones {
        width: 100px;
        min-width: 100px;
    }

    button.pi {
        padding: 6px;
        margin: 0 1px;
        min-width: 28px;
        height: 28px;
        font-size: 12px;
    }

    .priority-badge {
        font-size: 10px;
        padding: 2px 6px;
    }

    .selection-toolbar {
        padding: 8px 12px;
        font-size: 14px;
    }

    .paginator {
        padding: 12px;
    }
}

@media (max-width: 480px) {
    table {
        min-width: 600px; /* Reducir el ancho mínimo en móviles muy pequeños */
    }

    td, th {
        padding: 6px 8px;
        font-size: 12px;
        min-width: 60px;
    }

    .checkbox-column {
        width: 35px;
        min-width: 35px;
    }

    .acciones {
        width: 80px;
        min-width: 80px;
    }

    button.pi {
        padding: 4px;
        min-width: 24px;
        height: 24px;
        font-size: 10px;
    }
}</style>
