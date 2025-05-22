<script>
import tableComponent from "@/components/Commons/TableComponent.vue";
import apiServices from "../../../services/ApiServices";
import equipmentServices from "../../../services/EquipmentServices";

export default {
    name: "CompanyEquipment",
    components: { tableComponent },
    data() {
        return {
            columns: [
                { label: "Nombre", key: "client_name" },
                { label: "Teléfono", key: "phone" },
                { label: "Marca", key: "brand" },
                { label: "Modelo", key: "model" },
                { label: "Serie", key: "serial" },
                { label: "Estado", key: "status" }
            ],
            equipments: [],
            companyId: null,
            companyType: null,
            companyData: null,
            loading: true,
            error: null
        };
    },
    async created() {
        // Obtener ID y tipo de la empresa desde los parámetros de la ruta
        this.companyId = this.$route.params.id;
        this.companyType = this.$route.params.type;

        console.log("Parámetros de la ruta recibidos:", {
            id: this.companyId,
            type: this.companyType
        });

        if (this.companyId && this.companyType) {
            try {
                // Normalizar el tipo para asegurar compatibilidad
                this.normalizeCompanyType();

                console.log("Tipo normalizado:", this.companyType);

                await this.fetchCompanyData();
            } catch (error) {
                this.error = `Error al cargar datos: ${error.message}`;
                console.error("Error completo:", error);
            } finally {
                this.loading = false;
            }
        } else {
            this.error = "No se proporcionó un ID o tipo de empresa válido";
            this.loading = false;
        }
    },
    methods: {
        normalizeCompanyType() {
            // Asegurar que el tipo de compañía esté en el formato correcto
            if (this.companyType) {
                // Convertir a minúsculas y eliminar espacios
                const type = this.companyType.toLowerCase().trim();

                // Mapear a los tipos aceptados
                if (type === 'micro' || type.includes('micro')) {
                    this.companyType = 'micro';
                } else if (type === 'person' || type.includes('person')) {
                    this.companyType = 'person';
                } else {
                    this.companyType = 'company';
                }
            }
        },

        async fetchCompanyData() {
            try {
                // Obtener datos de la empresa según su tipo
                const endpoint = this.getEndpointByType();
                console.log("Obteniendo datos de la empresa en:", endpoint);

                this.companyData = await apiServices.get(endpoint);
                console.log("Datos de la empresa obtenidos:", this.companyData);
            } catch (error) {
                console.error("Error al obtener datos de la empresa:", error);
                throw new Error("No se pudieron cargar los datos de la empresa");
            }
        },

        getEndpointByType() {
            switch(this.companyType) {
                case 'micro':
                    return `micro-company/${this.companyId}`;
                case 'person':
                    return `natural-person/${this.companyId}`;
                case 'company':
                default:
                    return `company/${this.companyId}`;
            }
        },

        async fetchEquipments() {
            try {
                console.log(`Solicitando equipos para ${this.companyType} con ID ${this.companyId}`);

                // Usar el servicio para obtener equipos
                this.equipments = await equipmentServices.getEquipmentsByEntity(
                    this.companyId,
                    this.companyType
                );

                console.log("Equipos obtenidos:", this.equipments);
            } catch (error) {
                console.error("Error al obtener equipos:", error);
                throw new Error("No se pudieron cargar los equipos: " + error.message);
            }
        }
    }
};
</script>

<template>
    <div class="company-equipment-container">
        <!-- Mensaje de error si existe -->
        <div v-if="error" class="error-message">
            {{ error }}
            <button class="back-button" @click="$router.go(-1)">
                <i class="pi pi-arrow-left"></i> Volver
            </button>
        </div>

        <div v-else>
            <!-- Información de la empresa -->
            <div v-if="companyData" class="company-info">
                <h2>{{ companyData.name || companyData.client_name }}</h2>
                <p><strong>RUC/DNI:</strong> {{ companyData.ruc || companyData.dni }}</p>
                <p v-if="companyData.address"><strong>Dirección:</strong> {{ companyData.address }}</p>
                <button class="back-button" @click="$router.go(-1)">
                    <i class="pi pi-arrow-left"></i> Volver
                </button>
            </div>

            <!-- Mostrar mensaje de carga -->
            <div v-if="loading" class="loading-message">
                Cargando equipos...
            </div>

            <!-- Mostrar mensaje si no hay equipos -->
            <div v-else-if="equipments.length === 0" class="no-data">
                No se encontraron equipos para esta entidad.
            </div>

            <!-- Mostrar tabla con equipos -->
            <div v-else>
                <h3>Equipos registrados</h3>
                <table-component
                    :data="equipments"
                    :columns="columns"
                    entityType="equipment"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>
.company-equipment-container {
    padding: 20px;
}

.company-info {
    background-color: #f5f5f5;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.loading-message, .no-data {
    text-align: center;
    padding: 20px;
    font-size: 16px;
    color: #666;
}

.error-message {
    text-align: center;
    padding: 20px;
    font-size: 16px;
    color: #d32f2f;
    background-color: #ffebee;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.error-message button {
    margin-top: 15px;
}

h3 {
    margin-bottom: 15px;
    color: #333;
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
    margin-top: 10px;
    font-size: 14px;
}

.back-button:hover {
    background-color: #e0e0e0;
}
</style>
