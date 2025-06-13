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

const getDefaultRouteByRole = (role) => {
  const routes = {
    'admin': '/home-admin',
    'TiSupport': '/home-support',
    'client': '/'
  }
  return routes[role] || '/'
}

onMounted(async () => {
  // Verificar si el usuario está autenticado
  if (!authStore.isAuthenticated) {
    router.push('/auth/login')
    return
  }

  // Verificar el estado de autenticación con el servidor (si aplica)
  const isValid = await authStore.checkAuthStatus()

  if (!isValid) {
    router.push('/auth/login')
    return
  }

  // Redirigir según el rol
  const userRole = authStore.user?.role
  const defaultRoute = getDefaultRouteByRole(userRole)

  router.push(defaultRoute)
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
