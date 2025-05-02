import urlServices from "./UrlServices.js";
import axios from "axios";

const apiClient = axios.create({
    baseURL: `${urlServices}:8000/api`,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    }
});

class Requester {
    async get(url, headers = {}) {
        try {
            console.log(`Realizando solicitud GET a: ${url}`);
            const response = await apiClient.get(url, { headers });

            // Verificar si la respuesta es HTML en lugar de JSON
            if (response.data && typeof response.data === 'string' &&
                response.data.includes('<!DOCTYPE html>')) {
                console.error('Error: La API está devolviendo HTML en lugar de JSON');
                throw new Error('La API está devolviendo HTML en lugar de JSON. Verifica la configuración del servidor.');
            }

            return response.data;
        } catch (error) {
            console.error('Error en la solicitud GET:', error);
            throw error; // Re-lanzar el error para manejarlo en el componente
        }
    }

    async post(url, data, headers = {}) {
        try {
            console.log(`Realizando solicitud POST a: ${url}`);
            const response = await apiClient.post(url, data, { headers });

            // Verificar si la respuesta es HTML en lugar de JSON
            if (response.data && typeof response.data === 'string' &&
                response.data.includes('<!DOCTYPE html>')) {
                console.error('Error: La API está devolviendo HTML en lugar de JSON');
                throw new Error('La API está devolviendo HTML en lugar de JSON. Verifica la configuración del servidor.');
            }

            return response.data;
        } catch (error) {
            console.error('Error en la solicitud POST:', error);
            throw error; // Re-lanzar el error para manejarlo en el componente
        }
    }

    async put(url, data, headers = {}) {
        try {
            console.log(`Realizando solicitud PUT a: ${url}`);
            const response = await apiClient.put(url, data, { headers });

            // Verificar si la respuesta es HTML en lugar de JSON
            if (response.data && typeof response.data === 'string' &&
                response.data.includes('<!DOCTYPE html>')) {
                console.error('Error: La API está devolviendo HTML en lugar de JSON');
                throw new Error('La API está devolviendo HTML en lugar de JSON. Verifica la configuración del servidor.');
            }

            return response.data;
        } catch (error) {
            console.error('Error en la solicitud PUT:', error);
            throw error; // Re-lanzar el error para manejarlo en el componente
        }
    }

    async delete(url, headers = {}) {
        try {
            console.log(`Realizando solicitud DELETE a: ${url}`);
            const response = await apiClient.delete(url, { headers });

            // Verificar si la respuesta es HTML en lugar de JSON
            if (response.data && typeof response.data === 'string' &&
                response.data.includes('<!DOCTYPE html>')) {
                console.error('Error: La API está devolviendo HTML en lugar de JSON');
                throw new Error('La API está devolviendo HTML en lugar de JSON. Verifica la configuración del servidor.');
            }

            return response.data;
        } catch (error) {
            console.error('Error en la solicitud DELETE:', error);
            throw error; // Re-lanzar el error para manejarlo en el componente
        }
    }
}

const requester = new Requester();

export default {
    // Métodos genéricos expuestos
    get: (endpoint) => requester.get(endpoint),
    post: (endpoint, data) => requester.post(endpoint, data),
    put: (endpoint, data) => requester.put(endpoint, data),
    delete: (endpoint) => requester.delete(endpoint),
}
