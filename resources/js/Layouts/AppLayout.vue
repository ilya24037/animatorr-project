<script setup>
import Navbar from '@/Components/Navbar.vue'
import AuthModal from '@/Components/Modals/AuthModal.vue'
import RegisterModal from '@/Components/Modals/RegisterModal.vue'
</script>

<template>
  <div>
    <Navbar />
    <slot />
    <AuthModal />
    <RegisterModal />
  </div>
</template>
