<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const form = ref({
  title: '',
  description: '',
  price: 0
})

const submit = () => {
  router.post('/cabinet/ads', form.value)
}
</script>

<template>
  <div class="max-w-2xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Создание объявления</h1>
    <form @submit.prevent="submit" class="space-y-4">
      <input v-model="form.title" placeholder="Заголовок" class="w-full border rounded p-2" />
      <textarea v-model="form.description" placeholder="Описание" class="w-full border rounded p-2" />
      <input v-model.number="form.price" type="number" placeholder="Цена" class="w-full border rounded p-2" />
      <button class="bg-green-600 text-white px-4 py-2 rounded">Сохранить</button>
    </form>
  </div>
</template>
