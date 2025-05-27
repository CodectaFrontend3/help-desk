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

            // Usar el nuevo endpoint para todos los tipos de entidad
            const endpoint = 'machine';

            console.log(`Solicitando equipos para ${entityType} con ID ${entityId}. Endpoint: ${endpoint}`);

            // Obtener todos los equipos y luego filtrar por la entidad seleccionada
            const allEquipments = await apiServices.get(endpoint);

            // Mapear los tipos de entidad a los campos correspondientes en la tabla teams
            const fieldMap = {
                'company': 'id_company',
                'micro': 'id_microcompany',
                'person': 'id_personN'
            };

            const idField = fieldMap[entityType.toLowerCase()] || 'id_company';

            const filteredEquipments = allEquipments.filter(equipment =>
                equipment[idField] && equipment[idField].toString() === entityId.toString()
            );

            console.log(`Se encontraron ${filteredEquipments.length} equipos para la entidad`);

            return filteredEquipments;
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
            return await apiServices.get(`machine/${equipmentId}`);
        } catch (error) {
            console.error(`Error al obtener detalles del equipo ${equipmentId}:`, error);
            throw error;
        }
    }
};

export default EquipmentServices;
