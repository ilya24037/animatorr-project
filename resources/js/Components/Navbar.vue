<script setup>
/* ------------------------------------------------------------------
 * Navbar.vue  — главная шапка сайта
 * ------------------------------------------------------------------ */

import { ref, onMounted, computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js' // ✅ добавлено

/* базовые компоненты */
import ApplicationLogo     from '@/Components/ApplicationLogo.vue'
import FavoriteBlock       from '@/Components/FavoriteBlock.vue'
import CitySelectorModal   from '@/Components/CitySelectorModal.vue'
import AuthModal           from '@/Components/Modals/AuthModal.vue'

import { useLocationStore } from '@/Stores/useLocationStore'

/* ------------------------ reactive state --------------------------- */
const showCityModal = ref(false)
const showAuth      = ref(false)

const store = useLocationStore()
const user  = usePage().props.auth?.user ?? null
const currentCity = computed(() => store.city?.name ?? 'Выбрать город')

onMounted(() => {
  if (!localStorage.getItem('selectedCity')) {
    showCityModal.value = true
  }
})

function logout () {
  router.post('/logout')
}
</script>

<template>
  <nav class="bg-white border-b shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

      <!-- Логотип -->
      <Link href="/" class="flex items-center gap-2 text-xl font-semibold">
        <ApplicationLogo class="h-7 w-7" />
        <span class="hidden sm:inline">Сайт Аниматоры</span>
      </Link>

      <!-- Левая часть: выбор города -->
      <div>
        <button class="text-sm ..." @click="showCityModal = true">{{ currentCity }}</button>
        <CitySelectorModal v-model:show="showCityModal" />
      </div>

      <!-- Правая часть -->
      <div class="flex items-center gap-6">
        <FavoriteBlock />
        <Link href="/animators/create" class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">
          Разместить анкету
        </Link>

        <!-- Гость -->
        <template v-if="!user">
          <button class="text-blue-600 hover:underline" @click="showAuth = true">Войти / Регистрация</button>
          <AuthModal v-model:show="showAuth" />
        </template>

        <!-- Пользователь -->
        <template v-else>
          <div class="relative group inline-block">
            <button class="flex items-center gap-1 font-medium hover:text-blue-600">
              {{ user.name }}
              <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <ul class="absolute right-0 w-44 mt-2 bg-white border shadow-lg rounded-lg opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition-opacity">
              <li>
                <Link :href="route('profile.edit')" class="block px-4 py-2 hover:bg-gray-100">Профиль</Link>
              </li>
              <li>
                <button @click="logout" class="w-full text-left px-4 py-2 hover:bg-gray-100">Выйти</button>
              </li>
            </ul>
          </div>
        </template>
      </div>
    </div>
  </nav>
</template>

<style scoped>
.group:hover ul { opacity: 1; pointer-events: auto; }
ul { transition: opacity .15s ease; }
</style>
