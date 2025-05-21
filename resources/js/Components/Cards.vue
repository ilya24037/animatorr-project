<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import Card from './Card.vue'

const props = defineProps({
  cards: { type: Array,  default: () => [] },
  meta : { type: Object, default: null },
})

/**
 * Возвращает массив url картинок для карточки.
 * Если фотографий нет — путь в папку default.
 */
function firstPhoto(item) {
  if (item.photos?.length) return item.photos
  return [`/storage/${item.photo_folder ?? 'default'}/1.jpg`]
}

/** URL для кнопки «Показать ещё». Никогда не undefined. */
const nextUrl = computed(() => {
  if (!props.meta) return '#'
  return props.meta.links?.find(l => l.label === 'Next »')?.url ?? '#'
})
</script>

<template>
  <div
    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"
    v-if="cards?.length"
  >
    <Card
      v-for="a in cards"
      :key="a.id"
      :photos="firstPhoto(a)"
      :title="a.name"
      :price="Number(a.price)"
      :age="a.age"
      :height="a.height"
      :rating="a.rating"
      :reviews="a.reviews_count"
    />
  </div>

  <div v-if="meta && meta.current_page < meta.last_page" class="mt-8 text-center">
    <Link
      :href="nextUrl"
      preserve-scroll
      class="inline-block bg-blue-600 text-white px-6 py-2 rounded"
    >
      Показать ещё
    </Link>
  </div>
</template>
