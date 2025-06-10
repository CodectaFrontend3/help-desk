// src/stores/auth.js
import { defineStore } from "pinia";
import { ref, computed } from "vue";
import ApiService from "@/services/ApiServices";

export const useAuthStore = defineStore("auth", () => {
    // Estado
    const user = ref(null);
    const token = ref(null);
    const loading = ref(false);
    const checkingAuth = ref(false); // Flag para evitar llamadas concurrentes a checkAuthStatus

    // Getters computados
    const isAuthenticated = computed(() => !!token.value && !!user.value);
    const userRole = computed(() => user.value?.role || null);

    // Función para obtener datos del usuario desde la API
    const fetchUserProfile = async (authToken) => {
        try {
            // Asegura que ApiService use este token para la petición específica
            ApiService.setAuthToken(authToken);
            const userData = await ApiService.get("/user");
            return userData;
        } catch (error) {
            console.error("Error obteniendo perfil de usuario:", error);
            throw error;
        }
    };

    // Acciones
    const login = async (credentials) => {
        loading.value = true;
        try {
            const loginResponse = await ApiService.post("/login", {
                email: credentials.email,
                password: credentials.password,
            });

            let userData = null;
            if (loginResponse.token) {
                ApiService.setAuthToken(loginResponse.token);
                try {
                    userData = await fetchUserProfile(loginResponse.token);
                } catch (error) {
                    console.warn(
                        "No se pudo obtener el perfil completo, usando datos básicos"
                    );
                    userData = {
                        email: credentials.email,
                        name: credentials.email.split("@")[0],
                        role: "client", // rol por defecto o según lógica de tu backend
                    };
                }
            }

            token.value = loginResponse.token;
            user.value = userData;

            if (credentials.remember) {
                localStorage.setItem("token", loginResponse.token);
                localStorage.setItem("user", JSON.stringify(userData));
                localStorage.setItem("remember", "true");
            } else {
                sessionStorage.setItem("token", loginResponse.token);
                sessionStorage.setItem("user", JSON.stringify(userData));
            }

            return {
                success: true,
                token: loginResponse.token,
                user: userData,
            };
        } catch (error) {
            console.error("Error en login:", error);
            throw new Error(error.message || "Error al iniciar sesión");
        } finally {
            loading.value = false;
        }
    };

    const logout = async () => {
        try {
            if (token.value) {
                try {
                    await ApiService.post("/logout"); // Intenta notificar al backend
                } catch (error) {
                    console.warn("Error al hacer logout en servidor:", error);
                }
            }
        } finally {
            // Limpiar estado local del store
            user.value = null;
            token.value = null;
            ApiService.clearAuthToken(); // Elimina el token de ApiService (headers de Axios)

            // Limpiar almacenamiento persistente
            localStorage.removeItem("token");
            localStorage.removeItem("user");
            localStorage.removeItem("remember");
            sessionStorage.removeItem("token");
            sessionStorage.removeItem("user");

            // --- ¡IMPORTANTE! ---
            // La redirección a la página de login YA NO SE HACE AQUÍ.
            // Se hace en el componente que llama a `authStore.logout()`.
        }
    };

    const checkAuth = async () => {
        let savedToken = localStorage.getItem("token");
        let savedUser = localStorage.getItem("user");

        // Si no está en localStorage, intenta con sessionStorage
        if (!savedToken) {
            savedToken = sessionStorage.getItem("token");
            savedUser = sessionStorage.getItem("user");
        }

        if (savedToken && savedUser) {
            try {
                token.value = savedToken;
                user.value = JSON.parse(savedUser);

                ApiService.setAuthToken(savedToken); // Establece el token en ApiService para futuras peticiones

                // Verifica la validez del token y carga el perfil si es necesario
                const isValid = await checkAuthStatus();
                return isValid;
            } catch (error) {
                console.error("Error al parsear usuario guardado o token inválido:", error);
                // Si hay un error, limpiar sesión
                logout();
                return false;
            }
        }
        return false; // No hay token guardado
    };

    const initializeAuth = async () => {
        // Solo inicializa si no hay un usuario cargado y no estamos ya en proceso de verificación
        if (!user.value && !checkingAuth.value) {
            await checkAuth(); // Esto intentará cargar el usuario desde el almacenamiento y validarlo
        }
    };

    const checkAuthStatus = async () => {
        if (!token.value) {
            user.value = null; // Si no hay token, no hay usuario válido
            return false;
        }

        // Evita llamadas múltiples si ya estamos verificando activamente
        if (checkingAuth.value) {
            console.log("Ya se está verificando la autenticación, saltando llamada redundante a /user.");
            return true; // Asume que la verificación en curso es exitosa o se manejará en su propio hilo
        }
        checkingAuth.value = true; // Establecer el flag para indicar que la verificación está en curso

        try {
            const userData = await ApiService.get("/user"); // <--- Esta es la llamada principal a GET /user
            user.value = userData; // Actualiza los datos del usuario con la respuesta del servidor
            return true;
        } catch (error) {
            console.error("Error verificando estado de autenticación:", error);
            logout(); // Si falla (ej. 401 Unauthorized), significa que el token no es válido, así que cerramos sesión
            return false;
        } finally {
            checkingAuth.value = false; // Restablecer el flag al finalizar la verificación
        }
    };

    const hasRole = (requiredRole) => {
        if (!user.value) return false;
        if (Array.isArray(requiredRole)) {
            return requiredRole.includes(user.value.role);
        }
        return user.value.role === requiredRole;
    };

    const hasAnyRole = (roles) => {
        if (!user.value || !Array.isArray(roles)) return false;
        return roles.includes(user.value.role);
    };

    return {
        user,
        token,
        loading,
        checkingAuth,
        isAuthenticated,
        userRole,
        login,
        logout,
        initializeAuth,
        checkAuth,
        checkAuthStatus,
        hasRole,
        hasAnyRole,
    };
});
