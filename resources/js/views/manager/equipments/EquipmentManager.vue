<template>
    <div class="manager-company-equipment-container">
        <div v-if="error" class="error-message">
            {{ error }}
            <button class="back-button" @click="goBack">
                <i class="pi pi-arrow-left"></i> Volver
            </button>
        </div>

        <div v-else>
            <div v-if="loading" class="loading-message">
                <div class="loader"></div>
                <p>Cargando equipos de {{ companyName }}...</p>
            </div>

            <div v-else-if="equipments.length === 0" class="no-data">
                No se encontraron equipos registrados para {{ companyName }}.
            </div>

            <div v-else>
    <h3>Equipos Registrados - {{ companyName }}</h3>
    <p class="equipment-count">Total de equipos: {{ equipments.length }} | Mostrados: {{ filteredEquipments.length }}</p>

    <!-- Controles de Filtros y Ordenamiento -->
    <div class="filters-container">
        <!-- Filtro de texto -->
        <div class="filter-group">
            <label>Buscar:</label>
            <div class="search-input-container">
                <input
                    v-model="filterText"
                    type="text"
                    placeholder="Buscar por marca, tipo, usuario o área..."
                    class="search-input"
                >
                <i class="pi pi-search search-icon"></i>
            </div>
        </div>

        <!-- Filtro por categoría -->
        <div class="filter-group">
            <label>Filtrar por tipo:</label>
            <select v-model="filterBy" class="filter-select">
                <option value="all">Todos los equipos</option>
                <option value="laptop">Laptops</option>
                <option value="pc">Computadoras</option>
                <option value="impresora">Impresoras</option>
            </select>
        </div>

        <!-- Ordenamiento -->
        <div class="filter-group">
            <label>Ordenar por:</label>
            <select v-model="sortBy" class="filter-select">
                <option value="brand">Marca</option>
                <option value="type">Tipo</option>
                <option value="username">Usuario</option>
                <option value="end_revision">Última Revisión</option>
                <option value="revision_scheduled">Próxima Revisión</option>
            </select>
        </div>

        <!-- Botón de orden -->
        <div class="filter-group">
            <button @click="toggleSortOrder" class="sort-button" :title="sortOrder === 'asc' ? 'Cambiar a descendente' : 'Cambiar a ascendente'">
                <i :class="sortOrder === 'asc' ? 'pi pi-sort-amount-up' : 'pi pi-sort-amount-down'"></i>
                {{ sortOrder === 'asc' ? 'A-Z' : 'Z-A' }}
            </button>
        </div>

        <!-- Botón limpiar filtros -->
        <div class="filter-group">
            <button @click="clearFilters" class="clear-button">
                <i class="pi pi-times"></i>
                Limpiar
            </button>
        </div>
    </div>

    <!-- Mensaje cuando no hay resultados -->
    <div v-if="filteredEquipments.length === 0" class="no-results">
        No se encontraron equipos que coincidan con los filtros aplicados.
    </div>

    <!-- Grid de equipos -->
    <div v-else class="equipment-grid">
        <div
            v-for="equipment in filteredEquipments"
            :key="equipment.id"
            class="equipment-card"
            @click="viewEquipmentDetails(equipment)"
        >
            <div class="equipment-icon">
                <i :class="getEquipmentIcon(equipment.type)"></i>
            </div>
            <div class="equipment-info">
                <h4 class="equipment-title">{{ equipment.brand }}</h4>
                <div class="equipment-details">
                    <p><strong>Usuario:</strong> {{ equipment.username }}</p>
                    <p><strong>Área:</strong> {{ getAreaFromType(equipment.type) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>

        <!-- Modal de Detalles del Equipo -->
        <div v-if="showModal" class="modal-overlay" @click="closeModal">
            <div class="modal-content" @click.stop>
                <div class="modal-header">
                    <h2>Detalles del Equipo</h2>
                    <button class="close-button" @click="closeModal">
                        <i class="pi pi-times"></i>
                    </button>
                </div>

                <div v-if="modalLoading" class="modal-loading">
                    <div class="loader"></div>
                    <p>Cargando detalles...</p>
                </div>

                <div v-else-if="modalError" class="modal-error">
                    {{ modalError }}
                </div>

                <div v-else-if="selectedEquipment" class="modal-body">
                    <div class="status-header">
                        <div class="status-badge" :class="getStatusColor(selectedEquipment.end_revision)">
                            {{ getStatusText(selectedEquipment.end_revision) }}
                        </div>
                    </div>

                    <div class="details-grid">
                        <div class="detail-card">
                            <h3>Información General</h3>
                            <div class="detail-item">
                                <label>ID:</label>
                                <span>{{ selectedEquipment.id }}</span>
                            </div>
                            <div class="detail-item">
                                <label>Marca:</label>
                                <span>{{ selectedEquipment.brand }}</span>
                            </div>
                            <div class="detail-item">
                                <label>Tipo:</label>
                                <span>{{ selectedEquipment.type }}</span>
                            </div>
                            <div class="detail-item">
                                <label>Usuario:</label>
                                <span>{{ selectedEquipment.username }}</span>
                            </div>
                        </div>

                        <div class="detail-card">
                            <h3>Información de Revisiones</h3>
                            <div class="detail-item">
                                <label>Última Revisión:</label>
                                <span>{{ formatDate(selectedEquipment.end_revision) }}</span>
                            </div>
                            <div class="detail-item">
                                <label>Próxima Revisión:</label>
                                <span>{{ formatDate(selectedEquipment.revision_scheduled) }}</span>
                            </div>
                        </div>

                        <div class="detail-card">
                            <h3>Referencias</h3>
                            <div class="detail-item">
                                <label>ID Cliente:</label>
                                <span>{{ selectedEquipment.id_clientG }}</span>
                            </div>
                            <div class="detail-item">
                                <label>ID Empresa:</label>
                                <span>{{ selectedEquipment.id_company }}</span>
                            </div>
                            <div class="detail-item">
                                <label>ID Persona:</label>
                                <span>{{ selectedEquipment.id_personN }}</span>
                            </div>
                            <div class="detail-item">
                                <label>ID Plan:</label>
                                <span>{{ selectedEquipment.id_plan }}</span>
                            </div>
                        </div>

                        <div class="detail-card">
                            <h3>Fechas del Sistema</h3>
                            <div class="detail-item">
                                <label>Creado:</label>
                                <span>{{ formatDate(selectedEquipment.created_at) }}</span>
                            </div>
                            <div class="detail-item">
                                <label>Actualizado:</label>
                                <span>{{ formatDate(selectedEquipment.updated_at) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import tableComponent from "@/components/Commons/TableComponent.vue";
import userService from "../../../services/UserService";
import equipmentServices from "../../../services/EquipmentServices";

export default {
    name: "ManagerCompanyEquipment",
    components: { tableComponent },
    data() {
        return {
            columns: [
                { label: "Marca", key: "brand" },
                { label: "Tipo", key: "type" },
                { label: "Usuario", key: "username" },
                { label: "Fin Revisión", key: "end_revision", format: true },
                { label: "Revisión Programada", key: "revision_scheduled", format: true },
            ],
            equipments: [],
            managerInfo: null,
            loading: true,
            error: null,
            companyName: "",
            // Modal data
            showModal: false,
            selectedEquipment: null,
            modalLoading: false,
            modalError: null,
            // FILTRADOR:
            filterText: "",
            sortBy: "brand",
            sortOrder: "asc",
            filterBy: "all", // all, brand, type, username
        };
    },
    async created() {
        try {
            console.log('Iniciando carga de datos del manager...');

            // Obtener la información del manager logueado
            const userData = await userService.getCurrentUserInfo();
            console.log('userData recibida:', userData);

            if (!userData || !userData.userId) {
                throw new Error("No se pudo determinar la información del manager.");
            }

            this.managerInfo = userData;
            this.companyName = this.managerInfo.companyName;

            console.log("Información del manager:", this.managerInfo);

            // Cargar los equipos
            await this.fetchEquipments();

        } catch (error) {
            this.error = `Error al cargar datos: ${error.message}`;
            console.error("Error completo en ManagerCompanyEquipment:", error);
            console.error("Stack trace:", error.stack);
        } finally {
            this.loading = false;
        }
    },
    methods: {
        async fetchEquipments() {
            if (!this.managerInfo) {
                this.error = "Falta información del manager para buscar equipos.";
                return;
            }

            try {
                console.log(`Obteniendo equipos para el manager ${this.managerInfo.name}`);

                // Opción 1: Usar las máquinas que ya vienen en la respuesta del usuario
                if (this.managerInfo.machines && this.managerInfo.machines.length > 0) {
                    this.equipments = this.managerInfo.machines;
                    console.log("Equipos obtenidos desde userService:", this.equipments);
                    return;
                }

                // Opción 2: Si necesitas usar el servicio de equipos
                this.equipments = await equipmentServices.getEquipmentsByEntity(
                    this.managerInfo.companyId,
                    this.managerInfo.companyType
                );

                console.log("Equipos obtenidos para el manager:", this.equipments);
            } catch (error) {
                console.error("Error al obtener equipos para el manager:", error);
                this.error = (this.error ? this.error + "\n" : "") + "No se pudieron cargar los equipos: " + error.message;
            }
        },

        goBack() {
            this.$router.go(-1);
        },

        // Método para ver detalles de un equipo específico en modal
        async viewEquipmentDetails(equipment) {
            this.selectedEquipment = equipment;
            this.showModal = true;
            this.modalLoading = true;
            this.modalError = null;

            try {
                // Si necesitas datos adicionales del equipo, puedes cargarlos aquí
                // Por ahora usamos los datos que ya tenemos
                console.log("Mostrando detalles del equipo:", equipment);

                // Simular carga de datos adicionales si es necesario
                // const additionalData = await equipmentServices.getEquipmentDetails(equipment.id);
                // this.selectedEquipment = { ...equipment, ...additionalData };

            } catch (error) {
                this.modalError = `Error al cargar detalles: ${error.message}`;
                console.error("Error al cargar detalles del equipo:", error);
            } finally {
                this.modalLoading = false;
            }
        },

        closeModal() {
            this.showModal = false;
            this.selectedEquipment = null;
            this.modalError = null;
        },

        // Método para obtener el icono según el tipo de equipo
        getEquipmentIcon(type) {
            const iconMap = {
                'laptop': 'pi pi-desktop',
                'impresora': 'pi pi-print',
                'pc': 'pi pi-desktop',
                'totam': 'pi pi-desktop',
                'laudantium': 'pi pi-print',
                'ipsa': 'pi pi-desktop',
                'qui': 'pi pi-desktop',
            };

            const lowerType = type?.toLowerCase() || '';

            if (lowerType.includes('laptop') || lowerType.includes('totam')) {
                return 'pi pi-desktop';
            } else if (lowerType.includes('impresora') || lowerType.includes('print') || lowerType.includes('laudantium')) {
                return 'pi pi-print';
            } else if (lowerType.includes('pc') || lowerType.includes('qui') || lowerType.includes('ipsa')) {
                return 'pi pi-desktop';
            }

            return iconMap[lowerType] || 'pi pi-desktop';
        },

        // Método para obtener el área según el tipo
        getAreaFromType(type) {
            const areaMap = {
                'totam': 'Administración',
                'laudantium': 'Diseño',
                'ipsa': 'Administración',
                'qui': 'Administración',
            };

            return areaMap[type?.toLowerCase()] || 'Administración';
        },

        // Métodos para el modal de detalles
        formatDate(dateString) {
            if (!dateString) return 'No disponible';

            try {
                const date = new Date(dateString);
                return date.toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            } catch (error) {
                return dateString;
            }
        },

        getStatusColor(endRevision) {
            if (!endRevision) return 'gray';

            const now = new Date();
            const revisionDate = new Date(endRevision);
            const daysDiff = Math.ceil((revisionDate - now) / (1000 * 60 * 60 * 24));

            if (daysDiff < 0) return 'red';
            if (daysDiff <= 30) return 'orange';
            return 'green';
        },

        getStatusText(endRevision) {
            if (!endRevision) return 'Sin información';

            const now = new Date();
            const revisionDate = new Date(endRevision);
            const daysDiff = Math.ceil((revisionDate - now) / (1000 * 60 * 60 * 24));

            if (daysDiff < 0) return `Vencido hace ${Math.abs(daysDiff)} días`;
            if (daysDiff <= 30) return `Vence en ${daysDiff} días`;
            return `Vigente por ${daysDiff} días`;
        },

        clearFilters() {
            this.filterText = "";
            this.filterBy = "all";
            this.sortBy = "brand";
            this.sortOrder = "asc";
        },

        toggleSortOrder() {
            this.sortOrder = this.sortOrder === "asc" ? "desc" : "asc";
        },
    },
    computed: {
        filteredEquipments() {
            let filtered = [...this.equipments];

            // Aplicar filtro de texto
            if (this.filterText.trim()) {
                const searchText = this.filterText.toLowerCase().trim();
                filtered = filtered.filter(equipment =>
                    equipment.brand?.toLowerCase().includes(searchText) ||
                    equipment.type?.toLowerCase().includes(searchText) ||
                    equipment.username?.toLowerCase().includes(searchText) ||
                    this.getAreaFromType(equipment.type).toLowerCase().includes(searchText)
                );
            }

            // Aplicar filtro por categoría
            if (this.filterBy !== "all") {
                filtered = filtered.filter(equipment => {
                    switch (this.filterBy) {
                        case "laptop":
                            return equipment.type?.toLowerCase().includes("laptop") ||
                                equipment.type?.toLowerCase().includes("totam");
                        case "impresora":
                            return equipment.type?.toLowerCase().includes("impresora") ||
                                equipment.type?.toLowerCase().includes("laudantium");
                        case "pc":
                            return equipment.type?.toLowerCase().includes("pc") ||
                                equipment.type?.toLowerCase().includes("qui") ||
                                equipment.type?.toLowerCase().includes("ipsa");
                        default:
                            return true;
                    }
                });
            }

            // Aplicar ordenamiento
            filtered.sort((a, b) => {
                let valueA = a[this.sortBy] || "";
                let valueB = b[this.sortBy] || "";

                // Manejar fechas
                if (this.sortBy === "end_revision" || this.sortBy === "revision_scheduled") {
                    valueA = new Date(valueA);
                    valueB = new Date(valueB);
                } else {
                    valueA = valueA.toString().toLowerCase();
                    valueB = valueB.toString().toLowerCase();
                }

                if (this.sortOrder === "asc") {
                    return valueA > valueB ? 1 : valueA < valueB ? -1 : 0;
                } else {
                    return valueA < valueB ? 1 : valueA > valueB ? -1 : 0;
                }
            });

            return filtered;
        }
    },
};
</script>

<style scoped>
/* FILTROS Y ORDENAMIENTO */
.filters-container {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    align-items: end;
}

.filter-group {
    display: flex;
    flex-direction: column;
    min-width: 150px;
}

.filter-group label {
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
    font-size: 0.9em;
}

.search-input-container {
    position: relative;
}

.search-input {
    width: 100%;
    min-width: 250px;
    padding: 10px 35px 10px 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

.search-input:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
}

.search-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
}

.filter-select {
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    background: white;
}

.filter-select:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
}

.sort-button {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.sort-button:hover {
    background-color: #2980b9;
}

.clear-button {
    background-color: #95a5a6;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.clear-button:hover {
    background-color: #7f8c8d;
}

.no-results {
    text-align: center;
    padding: 40px;
    color: #666;
    background: #f8f9fa;
    border-radius: 8px;
    margin: 20px 0;
}

@media (max-width: 768px) {
    .filters-container {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-group {
        min-width: auto;
    }

    .search-input {
        min-width: auto;
    }
}



.manager-company-equipment-container {
    padding: 20px;
}

.loading-message {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 40px;
}

.loader {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin-bottom: 10px;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

.error-message {
    background-color: #ffebee;
    color: #c62828;
    padding: 20px;
    border-radius: 5px;
    margin: 20px 0;
}

.no-data {
    text-align: center;
    padding: 40px;
    color: #666;
}

.equipment-count {
    margin-bottom: 20px;
    font-weight: bold;
    color: #666;
}

.equipment-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.equipment-card {
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.equipment-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.equipment-icon {
    text-align: center;
    margin-bottom: 15px;
}

.equipment-icon i {
    font-size: 2.5em;
    color: #3498db;
}

.equipment-title {
    text-align: center;
    margin-bottom: 10px;
    color: #333;
}

.equipment-details p {
    margin: 5px 0;
    color: #666;
}

.back-button {
    background-color: #6c757d;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    margin: 10px 0;
}

.back-button:hover {
    background-color: #5a6268;
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    border-radius: 8px;
    width: 90%;
    max-width: 800px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #eee;
}

.modal-header h2 {
    margin: 0;
    color: #333;
}

.close-button {
    background: none;
    border: none;
    font-size: 1.5em;
    cursor: pointer;
    color: #666;
    padding: 5px;
}

.close-button:hover {
    color: #333;
}

.modal-loading {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 40px;
}

.modal-error {
    color: #c62828;
    padding: 20px;
    background-color: #ffebee;
    margin: 20px;
    border-radius: 5px;
}

.modal-body {
    padding: 20px;
}

.status-header {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: bold;
    color: white;
}

.status-badge.green {
    background-color: #4caf50;
}

.status-badge.orange {
    background-color: #ff9800;
}

.status-badge.red {
    background-color: #f44336;
}

.status-badge.gray {
    background-color: #9e9e9e;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.detail-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
}

.detail-card h3 {
    margin-top: 0;
    margin-bottom: 15px;
    color: #333;
    border-bottom: 2px solid #3498db;
    padding-bottom: 5px;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #e9ecef;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-item label {
    font-weight: bold;
    color: #495057;
    min-width: 120px;
}

.detail-item span {
    color: #333;
    text-align: right;
}
</style>
