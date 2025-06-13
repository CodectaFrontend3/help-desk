import urlServices from "./UrlServices.js";
import axios from "axios";

const apiClient = axios.create({
    baseURL: `${urlServices}:8000/api`,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    }
});

// Interceptor para agregar el token a todas las peticiones
apiClient.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Interceptor para manejar respuestas y errores de autenticación
apiClient.interceptors.response.use(
    (response) => {
        return response;
    },
    async (error) => {
        const originalRequest = error.config;

        // Si el token ha expirado (401) y no hemos intentado refrescar
        if (error.response?.status === 401 && !originalRequest._retry) {
            originalRequest._retry = true;

            try {
                // Intentar refrescar el token
                const refreshResponse = await apiClient.post('/refresh');
                const newToken = refreshResponse.data.token;

                // Actualizar el token en localStorage
                localStorage.setItem('token', newToken);

                // Reintentar la petición original con el nuevo token
                originalRequest.headers.Authorization = `Bearer ${newToken}`;
                return apiClient(originalRequest);

            } catch (refreshError) {
                // Si no se puede refrescar, limpiar la autenticación
                localStorage.removeItem('token');
                localStorage.removeItem('user');

                // Redirigir a login si estamos en el cliente
                if (typeof window !== 'undefined' && window.location) {
                    window.location.href = '/auth/login';
                }

                return Promise.reject(refreshError);
            }
        }

        return Promise.reject(error);
    }
);

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
            this.handleApiError(error);
            throw error;
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
            this.handleApiError(error);
            throw error;
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
            this.handleApiError(error);
            throw error;
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
            this.handleApiError(error);
            throw error;
        }
    }

    handleApiError(error) {
        if (error.response) {
            // El servidor respondió con un código de error
            const status = error.response.status;
            const message = error.response.data?.message || error.response.statusText;

            switch (status) {
                case 401:
                    console.warn('Error de autenticación: Token inválido o expirado');
                    break;
                case 403:
                    console.warn('Error de autorización: Sin permisos suficientes');
                    break;
                case 422:
                    console.warn('Error de validación:', error.response.data?.errors);
                    break;
                case 500:
                    console.error('Error interno del servidor');
                    break;
                default:
                    console.error(`Error HTTP ${status}:`, message);
            }
        } else if (error.request) {
            // La petición se realizó pero no hubo respuesta
            console.error('No se recibió respuesta del servidor:', error.request);
        } else {
            // Error en la configuración de la petición
            console.error('Error en la configuración de la petición:', error.message);
        }
    }

    // Métodos para manejar tokens
    setAuthToken(token) {
        if (token) {
            apiClient.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
    }

    clearAuthToken() {
        delete apiClient.defaults.headers.common['Authorization'];
    }
}

const requester = new Requester();

export default {
    // Métodos genéricos expuestos
    get: (endpoint, headers) => requester.get(endpoint, headers),
    post: (endpoint, data, headers) => requester.post(endpoint, data, headers),
    put: (endpoint, data, headers) => requester.put(endpoint, data, headers),
    delete: (endpoint, headers) => requester.delete(endpoint, headers),

    // Métodos para manejar autenticación
    setAuthToken: (token) => requester.setAuthToken(token),
    clearAuthToken: () => requester.clearAuthToken(),

    // Instancia de axios para casos especiales
    client: apiClient
}
