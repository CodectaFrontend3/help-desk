import { defineStore } from "pinia";
import { ref, computed } from "vue";
import ApiService from "@/services/ApiServices";

export const useAuthStore = defineStore("auth", () => {
    // Estado
    const user = ref(null);
    const token = ref(null);
    const loading = ref(false);
    const checkingAuth = ref(false);

    // Getters computados
    const isAuthenticated = computed(() => !!token.value && !!user.value);
    const userRole = computed(() => user.value?.role || null);

    // Función para obtener datos del usuario desde la API
    // Ahora usa ApiService.get
    const fetchUserProfile = async (authToken) => {
        try {
            // ApiService.setAuthToken se llama antes de cada petición autenticada para asegurar que el token esté en los headers de Axios. Sin embargo, como ApiService ya tiene un interceptor que añade el token de localStorage, no es estrictamente necesario llamarlo aquí si el token ya está en localStorage. Para consistencia, lo dejamos para la primera vez que se carga el perfil.
            ApiService.setAuthToken(authToken); // Asegura que ApiService use este token

            const userData = await ApiService.get("/user"); // Usa el método GET de ApiService
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
            // Usamos ApiService.post para la petición de login
            const loginResponse = await ApiService.post("/login", {
                email: credentials.email,
                password: credentials.password,
            });

            let userData = null;
            if (loginResponse.token) {
                // Una vez que tenemos el token del login, lo establecemos en ApiService
                // para que las futuras peticiones lo incluyan automáticamente.
                ApiService.setAuthToken(loginResponse.token);

                try {
                    userData = await fetchUserProfile(loginResponse.token); // Pasamos el token explícitamente a fetchUserProfile
                } catch (error) {
                    console.warn(
                        "No se pudo obtener el perfil completo, usando datos básicos"
                    );
                    userData = {
                        email: credentials.email,
                        name: credentials.email.split("@")[0],
                        role: "client", // rol por defecto
                    };
                }
            }

            // Guardar token y usuario
            token.value = loginResponse.token;
            user.value = userData;

            // Persistir en localStorage si el usuario eligió recordar
            if (credentials.remember) {
                localStorage.setItem("token", loginResponse.token);
                localStorage.setItem("user", JSON.stringify(userData));
                localStorage.setItem("remember", "true");
            } else {
                // Si no quiere recordar, usar sessionStorage
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
            // ApiService ya maneja muchos errores, pero aquí puedes relanzar para UI.
            throw new Error(error.message || "Error al iniciar sesión");
        } finally {
            loading.value = false;
        }
    };

    const logout = async () => {
        try {
            // Si hay un token, intentamos cerrar sesión en el backend.
            // ApiService ya tiene el token en sus headers si lo establecimos antes.
            if (token.value) {
                try {
                    await ApiService.post("/logout"); // Usa el método POST de ApiService para logout
                } catch (error) {
                    console.warn("Error al hacer logout en servidor:", error);
                }
            }
        } finally {
            // Limpiar estado local siempre
            user.value = null;
            token.value = null;

            // Limpiar el token también de ApiService
            ApiService.clearAuthToken();

            // Limpiar almacenamiento
            localStorage.removeItem("token");
            localStorage.removeItem("user");
            localStorage.removeItem("remember");
            sessionStorage.removeItem("token");
            sessionStorage.removeItem("user");
        }
    };

    const checkAuth = async () => {
        let savedToken = localStorage.getItem("token");
        let savedUser = localStorage.getItem("user");

        if (!savedToken) {
            savedToken = sessionStorage.getItem("token");
            savedUser = sessionStorage.getItem("user");
        }

        if (savedToken && savedUser) {
            try {
                token.value = savedToken;
                user.value = JSON.parse(savedUser);

                // IMPORTANTE: Establece el token en ApiService cuando lo recuperas del almacenamiento
                ApiService.setAuthToken(savedToken); //

                const isValid = await checkAuthStatus();
                return isValid;
            } catch (error) {
                console.error("Error al parsear usuario guardado:", error);
                logout();
                return false;
            }
        }

        return false;
    };

    const initializeAuth = () => {
        return checkAuth();
    };

    const checkAuthStatus = async () => {
        if (!token.value) return false;

        try {
            // ApiService ya tiene el token si checkAuth lo estableció o si viene de un login.
            const userData = await ApiService.get("/user"); // Usa ApiService.get
            user.value = userData;
            return true;
        } catch (error) {
            console.error("Error verificando estado de autenticación:", error);
            logout();
            return false;
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
