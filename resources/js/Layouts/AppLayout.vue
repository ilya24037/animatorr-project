
<script setup>
import AuthModal from '@/Components/Modals/AuthModal.vue'
import RegisterModal from '@/Components/Modals/RegisterModal.vue'
</script>

<template>
  <div>
    <!-- Основное содержимое сайта, например шапка и <slot /> -->
    <slot />

    <!-- Модальные окна авторизации и регистрации -->
    <AuthModal />
    <RegisterModal />
  </div>
</template>
