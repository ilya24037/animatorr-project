<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  ad: Object
})

const form = ref({
  title: props.ad.title,
  description: props.ad.description,
  price: props.ad.price
})

const submit = () => {
  router.put(`/cabinet/ads/${props.ad.id}`, form.value)
}
</script>

<template>
  <div class="max-w-2xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Редактировать объявление</h1>
    <form @submit.prevent="submit" class="space-y-4">
      <input v-model="form.title" placeholder="Заголовок" class="w-full border rounded p-2" />
      <textarea v-model="form.description" placeholder="Описание" class="w-full border rounded p-2" />
      <input v-model.number="form.price" type="number" placeholder="Цена" class="w-full border rounded p-2" />
      <button class="bg-blue-600 text-white px-4 py-2 rounded">Обновить</button>
    </form>
  </div>
</template>
