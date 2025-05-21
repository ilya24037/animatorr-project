<script setup>
import { ref } from 'vue'
import axios from '@/api'

const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

async function submit () {
  try {
    await axios.post('/auth/register', form.value) // SSR‑маршрут
    window.location.reload()                      // redirect на home
  } catch (err) {
    // обработка 422
  }
}
</script>
