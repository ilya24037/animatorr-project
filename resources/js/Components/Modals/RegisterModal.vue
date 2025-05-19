
<script setup>
import { ref } from 'vue'
import { useRegisterModal } from '@/Stores/useRegisterModal'

const { isOpen, close } = useRegisterModal()

const step = ref(1)
const phone = ref('')
const sms = ref('')
const name = ref('')
const password = ref('')
const error = ref('')
const loading = ref(false)
const timer = ref(60)
const smsSent = ref(false)

const sendPhone = async () => {
  error.value = ''
  if (!/^\d{10,}$/.test(phone.value.replace(/\D/g, ''))) {
    error.value = 'Введите корректный номер'
    return
  }
  loading.value = true
  setTimeout(() => {
    smsSent.value = true
    step.value = 2
    loading.value = false
    timer.value = 60
    runTimer()
  }, 1000)
}
const runTimer = () => {
  if (timer.value > 0) {
    setTimeout(() => {
      timer.value--
      runTimer()
    }, 1000)
  }
}
const checkSms = async () => {
  error.value = ''
  loading.value = true
  setTimeout(() => {
    if (sms.value === '0000') {
      step.value = 3
    } else if (sms.value === '1111') {
      error.value = 'Телефон уже зарегистрирован'
    } else {
      error.value = 'Неверный код'
    }
    loading.value = false
  }, 1000)
}
const register = async () => {
  error.value = ''
  if (name.value.length < 2 || password.value.length < 6) {
    error.value = 'Введите имя и пароль не короче 6 символов'
    return
  }
  loading.value = true
  setTimeout(() => {
    step.value = 4
    loading.value = false
  }, 1200)
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
      <template v-if="step === 1">
        <h2 class="text-2xl font-bold mb-2">Регистрация</h2>
        <div>
          <input v-model="phone" placeholder="Телефон" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500" />
        </div>
        <button @click="sendPhone" :disabled="loading" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-5 py-3">
          Получить код
        </button>
        <div v-if="error" class="text-red-500 text-sm">{{ error }}</div>
      </template>
      <template v-if="step === 2">
        <h2 class="text-2xl font-bold mb-2">Введите код из SMS</h2>
        <input v-model="sms" maxlength="4" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Код" />
        <button @click="checkSms" :disabled="loading" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-5 py-3">
          Подтвердить
        </button>
        <div class="text-gray-500 text-xs mt-2">Отправили SMS на {{ phone }}</div>
        <button v-if="timer===0" @click="sendPhone" class="text-blue-600 text-xs">Отправить код ещё раз</button>
        <div v-else class="text-xs text-gray-400 mt-1">Можно запросить код повторно через {{ timer }} сек</div>
        <div v-if="error" class="text-red-500 text-sm">{{ error }}</div>
      </template>
      <template v-if="step === 3">
        <h2 class="text-2xl font-bold mb-2">Придумайте имя и пароль</h2>
        <input v-model="name" placeholder="Имя" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 mb-2" />
        <input v-model="password" type="password" placeholder="Пароль" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500" />
        <button @click="register" :disabled="loading" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-5 py-3 mt-2">
          Зарегистрироваться
        </button>
        <div v-if="error" class="text-red-500 text-sm">{{ error }}</div>
      </template>
      <template v-if="step === 4">
        <h2 class="text-2xl font-bold mb-2">Регистрация завершена!</h2>
        <div class="text-gray-500">Теперь вы можете войти.</div>
        <button @click="toLogin" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-5 py-3 mt-2">
          Войти
        </button>
      </template>
      <div v-if="step !== 4" class="mt-4 text-xs text-gray-400 text-center">
        Регистрируясь, вы соглашаетесь с <a href="#" class="underline">политикой обработки данных</a>.
      </div>
    </div>
  </div>
</template>
