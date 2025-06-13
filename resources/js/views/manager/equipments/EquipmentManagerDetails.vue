<script>
import userService from "../../../services/UserService";
import equipmentServices from "../../../services/EquipmentServices";

export default {
    name: "EquipmentManagerDetails",
    data() {
        return {
            equipment: null,
            loading: true,
            error: null,
            managerInfo: null,
        };
    },
    async created() {
        try {
            // Obtener información del manager
            this.managerInfo = await userService.getCurrentUserInfo();

            // Obtener detalles del equipo
            await this.fetchEquipmentDetails();
        } catch (error) {
            this.error = `Error al cargar datos: ${error.message}`;
            console.error("Error en EquipmentManagerDetails:", error);
        } finally {
            this.loading = false;
        }
    },
    methods: {
        async fetchEquipmentDetails() {
            const equipmentId = this.$route.params.id;

            if (!equipmentId) {
                throw new Error("ID de equipo no proporcionado");
            }

            try {
                // Buscar el equipo en las máquinas del manager
                if (this.managerInfo.machines) {
                    this.equipment = this.managerInfo.machines.find(machine =>
                        machine.id.toString() === equipmentId.toString()
                    );
                }

                // Si no se encuentra, intentar obtenerlo del servicio
                if (!this.equipment) {
                    this.equipment = await equipmentServices.getEquipmentById(equipmentId);
                }

                if (!this.equipment) {
                    throw new Error("Equipo no encontrado o no tienes permisos para verlo");
                }

                console.log("Detalles del equipo:", this.equipment);
            } catch (error) {
                console.error("Error al obtener detalles del equipo:", error);
                throw error;
            }
        },

        goBack() {
            this.$router.go(-1);
        },

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

            if (daysDiff < 0) return 'red'; // Vencido
            if (daysDiff <= 30) return 'orange'; // Próximo a vencer
            return 'green'; // Vigente
        },

        getStatusText(endRevision) {
            if (!endRevision) return 'Sin información';

            const now = new Date();
            const revisionDate = new Date(endRevision);
            const daysDiff = Math.ceil((revisionDate - now) / (1000 * 60 * 60 * 24));

            if (daysDiff < 0) return `Vencido hace ${Math.abs(daysDiff)} días`;
            if (daysDiff <= 30) return `Vence en ${daysDiff} días`;
            return `Vigente por ${daysDiff} días`;
        }
    },
};
</script>

<template>
    <div class="equipment-details-container">
        <button class="back-button" @click="goBack">
            <i class="pi pi-arrow-left"></i> Volver a la lista
        </button>

        <div v-if="error" class="error-message">
            {{ error }}
        </div>

        <div v-else-if="loading" class="loading-message">
            <div class="loader"></div>
            <p>Cargando detalles del equipo...</p>
        </div>

        <div v-else-if="equipment" class="equipment-details">
            <div class="header">
                <h2>Detalles del Equipo</h2>
                <div class="status-badge" :class="getStatusColor(equipment.end_revision)">
                    {{ getStatusText(equipment.end_revision) }}
                </div>
            </div>

            <div class="details-grid">
                <div class="detail-card">
                    <h3>Información General</h3>
                    <div class="detail-item">
                        <label>ID:</label>
                        <span>{{ equipment.id }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Marca:</label>
                        <span>{{ equipment.brand }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Tipo:</label>
                        <span>{{ equipment.type }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Usuario:</label>
                        <span>{{ equipment.username }}</span>
                    </div>
                </div>

                <div class="detail-card">
                    <h3>Información de Revisiones</h3>
                    <div class="detail-item">
                        <label>Última Revisión:</label>
                        <span>{{ formatDate(equipment.end_revision) }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Próxima Revisión:</label>
                        <span>{{ formatDate(equipment.revision_scheduled) }}</span>
                    </div>
                </div>

                <div class="detail-card">
                    <h3>Referencias</h3>
                    <div class="detail-item">
                        <label>ID Cliente:</label>
                        <span>{{ equipment.id_clientG }}</span>
                    </div>
                    <div class="detail-item">
                        <label>ID Empresa:</label>
                        <span>{{ equipment.id_company }}</span>
                    </div>
                    <div class="detail-item">
                        <label>ID Persona:</label>
                        <span>{{ equipment.id_personN }}</span>
                    </div>
                    <div class="detail-item">
                        <label>ID Plan:</label>
                        <span>{{ equipment.id_plan }}</span>
                    </div>
                </div>

                <div class="detail-card">
                    <h3>Fechas del Sistema</h3>
                    <div class="detail-item">
                        <label>Creado:</label>
                        <span>{{ formatDate(equipment.created_at) }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Actualizado:</label>
                        <span>{{ formatDate(equipment.updated_at) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="no-data">
            No se encontraron detalles para este equipo.
        </div>
    </div>
</template>

<style scoped>
.equipment-details-container {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.back-button {
    margin-bottom: 20px;
    padding: 10px 15px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    transition: background-color 0.2s;
}

.back-button i {
    margin-right: 5px;
}

.back-button:hover {
    background-color: #e0e0e0;
}

.error-message {
    color: red;
    background-color: #ffebee;
    border: 1px solid red;
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.loading-message {
    text-align: center;
    padding: 40px;
    font-size: 1.2em;
}

.loader {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 0 auto 15px auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.equipment-details {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.header {
    background-color: #f8f9fa;
    padding: 20px;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h2 {
    margin: 0;
    color: #333;
}

.status-badge {
    padding: 8px 15px;
    border-radius: 20px;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 0.8em;
}

.status-badge.green {
    background-color: #d4edda;
    color: #155724;
}

.status-badge.orange {
    background-color: #fff3cd;
    color: #856404;
}

.status-badge.red {
    background-color: #f8d7da;
    color: #721c24;
}

.status-badge.gray {
    background-color: #e9ecef;
    color: #6c757d;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
}

.detail-card {
    background-color: #f8f9fa;
    border-radius: 6px;
    padding: 20px;
    border: 1px solid #e9ecef;
}

.detail-card h3 {
    margin: 0 0 15px 0;
    color: #495057;
    border-bottom: 2px solid #007bff;
    padding-bottom: 5px;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    padding: 8px 0;
    border-bottom: 1px solid #e9ecef;
}

.detail-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.detail-item label {
    font-weight: 600;
    color: #495057;
    flex: 0 0 40%;
}

.detail-item span {
    color: #212529;
    flex: 1;
    text-align: right;
}

.no-data {
    text-align: center;
    padding: 40px;
    color: #777;
    background-color: #f9f9f9;
    border-radius: 4px;
}

@media (max-width: 768px) {
    .details-grid {
        grid-template-columns: 1fr;
    }

    .header {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }

    .detail-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }

    .detail-item span {
        text-align: left;
    }
}
</style>
