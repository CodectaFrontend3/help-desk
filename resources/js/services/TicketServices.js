// TicketService.js
import apiServices from './ApiServices';

class TicketService {
    // Obtener todos los tickets
    async getAllTickets() {
        try {
            return await apiServices.get('/tickets');
        } catch (error) {
            console.error('Error al obtener tickets:', error);
            throw error;
        }
    }

    // Obtener tickets filtrados por estado
    async getTicketsByStatus(status) {
        try {
            return await apiServices.get(`/tickets?status=${status}`);
        } catch (error) {
            console.error(`Error al obtener tickets con estado ${status}:`, error);
            throw error;
        }
    }

    // Obtener tickets por cliente
    async getTicketsByClient(clientId) {
        try {
            return await apiServices.get(`/tickets?clientId=${clientId}`);
        } catch (error) {
            console.error(`Error al obtener tickets del cliente ${clientId}:`, error);
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
}

export default new TicketService();
