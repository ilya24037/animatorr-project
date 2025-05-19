<script setup>
import { Link } from '@inertiajs/vue3'
import Card from './Card.vue'

defineProps({
  cards: { type: Array,  default: () => [] },
  meta : { type: Object, default: null }
})

function firstPhoto(item) {
  if (item.photos?.length) return item.photos
  return [`/storage/${item.photo_folder ?? 'default'}/1.jpg`]
}
</script>

<template>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <Card
      v-for="a in cards"
      :key="a.id"
      :images="firstPhoto(a)"
      :title="a.name"
      :price="Number(a.price)"
      :age="a.age"
      :height="a.height"
      :rating="a.rating"
      :reviews="a.reviews_count" />
  </div>

  <div v-if="meta && meta.current_page < meta.last_page" class="mt-8 text-center">
    <Link :href="meta.links.find(l => l.label === 'Next »')?.url"
          preserve-scroll
          class="inline-block bg-blue-600 text-white px-6 py-2 rounded">
      Показать ещё
    </Link>
  </div>
</template>
