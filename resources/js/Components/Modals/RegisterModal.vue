<script setup>
import { ref } from 'vue'
import { api } from '@/api'
import { useRegisterModal } from '@/Stores/useRegisterModal'

const { isOpen, close } = useRegisterModal()

const email       = ref('')
const password    = ref('')
const password2   = ref('')
const name        = ref('')
const error       = ref('')
const loading     = ref(false)
const registered  = ref(false)

/* --------------------------------------------------------------------------
 *  Реальная регистрация пользователя через REST API v1
 * ------------------------------------------------------------------------ */
const handleSubmit = async () => {
  error.value = ''
  if (password.value !== password2.value) {
    error.value = 'Пароли не совпадают'
    return
  }

  loading.value = true

  try {
    await api.post('/auth/register', {
      name:                  name.value.trim(),
      email:                 email.value.trim(),
      password:              password.value,
      password_confirmation: password2.value,
    })

    /* если дошли до сюда — пользователь создан */
    registered.value = true
  } catch (err) {
    if (err.response?.status === 422) {
      // выводим первую ошибку валидации
      const bag = err.response.data.errors
      error.value = Object.values(bag)[0][0] ?? 'Ошибка валидации'
    } else {
      error.value = 'Не удалось зарегистрироваться. Попробуйте позже.'
    }
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <Teleport to="body">
    <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
      <div class="bg-white rounded-2xl p-8 w-full max-w-md shadow-xl relative">
        <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" @click="close">✕</button>

        <h2 class="text-2xl font-semibold mb-6">Регистрация</h2>

        <form @submit.prevent="handleSubmit" class="space-y-4">
          <input v-model="name"      class="input" placeholder="Имя"            required />
          <input v-model="email"     class="input" type="email" placeholder="E‑mail" required />
          <input v-model="password"  class="input" type="password" placeholder="Пароль" required minlength="8" />
          <input v-model="password2" class="input" type="password" placeholder="Повторите пароль" required minlength="8" />

          <button :disabled="loading" class="btn-primary w-full">
            <span v-if="!loading">Зарегистрироваться</span>
            <span v-else>…</span>
          </button>
        </form>

        <p v-if="error" class="text-sm text-red-600 mt-4">{{ error }}</p>
        <p v-if="registered" class="text-sm text-green-600 mt-4">
          Успех! Проверьте почту для подтверждения.
        </p>

        <p class="text-xs text-gray-500 mt-6">
          Регистрируясь, вы&nbsp;соглашаетесь с&nbsp;<a href="/privacy" class="underline">политикой&nbsp;обработки&nbsp;данных</a>.
        </p>
      </div>
    </div>
  </Teleport>
</template>

<style scoped>
.input {
  @apply w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500;
}
.btn-primary {
  @apply bg-blue-600 hover:bg-blue-700 text-white rounded-lg py-2 font-semibold;
}
</style>
