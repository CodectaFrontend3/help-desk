<template>
  <div class="container">
    <div class="left"></div>
    <div class="right">
      <div class="login-box">
        <h2>INICIO DE SESION</h2>
        <form @submit.prevent="handleSubmit">
          <label for="email">Usuario (Correo electronico)</label>
          <input
            type="email"
            id="email"
            v-model="email"
            placeholder="Correo electronico"
            required
          />

          <label for="password">Contraseña</label>
          <div class="password-wrapper">
            <input
              :type="showPassword ? 'text' : 'password'"
              id="password"
              v-model="password"
              placeholder=""
              required
            />
            <span class="eye" @click="togglePassword">👁</span>
          </div>

          <div class="remember">
            <input type="checkbox" id="remember" v-model="remember" />
            <label for="remember">Recordar contraseña</label>
          </div>

          <button type="submit" class="btn">Iniciar Sesion</button>

          <div class="forgot">
            <p>
              ¿Olvidaste tu contraseña?<br /><a href="/forgot-password">Te ayudamos</a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
  setup() {
    const email = ref('');
    const password = ref('');
    const remember = ref(false);
    const showPassword = ref(false);

    const togglePassword = () => {
      showPassword.value = !showPassword.value;
    };

    const handleSubmit = () => {
      alert(`Usuario: ${email.value}, Contraseña: ${password.value}, Recordar: ${remember.value}`);
    };

    onMounted(() => {
      email.value = 'prueba@ejemplo.com';
      password.value = '12345678';
      remember.value = true;
    });

    return {
      email,
      password,
      remember,
      showPassword,
      togglePassword,
      handleSubmit,
    };
  }
};
</script>


<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: sans-serif;
}

body,
html {
  height: 100%;
  background: #454545;
  overflow-x: hidden;
}

.container {
  display: flex;
  height: 100vh;
  min-height: 600px;
  background-color: #454545;
  width: 100%;
}

.left {
  flex: 1;
  background: #f89e1b;
  clip-path: polygon(0 0, 100% 0, 80% 50%, 100% 100%, 0 100%);
  min-width: 300px;
}

.right {
  flex: 1;
  background: #454545;
  display: flex;
  justify-content: center;
  align-items: center;
  min-width: 300px;
}

.login-box {
  background-color: #454545;
  padding: 20px;
  border-radius: 8px;
  text-align: center;
  max-height: 500px;
  width: 80%;
  max-width: 400px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.login-box h2 {
  font-family: Inter, sans-serif;
  padding: 20px;
  color: white;
  font-size: 32px;
  background-color: #5c5c5c;
  margin-bottom: 30px;
  border-radius: 8px;
}

.login-box label {
  display: block;
  color: white;
  margin: 15px 0 8px;
  font-size: 18px;
  text-align: left;
}

.login-box input[type='email'],
.login-box input[type='text'] {
  padding: 12px;
  border: 2px solid #ccc;
  border-radius: 20px;
  font-size: 16px;
  margin-bottom: 15px;
  width: 100%;
}

.login-box input[type='password'] {
  padding: 12px;
  border: 2px solid #ccc;
  border-radius: 20px;
  font-size: 16px;
  margin-bottom: 15px;
  width: 100%;
  padding-right: 40px;
}

.password-wrapper {
  position: relative;
  width: 100%;
}

.password-wrapper input {
  width: 100%;
}

.eye {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  font-size: 18px;
}

.remember {
  display: flex;
  align-items: center;
  color: white;
  font-size: 16px;
  margin-bottom: 20px;
  gap: 8px;
}

.remember input {
  width: auto;
  accent-color: #fca326;
}

.remember label {
  margin: 0;
  font-size: 16px;
}

.btn {
  background-color: #f89e1b;
  color: white;
  border: none;
  padding: 12px 20px;
  border-radius: 20px;
  cursor: pointer;
  font-weight: bold;
  font-size: 18px;
  width: 100%;
  margin-bottom: 15px;
  transition: background-color 0.3s ease;
}

.btn:hover {
  background-color: #e68e0a;
}

.forgot {
  font-size: 16px;
  color: white;
}

.forgot a {
  color: #f89e1b;
  font-weight: bold;
  text-decoration: none;
}

.forgot a:hover {
  text-decoration: underline;
}

/* Responsive design */
@media (max-width: 768px) {
  .container {
    flex-direction: column;
  }
  
  .left {
    height: 200px;
    clip-path: polygon(0 0, 100% 0, 100% 80%, 50% 100%, 0 100%);
  }
  
  .right {
    flex: 1;
  }
  
  .login-box {
    width: 90%;
    max-width: none;
  }
  
  .login-box h2 {
    font-size: 24px;
  }
}
</style>