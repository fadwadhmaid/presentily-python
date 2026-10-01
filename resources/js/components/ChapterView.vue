<!-- resources/js/components/ChapterView.vue -->
<template>
  <div class="min-h-screen bg-[#0a0a0f] text-white">
    <div class="fixed top-[-10%] left-[-5%] w-[45vw] max-w-[500px] h-[500px] bg-brandCyber/5 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- ═══════════ SIDEBAR ═══════════ -->
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

    <!-- ═══════════ MAIN ═══════════ -->
    <main class="md:ml-64 relative z-10">
      <!-- Header -->
      <header class="sticky top-0 z-20 bg-[#0a0a0f]/80 backdrop-blur-xl border-b border-slate-800/60 px-4 sm:px-6 py-4">
        <div class="flex items-center justify-between gap-4">
          <div class="flex items-center gap-3">
            <button @click="goToCourse" class="text-slate-400 hover:text-white p-2 transition">
              <ArrowLeft class="w-5 h-5" />
            </button>
            <div>
              <p class="text-[10px] text-slate-500 uppercase tracking-wider font-bold">
                Chapitre {{ chapter.number }} • {{ course.title }}
              </p>
              <h1 class="text-sm sm:text-base font-bold text-white truncate">{{ chapter.title || 'Chargement...' }}</h1>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-[#0f0f1a]/80 border border-slate-800 rounded-lg">
              <Zap class="w-3.5 h-3.5 text-brandCyber" />
              <span class="text-[10px] font-bold text-slate-400">+{{ chapter.xp }} XP</span>
            </div>
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brandCyber to-amber-500 flex items-center justify-center text-slate-950 font-bold text-sm">
              {{ userInitial }}
            </div>
          </div>
        </div>
      </header>

      <!-- Loader -->
      <div v-if="loading" class="p-6 lg:p-8">
        <div class="bg-[#0f0f1a]/60 border border-slate-800 rounded-2xl p-12 text-center animate-pulse">
          <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-800 mb-4"></div>
          <div class="h-4 bg-slate-800 rounded w-1/3 mx-auto mb-2"></div>
          <div class="h-3 bg-slate-800 rounded w-2/3 mx-auto"></div>
        </div>
      </div>

      <!-- Contenu -->
      <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-4 sm:p-6 lg:p-8">

        <!-- ═══════════ COLONNE PRINCIPALE ═══════════ -->
        <div class="lg:col-span-2 space-y-6">

          <!-- Hero du chapitre -->
          <div class="relative overflow-hidden rounded-2xl border border-slate-800 bg-gradient-to-br from-brandCyber/10 via-transparent to-brandMint/5 p-6 sm:p-8">
            <div class="absolute top-0 right-0 w-64 h-64 bg-brandCyber/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>

            <div class="relative">
              <div class="flex flex-wrap items-center gap-2 mb-4">
                <span class="text-[10px] font-bold uppercase tracking-wider text-brandCyber bg-brandCyber/10 border border-brandCyber/20 px-2.5 py-1 rounded-lg">
                  Chapitre {{ chapter.number }}
                </span>
                <span class="text-[10px] font-bold text-slate-400 bg-slate-800/60 px-2.5 py-1 rounded-lg flex items-center gap-1">
                  <Clock class="w-3 h-3" />
                  {{ chapter.duration }} min
                </span>
                <span v-if="chapter.category" class="text-[10px] font-bold bg-slate-800/60 px-2.5 py-1 rounded-lg" :class="chapter.categoryColor">
                  {{ chapter.category }}
                </span>
              </div>

              <h2 class="text-2xl sm:text-3xl font-extrabold text-white">{{ chapter.title }}</h2>
              <p class="text-sm text-slate-300 mt-3 max-w-2xl leading-relaxed">{{ chapter.description }}</p>

              <!-- Barre de progression du chapitre -->
              <div class="mt-6 max-w-md">
                <div class="flex items-center justify-between mb-2">
                  <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Ta progression</span>
                  <span class="text-[11px] font-bold text-brandCyber">{{ chapterProgress }}%</span>
                </div>
                <div class="w-full bg-slate-900/60 rounded-full h-2 overflow-hidden">
                  <div class="bg-gradient-to-r from-brandCyber to-amber-500 h-full rounded-full transition-all duration-1000"
                       :style="{ width: chapterProgress + '%' }"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Objectifs -->
          <div v-if="chapter.objectives?.length" class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-6">
            <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
              <Target class="w-4 h-4 text-brandCyber" />
              Objectifs du chapitre
            </h3>
            <ul class="space-y-3">
              <li v-for="(obj, i) in chapter.objectives" :key="i" class="flex items-start gap-3">
                <div class="w-5 h-5 rounded-full bg-brandMint/20 border border-brandMint/30 flex items-center justify-center flex-shrink-0 mt-0.5">
                  <Check class="w-3 h-3 text-brandMint" />
                </div>
                <span class="text-sm text-slate-300 leading-relaxed">{{ obj }}</span>
              </li>
            </ul>
          </div>

          <!-- Leçons -->
          <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-slate-800">
              <h3 class="text-base font-bold text-white flex items-center gap-2">
                <ListChecks class="w-4 h-4 text-brandCyber" />
                Contenu du chapitre
              </h3>
              <p class="text-xs text-slate-500 mt-1">{{ chapter.lessons.length }} leçons • {{ chapter.duration }} min</p>
            </div>

            <div class="divide-y divide-slate-800/60">
              <div v-for="(lesson, index) in chapter.lessons" :key="lesson.id"
                   class="group hover:bg-slate-800/30 transition cursor-pointer p-4 sm:p-5"
                   @click="openLesson(lesson, index)">
                <div class="flex items-center gap-4">
                  <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 border transition"
                       :class="getLessonStatusClass(lesson.status)">
                    <component :is="getLessonIcon(lesson.status)" class="w-5 h-5" />
                  </div>

                  <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                      <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Leçon {{ index + 1 }}</p>
                      <span v-if="lesson.status === 'in_progress'" class="text-[9px] font-bold text-brandCyber bg-brandCyber/10 border border-brandCyber/30 px-1.5 py-0.5 rounded">EN COURS</span>
                    </div>
                    <h4 class="text-sm font-semibold text-slate-200 mt-0.5 truncate group-hover:text-white transition">
                      {{ lesson.title }}
                    </h4>
                    <p class="text-[10px] text-slate-500 mt-1 line-clamp-1">{{ lesson.description }}</p>
                  </div>

                  <div class="hidden sm:flex items-center gap-3 text-[10px] text-slate-500">
                    <span class="flex items-center gap-1">
                      <Clock class="w-3 h-3" />
                      {{ lesson.duration }} min
                    </span>
                    <ArrowRight class="w-4 h-4 text-slate-600 group-hover:text-brandCyber group-hover:translate-x-1 transition" />
                  </div>
                </div>
              </div>

              <!-- Empty state -->
              <div v-if="!chapter.lessons.length" class="p-8 text-center text-slate-500">
                <p class="text-sm">Aucune leçon disponible pour ce chapitre.</p>
              </div>
            </div>
          </div>

          <!-- Bouton Terminer -->
          <div class="flex justify-end pt-2">
            <button
              v-if="chapter.progress < 100"
              @click="markChapterComplete"
              :disabled="saving"
              class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-gradient-to-r from-brandMint to-emerald-400 text-slate-950 font-bold text-sm shadow-[0_0_20px_rgba(74,222,128,0.2)] hover:shadow-[0_0_30px_rgba(74,222,128,0.4)] transition disabled:opacity-50"
            >
              <Trophy class="w-4 h-4" />
              {{ saving ? 'Enregistrement...' : 'Marquer comme terminé' }}
            </button>

            <div
              v-else
              class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-brandMint/10 border border-brandMint/30 text-brandMint font-bold text-sm"
            >
              <CheckCircle2 class="w-4 h-4" />
              Chapitre terminé !
            </div>
          </div>
        </div>

        <!-- ═══════════ SIDEBAR DROITE ═══════════ -->
        <div class="lg:col-span-1 space-y-6">

          <!-- Progression -->
          <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-6">
            <h3 class="text-sm font-bold text-white mb-4">Progression du chapitre</h3>

            <div class="flex items-center justify-center mb-5">
              <div class="relative w-32 h-32">
                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                  <circle class="text-slate-800" stroke-width="8" stroke="currentColor" fill="transparent" r="42" cx="50" cy="50"/>
                  <circle class="text-brandCyber" stroke-width="8" stroke-linecap="round" stroke="currentColor" fill="transparent" r="42" cx="50" cy="50"
                          :stroke-dasharray="263.89"
                          :stroke-dashoffset="263.89 * (1 - chapterProgress / 100)"
                          style="transition: stroke-dashoffset 1s ease-out;"/>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                  <span class="text-2xl font-extrabold text-white">{{ chapterProgress }}%</span>
                  <span class="text-[10px] text-slate-500 font-medium">Terminé</span>
                </div>
              </div>
            </div>

            <div class="space-y-3 pt-3 border-t border-slate-800/60">
              <div class="flex items-center justify-between">
                <span class="text-xs text-slate-500">Leçons terminées</span>
                <span class="text-xs font-bold text-white">{{ completedLessons }}/{{ chapter.lessons.length }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-xs text-slate-500">Durée totale</span>
                <span class="text-xs font-bold text-white">{{ chapter.duration }} min</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-xs text-slate-500">XP à gagner</span>
                <span class="text-xs font-bold text-brandMint">+{{ chapter.xp }} XP</span>
              </div>
            </div>
          </div>

          <!-- Ressources -->
          <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-6">
            <h3 class="text-sm font-bold text-white mb-4">Ressources</h3>
            <div class="space-y-2">
              <button class="w-full flex items-center gap-3 p-3 rounded-xl bg-slate-800/30 border border-slate-800 hover:border-brandCyber/30 hover:bg-slate-800/50 transition text-left">
                <div class="w-8 h-8 rounded-lg bg-red-400/10 border border-red-400/20 flex items-center justify-center flex-shrink-0">
                  <FileText class="w-4 h-4 text-red-400" />
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-xs font-semibold text-slate-200">Fiche du chapitre</p>
                  <p class="text-[10px] text-slate-500">PDF • 1.2 MB</p>
                </div>
                <Download class="w-4 h-4 text-slate-500" />
              </button>
              <button class="w-full flex items-center gap-3 p-3 rounded-xl bg-slate-800/30 border border-slate-800 hover:border-brandCyber/30 hover:bg-slate-800/50 transition text-left">
                <div class="w-8 h-8 rounded-lg bg-brandCyber/10 border border-brandCyber/20 flex items-center justify-center flex-shrink-0">
                  <Code2 class="w-4 h-4 text-brandCyber" />
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-xs font-semibold text-slate-200">Exemples de code</p>
                  <p class="text-[10px] text-slate-500">Fichier .py</p>
                </div>
                <Download class="w-4 h-4 text-slate-500" />
              </button>
            </div>
          </div>

          <!-- Astuce -->
          <div class="bg-gradient-to-br from-brandCyber/10 to-transparent border border-brandCyber/20 rounded-2xl p-5">
            <div class="flex items-start gap-3">
              <div class="w-9 h-9 rounded-lg bg-brandCyber/15 border border-brandCyber/30 flex items-center justify-center flex-shrink-0">
                <Lightbulb class="w-4 h-4 text-brandCyber" />
              </div>
              <div>
                <p class="text-xs font-bold text-brandCyber mb-1">Astuce</p>
                <p class="text-[11px] text-slate-400 leading-relaxed">
                  Prends des notes en regardant chaque leçon. Ça t'aidera pour la révision !
                </p>
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
  Check, ListChecks, Trophy, Circle, Lock, Zap, Target,
  FileText, Download, Code2, Lightbulb
} from 'lucide-vue-next'

const route = useRoute()
const router = useRouter()
const user = ref(JSON.parse(localStorage.getItem('user') || '{}'))
const userInitial = computed(() => user.value?.name?.charAt(0).toUpperCase() || 'U')

// ─── State ────────────────────────────────────
const loading = ref(true)
const saving = ref(false)

const course = ref({
  id: route.params.id,
  title: 'Chargement...',
  progress: 0,
})

const chapter = ref({
  id: route.params.chapterId,
  number: 1,
  title: '',
  description: '',
  duration: 0,
  xp: 0,
  category: '',
  categoryColor: '',
  objectives: [],
  lessons: [],
  progress: 0,
})

// ─── Computed ─────────────────────────────────
const completedLessons = computed(() =>
  chapter.value.lessons.filter(l => l.status === 'completed').length
)

const chapterProgress = computed(() => {
  if (!chapter.value.lessons.length) return chapter.value.progress || 0
  return Math.round((completedLessons.value / chapter.value.lessons.length) * 100)
})

// ─── Load ─────────────────────────────────────
const loadChapter = async () => {
  loading.value = true
  try {
    const { data } = await api.get(`/courses/${route.params.id}`)
    if (!data.success) throw new Error('Cours introuvable')

    const c = data.course

    // Remplir le cours
    course.value = {
      id: c.id,
      title: c.title,
      progress: c.progress ?? 0,
    }

    // Générer les leçons selon les données du cours
    const lessons = generateLessons(c)

    // Remplir le chapitre (= le cours dans ton modèle actuel)
    chapter.value = {
      id: c.id,
      number: c.number,
      title: c.title,
      description: c.description,
      duration: c.duration ?? 0,
      xp: c.xp_reward ?? 100,
      category: c.category || '',
      categoryColor: c.category_color || 'text-brandCyber',
      progress: c.progress ?? 0,
      objectives: [
        `Comprendre les bases de : ${c.title}`,
        `Maîtriser les concepts clés du chapitre ${c.number}`,
        `Appliquer avec des exercices pratiques`,
        `Se préparer efficacement pour le Bac`,
      ],
      lessons: lessons,
    }
  } catch (error) {
    console.error('Erreur chargement chapitre:', error)
    router.push('/courses')
  } finally {
    loading.value = false
  }
}

// ─── Génération des leçons (temporaire) ───────
const generateLessons = (c) => {
  const count = c.lessons || 4
  const totalDuration = c.duration || 30
  const lessonTitles = [
    'Introduction',
    'Concepts clés',
    'Pratique guidée',
    'Approfondissement',
    'Exercices d\'application',
    'Cas concrets',
    'Synthèse',
    'Projet pratique',
  ]

  const lessons = []
  const perLessonDuration = Math.round(totalDuration / count)

  for (let i = 1; i <= count; i++) {
    // Déterminer le statut selon la progression globale
    const progressRatio = (c.progress || 0) / 100
    const lessonStartRatio = (i - 1) / count
    const lessonEndRatio = i / count

    let status = 'locked'
    if (progressRatio >= lessonEndRatio) {
      status = 'completed'
    } else if (progressRatio >= lessonStartRatio) {
      status = 'in_progress'
    }

    lessons.push({
      id: i,
      title: `${lessonTitles[(i - 1) % lessonTitles.length]}`,
      description: `Leçon ${i} du chapitre : ${lessonTitles[(i - 1) % lessonTitles.length].toLowerCase()}`,
      duration: perLessonDuration,
      status: status,
    })
  }

  return lessons
}

// ─── Helpers UI ───────────────────────────────
const getLessonStatusClass = (status) => {
  return {
    completed: 'bg-brandMint/10 border-brandMint/30 text-brandMint',
    in_progress: 'bg-brandCyber/10 border-brandCyber/30 text-brandCyber',
    locked: 'bg-slate-800/60 border-slate-700 text-slate-600',
  }[status] || 'bg-slate-800/60 border-slate-700 text-slate-600'
}

const getLessonIcon = (status) => {
  return {
    completed: CheckCircle2,
    in_progress: PlayCircle,
    locked: Lock,
  }[status] || Circle
}

// ─── Actions ──────────────────────────────────
const openLesson = (lesson, index) => {
  if (lesson.status === 'locked') {
    alert(`🔒 Cette leçon est verrouillée.\n\nTermine la leçon précédente pour la débloquer.`)
    return
  }
  console.log('Ouvrir leçon :', lesson.title)
  // TODO: router.push(`/courses/${route.params.id}/chapters/${route.params.chapterId}/lessons/${lesson.id}`)
}

const goToCourse = () => {
  router.push(`/courses/${route.params.id}`)
}

const markChapterComplete = async () => {
  if (saving.value) return

  saving.value = true
  try {
    const { data } = await api.put(`/courses/${route.params.id}/progress`, {
      progress: 100,
    })

    if (data.success) {
      // Mettre à jour localement
      chapter.value.progress = 100
      course.value.progress = 100

      // Petit feedback
      setTimeout(() => {
        router.push(`/courses/${route.params.id}`)
      }, 800)
    }
  } catch (error) {
    console.error('Erreur sauvegarde progression:', error)
    alert('Impossible de sauvegarder. Réessaie plus tard.')
  } finally {
    saving.value = false
  }
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

  await loadChapter()
})

// ─── Logout ───────────────────────────────────
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