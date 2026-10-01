<!-- resources/js/components/LessonCard.vue -->
<template>
  <div class="space-y-6">

    <!-- ═══════════ DIALOGUE PROF / ÉLÈVE ═══════════ -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <!-- Prof -->
      <div
        class="flex items-start gap-3 bg-[#0a0a12]/80 border border-brandCyber/30 p-4 rounded-2xl transition-all duration-500"
        :class="showProf ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-2'"
      >
        <div class="w-12 h-12 rounded-2xl bg-brandCyber/20 border border-brandCyber flex items-center justify-center text-2xl flex-shrink-0 shadow-lg">
          👨‍🏫
        </div>
        <div class="space-y-1 flex-1">
          <div class="flex items-center justify-between">
            <span class="text-[10px] font-bold text-brandCyber uppercase font-mono tracking-wider">
              Prof Presentily
            </span>
            <button
              @click="toggleSound"
              class="text-slate-500 hover:text-brandCyber transition"
              :title="SOUND_ENABLED ? 'Couper le son' : 'Activer le son'"
            >
              <Volume2 v-if="SOUND_ENABLED" class="w-3.5 h-3.5" />
              <VolumeX v-else class="w-3.5 h-3.5" />
            </button>
          </div>
          <p class="text-sm text-slate-200 leading-relaxed font-medium min-h-[1.5rem]">
            {{ displayedProfText }}<span
              v-if="isTypingProf"
              class="inline-block w-[2px] h-[1em] bg-brandCyber ml-0.5 align-middle animate-pulse"
            ></span>
          </p>
        </div>
      </div>

      <!-- Élève -->
      <div
        class="flex items-start gap-3 bg-[#0a0a12]/80 border border-brandMint/30 p-4 rounded-2xl transition-all duration-500"
        :class="showStudent ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-2'"
      >
        <div class="space-y-1 flex-1 text-right">
          <span class="text-[10px] font-bold text-brandMint uppercase font-mono tracking-wider">
            {{ userName }}
          </span>
          <p class="text-sm text-slate-200 leading-relaxed font-medium italic">
            {{ step.student }}
          </p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-brandMint/20 border border-brandMint flex items-center justify-center flex-shrink-0 shadow-lg overflow-hidden">
          <UserAvatar v-if="avatarConfig" :config="avatarConfig" :size="48" />
          <span v-else class="text-2xl"></span>
        </div>
      </div>
    </div>

    <!-- ═══════════ QUIZ (si présent) ═══════════ -->
    <template v-if="step.quiz && showContent">
      <div class="bg-[#0a0a12] rounded-2xl border-2 border-purple-400/30 overflow-hidden animate-fade-in">
        <div class="flex items-center gap-3 p-5 border-b border-slate-800 bg-purple-400/5">
          <div class="w-10 h-10 rounded-xl bg-purple-400/10 border border-purple-400/20 flex items-center justify-center">
            <HelpCircle class="w-5 h-5 text-purple-400" />
          </div>
          <div>
            <p class="text-[10px] font-bold text-purple-400 uppercase tracking-wider">Quiz interactif</p>
            <p class="text-xs text-slate-500">Teste ta compréhension</p>
          </div>
        </div>

        <div class="p-6">
          <p class="text-base sm:text-lg text-white font-semibold mb-5 leading-relaxed">
            {{ step.quiz.question }}
          </p>

          <div class="space-y-3">
            <button
              v-for="option in step.quiz.options"
              :key="option.id"
              @click="selectQuizAnswer(option.id)"
              :disabled="quizAnswered"
              class="w-full text-left p-4 rounded-xl border-2 transition-all duration-200"
              :class="getQuizOptionClass(option.id)"
            >
              <div class="flex items-center gap-3">
                <div
                  class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm flex-shrink-0"
                  :class="getQuizBadgeClass(option.id)"
                >
                  {{ option.id.toUpperCase() }}
                </div>
                <span class="text-sm font-medium flex-1">{{ option.text }}</span>
                <CheckCircle2
                  v-if="quizAnswered && option.id === step.quiz.correctId"
                  class="w-5 h-5 text-brandMint flex-shrink-0"
                />
                <XCircle
                  v-else-if="quizAnswered && option.id === selectedAnswer && option.id !== step.quiz.correctId"
                  class="w-5 h-5 text-red-400 flex-shrink-0"
                />
              </div>
            </button>
          </div>

          <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="opacity-0 -translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
          >
            <div
              v-if="quizAnswered"
              class="mt-5 p-4 rounded-xl border-2"
              :class="selectedAnswer === step.quiz.correctId
                ? 'bg-brandMint/5 border-brandMint/30'
                : 'bg-orange-400/5 border-orange-400/30'"
            >
              <div class="flex items-start gap-3">
                <component
                  :is="selectedAnswer === step.quiz.correctId ? CheckCircle2 : AlertTriangle"
                  class="w-5 h-5 flex-shrink-0 mt-0.5"
                  :class="selectedAnswer === step.quiz.correctId ? 'text-brandMint' : 'text-orange-400'"
                />
                <div>
                  <p
                    class="text-sm font-bold mb-1"
                    :class="selectedAnswer === step.quiz.correctId ? 'text-brandMint' : 'text-orange-400'"
                  >
                    {{ selectedAnswer === step.quiz.correctId ? ' Bravo !' : 'Pas tout à fait...' }}
                  </p>
                  <p class="text-xs text-slate-400 leading-relaxed">{{ step.quiz.explanation }}</p>
                </div>
              </div>
            </div>
          </Transition>
        </div>
      </div>
    </template>

    <!-- ═══════════ CODE + MÉMOIRE (si pas de quiz) ═══════════ -->
    <template v-else-if="!step.quiz && showContent">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 animate-fade-in">

        <!-- BLOC CODE -->
        <div class="lg:col-span-7 bg-[#0a0a12] rounded-2xl border border-slate-800 overflow-hidden flex flex-col">
          <!-- Header fenêtre -->
          <div class="flex items-center justify-between px-4 py-2.5 border-b border-slate-800 bg-[#0f0f1a]">
            <div class="flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-red-500/80"></span>
              <span class="w-2.5 h-2.5 rounded-full bg-yellow-500/80"></span>
              <span class="w-2.5 h-2.5 rounded-full bg-green-500/80"></span>
              <span class="ml-3 text-[10px] font-mono text-slate-500">script.py</span>
            </div>
            <div class="flex items-center gap-2">
              <button
                @click="copyCode"
                class="text-[10px] font-bold text-slate-400 hover:text-white flex items-center gap-1.5 px-2 py-1 rounded hover:bg-slate-800 transition"
              >
                <component :is="copied ? Check : Copy" class="w-3 h-3" />
                {{ copied ? 'Copié !' : 'Copier' }}
              </button>
              <span class="text-[9px] font-bold text-brandMint bg-brandMint/10 px-2 py-0.5 rounded">Python</span>
            </div>
          </div>

          <!-- Code -->
          <div class="p-5 font-mono text-sm leading-relaxed code-container flex-1">
            <pre class="text-brandCyber whitespace-pre-wrap"><code v-html="step.code"></code></pre>
          </div>

          <!-- Explication -->
          <div class="px-5 py-3 bg-[#0f0f1a] border-t border-slate-800">
            <p class="text-xs text-slate-400 leading-relaxed">
              <span class="text-brandCyber font-bold"> Explication :</span>
              {{ step.explanation }}
            </p>
          </div>
        </div>

        <!-- BLOC MÉMOIRE + CONSOLE -->
        <div class="lg:col-span-5 bg-[#0a0a12] rounded-2xl border border-slate-800 overflow-hidden flex flex-col">
          <!-- Header mémoire -->
          <div class="flex items-center justify-between px-4 py-2.5 border-b border-slate-800 bg-[#0f0f1a]">
            <span class="text-[10px] font-mono text-slate-400"> Mémoire RAM</span>
            <span class="text-[10px] font-mono text-slate-500">
              {{ (step.memory?.length || 0) }} élément{{ (step.memory?.length || 0) > 1 ? 's' : '' }}
            </span>
          </div>

          <!-- Cases mémoire -->
          <div class="p-5 min-h-[140px] flex flex-wrap items-center justify-center gap-2 bg-[#0a0a12]/50 flex-1">
            <span v-if="!step.memory || step.memory.length === 0" class="text-xs text-slate-500 italic font-mono">
              [ Mémoire vide ]
            </span>

            <div
              v-else
              v-for="(val, idx) in step.memory"
              :key="idx"
              class="memory-cell flex flex-col items-center transition-all"
              :class="{ 'highlight': idx === step.highlight }"
            >
              <span class="text-[9px] font-mono font-bold text-slate-500 mb-1">[{{ idx }}]</span>
              <div
                class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center font-mono font-black text-sm transition-all border"
                :class="idx === step.highlight
                  ? 'bg-brandCyber text-slate-950 border-2 border-white shadow-[0_0_20px_rgba(253,224,71,0.4)] scale-110'
                  : 'bg-[#0f0f1a] text-white border-slate-700'"
              >
                {{ displayMemoryValue(val) }}
              </div>
            </div>
          </div>

          <!-- Console -->
          <div class="px-4 py-3 bg-[#0f0f1a] border-t border-slate-800 min-h-[60px] font-mono text-xs">
            <div class="flex items-start gap-2">
              <span class="text-brandMint flex-shrink-0">▶</span>
              <pre class="text-slate-300 whitespace-pre-wrap flex-1">{{ step.console || 'Console prête' }}</pre>
            </div>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script setup>
