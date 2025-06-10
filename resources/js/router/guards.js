// src/router/guards.js
import { useAuthStore } from '@/stores/auth'; // Importa el store de autenticación

// Flag para controlar la carga inicial de la autenticación
let isInitialLoad = true;

export function setupRouterGuards(router) {
    router.beforeEach(async (to, from, next) => {
        const authStore = useAuthStore();

        // 1. Inicialización de autenticación (se ejecuta una única vez en la carga inicial)
        if (isInitialLoad) {
            console.log("Realizando inicialización de autenticación al cargar la aplicación...");
            // `initializeAuth` internamente llama a `checkAuth` y luego a `checkAuthStatus`
            // lo que realiza la petición GET /user si hay un token guardado.
            await authStore.initializeAuth();
            isInitialLoad = false; // Desactiva el flag después de la primera carga
        }

        // 2. Verificar si la ruta requiere autenticación
        if (to.meta.requiresAuth && !authStore.isAuthenticated) {
            console.log('Redirigiendo a login - Ruta requiere autenticación y usuario no autenticado');
            return next({ name: 'Login', query: { redirect: to.fullPath } });
        }

        // 3. Si está autenticado pero trata de acceder a rutas de invitado (login, register, etc.)
        if (to.meta.requiresGuest && authStore.isAuthenticated) {
            console.log('Usuario autenticado intentando acceder a ruta de invitado, redirigiendo a Home');
            // Redirige al dashboard o home por defecto para el rol del usuario
            let defaultRouteName = 'Home'; // Ruta por defecto si no se encuentra un rol específico
            if (authStore.userRole) {
                switch (authStore.userRole) {
                    case 'admin':
                        defaultRouteName = 'AdminDashboard';
                        break;
                    case 'TiSupport':
                        defaultRouteName = 'TiSupportDashboard';
                        break;
                    case 'client':
                        defaultRouteName = 'ClientDashboard';
                        break;
                    default:
                        // Si el rol no mapea a una ruta específica, se queda en 'Home'
                        break;
                }
            }
            return next({ name: defaultRouteName });
        }


        // 4. Verificar roles específicos en la ruta final
        if (to.meta.roles && authStore.user) {
            const userRole = authStore.user.role;
            const requiredRoles = to.meta.roles;

            if (!requiredRoles.includes(userRole)) {
                console.warn(`Acceso denegado: Usuario con rol '${userRole}' intentando acceder a ruta que requiere roles:`, requiredRoles);
                return next({ name: 'Unauthorized' });
            }
        }

        // 5. Verificar roles en rutas padre (para rutas anidadas)
        // Esto es importante si tienes rutas como /admin/clients donde 'clients' también tiene meta.roles
        const matchedRoutes = to.matched;
        for (const route of matchedRoutes) {
            if (route.meta.roles && authStore.user) {
                const userRole = authStore.user.role;
                const requiredRoles = route.meta.roles;

                if (!requiredRoles.includes(userRole)) {
                    console.warn(`Acceso denegado en ruta padre: Usuario con rol '${userRole}' intentando acceder a ruta que requiere roles:`, requiredRoles);
                    return next({ name: 'Unauthorized' }); // Redirige si el rol no coincide con el de la ruta padre
                }
            }
        }

        // 6. Establecer título de página
        const title = to.meta.title;
        if (title) {
            document.title = `${title} - Mi App`; // Puedes personalizar el sufijo del título
        } else {
            document.title = 'Mi App'; // Título por defecto
        }

        // 7. Continuar la navegación
        next();
    });

    // Guard para interceptar errores de navegación (opcional, pero recomendado)
    router.onError((error) => {
        console.error('Error de navegación:', error);

        // Puedes añadir lógica para redirigir a una página de error o manejar errores específicos
        // Por ejemplo, si el error es de autenticación (401), puedes cerrar la sesión.
        if (error.message?.includes('401') || error.message?.includes('No Autenticado')) {
            const authStore = useAuthStore();
            authStore.logout();
            router.replace({ name: 'Login' });
        }
    });
}
