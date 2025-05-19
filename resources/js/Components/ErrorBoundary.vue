<template>
  <div v-if="error">
    <div class="bg-red-100 text-red-800 p-4 rounded text-sm">
      ⚠ Ошибка загрузки карточки
    </div>
  </div>
  <slot v-else />
</template>

<script setup>
import { ref, onErrorCaptured } from 'vue'

const error = ref(false)

onErrorCaptured((err, instance, info) => {
  console.error('❌ Ошибка в компоненте:', info, err)
  error.value = true
  return false // предотвратить всплытие ошибки дальше
})
</script>
