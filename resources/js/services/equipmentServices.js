import apiServices from "./ApiServices";

const EquipmentServices = {
    /**
     * Obtiene equipos de una empresa, microempresa o persona natural
     * @param {string} entityId - ID de la entidad (empresa, microempresa, persona natural)
     * @param {string} entityType - Tipo de entidad ('company', 'micro', 'person')
     * @returns {Promise<Array>} - Lista de equipos
     */
    async getEquipmentsByEntity(entityId, entityType) {
        try {
            // Validar parámetros
            if (!entityId) {
                throw new Error("Se requiere un ID de entidad válido");
            }

            if (!entityType) {
                console.warn("Tipo de entidad no especificado, usando 'company' por defecto");
                entityType = 'company';
            }

            // Determinar el endpoint correcto según el tipo de entidad
            let endpoint = '';

            switch(entityType.toLowerCase()) {
                case 'micro':
                    endpoint = `micro-company/${entityId}/equipments`;
                    break;
                case 'person':
                    endpoint = `natural-person/${entityId}/equipments`;
                    break;
                case 'company':
                    endpoint = `company/${entityId}/equipments`;
                    break;
                default:
                    console.warn(`Tipo de entidad no reconocido: ${entityType}, usando 'company' por defecto`);
                    endpoint = `company/${entityId}/equipments`;
            }

            console.log(`Solicitando equipos para ${entityType} con ID ${entityId}. Endpoint: ${endpoint}`);

            // Añadir manejo de error específico para respuestas HTML
            try {
                return await apiServices.get(endpoint);
            } catch (apiError) {
                // Si el error es debido a recibir HTML en lugar de JSON
                if (apiError.message && apiError.message.includes('HTML en lugar de JSON')) {
                    console.error(`El endpoint ${endpoint} está devolviendo HTML. Posible problema de configuración en el servidor o ruta incorrecta.`);
                    throw new Error(`No se pudieron obtener los equipos. Verifique la configuración del servidor para el endpoint ${endpoint}`);
                }
                throw apiError;
            }
        } catch (error) {
            console.error(`Error al obtener equipos para ${entityType} con ID ${entityId}:`, error);
            throw error;
        }
    },

    /**
     * Obtiene detalles de un equipo específico
     * @param {string} equipmentId - ID del equipo
     * @returns {Promise<Object>} - Detalles del equipo
     */
    async getEquipmentDetails(equipmentId) {
        try {
            if (!equipmentId) {
                throw new Error("Se requiere un ID de equipo válido");
            }

            console.log(`Solicitando detalles del equipo con ID ${equipmentId}`);
            return await apiServices.get(`equipment/${equipmentId}`);
        } catch (error) {
            console.error(`Error al obtener detalles del equipo ${equipmentId}:`, error);
            throw error;
        }
    }
};

export default EquipmentServices;
