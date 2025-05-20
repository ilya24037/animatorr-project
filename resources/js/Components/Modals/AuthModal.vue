<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { useAuthModal } from '@/Stores/useAuthModal'
import { useRegisterModal } from '@/Stores/useRegisterModal'

const { isOpen, close } = useAuthModal()
const { open: openRegister } = useRegisterModal()

const showPassword = ref(false)

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

function onLogin() {
  form.post('/auth/login', {  // ВАЖНО: путь /auth/login
    onSuccess: () => {
      close()
      form.reset('password')
    }
  })
}

function toRegister() {
  close()
  openRegister()
}
</script>

<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" @click.self="close">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 relative flex flex-col gap-6">
      <button @click="close" class="absolute right-4 top-4 text-gray-400 hover:text-gray-600">
        <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            d="M18 6L6 18M6 6l12 12" />
        </svg>
      </button>
      <h2 class="text-2xl font-bold mb-2">Вход</h2>
      <form @submit.prevent="onLogin" class="flex flex-col gap-4">
        <div class="relative">
          <input
            v-model="form.email"
            type="email"
            autocomplete="username"
            placeholder="Email"
            class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>
        <div class="relative">
          <input
            :type="showPassword ? 'text' : 'password'"
            v-model="form.password"
            autocomplete="current-password"
            placeholder="Пароль"
            class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
          <button
            type="button"
            @click="showPassword = !showPassword"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
            tabindex="-1"
          >
            <svg v-if="!showPassword" width="20" height="20" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-width="2" d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12Z" />
              <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" />
            </svg>
            <svg v-else width="20" height="20" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-width="2" d="M1 1l22 22M17.94 17.94C16.01 19.3 14.09 20 12 20c-7 0-11-8-11-8 1.09-2.09 2.97-4.51 5.47-6.56M22.29 22.29c-.46-.5-.97-.98-1.5-1.42M12 12v0" />
            </svg>
          </button>
        </div>
        <div class="flex items-center justify-between text-sm">
          <label class="flex items-center gap-2 cursor-pointer">
            <input v-model="form.remember" type="checkbox" class="form-checkbox accent-blue-600" />
            <span>Запомнить меня</span>
          </label>
          <a href="#" class="text-blue-600 hover:underline">Забыли пароль?</a>
        </div>
        <button
          type="submit"
          :disabled="form.processing"
          class="bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-5 py-3 transition disabled:opacity-50"
        >
          Войти
        </button>
        <!-- Блок ошибок -->
        <div v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</div>
        <div v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</div>
      </form>
      <div class="text-center mt-2">
        <div class="mb-2 text-gray-500 text-sm">Нет аккаунта?</div>
        <button @click="toRegister" class="text-blue-600 font-semibold hover:underline">Зарегистрироваться</button>
      </div>
      <p class="mt-4 text-xs text-gray-400 text-center">
        При входе вы соглашаетесь с <a href="#" class="underline">условиями использования</a> и <a href="#" class="underline">политикой конфиденциальности</a>.
      </p>
    </div>
  </div>
</template>
