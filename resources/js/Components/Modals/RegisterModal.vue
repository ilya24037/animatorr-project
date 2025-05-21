<script setup>
import { ref } from 'vue'
import { api } from '../../api'
import { useRegisterModal } from '@/Stores/useRegisterModal'
import { useAuthModal } from '@/Stores/useAuthModal'

/* modal state from pinia-like composable */
const { isOpen, close } = useRegisterModal()
const { open: openAuth } = useAuthModal()

const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const error = ref(null)
const loading = ref(false)

const submit = async () => {
  loading.value = true
  error.value = null
  try {
    await api.post('/auth/register', {
      name: name.value.trim(),
      email: email.value.trim(),
      password: password.value,
      password_confirmation: password_confirmation.value,
    })
    // после успешной регистрации переходим к авторизации
    close()
    openAuth()
  } catch (e) {
    error.value = 'Не удалось зарегистрироваться.'
  } finally {
    loading.value = false
  }
}

const toLogin = () => {
  close()
  openAuth()
}
</script>

<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
    @click.self="close"
  >
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl relative">
      <button
        @click="close"
        class="absolute right-4 top-4 text-gray-400 hover:text-gray-600"
      >
        ×
      </button>

      <h2 class="mb-4 text-2xl font-bold text-center">Регистрация</h2>

      <div class="space-y-3">
        <input v-model="name" placeholder="Имя" class="w-full border rounded p-3" />
        <input v-model="email" placeholder="Email" class="w-full border rounded p-3" />
        <input type="password" v-model="password" placeholder="Пароль" class="w-full border rounded p-3" />
        <input type="password" v-model="password_confirmation" placeholder="Повторите пароль" class="w-full border rounded p-3" />
      </div>

      <button
        :disabled="loading"
        @click="submit"
        class="mt-5 w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold"
      >
        {{ loading ? 'Подождите…' : 'Зарегистрироваться' }}
      </button>

      <p v-if="error" class="mt-3 text-sm text-red-500 text-center">{{ error }}</p>

      <div class="text-center mt-4 text-sm">
        Есть аккаунт?
        <button @click="toLogin" class="text-blue-600 font-semibold hover:underline">Войти</button>
      </div>
    </div>
  </div>
</template>