import { ref, computed, watch, onUnmounted, nextTick } from 'vue'
import {
  CheckCircle2, XCircle, Check, Copy, HelpCircle, AlertTriangle,
  Volume2, VolumeX
} from 'lucide-vue-next'
import UserAvatar from './UserAvatar.vue'

const props = defineProps({
  step: { type: Object, required: true },
  user: { type: Object, default: () => ({}) },
})

const emit = defineEmits(['quiz-answered'])

// ─── User info ─────────────────────────────────
const userName = computed(() => props.user?.name || 'Élève')
const avatarConfig = computed(() => props.user?.avatar_config || null)

// ─── Séquence d'apparition ─────────────────────
const showProf = ref(false)
const showStudent = ref(false)
const showContent = ref(false)

// ─── Effet machine à écrire (Prof) + son ────────
const displayedProfText = ref('')
const isTypingProf = ref(false)
let typeInterval = null
let studentTimeout = null
let contentTimeout = null
const TYPING_SPEED = 18 // ms par caractère
const DELAY_BEFORE_STUDENT = 400 // ms après la fin du prof
const DELAY_BEFORE_CONTENT = 700 // ms après l'apparition de l'élève

// ─── Audio ──────────────────────────────────────
let typeAudio = null
let audioPool = []
let poolIndex = 0
const POOL_SIZE = 2
const SOUND_ENABLED = ref(true)
const MIN_SOUND_INTERVAL = 45
let lastSoundTime = 0

