<script setup>
import { useForm } from '@inertiajs/vue3'
import { useLocationStore } from '@/Stores/useLocationStore'

const store = useLocationStore()

const form = useForm({
  name: '',
  city: store.city || '',
  price: '',
  type: 'private',
  is_online: false,
  is_verified: false,
  age: '',
  height: '',
  weight: '',
})

const submit = () => {
  form.post(route('animators.store'))
}
</script>

<template>
  <div class="max-w-xl mx-auto py-8 space-y-6">
    <h1 class="text-2xl font-bold">Разместить объявление</h1>

    <form @submit.prevent="submit" class="space-y-4">
      <input v-model="form.name" type="text" placeholder="Имя" class="input w-full" />
      <input v-model="form.city" type="text" placeholder="Город" class="input w-full" />
      <input v-model.number="form.price" type="number" placeholder="Цена, ₽" class="input w-full" />

      <select v-model="form.type" class="input w-full">
        <option value="private">Частный исполнитель</option>
        <option value="company">Компания</option>
      </select>

      <label class="flex items-center gap-2">
        <input type="checkbox" v-model="form.is_online" />
        Работает сейчас
      </label>

      <label class="flex items-center gap-2">
        <input type="checkbox" v-model="form.is_verified" />
        Проверенный
      </label>

      <input v-model.number="form.age" type="number" placeholder="Возраст" class="input w-full" />
      <input v-model.number="form.height" type="number" placeholder="Рост (см)" class="input w-full" />
      <input v-model.number="form.weight" type="number" placeholder="Вес (кг)" class="input w-full" />

      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
        Опубликовать
      </button>
    </form>
  </div>
</template>
