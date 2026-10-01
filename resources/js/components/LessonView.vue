<!-- resources/js/components/LessonView.vue -->
<template>
  <div class="min-h-screen bg-[#0a0a0f] text-white">



    <!-- 🎉 Card de félicitations (Teleport to body → pas de piège CSS) -->
    <LessonCompleteCard
      :visible="showCompleteCard"
      :user-name="user?.name || 'Élève'"
      :chapter-title="lesson.title"
      :xp="lesson.xp || 100"
      :duration="lesson.duration || 30"
      :steps-count="totalSteps"
      @close="handleCompleteClose"
      @next="handleCompleteNext"
    />

    <!-- Blobs d'arrière-plan -->
    <div class="fixed top-[-10%] ..."></div>







    <div class="fixed top-[-10%] left-[-5%] w-[45vw] max-w-[500px] h-[500px] bg-brandCyber/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="fixed bottom-[10%] right-[-5%] w-[45vw] max-w-[500px] h-[500px] bg-brandMint/10 rounded-full blur-[150px] pointer-events-none"></div>

    <!-- ═══════════ HEADER ═══════════ -->
    <header class="border-b border-slate-800/80 bg-[#0a0a0f]/80 backdrop-blur-md sticky top-0 z-40">
      <div class="container mx-auto px-4 sm:px-6 py-4 max-w-7xl flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
          <button
            @click="goBack"
            class="text-xs font-mono font-bold text-slate-400 hover:text-brandCyber transition bg-slate-900 border border-slate-800 px-3 py-1.5 rounded-xl"
          >
            ← Retour aux cours
          </button>
          <span class="hidden sm:inline-block text-xs bg-brandMint/10 text-brandMint font-bold px-2.5 py-1 rounded-full border border-brandMint/20">
            Chapitre {{ lesson.courseNumber }} : {{ lesson.title }}
          </span>
        </div>

        <div class="flex items-center gap-3">
          <button
            @click="toggleFullscreen"
            class="text-slate-400 hover:text-white transition p-2 rounded-xl hover:bg-slate-800/60"
            title="Plein écran"
          >
            <Maximize2 v-if="!isFullscreen" class="w-5 h-5" />
            <Minimize2 v-else class="w-5 h-5" />
          </button>
          <span class="text-xs font-mono text-slate-400">{{ progressPercent }}%</span>
          <div class="w-24 h-1.5 bg-slate-800 rounded-full overflow-hidden">
            <div
              class="h-full bg-gradient-to-r from-brandMint to-brandCyber transition-all duration-700"
              :style="{ width: progressPercent + '%' }"
            ></div>
          </div>
        </div>
      </div>
    </header>

    <!-- ═══════════ LOADER ═══════════ -->
    <div v-if="loading" class="container mx-auto px-4 sm:px-6 pt-20 max-w-6xl text-center">
      <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-800 animate-pulse mb-4"></div>
      <p class="text-sm text-slate-500">Chargement du cours...</p>
    </div>

    <!-- ═══════════ PAS DE CONTENU ═══════════ -->
    <div v-else-if="!lesson.parts || lesson.parts.length === 0" class="container mx-auto px-4 sm:px-6 pt-20 max-w-2xl text-center">
      <div class="w-20 h-20 mx-auto rounded-3xl bg-slate-800/60 border border-slate-700 flex items-center justify-center mb-4">
        <FileQuestion class="w-10 h-10 text-slate-600" />
      </div>
      <h2 class="text-lg font-bold text-white mb-1">Contenu en préparation</h2>
      <p class="text-sm text-slate-500 mb-6">Cette leçon sera bientôt disponible</p>
      <router-link
        to="/courses"
        class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-brandCyber/10 text-brandCyber font-bold text-sm hover:bg-brandCyber/20 transition"
      >
        <ArrowLeft class="w-4 h-4" />
        Retour aux cours
      </router-link>
    </div>

    <!-- ═══════════ CONTENU DU COURS ═══════════ -->
    <main v-else class="container mx-auto px-4 sm:px-6 pt-6 pb-32 max-w-6xl relative z-10">

      <!-- OBJECTIFS -->
      <div class="bg-[#0f0f1a]/60 border border-brandMint/30 rounded-2xl p-5 sm:p-6 mb-6">
        <h2 class="text-sm font-bold text-brandMint uppercase tracking-wider mb-4 flex items-center gap-2">
          <Target class="w-4 h-4" />
          Objectifs du cours
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-slate-300">
          <div v-for="(obj, i) in lesson.objectives" :key="i" class="flex items-start gap-2">
            <CheckCircle2 class="w-4 h-4 text-brandMint flex-shrink-0 mt-0.5" />
            <span>{{ obj }}</span>
          </div>
        </div>
      </div>

      <!-- INDICATEURS DE PARTIE -->
      <div class="flex flex-wrap gap-2 mb-6 justify-center">
        <button
          v-for="(part, i) in lesson.parts"
          :key="i"
          @click="goToPart(i)"
          class="px-3 sm:px-4 py-2 rounded-xl text-xs font-bold transition-all"
          :class="getPartClass(i)"
        >
          Partie {{ i + 1 }}<span class="hidden sm:inline"> : {{ truncate(part.title, 20) }}</span>
        </button>
      </div>

      <!-- CONTENEUR PRINCIPAL -->
      <div
        ref="courseContainer"
        class="bg-[#0f0f1a]/90 border-2 border-brandCyber/30 rounded-3xl overflow-hidden shadow-2xl relative transition-all duration-300"
        :class="{ 'fullscreen-mode': isFullscreen }"
      >
        <!-- En-tête de la partie -->
        <div class="bg-[#0a0a12]/50 px-6 py-4 border-b border-slate-800 flex items-center justify-between flex-wrap gap-2">
          <div class="flex items-center gap-3">
            <span class="text-xs font-mono font-bold text-brandCyber bg-brandCyber/10 px-3 py-1 rounded-full border border-brandCyber/20">
              Partie {{ currentPart + 1 }} / {{ lesson.parts.length }}
            </span>
            <h2 class="text-sm font-bold text-white">{{ currentPartData.title }}</h2>
          </div>
          <span class="text-xs text-slate-400 font-mono">
            Étape {{ currentStep + 1 }} / {{ currentPartData.steps.length }}
          </span>
        </div>

        <!-- Carte courante -->
        <div class="p-4 sm:p-6">
          <LessonCard
            :key="`${currentPart}-${currentStep}`"
            :step="currentStepData"
            :user="user"
            @quiz-answered="handleQuizAnswered"
          />
        </div>

        <!-- Contrôles -->
        <div class="px-4 sm:px-6 py-4 border-t border-slate-800 bg-[#0a0a12]/50 flex flex-wrap items-center justify-between gap-4">
          <div class="flex items-center gap-3">
            <button
              @click="prevStep"
              :disabled="isFirstStep"
              class="bg-slate-800 hover:bg-slate-700 text-slate-300 px-5 py-3 rounded-2xl text-xs font-bold transition border border-slate-700 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              ← Précédent
            </button>
            <button
              @click="nextStep"
              class="bg-gradient-to-r from-brandCyber to-amber-400 text-slate-950 font-black px-6 py-3 rounded-2xl text-xs uppercase tracking-wider hover:brightness-110 transition shadow-lg flex items-center gap-2"
            >
              <template v-if="isLastStep">
                <Trophy class="w-4 h-4" />
                Terminer
              </template>
              <template v-else>
                Suivant →
              </template>
            </button>
          </div>

          <div class="flex items-center gap-2">
            <button
              @click="resetCourse"
              class="bg-slate-800 hover:bg-slate-700 text-slate-400 px-4 py-3 rounded-2xl text-xs font-bold transition border border-slate-700"
            >
              ↺ Recommencer
            </button>
          </div>
        </div>
      </div>

      

    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '../plugins/axios'
