<!-- resources/js/components/LessonCompleteCard.vue -->
<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition duration-500 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-300 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="visible"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
        @click.self="close"
      >
        <!-- Confettis -->
        <div class="confetti-container absolute inset-0 pointer-events-none overflow-hidden">
          <span
            v-for="i in 60"
            :key="i"
            class="confetti"
            :style="getConfettiStyle(i)"
          ></span>
        </div>

        <!-- Card -->
        <Transition
          appear
          enter-active-class="transition duration-700 ease-out"
          enter-from-class="opacity-0 scale-50 -translate-y-12"
          enter-to-class="opacity-100 scale-100 translate-y-0"
        >
          <div
            v-if="visible"
            class="relative max-w-lg w-full bg-gradient-to-br from-[#0f0f1a] via-[#0a0a12] to-[#0f0f1a] rounded-3xl border-2 border-brandCyber shadow-[0_0_60px_rgba(253,224,71,0.4)] overflow-hidden"
          >
            <!-- Halo animé -->
            <div class="absolute inset-0 bg-gradient-to-r from-brandCyber/10 via-brandMint/10 to-purple-400/10 animate-pulse-slow"></div>

            <!-- Contenu -->
            <div class="relative p-8 sm:p-10 text-center space-y-5">

              <!-- Trophée animé -->
              <div class="text-6xl sm:text-7xl animate-bounce-slow">
                🏆
              </div>

              <!-- Titre -->
              <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                BRAVO <span class="text-brandCyber">{{ userName }}</span> !
              </h2>

              <!-- Sous-titre -->
              <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                Tu viens de terminer le chapitre
              </p>

              <!-- Nom du chapitre -->
              <div class="inline-block px-4 py-2 rounded-xl bg-brandCyber/10 border border-brandCyber/40">
                <p class="text-base sm:text-lg font-bold text-brandCyber">
                  {{ chapterTitle }}
                </p>
              </div>

              <!-- Stats -->
              <div class="grid grid-cols-3 gap-3 pt-2">
                <div class="bg-[#0a0a12]/60 border border-slate-800 rounded-xl p-3">
                  <p class="text-[10px] uppercase tracking-wider text-slate-500 font-mono">XP</p>
                  <p class="text-lg font-black text-brandCyber">+{{ xp }}</p>
                </div>
                <div class="bg-[#0a0a12]/60 border border-slate-800 rounded-xl p-3">
                  <p class="text-[10px] uppercase tracking-wider text-slate-500 font-mono">Durée</p>
                  <p class="text-lg font-black text-brandMint">{{ duration }}m</p>
                </div>
                <div class="bg-[#0a0a12]/60 border border-slate-800 rounded-xl p-3">
                  <p class="text-[10px] uppercase tracking-wider text-slate-500 font-mono">Étapes</p>
                  <p class="text-lg font-black text-purple-400">{{ stepsCount }}</p>
                </div>
              </div>

              <!-- Message motivant -->
              <p class="text-xs text-slate-400 italic pt-1">
                « {{ motivationalMessage }} »
              </p>

              <!-- Boutons -->
              <div class="flex flex-col sm:flex-row gap-3 pt-3">
                <button
                  @click="close"
                  class="flex-1 px-5 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-sm transition"
                >
                  Fermer
                </button>
                <button
                  @click="goNext"
                  class="flex-1 px-5 py-3 rounded-xl bg-brandCyber hover:bg-yellow-300 text-slate-950 font-black text-sm transition shadow-[0_0_20px_rgba(253,224,71,0.4)]"
                >
                  Chapitre suivant →
                </button>
              </div>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { ref, watch, onUnmounted } from 'vue'

const props = defineProps({
  visible: { type: Boolean, default: false },
  userName: { type: String, default: 'Élève' },
  chapterTitle: { type: String, default: 'Chapitre' },
  xp: { type: Number, default: 100 },
  duration: { type: Number, default: 30 },
  stepsCount: { type: Number, default: 0 },
})

