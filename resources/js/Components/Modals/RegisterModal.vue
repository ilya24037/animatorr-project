<template>
  <div class="modal">
    <form @submit.prevent="handleRegister">
      <input v-model="formData.email" type="email" placeholder="Email" required />
      <input v-model="formData.password" type="password" placeholder="Пароль" required />
      <button type="submit">Зарегистрироваться</button>
      <p v-if="error" class="error-message">{{ error }}</p>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const formData = ref({
  email: '',
  password: ''
})

const error = ref('')

const handleRegister = async () => {
  try {
    await axios.post('/register', formData.value)
    // Дополнительная логика после успешной регистрации
  } catch (e) {
    error.value = e.response?.status === 422
      ? 'Проверьте введённые данные'
      : 'Не удалось зарегистрироваться. Попробуйте позже.'
  }
}
</script>

<style scoped>
.modal {
  /* Стили модального окна */
}

.error-message {
  color: red;
  margin-top: 10px;
}
</style>
