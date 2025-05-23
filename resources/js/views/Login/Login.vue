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
              ¿Olvidaste tu contraseña?<br /><a href="#">Te ayudamos</a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const email = ref('');
const password = ref('');
const remember = ref(false);
const showPassword = ref(false);

const togglePassword = () => {
  showPassword.value = !showPassword.value;
};

const handleSubmit = () => {
  alert(Usuario: ${email.value}, Contraseña: ${password.value}, Recordar: ${remember.value});
};

onMounted(() => {
  email.value = 'prueba@ejemplo.com';
  password.value = '12345678';
  remember.value = true;
});
</script>

<style scoped>
/* (Se mantiene igual todo el CSS original, puedes pegarlo directamente aquí) */

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
  font: Inter;
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

.login-box input[type='email'],
.login-box input[type='text'] {
  padding: 5px;
  border: black;
  border-radius: 20px;
  font-size: 28px;
  margin-bottom: 10px;
  width: 50%;
}

.login-box input[type='password'] {
  padding: 5px;
  border: black;
  border-radius: 20px;
  font-size: 28px;
  margin-bottom: 10px;
  width: 100%;
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

/* Agrega aquí los media queries igual que en tu HTML original */

</style>