const emit = defineEmits(['close', 'next'])

// ─── Messages motivants aléatoires ──────────────
const motivationalMessages = [
  'Tu es sur la voie de la réussite !',
  'Continue comme ça, tu vas tout déchirer !',
  'Chaque chapitre te rapproche du Bac !',
  'Ton cerveau te dit merci 🧠',
  'Un pas de plus vers la mention !',
  'Le savoir, c\'est le pouvoir !',
]

const motivationalMessage = ref(motivationalMessages[0])

// ─── Confettis ──────────────────────────────────
const CONFETTI_COLORS = [
  '#fde047', // brandCyber
  '#34d399', // brandMint
  '#a78bfa', // purple
  '#f472b6', // pink
  '#60a5fa', // blue
  '#fb923c', // orange
]

const getConfettiStyle = (i) => {
  const left = Math.random() * 100
  const delay = Math.random() * 2
  const duration = 2.5 + Math.random() * 2
  const color = CONFETTI_COLORS[i % CONFETTI_COLORS.length]
  const size = 6 + Math.random() * 8
  const rotate = Math.random() * 360

  return {
    left: `${left}%`,
    background: color,
    width: `${size}px`,
    height: `${size * 1.5}px`,
    animationDelay: `${delay}s`,
    animationDuration: `${duration}s`,
    transform: `rotate(${rotate}deg)`,
  }
}

// ─── Audio ──────────────────────────────────────
let applauseAudio = null
let confettiAudio = null

const initAudio = () => {
  if (!applauseAudio) {
    applauseAudio = new Audio('/sounds/applause.wav')
    applauseAudio.volume = 0.4
  }
  if (!confettiAudio) {
    confettiAudio = new Audio('/sounds/confetti.mp3')
    confettiAudio.volume = 0.3
  }
}

const playCelebrationSound = () => {
  initAudio()
  try {
    applauseAudio.currentTime = 0
    applauseAudio.play().catch(() => {})
    // Petit délai pour le "pop" des confettis
    setTimeout(() => {
      confettiAudio.currentTime = 0
      confettiAudio.play().catch(() => {})
    }, 200)
  } catch (e) {}
}

const stopSounds = () => {
  if (applauseAudio) {
    applauseAudio.pause()
    applauseAudio.currentTime = 0
  }
  if (confettiAudio) {
    confettiAudio.pause()
    confettiAudio.currentTime = 0
  }
}

// ─── Actions ────────────────────────────────────
const close = () => {
  stopSounds()
  emit('close')
}

const goNext = () => {
  stopSounds()
  emit('next')
}

// ─── Réactions à l'apparition ───────────────────
watch(() => props.visible, (isVisible) => {
  if (isVisible) {
    // Message aléatoire
    motivationalMessage.value = motivationalMessages[Math.floor(Math.random() * motivationalMessages.length)]
    // Son de fête
    playCelebrationSound()
  } else {
    stopSounds()
  }
})

onUnmounted(() => {
  stopSounds()
})
</script>

<style scoped>
/* Confettis qui tombent */
.confetti {
  position: absolute;
  top: -20px;
  border-radius: 2px;
  opacity: 0;
  animation-name: fall;
  animation-timing-function: linear;
  animation-iteration-count: infinite;
}

@keyframes fall {
  0% {
    top: -20px;
    opacity: 1;
    transform: translateX(0) rotate(0deg);
  }
  100% {
    top: 110%;
    opacity: 0;
    transform: translateX(100px) rotate(720deg);
  }
}

/* Pulsation du halo */
.animate-pulse-slow {
  animation: pulseSlow 3s ease-in-out infinite;
}

@keyframes pulseSlow {
  0%, 100% { opacity: 0.3; }
  50% { opacity: 0.7; }
}

/* Rebond lent du trophée */
.animate-bounce-slow {
  animation: bounceSlow 2s ease-in-out infinite;
}

@keyframes bounceSlow {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-12px); }
}
</style>