const initAudio = () => {
  if (typeAudio) return
  typeAudio = new Audio('/sounds/typewriter.mp3')
  typeAudio.volume = 0.12
  typeAudio.preload = 'auto'

  for (let i = 0; i < POOL_SIZE; i++) {
    const a = typeAudio.cloneNode()
    a.volume = 0.12
    audioPool.push(a)
  }
}

const playTypeSound = () => {
  if (!SOUND_ENABLED.value || !audioPool.length) return
  const now = performance.now()
  if (now - lastSoundTime < MIN_SOUND_INTERVAL) return
  lastSoundTime = now

  const a = audioPool[poolIndex]
  poolIndex = (poolIndex + 1) % POOL_SIZE
  try {
    a.currentTime = 0
    a.play().catch(() => {})
  } catch (e) {}
}

const stopAllSounds = () => {
  audioPool.forEach(a => {
    try {
      a.pause()
      a.currentTime = 0
    } catch (e) {}
  })
  lastSoundTime = 0
}

const toggleSound = () => {
  SOUND_ENABLED.value = !SOUND_ENABLED.value
  if (SOUND_ENABLED.value) initAudio()
  else stopAllSounds()
}

// ─── Nettoyage de la séquence ───────────────────
const clearSequence = () => {
  if (typeInterval) { clearInterval(typeInterval); typeInterval = null }
  if (studentTimeout) { clearTimeout(studentTimeout); studentTimeout = null }
  if (contentTimeout) { clearTimeout(contentTimeout); contentTimeout = null }
  stopAllSounds()
}

