<script>
import equipmentServices from '../../../services/EquipmentServices';

export default {
    name: "CompanyEquipmentDetails",
    data() {
        return {
            equipment: null,
            loading: true,
            error: null
        };
    },
    async created() {
        const { equipmentId } = this.$route.params;

        if (equipmentId) {
            await this.fetchEquipmentDetails(equipmentId);
        } else {
            this.error = "No se proporcionó un ID de equipo válido";
            this.loading = false;
        }
    },
    methods: {
        async fetchEquipmentDetails(id) {
            try {
                // Utilizar el servicio especializado para obtener detalles del equipo
                this.equipment = await equipmentServices.getEquipmentDetails(id);
                console.log("Detalles del equipo:", this.equipment);
            } catch (error) {
                console.error("Error al obtener detalles del equipo:", error);
                this.error = "Error al cargar los detalles del equipo: " + error.message;
            } finally {
                this.loading = false;
            }
        },
        goBack() {
            this.$router.go(-1); // Volver a la página anterior
        }
    }
};
</script>

<template>
    <div class="equipment-details-container">
        <button class="back-button" @click="goBack">
            <i class="pi pi-arrow-left"></i> Volver
        </button>

        <!-- Mostrar mensaje de carga -->
        <div v-if="loading" class="loading-message">
            Cargando detalles del equipo...
        </div>

        <!-- Mostrar mensaje de error -->
        <div v-else-if="error" class="error-message">
            {{ error }}
        </div>

        <!-- Mostrar detalles del equipo -->
        <div v-else-if="equipment" class="equipment-card">
            <h2>Detalles del Equipo</h2>

            <div class="equipment-info">
                <div class="info-row">
                    <div class="info-label">Nombre:</div>
                    <div class="info-value">{{ equipment.name }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Tipo:</div>
                    <div class="info-value">{{ equipment.type }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Marca:</div>
                    <div class="info-value">{{ equipment.brand }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Modelo:</div>
                    <div class="info-value">{{ equipment.model }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Número de Serie:</div>
                    <div class="info-value">{{ equipment.serial }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Estado:</div>
                    <div class="info-value" :class="{'status-active': equipment.status === 'Activo'}">
                        {{ equipment.status }}
                    </div>
                </div>

                <!-- Mostrar fecha de adquisición si existe -->
                <div v-if="equipment.acquisitionDate" class="info-row">
                    <div class="info-label">Fecha de Adquisición:</div>
                    <div class="info-value">{{ new Date(equipment.acquisitionDate).toLocaleDateString() }}</div>
                </div>

                <!-- Mostrar historial de mantenimiento si existe -->
                <div v-if="equipment.maintenanceHistory && equipment.maintenanceHistory.length > 0" class="maintenance-history">
                    <h3>Historial de Mantenimiento</h3>
                    <ul>
                        <li v-for="(maintenance, index) in equipment.maintenanceHistory" :key="index">
                            <div>
                                <strong>Fecha:</strong> {{ new Date(maintenance.date).toLocaleDateString() }}
                            </div>
                            <div>
                                <strong>Tipo:</strong> {{ maintenance.type }}
                            </div>
                            <div>
                                <strong>Descripción:</strong> {{ maintenance.description }}
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Mostrar observaciones si existen -->
                <div v-if="equipment.observations" class="info-row">
                    <div class="info-label">Observaciones:</div>
                    <div class="info-value observation-text">{{ equipment.observations }}</div>
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
    max-width: 800px;
    margin: 0 auto;
}

.back-button {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background-color: #f0f0f0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-bottom: 20px;
    font-size: 14px;
}

.back-button:hover {
    background-color: #e0e0e0;
}

.equipment-card {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.equipment-card h2 {
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
    color: #333;
}

.equipment-info {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.info-row {
    display: flex;
    border-bottom: 1px solid #f5f5f5;
    padding-bottom: 8px;
}

.info-label {
    flex: 1;
    font-weight: bold;
    color: #666;
}

.info-value {
    flex: 2;
}

.status-active {
    color: green;
    font-weight: bold;
}

.maintenance-history {
    margin-top: 20px;
}

.maintenance-history h3 {
    font-size: 18px;
    margin-bottom: 10px;
}

.maintenance-history ul {
    list-style: none;
    padding: 0;
}

.maintenance-history li {
    background-color: #f9f9f9;
    padding: 12px;
    margin-bottom: 8px;
    border-radius: 4px;
}

.observation-text {
    white-space: pre-line;
}

.loading-message, .error-message, .no-data {
    text-align: center;
    padding: 30px;
    font-size: 16px;
}

.error-message {
    color: #d32f2f;
    background-color: #ffebee;
    border-radius: 8px;
    padding: 20px;
}
</style>
