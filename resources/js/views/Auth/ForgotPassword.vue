<template>
  <div>
    <div class="header">
      <div class="input-wrapper">
        <input v-model="email" type="email" placeholder="Correo electrónico" required />
      </div>

      <div class="password-wrapper">
        <input :type="showPassword ? 'text' : 'password'" v-model="password" placeholder="Contraseña" required />
        <span class="eye" @click="togglePassword">👁</span>
      </div>

      <button @click="login">Iniciar Sesión</button>

      <a class="forgot-link" @click="toggleRecovery">¿Olvidaste tu cuenta?</a>
    </div>

    <div v-if="showRecovery" class="main-content">
      <div class="recovery-box">
        <div class="recovery-title">Recuperar tu contraseña</div>
        <div class="recovery-content">
          <p>
            Ingresa tu correo electrónico o número de celular para que nuestro soporte pueda ayudarte.
          </p>
          <input v-model="recoveryInput" type="text" placeholder="Correo electrónico o número de celular" />
          <div class="recovery-actions">
            <button class="btn-cancel" @click="toggleRecovery">Cancelar</button>
            <button class="btn-send" @click="sendRecovery">Enviar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="footer"></div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const email = ref('')
const password = ref('')
const showPassword = ref(false)
const showRecovery = ref(false)
const recoveryInput = ref('')

const togglePassword = () => {
  showPassword.value = !showPassword.value
}

const toggleRecovery = () => {
  showRecovery.value = !showRecovery.value
}

const login = () => {
  console.log('Login con:', email.value, password.value)
}

const sendRecovery = () => {
  console.log('Recuperar con:', recoveryInput.value)
}
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: Arial, sans-serif;
}

body {
  background-color: #454545;
  min-height: 100vh;
}

.header {
  background-color: #fca326;
  padding: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
}

.header input {
  padding: 10px 15px;
  border-radius: 25px;
  border: none;
  font-size: 28px;
  width: 380px;
  outline: none;
}

.header button {
  padding: 10px 25px;
  border-radius: 25px;
  border: none;
  background-color: #555555;
  color: white;
  font-size: 28px;
  cursor: pointer;
}

.header .forgot-link {
  color: #333;
  font-weight: bold;
  text-decoration: none;
  font-size: 28px;
  cursor: pointer;
}

.password-wrapper {
  position: relative;
}

.eye {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
}

.main-content {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 400px;
  padding: 30px;
}

.recovery-box {
  background-color: rgba(80, 80, 80, 0.8);
  width: 100%;
  max-width: 940px;
  height: 525px;
  border-radius: 3px;
  overflow: hidden;
}

.recovery-title {
  background-color: rgba(70, 70, 70, 1);
  color: white;
  padding: 15px 20px;
  font-size: 40px;
}

.recovery-content {
  padding: 30px 20px;
  color: white;
}

.recovery-content p {
  margin-bottom: 60px;
  font-size: 32px;
  line-height: 1.5;
}

.recovery-content input {
  width: 100%;
  padding: 12px 15px;
  border-radius: 25px;
  border: none;
  font-size: 28px;
  margin-bottom: 20px;
}

.recovery-actions {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
}

.btn-cancel {
  padding: 10px 20px;
  border-radius: 25px;
  border: none;
  background-color: #888888;
  color: white;
  font-size: 28px;
  cursor: pointer;
}

.btn-send {
  padding: 10px 30px;
  border-radius: 25px;
  border: none;
  background-color: #fca326;
  color: white;
  font-size: 28px;
  cursor: pointer;
}

.footer {
  background-color: #fca326;
  height: 80px;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
