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
        // Nueva prop para configurar los botones disponibles
        availableActions: {
            type: Array,
            default: () => ['view', 'equipment', 'chat'] // Todas las acciones por defecto
        },
        // Nueva prop para mostrar checkbox de selección (solo admin)
        showSelectionCheckbox: {
            type: Boolean,
            default: false
        },
        // Nueva prop para mostrar columna de prioridad
        showPriorityColumn: {
            type: Boolean,
            default: false
        },
        // Prop para el usuario actual (para verificar rol)
        currentUser: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            showPopup: false,
            first: 0,
            rows: 10,
            rowsPerPageOptions: [5, 10, 20, 50],
            selectedClientId: null,
            selectedRows: [], // Array para almacenar las filas seleccionadas
            selectAll: false, // Estado del checkbox "Seleccionar todo"
            // Configuración centralizada de botones
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
                // Puedes agregar más botones según necesites
            }
        };
    },
    computed: {
        navbarConfig() {
            return this.$route.meta.navbarConfig || {};
        },
        paginatedData() {
            return this.data.slice(this.first, this.first + this.rows);
        },
        // Computed para obtener los botones que deben mostrarse
        visibleButtons() {
            if (!this.showButtons()) return [];

            return this.availableActions
                .filter(actionKey => this.buttonConfig[actionKey])
                .map(actionKey => ({
                    key: actionKey,
                    ...this.buttonConfig[actionKey]
                }));
        },
        // Verificar si el usuario es admin
        isAdmin() {
            return this.currentUser && (this.currentUser.role === 'admin' || this.currentUser.isAdmin === true);
        },
        // Verificar si debe mostrar el checkbox (solo admin)
        shouldShowCheckbox() {
            return this.showSelectionCheckbox && this.isAdmin;
        },
        // Estado intermedio del checkbox principal
        isIndeterminate() {
            return this.selectedRows.length > 0 && this.selectedRows.length < this.paginatedData.length;
        }
    },
    watch: {
        // Watchers para manejar la selección
        selectedRows: {
            handler(newVal) {
                this.selectAll = newVal.length === this.paginatedData.length && this.paginatedData.length > 0;
                // Emitir evento con las filas seleccionadas
                this.$emit('selection-change', newVal);
            },
            deep: true
        },
        paginatedData() {
            // Limpiar selección al cambiar de página
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
            // Si se especifican acciones disponibles, siempre mostrar los botones
            if (this.availableActions && this.availableActions.length > 0) {
                return true;
            }
            // Fallback a la configuración original
            return this.$route.meta.navbarConfig?.companySoporteTi === true;
        },

        // Método centralizado para ejecutar acciones
        executeAction(actionKey, row) {
            if (this[actionKey]) {
                this[actionKey](row);
            } else {
                console.warn(`Acción ${actionKey} no encontrada`);
            }
        },

        // Métodos para manejar la selección
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

        // Método para obtener el color de prioridad
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

        // Método para formatear texto de prioridad
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

        viewEquipment(row) {
            const id = row.id || row._id;

            if (!id) {
                console.error("Error: No se pudo obtener el ID del registro", row);
                return;
            }

            console.log("Navegando a detalles de equipos para:", row);
            console.log("ID:", id, "Tipo:", this.entityType);

            if (this.entityType === "equipment") {
                const urlParts = this.$route.path.split('/');
                const companyIdIndex = urlParts.indexOf('company-equipment') + 1;
                const companyId = urlParts[companyIdIndex] || this.$route.params.id;

                console.log("Navegando a detalles de equipo con companyId:", companyId, "equipmentId:", id);

                this.$router.push({
                    name: "Detalles de Equipo",
                    params: {
                        companyId: companyId,
                        equipmentId: id,
                    },
                });
            } else {
                let type = this.entityType;

                if (this.$route.name === "CompanyMicro" || this.$route.name.includes("Microempresa")) {
                    type = "micro";
                } else if (this.$route.name === "CompanyPerson" || this.$route.name.includes("Persona")) {
                    type = "person";
                } else {
                    type = "company";
                }

                console.log("Navegando a equipos de empresa con ID:", id, "Tipo:", type);

                this.$router.push({
                    name: "Equipos de Empresa",
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

        // Nuevos métodos para las acciones adicionales
        viewChat(row) {
            // Implementa la lógica para ir al chat
            const id = row.id || row._id;
            console.log('Ir al chat con ID:', id);

            // Ejemplo de navegación al chat
            this.$router.push({
                name: 'Chat',
                params: { id: id },
                query: { type: this.entityType || 'default' }
            });
        },

        editRecord(row) {
            // Implementa la lógica para editar
            console.log('Editar registro:', row);
            this.$emit('edit', row);
        },

        deleteRecord(row) {
            // Implementa la lógica para eliminar
            console.log('Eliminar registro:', row);
            this.$emit('delete', row);
        },

        downloadRecord(row) {
            // Implementa la lógica para descargar
            console.log('Descargar registro:', row);
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
        <!-- Toolbar para acciones masivas (solo si hay selección) -->
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
                        <!-- Checkbox para seleccionar todo (solo admin) -->
                        <th v-if="shouldShowCheckbox" class="checkbox-column">
                            <input type="checkbox" :checked="selectAll" :indeterminate="isIndeterminate"
                                @change="toggleSelectAll" title="Seleccionar todo" />
                        </th>

                        <!-- Columna de prioridad -->
                        <th v-if="showPriorityColumn" class="priority-column">Prioridad</th>

                        <th v-for="(col, index) in columns" :key="index">
                            {{ col.label }}
                        </th>
                        <th v-if="this.$route.meta.role === 'admin-tickets'">Prioridad</th>
                        <th v-if="visibleButtons.length > 0">Acciones</th>
                        <th v-if="this.$route.meta.role === 'admin-tickets'">Soporte In Situ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, rowIndex) in paginatedData" :key="rowIndex"
                        :class="{ 'selected-row': isRowSelected(row) }">

                        <!-- Checkbox para seleccionar fila (solo admin) -->
                        <td v-if="shouldShowCheckbox" class="checkbox-column">
                            <input type="checkbox" :checked="isRowSelected(row)" @change="toggleRowSelection(row)" />
                        </td>

                        <!-- Columna de prioridad -->
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

                        <td v-if="this.$route.meta.role === 'admin-tickets'">
                            <button class="pi pi-arrow-down"></button>
                        </td>

                        <td v-if="visibleButtons.length > 0" class="acciones">
                            <button v-for="button in visibleButtons" :key="button.key" :class="button.icon"
                                :title="button.title" @click="executeAction(button.action, row)"></button>
                        </td>

                        <td v-if="this.$route.meta.role === 'admin-tickets'" class="acciones">
                            <label v-for="button in visibleButtons" :key="button.key" class="checkbox-container">
                                <input type="checkbox" :title="button.title" @change="executeAction(button.action, row)" :checked="button.checked || false">
                                <span class="checkmark"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Paginador funcional -->
        <Paginator :rows="rows" :totalRecords="data.length" :first="first" :rowsPerPageOptions="rowsPerPageOptions"
            @page="onPageChange" class="paginator" />

        <!-- Popup -->
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
