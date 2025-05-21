<template>
  <Teleport to="body">
    <Transition name="fade">
      <div v-if="isOpen"
           class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white w-[420px] rounded-xl p-6 space-y-4"
             @click.stop>
          <h2 class="text-2xl font-semibold text-center">Регистрация</h2>

          <form @submit.prevent="submit" class="space-y-3">
            <input v-model="form.name" type="text" placeholder="Имя"
                   class="input" required />
            <input v-model="form.email" type="email" placeholder="E‑mail"
                   class="input" required />
            <input v-model="form.password" type="password"
                   placeholder="Пароль" class="input" required />
            <input v-model="form.password_confirmation" type="password"
                   placeholder="Повторите пароль" class="input" required />

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg py-2 mt-2">
              Зарегистрироваться
            </button>
          </form>

          <p v-if="error" class="text-red-600 text-sm text-center">{{ error }}</p>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { ref, watch } from 'vue'
import api from '@/api'
import useRegisterModal from '@/Stores/useRegisterModal'

const { isOpen, close } = useRegisterModal()

const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const error = ref('')

async function submit () {
  error.value = ''
  try {
    await api.post('/auth/register', form.value)
    window.location.reload()
  } catch (e) {
    if (e.response?.status === 422) {
      error.value = 'Проверьте введённые данные'
    } else {
      error.value = 'Не удалось зарегистрироваться. Попробуйте позже.'
    }
  }
}

watch(isOpen, val => {
  if (!val) {
    form.value = {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
    }
    error.value = ''
  }
})
</script>

<style scoped>
.input {
  @apply w-full border rounded-lg px-3 py-2 bg-white placeholder-gray-400;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity .2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
