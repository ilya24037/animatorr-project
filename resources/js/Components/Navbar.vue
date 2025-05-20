<script setup>
import { useAuthModal } from '@/Stores/useAuthModal'
const { open } = useAuthModal()
</script>

<template>
  <header class="w-full bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center py-4 px-6">
      <div class="text-2xl font-bold text-blue-700 tracking-wide">Animatorr</div>
      <nav class="flex gap-6 items-center">
        <a href="/" class="text-gray-700 hover:text-blue-600 transition">Главная</a>
        <button @click="open" class="text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg transition border border-blue-100 font-semibold">
          Войти
        </button>
      </nav>
    </div>
  </header>
</template>
