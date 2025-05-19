<template>
  <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="close">
    <div class="w-full max-w-md bg-white rounded-lg p-6 relative shadow-lg" role="dialog" aria-modal="true" aria-labelledby="modalLoginTitle">
      <button class="absolute top-3 right-3 text-gray-600 hover:text-gray-900" aria-label="Закрыть окно" @click="close">✕</button>
      <h2 id="modalLoginTitle" class="text-2xl font-semibold mb-4">Вход</h2>
      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label class="block mb-1 text-gray-700">Email или телефон</label>
          <div class="relative">
            <input v-model="form.login" type="text" placeholder="you@email.com" class="w-full border rounded p-2 pr-8" autocomplete="username" />
            <button v-if="form.login" type="button" class="absolute right-2 top-2 text-gray-400 hover:text-gray-600" @click="form.login = ''">×</button>
          </div>
          <span v-if="form.errors.login" class="text-red-600 text-sm">{{ form.errors.login }}</span>
        </div>
        <div>
          <label class="block mb-1 text-gray-700">Пароль</label>
          <input v-model="form.password" type="password" class="w-full border rounded p-2" autocomplete="current-password" />
          <span v-if="form.errors.password" class="text-red-600 text-sm">{{ form.errors.password }}</span>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white rounded py-2">Войти</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { useAuthModal } from '@/Stores/useAuthModal'

const { visible: show, hide: close } = useAuthModal()

const form = useForm({
  login: '',
  password: '',
})

function submit() {
  form.post(route('login'), {
    onSuccess: () => close(),
  })
}
</script>
