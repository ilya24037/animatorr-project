<script setup>
import { ref } from 'vue'
import { useLocationStore } from '@/Stores/useLocationStore'

/*
 * CitySelectorModal.vue
 * Окно выбора города. После выбора:
 *   • сохраняет объект города в Pinia‑хранилище;
 *   • записывает флаг в localStorage, чтобы модалка не всплывала сама.
 */

const emit = defineEmits(['update:show'])            // v‑model:show
const props = defineProps({                          // передаём :show из Navbar
  show: { type: Boolean, default: false },
})

const store = useLocationStore()

// Список городов можно получить из API; пока — статичный массив
const cities = ref([
  { id: 1, name: 'Москва' },
  { id: 2, name: 'Санкт-Петербург' },
  { id: 3, name: 'Казань' },
  { id: 4, name: 'Екатеринбург' },
  { id: 5, name: 'Новосибирск' },
])

function selectCity(city) {
  emit('update:show', false)          // закрыть модалку
  store.setCity(city)                 // сохранить в Pinia + localStorage (сам store)
  localStorage.setItem('selectedCity', JSON.stringify(city)) // флаг «выбран»
}
</script>

<template>
  <Teleport to="body">
    <transition name="fade">
      <div v-if="props.show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl w-[420px] max-h-[80vh] overflow-y-auto p-6 relative">
          <button class="absolute top-3 right-3 text-gray-400 hover:text-gray-600"
                  @click="$emit('update:show', false)">×</button>

          <h2 class="text-xl font-semibold mb-4">Выберите город</h2>

          <ul class="space-y-1">
            <li v-for="city in cities" :key="city.id">
              <button @click="selectCity(city)"
                      class="w-full text-left px-3 py-2 rounded-lg hover:bg-gray-100">
                {{ city.name }}
              </button>
            </li>
          </ul>
        </div>
      </div>
    </transition>
  </Teleport>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity .15s ease; }
.fade-enter-from,  .fade-leave-to      { opacity: 0; }
</style>
