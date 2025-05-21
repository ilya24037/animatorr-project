import { ref, computed } from 'vue'

/* ──────────────── state ──────────────── */
const isOpen = ref(false)

/* ─────────────── actions ─────────────── */
function open ()   { isOpen.value = true }
function close ()  { isOpen.value = false }
function toggle () { isOpen.value = !isOpen.value }

/* ──────────── composable ─────────────── */
function useRegisterModal () {
  return {
    isOpen: computed(() => isOpen.value),
    open,
    close,
    toggle,
  }
}

/* ─────────────── exports ─────────────── */
export { useRegisterModal }   // именованный экспорт
export default useRegisterModal   // ← default — тоже функция
