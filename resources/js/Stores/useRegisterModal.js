
import { ref } from 'vue'

const isOpen = ref(false)

export function open () { isOpen.value = true }
export function close () { isOpen.value = false }

// default export для импорта «import modal from '@/Stores/useRegisterModal'»
export default {
  isOpen,
  open,
  close,
}
