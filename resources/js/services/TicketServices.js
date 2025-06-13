// src/services/TicketServices.js
import apiServices from "./ApiServices";

class TicketService {
    // Obtener todos los tickets
    async getAllTickets() {
        try {
            return await apiServices.get("/tickets");
        } catch (error) {
            console.error("Error al obtener tickets:", error);
            throw error;
        }
    }

    // Obtener tickets filtrados por estado
    async getTicketsByStatus(status) {
        try {
            return await apiServices.get(`/tickets?status=${status}`);
        } catch (error) {
            console.error(
                `Error al obtener tickets con estado ${status}:`,
                error
            );
            throw error;
        }
    }

    // Obtener tickets por cliente
    async getTicketsByClient(clientId) {
        try {
            return await apiServices.get(`/tickets?clientId=${clientId}`);
        } catch (error) {
            console.error(
                `Error al obtener tickets del cliente ${clientId}:`,
                error
            );
            throw error;
        }
    }

    // Obtener tickets por urgencia
    async getTicketsByUrgency(urgency) {
        try {
            return await apiServices.get(`/tickets?urgency=${urgency}`);
        } catch (error) {
            console.error(`Error al obtener tickets urgentes:`, error);
            throw error;
        }
    }

    // Método flexible para obtener tickets con múltiples filtros
    async getFilteredTickets(filters = {}) {
        try {
            const queryParams = Object.entries(filters)
                .map(([key, value]) => `${key}=${value}`)
                .join('&');

            const endpoint = queryParams ? `/tickets?${queryParams}` : '/tickets';
            return await apiServices.get(endpoint);
        } catch (error) {
            console.error('Error al obtener tickets filtrados:', error);
            throw error;
        }
    }

    // **NUEVO/MODIFICADO:** Método para obtener la cantidad de máquinas, opcionalmente por empresa.
    async getMachinesCount(companyId = null) {
        try {
            let endpoint = '/machine';
            if (companyId) {
                // Asume que tu API soporta filtrar máquinas por companyId
                endpoint = `/machine?companyId=${companyId}`;
            }
            const response = await apiServices.get(endpoint);
            // Asegúrate de que response.data sea el array o que response sea el array directamente.
            // Si apiServices ya devuelve response.data, entonces response.length.
            // Si la respuesta de axios es { data: [...] }, entonces response.data.length.
            if (response && Array.isArray(response)) {
                return response.length; // Si apiServices ya devuelve response.data directamente
            }
            if (response && Array.isArray(response.data)) {
                 return response.data.length; // Si la respuesta de axios es { data: [...] }
            }

            console.warn("La respuesta de /machine no es un array válido:", response);
            return 0; // Si la respuesta no es un array válido, devuelve 0
        } catch (error) {
            console.error("Error al obtener la cantidad de equipos:", error);
            if (error.response && error.response.status === 404) {
                 return 0; // Para no bloquear si el endpoint no está listo o no se encuentra
            }
            throw error; // Re-lanza otros errores si no es 404
        }
    }
}

export default new TicketService();
