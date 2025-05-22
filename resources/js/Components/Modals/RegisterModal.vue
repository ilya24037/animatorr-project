<script setup>
import { ref, watch }       from 'vue'
import axios                from 'axios'             // ← поменяли
import { useRegisterModal } from '@/Stores/useRegisterModal'

const { isOpen, close } = useRegisterModal()

const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const error = ref('')

async function submit () {
  error.value = ''
  try {
    await axios.post('/auth/register', form.value)   // ← прямой SSR-маршрут
    close()
    window.location.reload()
  } catch (e) {
    error.value = e.response?.status === 422
      ? 'Проверьте введённые данные'
      : 'Не удалось зарегистрироваться. Попробуйте позже.'
  }
}
…
</script>
