<script setup>
import { router } from '@inertiajs/vue3'
import Filters from '@/Components/Filters.vue'
import Map     from '@/Components/Map.vue'
import Cards   from '@/Components/Cards.vue'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
  cards:   Object,   // paginator
  filters: Object,
  cities:  Array
})

/* отправляем ноовые фильтры через Inertia */
function applyFilters(payload) {
  router.get('/', payload, { preserveState: true, replace: true })
}
</script>

<template>
  <div class="flex gap-8 max-w-7xl mx-auto py-6">

    <!-- Сайдбар фильтров -->
    <aside class="w-[300px] shrink-0">
      <Filters :init="filters" :cities="cities" @apply="applyFilters" />
    </aside>

    <!-- Правая колонка -->
    <section class="flex-1 space-y-6">

      <!-- Карта -->
      <Map :cards="cards.data" />

      <!-- Сетка карточек -->
      <Cards :cards="cards.data"
             :meta="{ links: cards.links,
                     current_page: cards.current_page,
                     last_page: cards.last_page }" />
    </section>
  </div>
</template>
