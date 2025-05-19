<script setup>
// ✅ AuthModal.vue с поддержкой v-model:show
const props = defineProps({
  show: Boolean
})

const emit = defineEmits(['update:show'])

function close() {
  emit('update:show', false)
}
</script>

<template>
  <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="close">
    <div class="w-full max-w-md bg-white rounded-lg p-6 relative shadow-lg" role="dialog" aria-modal="true">
      <!-- Кнопка закрытия -->
      <button class="absolute top-3 right-3 text-gray-600 hover:text-gray-900" @click="close">✕</button>

      <!-- Заголовок -->
      <h2 class="text-2xl font-semibold mb-4">Вход</h2>

      <!-- Пример формы -->
      <form class="space-y-4" @submit.prevent="alert('Войти!')">
        <div>
          <label class="block text-sm font-medium">Email</label>
          <input type="email" class="w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-sm font-medium">Пароль</label>
          <input type="password" class="w-full border rounded p-2" />
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white rounded py-2">Войти</button>
      </form>
    </div>
  </div>
</template>
