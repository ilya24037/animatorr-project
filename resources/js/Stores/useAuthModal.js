import { ref } from 'vue'

const visible = ref(false)

export function useAuthModal() {
  function show() {
    visible.value = true
  }
  function hide() {
    visible.value = false
  }
  return { visible, show, hide }
}
