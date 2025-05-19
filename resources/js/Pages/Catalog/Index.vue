<script setup>
defineProps({
  animators: Object,
  filters: Object
})
</script>

<template>
  <div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Каталог аниматоров</h1>

    <pre class="bg-gray-100 p-2 rounded">{{ animators }}</pre>
    <!-- выведите реальные карточки позже -->
  </div>
</template>
