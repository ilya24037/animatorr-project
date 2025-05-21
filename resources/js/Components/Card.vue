<template>
  <div class="relative group bg-white rounded-lg shadow-md overflow-hidden border p-4">
    <!-- Иконки -->
    <div class="absolute top-3 right-3 z-10 flex gap-3">
      <button class="text-gray-400 hover:text-pink-500">
        <HeartIcon class="w-5 h-5" />
      </button>
      <button class="text-gray-400 hover:text-gray-800">
        <BarChart2Icon class="w-5 h-5" />
      </button>
    </div>

    <!-- Фото + точки выбора -->
    <div class="relative"
         @mousemove="onMouseMove"
         @mouseleave="resetImage"
    >
      <transition name="fade" mode="out-in">
        <img
          :key="images[currentImage]"
          :src="images[currentImage] ?? '/images/no-photo.png'"
          class="w-full h-[260px] object-cover rounded transition-opacity duration-300"
          alt="Фото аниматора"
        />
      </transition>

      <div
        v-if="images && images.length > 1"
        class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1 z-10"
      >
        <span
          v-for="(img, i) in images"
          :key="i"
          class="w-2.5 h-2.5 rounded-full cursor-pointer border border-gray-400 transition-all duration-200"
          :class="i === currentImage ? 'bg-gray-800 scale-110' : 'bg-white opacity-80'"
          @click="currentImage = i"
          @mouseenter="currentImage = i"
        ></span>
      </div>
    </div>

    <!-- Инфо -->
    <div class="mt-3 space-y-1">
      <p class="text-pink-600 text-lg font-semibold">{{ price }} ₽</p>
      <p class="text-base font-semibold">{{ title }}</p>
      <p class="text-sm text-gray-600">{{ age }} лет</p>
      <p class="text-sm text-gray-600">рост {{ height }} см</p>

      <div class="flex items-center gap-2 text-sm mt-1">
        <StarIcon class="w-4 h-4 text-yellow-400" />
        <span>{{ rating }}</span>
        <span class="ml-2 text-gray-400">{{ reviews }} отзывов</span>
      </div>
    </div>

    <button
      class="w-full mt-4 bg-blue-600 text-white flex items-center justify-center gap-2 py-2 rounded-lg hover:bg-blue-700"
    >
      <PhoneIcon class="w-4 h-4" />
      Позвонить
    </button>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import {
  HeartIcon,
  BarChart2Icon,
  StarIcon,
  PhoneIcon
} from 'lucide-vue-next'

const props = defineProps({
  images: { type: Array, default: () => [] },
  title: String,
  price: Number,
  age: Number,
  height: Number,
  rating: Number,
  reviews: Number,
})

const currentImage = ref(0)

function onMouseMove(event) {
  const el = event.currentTarget
  const width = el.offsetWidth
  const mouseX = event.offsetX
  const imageCount = props.images.length || 0

  if (imageCount === 0) return;
  const index = Math.floor((mouseX / width) * imageCount)
  currentImage.value = Math.min(index, imageCount - 1)
}

function resetImage() {
  currentImage.value = 0
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>

