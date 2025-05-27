import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  // Estado
  const user = ref(null)
  const token = ref(null)
  const loading = ref(false)

  // Getters computados
  const isAuthenticated = computed(() => !!token.value && !!user.value)
  const userRole = computed(() => user.value?.role || null)

  // Simulación de usuarios para desarrollo
  const mockUsers = [
    {
      id: 1,
      email: 'admin@ejemplo.com',
      password: '12345678',
      name: 'Administrador',
      role: 'admin'
    },
    {
      id: 2,
      email: 'soporte@ejemplo.com',
      password: '12345678',
      name: 'Soporte TI',
      role: 'TiSupport'
    },
    {
      id: 3,
      email: 'cliente@ejemplo.com',
      password: '12345678',
      name: 'Cliente',
      role: 'client'
    },
    {
      id: 4,
      email: 'prueba@ejemplo.com',
      password: '12345678',
      name: 'Usuario Prueba',
      role: 'client'
    }
  ]

  // Función para simular login (reemplazar con API real)
  const mockLogin = async (credentials) => {
    // Simular delay de red
    await new Promise(resolve => setTimeout(resolve, 1000))

    const user = mockUsers.find(u =>
      u.email === credentials.email && u.password === credentials.password
    )

    if (!user) {
      throw new Error('Credenciales inválidas')
    }

    return {
      token: `mock-token-${user.id}-${Date.now()}`,
      user: {
        id: user.id,
        name: user.name,
        email: user.email,
        role: user.role
      }
    }
  }

  // Acciones
  const login = async (credentials) => {
    loading.value = true
    try {
      let data

      // Si estás en desarrollo, usar login simulado
      if (import.meta.env.DEV || !import.meta.env.VITE_API_URL) {
        data = await mockLogin(credentials)
      } else {
        // Producción - llamada real a la API
        const response = await fetch(`${import.meta.env.VITE_API_URL}/api/login`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(credentials),
        })

        if (!response.ok) {
          const errorData = await response.json()
          throw new Error(errorData.message || 'Credenciales inválidas')
        }

        data = await response.json()
      }

      // Guardar token y usuario
      token.value = data.token
      user.value = data.user

      // Persistir en localStorage si el usuario eligió recordar
      if (credentials.remember) {
        localStorage.setItem('token', data.token)
        localStorage.setItem('user', JSON.stringify(data.user))
        localStorage.setItem('remember', 'true')
      } else {
        // Si no quiere recordar, usar sessionStorage
        sessionStorage.setItem('token', data.token)
        sessionStorage.setItem('user', JSON.stringify(data.user))
      }

      return data
    } catch (error) {
      console.error('Error en login:', error)
      throw error
    } finally {
      loading.value = false
    }
  }

  const logout = () => {
    // Limpiar estado
    user.value = null
    token.value = null

    // Limpiar almacenamiento
    localStorage.removeItem('token')
    localStorage.removeItem('user')
    localStorage.removeItem('remember')
    sessionStorage.removeItem('token')
    sessionStorage.removeItem('user')
  }

  const initializeAuth = () => {
    // Intentar recuperar de localStorage primero
    let savedToken = localStorage.getItem('token')
    let savedUser = localStorage.getItem('user')
    let isRemembered = localStorage.getItem('remember')

    // Si no está en localStorage, verificar sessionStorage
    if (!savedToken) {
      savedToken = sessionStorage.getItem('token')
      savedUser = sessionStorage.getItem('user')
    }

    if (savedToken && savedUser) {
      token.value = savedToken
      try {
        user.value = JSON.parse(savedUser)
      } catch (error) {
        console.error('Error parsing saved user:', error)
        logout()
      }
    }
  }

  const checkAuthStatus = async () => {
    if (!token.value) return false

    try {
      // En desarrollo, simplemente verificar si el token existe
      if (import.meta.env.DEV || !import.meta.env.VITE_API_URL) {
        return !!user.value
      }

      // En producción, verificar con el servidor
      const response = await fetch(`${import.meta.env.VITE_API_URL}/api/auth/me`, {
        headers: {
          'Authorization': `Bearer ${token.value}`,
        },
      })

      if (!response.ok) {
        logout()
        return false
      }

      const userData = await response.json()
      user.value = userData
      return true
    } catch (error) {
      console.error('Error checking auth status:', error)
      logout()
      return false
    }
  }

  const hasRole = (requiredRole) => {
    if (!user.value) return false
    if (Array.isArray(requiredRole)) {
      return requiredRole.includes(user.value.role)
    }
    return user.value.role === requiredRole
  }

  const hasAnyRole = (roles) => {
    if (!user.value || !Array.isArray(roles)) return false
    return roles.includes(user.value.role)
  }

  return {
    // Estado
    user,
    token,
    loading,
    // Getters
    isAuthenticated,
    userRole,
    // Acciones
    login,
    logout,
    initializeAuth,
    checkAuthStatus,
    hasRole,
    hasAnyRole,
  }
})
