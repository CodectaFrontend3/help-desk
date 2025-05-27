import { useAuthStore } from '@/stores/auth'

export function setupRouterGuards(router) {
  router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    // Verificar si la ruta requiere autenticación
    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
      return next({ name: 'Login', query: { redirect: to.fullPath } });
    }

    // Si está autenticado pero trata de acceder a rutas de invitado
    if (to.meta.requiresGuest && authStore.isAuthenticated) {
      return next({ name: 'Home' });
    }

    // Verificar roles
    if (to.meta.roles && !to.meta.roles.includes(authStore.user?.role)) {
      return next({ name: 'Unauthorized' });
    }

    // Establecer título de página
    document.title = to.meta.title ? `${to.meta.title} - Mi App` : 'Mi App';

    next();
  });
}
