
<script setup>
import { ref } from 'vue'
import axios from 'axios'                        // ⬅️ добавили
import { useRegisterModal } from '@/Stores/useRegisterModal'

const { isOpen, close } = useRegisterModal()

const email       = ref('')
const password    = ref('')
const name        = ref('')
const error       = ref('')
const loading     = ref(false)
const registered  = ref(false)

/* --------------------------------------------------------------------------
 *  Реальная регистрация пользователя
 * -------------------------------------------------------------------------*/
const register = async () => {
  error.value = ''

  /* быстрая клиентская валидация ----------------------------------------- */
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(email.value)) {
    error.value = 'Введите корректный email'
    return
  }
  if (password.value.length < 6) {
    error.value = 'Пароль должен быть не короче 6 символов'
    return
  }
  if (name.value.trim().length < 2) {
    error.value = 'Введите имя (минимум 2 символа)'
    return
  }

  loading.value = true

  try {
    /* ---- отправляем данные на бек-енд ---- */
    await axios.post('/register', {
      name:                  name.value.trim(),
      email:                 email.value.trim(),
      password:              password.value,
      password_confirmation: password.value,
    })

    /* если дошли до сюда — пользователь создан */
    registered.value = true
  } catch (err) {
    /* Laravel вернёт 422 с полем errors — берём первую ошибку */
    if (err.response && err.response.status === 422) {
      const first = Object.values(err.response.data.errors ?? {}).flat()[0]
      error.value = first || 'Ошибка валидации'
    } else {
      error.value = 'Не удалось зарегистрироваться. Попробуйте позже.'
    }
  } finally {
    loading.value = false
  }
}

const toLogin = () => close()
</script>

<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
  >
    <div
      class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl"
      @click.stop
    >
      <!-- кнопка закрытия -->
      <button
        @click="close"
        class="absolute right-4 top-4 text-gray-400 hover:text-gray-600"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
          <path
            d="M6.225 4.811a1 1 0 0 0-1.414 1.414L10.586 12l-5.775 5.775a1 1 0 1 0 1.414 1.414L12 13.414l5.775 5.775a1 1 0 0 0 1.414-1.414L13.414 12l5.775-5.775a1 1 0 0 0-1.414-1.414L12 10.586 6.225 4.811Z"
          />
        </svg>
      </button>

      <!-- до регистрации / после -->
      <template v-if="!registered">
        <h2 class="mb-4 text-2xl font-bold">Регистрация</h2>

        <input
          v-model="name"
          placeholder="Имя"
          class="mb-3 w-full rounded-lg border px-4 py-3 focus:ring-2 focus:ring-blue-500"
        />
        <input
          v-model="email"
          type="email"
          placeholder="E-mail"
          class="mb-3 w-full rounded-lg border px-4 py-3 focus:ring-2 focus:ring-blue-500"
        />
        <input
          v-model="password"
          type="password"
          placeholder="Пароль"
          class="mb-4 w-full rounded-lg border px-4 py-3 focus:ring-2 focus:ring-blue-500"
        />

        <button
          @click="register"
          :disabled="loading"
          class="w-full rounded-lg bg-blue-600 px-5 py-3 font-semibold text-white hover:bg-blue-700 disabled:opacity-50"
        >
          <span v-if="!loading">Зарегистрироваться</span>
          <span v-else class="animate-pulse">Подождите…</span>
        </button>

        <div v-if="error" class="mt-3 text-sm text-red-500">{{ error }}</div>
      </template>

      <template v-else>
        <h2 class="mb-2 text-2xl font-bold">Регистрация завершена!</h2>
        <p class="mb-4 text-gray-500">Теперь вы можете войти.</p>

        <button
          @click="toLogin"
          class="rounded-lg bg-blue-600 px-5 py-3 font-semibold text-white hover:bg-blue-700"
        >
          Войти
        </button>
      </template>

      <div class="mt-4 text-center text-xs text-gray-400">
        Регистрируясь, вы соглашаетесь с
        <a href="#" class="underline">политикой обработки данных</a>.
      </div>
    </div>
  </div>
</template>
