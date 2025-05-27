import apiServices from "./ApiServices";

export default {
    async getCurrentUserInfo() {
        try {
            console.log('Llamando a la API: clientG/1');
            const response = await apiServices.get('clientG/1');

            // Debug: ver la estructura completa de la respuesta
            console.log('Respuesta completa de la API:', response);
            console.log('response.data:', response.data);

            // Verificar si la respuesta tiene la estructura esperada
            let user;
            if (response.data) {
                user = response.data;
            } else if (response.id) {
                // Si la respuesta directa es el usuario (sin .data)
                user = response;
            } else {
                console.error('Estructura de respuesta inesperada:', response);
                throw new Error('La estructura de la respuesta de la API no es la esperada');
            }

            // Verificar que el usuario tenga las propiedades básicas
            if (!user || !user.id) {
                console.error('Usuario sin ID:', user);
                throw new Error('Los datos del usuario no contienen un ID válido');
            }

            console.log('Datos del usuario procesados:', user);

            // Adaptamos la respuesta a lo que espera el componente
            const userData = {
                userId: user.id,
                name: user.name || 'Usuario sin nombre',
                lastName: user.last_name || '',
                email: user.email || '',
                role: 'manager', // Como es un manager, establecemos el rol
                // Como la API no devuelve company info directamente,
                // podemos usar los datos del usuario o establecer valores por defecto
                companyId: user.id, // Usando el ID del usuario como company ID por ahora
                companyType: 'company', // Valor por defecto
                companyName: `Empresa de ${user.name || 'Usuario'}`, // Nombre generado
                machines: user.machines || [] // Las máquinas del usuario
            };

            console.log('userData final:', userData);
            return userData;

        } catch (error) {
            console.error('Error al obtener los datos del usuario autenticado:', error);
            console.error('Detalles del error:', {
                message: error.message,
                response: error.response,
                status: error.response?.status,
                statusText: error.response?.statusText
            });
            throw new Error('No se pudo obtener la información del usuario: ' + (error.response?.statusText || error.message));
        }
    }
};
