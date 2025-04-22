import urlServices from "./UrlServices.js";
import axios from "axios";

const  apiClient = axios.create({
    baseURL: `${urlServices}:8000/api`, headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    }
})

class Requester {
    async get(url, headers = {}) {
        try {
            const response = await apiClient.get(url, { headers });
            console.log(response);
            return response.data;
        } catch (error) {
            console.error('Error en la solicitud GET:', error);
            return null;
        }
    }
    async post(url, data, headers = {}) {
        try {
            const response = await apiClient.post(url, data, { headers });
            return response.data;
        } catch (error) {
            console.error('Error en la solicitud POST:', error);
            return null;
        }
    }
    async put(url, data, headers = {}) {
        try {
            const response = await apiClient.put(url, data, { headers });
            return response.data;
        } catch (error) {
            console.error('Error en la solicitud PUT:', error);
            return null;
        }
    }

    async patch(url, data, headers = {}) {
        try {
            const response = await apiClient.patch(url, data, { headers });
            return response.data;
        } catch (error) {
            console.error('Error en la solicitud PATCH:', error.response ? error.response.data : error.message);
            return null;
        }
    }
    async delete(url, headers = {}) {
        try {
            const response = await apiClient.delete(url, { headers });
            return response.data;
        } catch (error) {
            console.error('Error en la solicitud DELETE:', error);
            return null;
        }
    }

    async uncontrolledGet(url, headers = {}) {
        const response = await apiClient.get(url, { headers });
        return response.data; // Devuelve solo los datos del backend
    }

    async uncontrolledPost(url, data, headers = {}) {
        const response = await apiClient.post(url, data, { headers });
        return response.data;
    }

    async uncontrolledPut(url, data, headers = {}) {
        const response = await apiClient.put(url, data, { headers });
        return response.data;
    }

    async uncontrolledPatch(url, data, headers = {}) {
        const response = await apiClient.patch(url, data, { headers });
        return response.data;
    }

    async uncontrolledDelete(url, headers = {}) {
        const response = await apiClient.delete(url, { headers });
        return response.data;
    }
}
const requester = new Requester()

export default {
    // Métodos genéricos expuestos
    get: (endpoint) => requester.get(endpoint),
    post: (data, endpoint) => requester.post(endpoint, data),
    put: (data, endpoint) => requester.put(endpoint, data),
    delete: (endpoint) => requester.delete(endpoint),
    async getMicroCompany(){
        return await requester.get(`/micro-company`);
    }
}
