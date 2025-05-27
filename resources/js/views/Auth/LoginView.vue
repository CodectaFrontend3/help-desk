<template>
    <div class="container">
        <div class="left"></div>
        <div class="right">
            <div class="login-box">
                <h2>INICIO DE SESION</h2>
                <form @submit.prevent="handleSubmit">
                    <label for="email">Usuario (Correo electrónico)</label>
                    <input
                        type="email"
                        id="email"
                        v-model="email"
                        placeholder="Correo electrónico"
                        required
                        :disabled="authStore.loading"
                    />

                    <label for="password">Contraseña</label>
                    <div class="password-wrapper">
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            id="password"
                            v-model="password"
                            placeholder=""
                            required
                            :disabled="authStore.loading"
                        />
                        <span class="eye" @click="togglePassword">👁</span>
                    </div>

                    <div class="remember">
                        <input
                            type="checkbox"
                            id="remember"
                            v-model="remember"
                        />
                        <label for="remember">Recordar contraseña</label>
                    </div>

                    <!-- Mostrar errores de login -->
                    <div v-if="errorMessage" class="error-message">
                        {{ errorMessage }}
                    </div>

                    <button
                        type="submit"
                        class="btn"
                        :disabled="authStore.loading"
                    >
                        {{ authStore.loading ? 'Iniciando...' : 'Iniciar Sesión' }}
                    </button>

                    <div class="forgot">
                        <p>
                            ¿Olvidaste tu contraseña?<br />
                            <router-link to="/auth/forgot-password">Te ayudamos</router-link>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();

const email = ref('');
const password = ref('');
const remember = ref(false);
const showPassword = ref(false);
const errorMessage = ref('');

const togglePassword = () => {
    showPassword.value = !showPassword.value;
};

const handleSubmit = async () => {
    try {
        errorMessage.value = '';

        const credentials = {
            email: email.value,
            password: password.value,
            remember: remember.value
        };

        // Llamar al método login del store
        await authStore.login(credentials);

        // Redirigir según el rol del usuario
        const redirectPath = route.query.redirect || getDefaultRouteByRole(authStore.user.role);
        router.push(redirectPath);

    } catch (error) {
        errorMessage.value = error.message || 'Error al iniciar sesión. Verifica tus credenciales.';
    }
};

const getDefaultRouteByRole = (role) => {
    switch (role) {
        case 'admin':
            return '/admin/dashboard';
        case 'TiSupport':
            return '/support/dashboard';
        case 'client':
            return '/client';
        default:
            return '/';
    }
};

onMounted(() => {
    // Solo para desarrollo - quitar en producción
    if (import.meta.env.DEV) {
        email.value = 'prueba@ejemplo.com';
        password.value = '12345678';
        remember.value = true;
    }
});
</script>

<style scoped>
.container {
    flex: 1;
    display: flex;
    height: 100vh;
    min-height: 600px;
}

.left {
    width: 50%;
    background: #f89e1b;
    clip-path: polygon(0 0, 100% 0, 50% 50%, 100% 100%, 0 100%);
    min-width: 300px;
}

.right {
    width: 50%;
    background: #454545;
    display: flex;
    justify-content: center;
    align-items: center;
    min-width: 300px;
}

.login-box {
    background-color: #454545;
    padding: 2px;
    border-radius: 8px;
    text-align: center;
    height: 100%;
    max-height: 500px;
    width: 80%;
    max-width: 1000px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.login-box h2 {
    font-family: Inter;
    padding: 20px;
    color: white;
    font-size: 64px;
    background-color: #5c5c5c;
    margin-bottom: 40px;
}

.login-box label {
    display: block;
    align-items: center;
    color: white;
    margin: 10px 0 5px;
    width: 100%;
    font-size: 30px;
}

.login-box input[type="email"],
.login-box input[type="text"] {
    padding: 5px;
    border: black;
    border-radius: 20px;
    font-size: 28px;
    margin-bottom: 10px;
    width: 50%;
}

.login-box input[type="password"] {
    padding: 5px;
    border: black;
    border-radius: 20px;
    font-size: 28px;
    margin-bottom: 10px;
    width: 100%;
}

.login-box input:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.password-wrapper {
    position: relative;
    display: inline-block;
    width: 50%;
}

.password-wrapper input {
    padding-right: 30px;
    width: 100%;
}

.eye {
    position: absolute;
    right: 15px;
    top: 9px;
    cursor: pointer;
}

.remember {
    display: flex;
    color: white;
    font-size: 20px;
    margin-bottom: 20px;
    width: 50%;
    margin-left: 180px;
}

.remember input {
    width: auto;
    font-size: 16px;
    accent-color: #fca326;
}

.error-message {
    background-color: #ff4757;
    color: white;
    padding: 10px;
    border-radius: 5px;
    margin: 10px 0;
    font-size: 16px;
    width: 50%;
    margin-left: auto;
    margin-right: auto;
}

.btn {
    background-color: #f89e1b;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 20px;
    cursor: pointer;
    font-weight: bold;
    font-size: 20px;
    width: 53%;
    margin: 0 auto;
    transition: opacity 0.3s ease;
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn:hover:not(:disabled) {
    background-color: #e8900f;
}

.forgot {
    margin-top: 15px;
    font-size: 20px;
    color: white;
}

.forgot a {
    color: #f89e1b;
    font-weight: bold;
    font-size: 20px;
    text-decoration: none;
}

.forgot a:hover {
    text-decoration: underline;
}

/* Media queries para responsividad */
@media (max-width: 768px) {
    .container {
        flex-direction: column;
    }

    .left {
        width: 100%;
        height: 30%;
        clip-path: none;
    }

    .right {
        width: 100%;
        height: 70%;
    }

    .login-box h2 {
        font-size: 32px;
    }

    .login-box label {
        font-size: 20px;
    }

    .login-box input[type="email"],
    .login-box input[type="text"],
    .password-wrapper {
        width: 80%;
    }

    .remember {
        width: 80%;
        margin-left: 10%;
    }

    .btn {
        width: 80%;
    }

    .error-message {
        width: 80%;
    }
}
</style>