// ─── Séquence complète ──────────────────────────
const runSequence = async (text) => {
  clearSequence()

  // Reset visuel
  displayedProfText.value = ''
  isTypingProf.value = false
  showProf.value = false
  showStudent.value = false
  showContent.value = false

  initAudio()
  await nextTick()

  // 1️Afficher la bulle du prof
  showProf.value = true
  await new Promise(r => setTimeout(r, 200))

  // 2 Effet machine à écrire
  isTypingProf.value = true
  let i = 0
  typeInterval = setInterval(() => {
    if (i < text.length) {
      const char = text.charAt(i)
      displayedProfText.value += char
      i++
      if (char.trim() !== '') playTypeSound()
    } else {
      // 3️ Fin de la frappe du prof
      clearInterval(typeInterval)
      typeInterval = null
      isTypingProf.value = false
      stopAllSounds()

      // 4️ Faire apparaître l'élève
      studentTimeout = setTimeout(() => {
        showStudent.value = true

        // 5️ Puis faire apparaître le contenu (code ou quiz)
        contentTimeout = setTimeout(() => {
          showContent.value = true
        }, DELAY_BEFORE_CONTENT)
      }, DELAY_BEFORE_STUDENT)
    }
  }, TYPING_SPEED)
}

// Déclenche la séquence quand l'étape change
watch(
  () => props.step?.prof,
  (newText) => {
    if (newText) runSequence(newText)
  },
  { immediate: true }
)

onUnmounted(() => {
  clearSequence()
})

// ─── Quiz state ────────────────────────────────
const selectedAnswer = ref(null)
const quizAnswered = ref(false)

watch(() => props.step, () => {
  selectedAnswer.value = null
  quizAnswered.value = false
  copied.value = false
})

const selectQuizAnswer = (optionId) => {
  if (quizAnswered.value) return
  selectedAnswer.value = optionId
  quizAnswered.value = true
  emit('quiz-answered', optionId === props.step.quiz.correctId)
}

const getQuizOptionClass = (optionId) => {
  if (!quizAnswered.value) {
    return 'border-slate-800 bg-slate-800/30 hover:border-purple-400/40 hover:bg-slate-800/60'
  }
  if (optionId === props.step.quiz.correctId) {
    return 'border-brandMint/60 bg-brandMint/10'
  }
  if (optionId === selectedAnswer.value) {
    return 'border-red-400/60 bg-red-400/10'
  }
  return 'border-slate-800 bg-slate-800/20 opacity-50'
}

const getQuizBadgeClass = (optionId) => {
  if (!quizAnswered.value) return 'bg-slate-800 text-slate-400'
  if (optionId === props.step.quiz.correctId) return 'bg-brandMint text-slate-950'
  if (optionId === selectedAnswer.value) return 'bg-red-400 text-slate-950'
  return 'bg-slate-800 text-slate-500'
}

// ─── Copy ──────────────────────────────────────
const copied = ref(false)

const copyCode = async () => {
  try {
    const temp = document.createElement('div')
    temp.innerHTML = props.step.code
    await navigator.clipboard.writeText(temp.textContent || temp.innerText || '')
    copied.value = true
    setTimeout(() => { copied.value = false }, 2000)
  } catch (e) {
    console.error('Erreur copie:', e)
  }
}

// ─── Memory helpers ────────────────────────────
const displayMemoryValue = (val) => {
  if (val === '\n') return '↵'
  if (val === '\t') return '→'
  return val
}
</script>

<style scoped>
.code-container {
  min-height: 140px;
  background: #0a0a12;
}

.memory-cell.highlight {
  transform: scale(1.1);
  transition: transform 0.3s ease;
}

/* Curseur clignotant machine à écrire */
@keyframes blink {
  0%, 49% { opacity: 1; }
  50%, 100% { opacity: 0; }
}

.animate-pulse {
  animation: blink 0.8s steps(1) infinite;
}

/* Apparition douce du contenu */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(8px); }
  to   { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
  animation: fadeInUp 0.5s ease-out both;
}

/* Coloration syntaxique */
:deep(.code-comment) { color: #64748b; font-style: italic; }
:deep(.code-keyword) { color: #a78bfa; font-weight: 600; }
:deep(.code-string) { color: #34d399; }
:deep(.code-number) { color: #fbbf24; }
:deep(.code-function) { color: #60a5fa; }
:deep(.code-variable) { color: #f472b6; }
:deep(.code-operator) { color: #fde047; font-weight: 600; }
</style>