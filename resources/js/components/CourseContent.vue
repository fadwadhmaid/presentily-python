<!-- resources/js/components/CourseContent.vue -->
<template>
  <div class="min-h-screen bg-[#0a0a0f] text-white">
    <div class="fixed top-[-10%] left-[-5%] w-[45vw] max-w-[500px] h-[500px] bg-brandCyber/5 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- SIDEBAR (identique) -->
    <aside class="fixed top-0 left-0 h-full w-64 bg-[#0f0f1a]/95 backdrop-blur-xl border-r border-slate-800 hidden md:flex flex-col z-30">
      <div class="flex items-center gap-2 px-6 py-6 border-b border-slate-800/60">
        <span class="text-2xl font-extrabold tracking-tight bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent">
          Presenti<span class="text-brandCyber">ly</span>
        </span>
      </div>

      <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        <p class="text-[10px] font-bold text-slate-600 uppercase tracking-wider px-4 mb-3">Apprentissage</p>
        <router-link to="/dashboard" class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition">
          <LayoutDashboard class="w-5 h-5" />
          <span class="font-medium text-sm">Tableau de bord</span>
        </router-link>
        <router-link to="/courses" class="group flex items-center gap-3 px-4 py-2.5 rounded-xl bg-brandCyber/10 text-brandCyber border border-brandCyber/20 transition">
          <BookOpen class="w-5 h-5" />
          <span class="font-semibold text-sm">Mes cours</span>
        </router-link>
        <router-link to="/exercises" class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition">
          <ClipboardList class="w-5 h-5" />
          <span class="font-medium text-sm">Exercices</span>
        </router-link>
        <p class="text-[10px] font-bold text-slate-600 uppercase tracking-wider px-4 mt-6 mb-3">Progression</p>
        <router-link to="/badges" class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition">
          <Award class="w-5 h-5" />
          <span class="font-medium text-sm">Badges</span>
        </router-link>
        <router-link to="/leaderboard" class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition">
          <BarChart3 class="w-5 h-5" />
          <span class="font-medium text-sm">Classement</span>
        </router-link>
      </nav>

      <div class="px-4 py-4 border-t border-slate-800/60">
        <button @click="logout" class="flex items-center gap-3 px-4 py-2.5 w-full rounded-xl text-red-400 hover:bg-red-500/10 transition">
          <LogOut class="w-5 h-5" />
          <span class="font-medium text-sm">Déconnexion</span>
        </button>
      </div>
    </aside>

    <!-- MAIN -->
    <main class="md:ml-64 relative z-10">
      <header class="sticky top-0 z-20 bg-[#0a0a0f]/80 backdrop-blur-xl border-b border-slate-800/60 px-4 sm:px-6 py-4">
        <div class="flex items-center justify-between gap-4">
          <div class="flex items-center gap-3">
            <router-link :to="`/courses/${route.params.id}`" class="text-slate-400 hover:text-white p-2 transition">
              <ArrowLeft class="w-5 h-5" />
            </router-link>
            <div>
              <p class="text-[10px] text-slate-500 uppercase tracking-wider font-bold">Contenu du cours</p>
              <h1 class="text-sm sm:text-base font-bold text-white truncate">{{ course.title }}</h1>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-[#0f0f1a]/80 border border-slate-800 rounded-lg">
              <div class="w-2 h-2 bg-brandMint rounded-full animate-pulse"></div>
              <span class="text-[10px] font-bold text-slate-400">Progression {{ course.progress }}%</span>
            </div>
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brandCyber to-amber-500 flex items-center justify-center text-slate-950 font-bold text-sm">
              {{ userInitial }}
            </div>
          </div>
        </div>
      </header>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-4 sm:p-6 lg:p-8">
        <!-- CONTENU PRINCIPAL -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Barre de progression -->
          <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-3">
              <div>
                <h3 class="text-sm font-bold text-white">Ta progression</h3>
                <p class="text-[10px] text-slate-500 mt-0.5">{{ completedChapters }} / {{ course.chapters }} chapitres terminés</p>
              </div>
              <span class="text-2xl font-extrabold text-brandCyber">{{ course.progress }}%</span>
            </div>
            <div class="w-full bg-slate-800 rounded-full h-2 overflow-hidden">
              <div class="bg-gradient-to-r from-brandCyber to-amber-500 h-full rounded-full transition-all duration-1000"
                   :style="{ width: course.progress + '%' }"></div>
            </div>
          </div>

          <!-- Liste des chapitres -->
          <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-slate-800">
              <h3 class="text-base font-bold text-white flex items-center gap-2">
                <ListChecks class="w-4 h-4 text-brandCyber" />
                Contenu du cours
              </h3>
              <p class="text-xs text-slate-500 mt-1">{{ course.chapters }} chapitres • {{ course.hours }}h de contenu</p>
            </div>

            <div class="divide-y divide-slate-800/60">
              <div v-for="(chapter, index) in course.chaptersList" :key="chapter.id"
                   class="group hover:bg-slate-800/30 transition cursor-pointer"
                   @click="openChapter(chapter, index)">
                <div class="flex items-center gap-4 p-4 sm:p-5">
                  <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 border transition"
                       :class="getChapterStatusClass(chapter.status)">
                    <component :is="getChapterIcon(chapter.status)" class="w-5 h-5" />
                  </div>

                  <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                      <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Chapitre {{ index + 1 }}</p>
                      <span v-if="chapter.isNew" class="text-[9px] font-bold text-brandCyber bg-brandCyber/10 border border-brandCyber/30 px-1.5 py-0.5 rounded">NOUVEAU</span>
                    </div>
                    <h4 class="text-sm font-semibold text-slate-200 mt-0.5 truncate group-hover:text-white transition">
                      {{ chapter.title }}
                    </h4>
                    <p class="text-[10px] text-slate-500 mt-1 line-clamp-1">{{ chapter.description }}</p>
                  </div>

                  <div class="hidden sm:flex items-center gap-3 text-[10px] text-slate-500">
                    <span class="flex items-center gap-1">
                      <Clock class="w-3 h-3" />
                      {{ chapter.duration }} min
                    </span>
                    <ArrowRight class="w-4 h-4 text-slate-600 group-hover:text-brandCyber group-hover:translate-x-1 transition" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- SIDEBAR DROITE -->
        <div class="lg:col-span-1 space-y-6">
          <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-6">
            <h3 class="text-sm font-bold text-white mb-4">Ta progression</h3>

            <div class="flex items-center justify-center mb-5">
              <div class="relative w-32 h-32">
                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                  <circle class="text-slate-800" stroke-width="8" stroke="currentColor" fill="transparent" r="42" cx="50" cy="50"/>
                  <circle class="text-brandCyber" stroke-width="8" stroke-linecap="round" stroke="currentColor" fill="transparent" r="42" cx="50" cy="50"
                          :stroke-dasharray="263.89"
                          :stroke-dashoffset="263.89 * (1 - course.progress / 100)"
                          style="transition: stroke-dashoffset 1s ease-out;"/>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                  <span class="text-2xl font-extrabold text-white">{{ course.progress }}%</span>
                  <span class="text-[10px] text-slate-500 font-medium">Terminé</span>
                </div>
              </div>
            </div>

            <div class="space-y-3 pt-3 border-t border-slate-800/60">
              <div class="flex items-center justify-between">
                <span class="text-xs text-slate-500">Chapitres terminés</span>
                <span class="text-xs font-bold text-white">{{ completedChapters }}/{{ course.chapters }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-xs text-slate-500">Temps d'étude</span>
                <span class="text-xs font-bold text-white">{{ studyTime }}h</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-xs text-slate-500">XP gagnés</span>
                <span class="text-xs font-bold text-brandMint">+{{ xpGained }} XP</span>
              </div>
            </div>
          </div>

          <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-6">
            <h3 class="text-sm font-bold text-white mb-4">Ressources</h3>
            <div class="space-y-2">
              <button class="w-full flex items-center gap-3 p-3 rounded-xl bg-slate-800/30 border border-slate-800 hover:border-brandCyber/30 hover:bg-slate-800/50 transition text-left">
                <div class="w-8 h-8 rounded-lg bg-red-400/10 border border-red-400/20 flex items-center justify-center flex-shrink-0">
                  <FileText class="w-4 h-4 text-red-400" />
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-xs font-semibold text-slate-200">Fiche de révision PDF</p>
                  <p class="text-[10px] text-slate-500">2.4 MB</p>
                </div>
                <Download class="w-4 h-4 text-slate-500" />
              </button>
              <button class="w-full flex items-center gap-3 p-3 rounded-xl bg-slate-800/30 border border-slate-800 hover:border-brandCyber/30 hover:bg-slate-800/50 transition text-left">
                <div class="w-8 h-8 rounded-lg bg-brandCyber/10 border border-brandCyber/20 flex items-center justify-center flex-shrink-0">
                  <Code2 class="w-4 h-4 text-brandCyber" />
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-xs font-semibold text-slate-200">Code source des exemples</p>
                  <p class="text-[10px] text-slate-500">Dossier ZIP</p>
                </div>
                <Download class="w-4 h-4 text-slate-500" />
              </button>
            </div>
          </div>

          <div class="bg-gradient-to-br from-brandMint/10 to-transparent border border-brandMint/20 rounded-2xl p-5">
            <div class="flex items-start gap-3">
              <div class="w-9 h-9 rounded-lg bg-brandMint/15 border border-brandMint/30 flex items-center justify-center flex-shrink-0">
                <Trophy class="w-4 h-4 text-brandMint" />
              </div>
              <div>
                <p class="text-xs font-bold text-brandMint mb-1">Continue comme ça !</p>
                <p class="text-[11px] text-slate-400 leading-relaxed">Tu es à {{ 100 - course.progress }}% de terminer ce cours. Chaque leçon te rapproche du badge final !</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '../plugins/axios'
import {
  LayoutDashboard, BookOpen, ClipboardList, Award, BarChart3,
  LogOut, ArrowLeft, ArrowRight, Clock, PlayCircle, CheckCircle2,
  Check, Sparkles, Trophy, Zap, Bookmark, Users, Star,
} from 'lucide-vue-next'

const route = useRoute()
const router = useRouter()

// ─── User ─────────────────────────────────────
const user = ref(JSON.parse(localStorage.getItem('user') || '{}'))
const userInitial = computed(() => user.value?.name?.charAt(0).toUpperCase() || 'U')

// ─── State ────────────────────────────────────
const loading = ref(true)
const course = ref({
  id: null,
  title: '',
  description: '',
  level: '',
  levelClass: 'text-brandCyber bg-brandCyber/20 border-brandCyber/40',
  bannerClass: 'bg-gradient-to-br from-brandCyber/15 via-brandCyber/5 to-transparent',
  progress: 0,
  chapters: 0,
  hours: 0,
  xpReward: 0,
  objectives: [],
})

// ─── Load course from API ─────────────────────
const loadCourse = async () => {
  loading.value = true
  try {
    const { data } = await api.get(`/courses/${route.params.id}`)
    if (data.success) {
      const c = data.course

      // Calcul de la durée en heures
      const hours = Math.round((c.duration || 0) / 60)

      course.value = {
        id: c.id,
        title: c.title,
        description: c.description,
        level: getLevelLabel(c.number),
        levelClass: 'text-brandCyber bg-brandCyber/20 border-brandCyber/40',
        bannerClass: 'bg-gradient-to-br from-brandCyber/15 via-brandCyber/5 to-transparent',
        progress: c.progress ?? 0,
        chapters: c.lessons ?? 0,
        hours: hours,
        xpReward: c.xp_reward ?? 100,
        objectives: generateObjectives(c),
        category: c.category,
        categoryColor: c.category_color,
      }
    }
  } catch (error) {
    console.error('Erreur chargement cours:', error)
  } finally {
    loading.value = false
  }
}

// ─── Helpers ──────────────────────────────────
const getLevelLabel = (number) => {
  if (number <= 4) return 'Débutant'
  if (number <= 12) return 'Intermédiaire'
  return 'Avancé'
}

const generateObjectives = (course) => {
  // Objectifs génériques selon le chapitre
  return [
    `Maîtriser les concepts du chapitre ${course.number}`,
    `Comprendre ${course.title.toLowerCase()}`,
    `Appliquer à des exercices pratiques`,
    `Se préparer pour le Bac`,
  ]
}

// ─── Actions ──────────────────────────────────
const goToContent = () => {
  // Aller au chapitre 1 (le cours = 1 chapitre pour le moment)
  router.push(`/courses/${route.params.id}/chapters/1`)
}

// ─── Lifecycle ────────────────────────────────
onMounted(async () => {
  try {
    const { data } = await api.get('/me')
    if (data.success) {
      user.value = data.user
      localStorage.setItem('user', JSON.stringify(user.value))
    }
  } catch (error) {
    console.error('Erreur user:', error)
  }

  await loadCourse()
})

const logout = async () => {
  try { await api.post('/logout') } catch (e) {}
  localStorage.removeItem('token')
  localStorage.removeItem('user')
  router.push('/')
}
</script>

<style scoped>
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>