import { useAuthStore } from '@/stores/auth'

export function setupRouterGuards(router) {
  router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    // Si la ruta requiere autenticación y no está autenticado
    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
      // Intentar verificar autenticación desde localStorage/sessionStorage
      const hasValidSession = await authStore.checkAuth();

      if (!hasValidSession) {
        console.log('Redirigiendo a login - No autenticado');
        return next({
          name: 'Login',
          query: { redirect: to.fullPath }
        });
      }
    }

    // Si está autenticado pero trata de acceder a rutas de invitado (login, register, etc.)
    if (to.meta.requiresGuest && authStore.isAuthenticated) {
      console.log('Usuario autenticado accediendo a ruta de invitado, redirigiendo a home');
      return next({ name: 'Home' });
    }

    // Verificar roles específicos
    if (to.meta.roles && authStore.user) {
      const userRole = authStore.user.role;
      const requiredRoles = to.meta.roles;

      if (!requiredRoles.includes(userRole)) {
        console.warn(`Acceso denegado: Usuario con rol '${userRole}' intentando acceder a ruta que requiere roles:`, requiredRoles);
        return next({ name: 'Unauthorized' });
      }
    }

    // Verificar roles en rutas padre (para rutas anidadas)
    const matchedRoutes = to.matched;
    for (const route of matchedRoutes) {
      if (route.meta.roles && authStore.user) {
        const userRole = authStore.user.role;
        const requiredRoles = route.meta.roles;

        if (!requiredRoles.includes(userRole)) {
          console.warn(`Acceso denegado en ruta padre: Usuario con rol '${userRole}' intentando acceder a ruta que requiere roles:`, requiredRoles);
          return next({ name: 'Unauthorized' });
        }
      }
    }

    // Establecer título de página
    const title = to.meta.title;
    if (title) {
      document.title = `${title} - Mi App`;
    } else {
      document.title = 'Mi App';
    }

    // Debug: Log de navegación exitosa
    if (process.env.NODE_ENV === 'development') {
      console.log(`Navegando a: ${to.path} (${to.name}) - Usuario: ${authStore.user?.name || 'No autenticado'} (${authStore.user?.role || 'Sin rol'})`);
    }

    next();
  });

  // Guard para interceptar errores de navegación
  router.onError((error) => {
    console.error('Error de navegación:', error);

    // Si hay un error relacionado con autenticación, limpiar y redirigir
    if (error.message?.includes('401') || error.message?.includes('token')) {
      const authStore = useAuthStore();
      authStore.logout();
      router.push({ name: 'Login' });
    }
  });
}
