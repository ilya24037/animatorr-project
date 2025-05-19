<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'

const show  = defineModel('show', { type: Boolean, default: false })

const step   = ref('email')        
const exists = ref(null)           

const email    = ref('')
const password = ref('')
const name     = ref('')

const busy   = ref(false)
const errors = ref({ email: null, password: null, name: null })

watch(show, (v) => {
  if (v) {
    step.value   = 'email'
    exists.value = null
    email.value  = ''
    password.value = ''
    name.value   = ''
    errors.value = { email: null, password: null, name: null }
  }
})

async function submitEmail () {
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
    errors.value.email = 'Введите корректный e-mail'
    return
  }

  busy.value = true
  errors.value.email = null

  try {
    const { data } = await axios.post('/auth/check-email', { email: email.value })
    exists.value = data.exists
    step.value   = data.exists ? 'login' : 'register'
  } catch {
    errors.value.email = 'Ошибка сервера. Попробуйте позже'
  } finally {
    busy.value = false
  }
}

function login () {
  busy.value = true
  router.post('/login',
    { email: email.value, password: password.value },
    {
      onError: err => {
        errors.value.password = err.password ?? 'Неверный пароль'
        busy.value = false
      },
      onSuccess: () => {
        busy.value = false
        show.value = false
      }
    })
}

function register () {
  busy.value = true
  router.post('/register',
    {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password.value
    },
    {
      onError: err => {
        errors.value = { ...errors.value, ...err }
        busy.value = false
      },
      onSuccess: () => {
        busy.value = false
        show.value = false
      }
    })
}
</script>

<template>
  <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-xl w-[420px] p-6 space-y-6 shadow">
      <h2 class="text-xl font-semibold">
        {{ step === 'email' ? 'Ваш e-mail' : step === 'login' ? 'Вход' : 'Регистрация' }}
      </h2>

      <form v-if="step === 'email'" @submit.prevent="submitEmail" class="space-y-4">
        <input v-model="email" type="email" placeholder="you@mail.ru" class="w-full border rounded px-4 py-2" />
        <div v-if="errors.email" class="text-red-500 text-sm">{{ errors.email }}</div>
        <button :disabled="busy" class="w-full bg-blue-600 text-white rounded py-2">Дальше</button>
      </form>

      <form v-else-if="step === 'login'" @submit.prevent="login" class="space-y-4">
        <input v-model="password" type="password" placeholder="Пароль" class="w-full border rounded px-4 py-2" />
        <div v-if="errors.password" class="text-red-500 text-sm">{{ errors.password }}</div>
        <button :disabled="busy" class="w-full bg-blue-600 text-white rounded py-2">Войти</button>
      </form>

      <form v-else @submit.prevent="register" class="space-y-4">
        <input v-model="name" placeholder="Имя" class="w-full border rounded px-4 py-2" />
        <div v-if="errors.name" class="text-red-500 text-sm">{{ errors.name }}</div>

        <input v-model="password" type="password" placeholder="Пароль" class="w-full border rounded px-4 py-2" />
        <div v-if="errors.password" class="text-red-500 text-sm">{{ errors.password }}</div>

        <button :disabled="busy" class="w-full bg-green-600 text-white rounded py-2">Зарегистрироваться</button>
      </form>
    </div>
  </div>
</template>