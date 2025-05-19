<script setup>
import { ref } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import AuthModal from '@/Components/Modals/AuthModal.vue'
import { useAuthModal } from '@/Stores/useAuthModal'

// Пример использования хука для открытия модального окна
const { open } = useAuthModal()
</script>

<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Шапка сайта -->
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Animatorr</h1>
        <nav>
          <ul class="flex space-x-4">
            <li>
              <Link href="/" class="text-gray-500 hover:text-gray-700">Главная</Link>
            </li>
            <li>
              <button @click="open" class="text-blue-600 hover:text-blue-800">Войти</button>
            </li>
          </ul>
        </nav>
      </div>
    </header>

    <!-- Основной контент -->
    <main>
      <slot />
    </main>

    <!-- Модальное окно авторизации -->
    <AuthModal />
  </div>
</template>
