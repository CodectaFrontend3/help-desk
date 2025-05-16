<script>
import TableComponent from '../../../components/Commons/TableComponent.vue';
import equipmentServices from '../../../services/EquipmentServices';

export default {
    name: "CompanyEquipmentDetails",
    components: { TableComponent },
    data() {
        return {
            equipment: null,
            loading: true,
            error: null,
            activeTab: 'usuario', // Valores posibles: 'usuario', 'hardware', 'software'
            softwareData: [],
            hardwareComponents: []
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

                // Simular carga de datos adicionales (software/hardware)
                if (this.equipment) {
                    // Simular datos de software que vendrian del backend
                    this.softwareData = [
                        {
                            nombre: 'Antivirus',
                            licencia: 'xxxxxxxxx',
                            correo: 'gth@gmail',
                            contrasena: 'ppppapp',
                            fec_instalacion: '25 May 2023',
                            fec_caducidad: '25 May 2024',
                            proveedor: 'info tec'
                        },
                        {
                            nombre: 'Microsoft Windows',
                            licencia: '8376478792',
                            correo: 'asdd@gmail',
                            contrasena: 'ppppapp',
                            fec_instalacion: '25 Ene 2020',
                            fec_caducidad: '25 Ene 2021',
                            proveedor: 'info tec'
                        },
                        {
                            nombre: 'Adobe',
                            licencia: '8475637289',
                            correo: 'asdd@gmail',
                            contrasena: 'ppppapp',
                            fec_instalacion: '20 Jun 2023',
                            fec_caducidad: '25 Jan 2024',
                            proveedor: 'info tec'
                        },
                        {
                            nombre: 'Adobe pirata',
                            licencia: '2947373920',
                            correo: 'dtd@gmail',
                            contrasena: '',
                            fec_instalacion: '30 May 2023',
                            fec_caducidad: '',
                            proveedor: 'Internet'
                        }
                    ];

                    // Simular datos de hardware que vendrian del backend
                    this.hardwareComponents = [
                        {
                            tipo: 'SSD',
                            fecha_instalacion: '5 May 2024',
                            descripcion: 'Almacenamiento de SSD de 500gb',
                            serie: '',
                            proveedor: 'Tienda X'
                        }
                    ];
                }

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
        },
        changeTab(tabName) {
            this.activeTab = tabName;
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
            <h2>Equipos - YYY</h2>

            <!-- Tabs de navegación -->
            <div class="equipment-tabs">
                <button
                    @click="changeTab('usuario')"
                    :class="['tab-button', { active: activeTab === 'usuario' }]">
                    Usuario
                </button>
                <button
                    @click="changeTab('hardware')"
                    :class="['tab-button', { active: activeTab === 'hardware' }]">
                    Hardware
                </button>
                <button
                    @click="changeTab('software')"
                    :class="['tab-button', { active: activeTab === 'software' }]">
                    Software
                </button>
            </div>

            <!-- Tab de Usuario -->
            <div v-if="activeTab === 'usuario'" class="tab-content">
                <div class="equipment-user-form">
                    <div class="equipment-icon">
                        <img src="/path/to/computer-icon.png" alt="Computer Icon" class="icon-image">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Usuario:</label>
                            <div class="input-dropdown">
                                <input type="text" v-model="equipment.username" disabled />
                                <span class="dropdown-icon">▼</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Área:</label>
                            <div class="input-dropdown">
                                <input type="text" value="area" disabled />
                                <span class="dropdown-icon">▼</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Sucursal:</label>
                            <input type="text" value="" disabled />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab de Hardware -->
            <div v-if="activeTab === 'hardware'" class="tab-content">
                <div class="hardware-content">
                    <div class="form-row two-columns">
                        <div class="form-group">
                            <label>Tipo del equipo:</label>
                            <input type="text" placeholder="nombre hardware" />
                        </div>
                        <div class="form-group">
                            <label>N° Serie:</label>
                            <input type="text" placeholder="serial" />
                        </div>
                        <div class="form-group">
                            <label>Fecha de compra:</label>
                            <input type="text" placeholder="fecha de compra" />
                        </div>
                    </div>

                    <div class="form-row three-columns">
                        <div class="form-group">
                            <label>Marca:</label>
                            <input type="text" placeholder="marca" />
                        </div>
                        <div class="form-group">
                            <label>Proveedor:</label>
                            <input type="text" placeholder="proveedor" />
                        </div>
                        <div class="form-group checkbox-group">
                            <div>
                                <label>Plan:</label>
                                <input type="checkbox" checked />
                            </div>
                            <div>
                                <label>Prioridad:</label>
                                <div class="priority-dropdown">
                                    <span>Alta</span>
                                    <span class="dropdown-icon">▼</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group full-width">
                            <label>Descripcion del equipo:</label>
                            <textarea placeholder="Teclado Lenovo K480, mecánico y ergonómico"></textarea>
                        </div>
                    </div>

                    <div class="hardware-components-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Fecha de Instalacion</th>
                                    <th>Descripcion</th>
                                    <th>Serie</th>
                                    <th>Proveedor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(component, index) in hardwareComponents" :key="index">
                                    <td>{{ component.tipo }}</td>
                                    <td>{{ component.fecha_instalacion }}</td>
                                    <td>{{ component.descripcion }}</td>
                                    <td>{{ component.serie }}</td>
                                    <td>{{ component.proveedor }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tab de Software -->
            <div v-if="activeTab === 'software'" class="tab-content">
                <div class="software-content">
                    <h3>Detalles del Software:</h3>

                    <div class="software-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Licencia</th>
                                    <th>Correo</th>
                                    <th>Contraseña</th>
                                    <th>Fec de instalacion</th>
                                    <th>Fec de caducidad</th>
                                    <th>Proveedor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(software, index) in softwareData" :key="index">
                                    <td>{{ software.nombre }}</td>
                                    <td>{{ software.licencia }}</td>
                                    <td>{{ software.correo }}</td>
                                    <td>{{ software.contrasena }}</td>
                                    <td>{{ software.fec_instalacion }}</td>
                                    <td>{{ software.fec_caducidad }}</td>
                                    <td>{{ software.proveedor }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="button-container">
                        <button class="back-action">Volver</button>
                    </div>
                </div>
            </div>

            <!-- Info general del equipo (siempre visible) -->
            <div v-if="false" class="equipment-info">
                <div class="info-row">
                    <div class="info-label">Marca:</div>
                    <div class="info-value">{{ equipment.brand }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Tipo:</div>
                    <div class="info-value">{{ equipment.type }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Usuario:</div>
                    <div class="info-value">{{ equipment.username }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Fin Revisión:</div>
                    <div class="info-value">{{ equipment.end_revision }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Revisión Programada:</div>
                    <div class="info-value" :class="{'status-active': equipment.status === 'Activo'}">
                        {{ equipment.revision_scheduled }}
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
    max-width: 1000px;
    margin: 0 auto;
    font-family: Arial, sans-serif;
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
    text-align: center;
}

/* Estilo para las pestañas */
.equipment-tabs {
    display: flex;
    background-color: #f0f0f0;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 20px;
}

.tab-button {
    flex: 1;
    padding: 10px 15px;
    border: none;
    background-color: transparent;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

.tab-button.active {
    background-color: #ffa726;
    color: white;
    font-weight: bold;
}

.tab-button:hover:not(.active) {
    background-color: #e0e0e0;
}

.tab-content {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    min-height: 300px;
}

/* Estilos para la sección Usuario */
.equipment-user-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
}

.equipment-icon {
    margin-bottom: 30px;
}

.icon-image {
    width: 120px;
    height: 120px;
    /* Usar una imagen de placeholder */
    background-color: #333;
    border-radius: 8px;
}

.form-row {
    width: 100%;
    margin-bottom: 15px;
    display: flex;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    flex: 1;
    margin-bottom: 10px;
}

.form-group label {
    margin-bottom: 5px;
    font-weight: bold;
    color: #666;
}

.form-group input, .form-group textarea {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.form-group textarea {
    height: 80px;
    resize: vertical;
}

.input-dropdown {
    position: relative;
}

.dropdown-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 12px;
    color: #666;
    pointer-events: none;
}

/* Estilos para hardware */
.two-columns {
    flex-wrap: wrap;
}

.two-columns .form-group {
    flex: 0 0 48%;
}

.three-columns {
    flex-wrap: wrap;
}

.three-columns .form-group {
    flex: 0 0 30%;
}

.full-width {
    width: 100%;
}

.checkbox-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.checkbox-group div {
    display: flex;
    align-items: center;
    gap: 10px;
}

.priority-dropdown {
    display: flex;
    align-items: center;
    background-color: #f5f5f5;
    padding: 3px 10px;
    border-radius: 4px;
    gap: 10px;
}

.hardware-components-table,
.software-table {
    width: 100%;
    margin-top: 20px;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th, table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

table th {
    background-color: #f5f5f5;
    font-weight: bold;
    color: #666;
}

table tr:hover {
    background-color: #f9f9f9;
}

/* Botón de volver en Software */
.button-container {
    margin-top: 20px;
    text-align: center;
}

.back-action {
    padding: 8px 16px;
    background-color: #ffa726;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
}

.back-action:hover {
    background-color: #ff9100;
}

/* Estilos antiguos */
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
