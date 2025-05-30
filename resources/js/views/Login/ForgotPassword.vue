<template>
  <div class="page-wrapper">
    <div class="header">
      <div class="input-wrapper">
        <input type="email" placeholder="Correo electrónico" required />
      </div>

      <div class="password-wrapper">
        <input type="password" v-model="password" id="password" placeholder="Contraseña" required />
        <span class="eye" @click="togglePassword">👁️</span>
      </div>

      <button>Iniciar Sesión</button>

      <a class="forgot-link">¿Olvidaste tu cuenta?</a>
    </div>

    <div class="main-content">
      <div class="recovery-box">
        <div class="recovery-title">
          Recuperar tu contraseña
        </div>

        <div class="recovery-content">
          <p>
            Ingresa tu correo electrónico o número de celular para que nuestro soporte pueda ayudarte.
          </p>

          <input type="text" placeholder="Correo electrónico o número de celular" />

          <div class="recovery-actions">
            <button class="btn-cancel">Cancelar</button>
            <button class="btn-send">Enviar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="footer">
      © 2025 Tu Empresa
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const password = ref('')
const showPassword = ref(false)

function togglePassword() {
  const passwordInput = document.getElementById('password')
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text'
    showPassword.value = true
  } else {
    passwordInput.type = 'password'
    showPassword.value = false
  }
}
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: Arial, sans-serif;
}

html, body {
  height: 100%;
  width: 100%;
}

body {
  background-color: #454545;
}

.page-wrapper {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  width: 100%;
}

.header,
.main-content,
.footer {
  width: 100%;
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
  font-size: 1.2rem;
  width: 100%;
  max-width: 380px;
  outline: none;
}

.header button {
  padding: 10px 25px;
  border-radius: 25px;
  border: none;
  background-color: #555555;
  color: white;
  font-size: 1.2rem;
  cursor: pointer;
  width: 100%;
  max-width: 200px;
}

.header .forgot-link {
  color: #333;
  font-weight: bold;
  text-decoration: none;
  font-size: 1.1rem;
  cursor: pointer;
  width: 100%;
  text-align: center;
}

.password-wrapper {
  position: relative;
  width: 100%;
  max-width: 380px;
}

.eye {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
}

.main-content {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
}

.recovery-box {
  background-color: rgba(80, 80, 80, 0.8);
  width: 100%;
  max-width: 940px;
  border-radius: 8px;
  overflow: hidden;
}

.recovery-title {
  background-color: rgba(70, 70, 70, 1);
  color: white;
  padding: 15px 20px;
  font-size: 2rem;
}

.recovery-content {
  padding: 20px;
  color: white;
}

.recovery-content p {
  margin-bottom: 40px;
  font-size: 1.2rem;
  line-height: 1.5;
}

.recovery-content input {
  width: 100%;
  padding: 12px 15px;
  border-radius: 25px;
  border: none;
  font-size: 1.2rem;
  margin-bottom: 20px;
}

.recovery-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  flex-wrap: wrap;
}

.btn-cancel, .btn-send {
  padding: 10px 20px;
  border-radius: 25px;
  border: none;
  color: white;
  font-size: 1.2rem;
  cursor: pointer;
}

.btn-cancel {
  background-color: #888888;
}

.btn-send {
  background-color: #fca326;
}

.footer {
  background-color: #fca326;
  height: 80px;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .header input,
  .header button,
  .password-wrapper {
    max-width: 100%;
  }

  .recovery-title {
    font-size: 1.5rem;
  }

  .recovery-content p {
    font-size: 1rem;
  }

  .btn-cancel, .btn-send {
    width: 100%;
    text-align: center;
    font-size: 1rem;
  }

  .recovery-actions {
    justify-content: center;
  }
}
</style>