import { getLesson } from '../data/lessons'
import LessonCard from './LessonCard.vue'
import {
  Maximize2, Minimize2, Target, CheckCircle2, ArrowLeft,
  Trophy, FileQuestion
} from 'lucide-vue-next'
import LessonCompleteCard from './LessonCompleteCard.vue'
const route = useRoute()
const router = useRouter()
// ─── Confetti card ────────────────────────────
const showCompleteCard = ref(false)
// ─── User ─────────────────────────────────────
const user = ref(JSON.parse(localStorage.getItem('user') || '{}'))

// ─── State ────────────────────────────────────
const loading = ref(true)
const currentPart = ref(0)
const currentStep = ref(0)
const isFullscreen = ref(false)
const showSummary = ref(false)
const courseContainer = ref(null)

// ─── Lesson ───────────────────────────────────
const lesson = ref({
  id: null,
  title: 'Chargement...',
  subtitle: '',
  duration: 0,
  xp: 0,
  courseNumber: null,
  objectives: [],
  parts: [],
})

// ─── Computed ─────────────────────────────────
const currentPartData = computed(() => lesson.value.parts[currentPart.value] || { steps: [], title: '' })
const currentStepData = computed(() => currentPartData.value.steps[currentStep.value] || {})

const isFirstStep = computed(() => currentPart.value === 0 && currentStep.value === 0)
const isLastStep = computed(() =>
  currentPart.value === lesson.value.parts.length - 1 &&
  currentStep.value === currentPartData.value.steps.length - 1
)

// Comptage des étapes
const totalSteps = computed(() =>
  lesson.value.parts.reduce((sum, p) => sum + (p.steps?.length || 0), 0)
)

const completedSteps = computed(() => {
  let done = 0
  for (let i = 0; i < currentPart.value; i++) {
    done += lesson.value.parts[i].steps?.length || 0
  }
  done += currentStep.value + 1
  return done
})

const progressPercent = computed(() => {
  if (totalSteps.value === 0) return 0
  return Math.round((completedSteps.value / totalSteps.value) * 100)
})

