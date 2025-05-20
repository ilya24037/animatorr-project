
<script setup>
import { ref } from 'vue'
import { useRegisterModal } from '@/Stores/useRegisterModal'

const { isOpen, close } = useRegisterModal()

const email = ref('')
const password = ref('')
const name = ref('')
const error = ref('')
const loading = ref(false)
const registered = ref(false)

const register = async () => {
  error.value = ''
  // Валидация email и пароля
  if (!/^\S+@\S+\.\S+$/.test(email.value)) {
    error.value = 'Введите корректный email'
    return
  }
  if (password.value.length < 6) {
    error.value = 'Пароль должен быть не короче 6 символов'
    return
  }
  if (name.value.length < 2) {
    error.value = 'Введите имя (минимум 2 символа)'
    return
  }
  loading.value = true
  // Здесь должен быть реальный запрос на регистрацию (через Inertia/axios)
  setTimeout(() => {
    loading.value = false
    registered.value = true
  }, 1000)
}

const toLogin = () => {
  close()
}
</script>

<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 relative flex flex-col gap-6 min-h-[370px]">
      <button @click="close" class="absolute right-4 top-4 text-gray-400 hover:text-gray-600">
        <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            d="M18 6L6 18M6 6l12 12" />
        </svg>
      </button>
      <template v-if="!registered">
        <h2 class="text-2xl font-bold mb-2">Регистрация</h2>
        <input v-model="name" placeholder="Имя" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500" />
        <input v-model="email" type="email" placeholder="Email" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500" />
        <input v-model="password" type="password" placeholder="Пароль" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500" />
        <button @click="register" :disabled="loading" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-5 py-3">
          Зарегистрироваться
        </button>
        <div v-if="error" class="text-red-500 text-sm">{{ error }}</div>
      </template>
      <template v-else>
        <h2 class="text-2xl font-bold mb-2">Регистрация завершена!</h2>
        <div class="text-gray-500 mb-2">Теперь вы можете войти.</div>
        <button @click="toLogin" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-5 py-3">
          Войти
        </button>
      </template>
      <div class="mt-4 text-xs text-gray-400 text-center">
        Регистрируясь, вы соглашаетесь с <a href="#" class="underline">политикой обработки данных</a>.
      </div>
    </div>
  </div>
</template>
