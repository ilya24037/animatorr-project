import { ref } from 'vue'

const isOpen = ref(false)

export function useAuthModal() {
  function open() {
    isOpen.value = true
  }

  function close() {
    isOpen.value = false
  }

  function openRegister() {
    // Логика открытия модального окна регистрации
  }

  return {
    isOpen,
    open,
    close,
    openRegister
  }
}