// ─── Load ─────────────────────────────────────
const loadLesson = async () => {
  loading.value = true
  try {
    const { data } = await api.get(`/courses/${route.params.id}`)
    if (!data.success) throw new Error('Cours introuvable')

    const course = data.course
    const sectionCode = course.section?.code || user.value.section?.code || 'informatique'

    const content = getLesson(sectionCode, course.number)

    if (!content) {
      lesson.value = { ...lesson.value, title: course.title, courseNumber: course.number, parts: [] }
      return
    }

    lesson.value = {
      ...content,
      courseId: course.id,
      courseNumber: course.number,
      apiProgress: course.progress,
    }
  } catch (error) {
    console.error('Erreur chargement:', error)
    router.push('/courses')
  } finally {
    loading.value = false
  }
}

// ─── Navigation ───────────────────────────────
const nextStep = () => {
  if (!isLastStep.value) {
    if (currentStep.value < currentPartData.value.steps.length - 1) {
      currentStep.value++
    } else if (currentPart.value < lesson.value.parts.length - 1) {
      currentPart.value++
      currentStep.value = 0
    }
    scrollToTop()
  } else {
    finishLesson()
  }
}

const prevStep = () => {
  if (!isFirstStep.value) {
    if (currentStep.value > 0) {
      currentStep.value--
    } else if (currentPart.value > 0) {
      currentPart.value--
      currentStep.value = currentPartData.value.steps.length - 1
    }
    scrollToTop()
  }
}

const goToPart = (index) => {
  if (index >= 0 && index < lesson.value.parts.length) {
    currentPart.value = index
    currentStep.value = 0
    showSummary.value = false
    scrollToTop()
  }
}

const resetCourse = () => {
  currentPart.value = 0
  currentStep.value = 0
  showSummary.value = false
  scrollToTop()
}

const scrollToTop = () => {
  if (courseContainer.value) {
    courseContainer.value.scrollIntoView({ behavior: 'smooth', block: 'start' })
  }
}

// ─── Fullscreen ───────────────────────────────
const toggleFullscreen = () => {
  isFullscreen.value = !isFullscreen.value
}

// ─── Quiz ─────────────────────────────────────
const handleQuizAnswered = (isCorrect) => {
  console.log('Quiz répondu:', isCorrect ? '✅' : '❌')
}

// ─── Finish ───────────────────────────────────
const finishLesson = async () => {
  try {
    await api.put(`/courses/${route.params.id}/progress`, { progress: 100 })

    // Mettre à jour le user local (XP)
    user.value.total_xp = (user.value.total_xp || 0) + (lesson.value.xp || 0)
    localStorage.setItem('user', JSON.stringify(user.value))

    // ✅ Forcer le rechargement de Courselist en revenant
    // (Courselist rechargera automatiquement grâce au watch sur route.path
    //  et à visibilitychange — aucun événement à émettre nécessaire)
  } catch (error) {
    console.error('Erreur sauvegarde:', error)
  }

  showCompleteCard.value = true
}

const handleCompleteClose = () => {
  showCompleteCard.value = false
}

const handleCompleteNext = () => {
  showCompleteCard.value = false
  // Navigation vers la prochaine leçon (à adapter)
  router.push('/courses')
}

const goBack = () => router.push(`/courses/${route.params.id}`)

// ─── Helpers ──────────────────────────────────
const truncate = (text, len) => {
  if (!text) return ''
  return text.length > len ? text.slice(0, len) + '...' : text
}

const getPartClass = (index) => {
  if (index === currentPart.value) {
    return 'bg-brandCyber text-slate-950 shadow-lg'
  }
  if (index < currentPart.value) {
    return 'bg-brandMint text-slate-950'
  }
  return 'bg-slate-800 text-slate-400 hover:bg-slate-700'
}

// ─── Clavier ──────────────────────────────────
const handleKeydown = (e) => {
  if (e.key === 'ArrowRight') nextStep()
  if (e.key === 'ArrowLeft') prevStep()
  if (e.key === 'Escape' && isFullscreen.value) isFullscreen.value = false
}

// ─── Lifecycle ────────────────────────────────
onMounted(async () => {
  try {
    const { data } = await api.get('/me')
    if (data.success) {
      user.value = data.user
      localStorage.setItem('user', JSON.stringify(user.value))
    }
  } catch (e) {
    console.error('Erreur user:', e)
  }
  await loadLesson()
  window.addEventListener('keydown', handleKeydown)
})

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeydown)
})
</script>

<style scoped>
.fullscreen-mode {
  position: fixed !important;
  top: 0 !important;
  left: 0 !important;
  right: 0 !important;
  bottom: 0 !important;
  z-index: 9999 !important;
  background: #0a0a0f !important;
  overflow-y: auto !important;
  border-radius: 0 !important;
  border: none !important;
  margin: 0 !important;
  padding: 0 !important;
}
</style>