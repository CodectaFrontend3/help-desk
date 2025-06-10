<template>
  <div class="redirect-container">
    <div class="loading-spinner">
      <div class="spinner"></div>
      <p>Redirigiendo...</p>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

// CAMBIO IMPORTANTE: Usar nombres de ruta para mayor robustez
// Y corregir la ruta para el rol 'client'
const getRedirectRouteNameByRole = (role) => {
  switch (role) {
    case 'admin':
      return 'AdminDashboard';     // Nombre de ruta definido en index.js
    case 'TiSupport':
      return 'TiSupportDashboard'; // Nombre de ruta definido en index.js
    case 'client':
      return 'ClientDashboard';    // CAMBIO: 'ClientDashboard' que apunta a '/client'
    default:
      return 'Login'; // Fallback si el rol es desconocido o nulo
  }
}

onMounted(async () => {
  // Paso 1: Verificar el estado de autenticación (incluyendo con el servidor)
  // La acción checkAuthStatus también actualiza authStore.isAuthenticated
  const isValid = await authStore.checkAuthStatus();

  // Paso 2: Si no es válido (no autenticado o token expirado/inválido)
  if (!isValid) {
    // Redirigir al login y REEMPLAZAR la entrada en el historial
    router.replace({ name: 'Login' });
    return; // Detener la ejecución
  }

  // Paso 3: Si está autenticado y válido, determinar la ruta de redirección según el rol
  const userRole = authStore.user?.role;
  const redirectRouteName = getRedirectRouteNameByRole(userRole);

  // Paso 4: Redirigir a la ruta apropiada, REEMPLAZANDO la entrada actual en el historial
  router.replace({ name: redirectRouteName });
})
</script>

<style scoped>
.redirect-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f5f5f5;
}

.loading-spinner {
  text-align: center;
  color: #666;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #f89e1b;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 20px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.loading-spinner p {
  font-size: 18px;
  margin: 0;
}
</style>
