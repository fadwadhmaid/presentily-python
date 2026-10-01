<template>
  <div class="min-h-screen bg-[#0a0a0f] text-white">
    <div class="fixed top-[-10%] left-[-5%] w-[45vw] max-w-[500px] h-[500px] bg-brandCyber/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="fixed bottom-[10%] right-[-5%] w-[45vw] max-w-[500px] h-[500px] bg-brandMint/5 rounded-full blur-[150px] pointer-events-none"></div>

    <!-- SIDEBAR -->
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

      <!-- Section actuelle -->
      <div class="mx-4 mb-4 p-4 rounded-xl border transition"
           :class="section === 'informatique'
             ? 'bg-brandCyber/10 border-brandCyber/20'
             : 'bg-brandMint/10 border-brandMint/20'">
        <div class="flex items-start gap-3">
          <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 border"
               :class="section === 'informatique'
                 ? 'bg-brandCyber/15 border-brandCyber/30'
                 : 'bg-brandMint/15 border-brandMint/30'">
            <component :is="section === 'informatique' ? Code2 : FlaskConical"
                       class="w-4 h-4"
                       :class="section === 'informatique' ? 'text-brandCyber' : 'text-brandMint'" />
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Ta section</p>
            <p class="text-xs font-bold truncate"
               :class="section === 'informatique' ? 'text-brandCyber' : 'text-brandMint'">
              {{ sectionLabel }}
            </p>
            <button @click="openSectionModal" class="text-[10px] text-slate-400 hover:text-white mt-1 underline">
              Changer
            </button>
          </div>
        </div>
      </div>

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
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-slate-400 hover:text-white p-2">
              <Menu class="w-6 h-6" />
            </button>
            <div>
              <h1 class="text-lg sm:text-xl font-bold text-white">Mes cours</h1>
              <p class="text-xs text-slate-500 hidden sm:block">
                Programme {{ section === 'informatique' ? 'Bac Informatique' : 'Bac Scientifique' }}
              </p>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <button class="relative p-2 text-slate-400 hover:text-white hover:bg-slate-800/50 rounded-lg transition">
              <Bell class="w-5 h-5" />
              <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-[#0a0a0f]"></span>
            </button>
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brandCyber to-amber-500 flex items-center justify-center text-slate-950 font-bold text-sm">
              {{ userInitial }}
            </div>
          </div>
        </div>
      </header>

      <div class="p-4 sm:p-6 lg:p-8 space-y-6">
        <!-- HERO -->
        <div class="relative overflow-hidden rounded-2xl border p-5 sm:p-6 lg:p-8 transition"
             :class="section === 'informatique'
               ? 'bg-gradient-to-br from-brandCyber/10 via-transparent to-brandMint/5 border-brandCyber/20'
               : 'bg-gradient-to-br from-brandMint/10 via-transparent to-brandCyber/5 border-brandMint/20'">
          <div class="absolute top-0 right-0 w-64 h-64 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"
               :class="section === 'informatique' ? 'bg-brandCyber/10' : 'bg-brandMint/10'"></div>
          <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
              <p class="text-xs font-bold uppercase tracking-wider mb-2 flex items-center gap-2"
                 :class="section === 'informatique' ? 'text-brandCyber' : 'text-brandMint'">
                <Sparkles class="w-3.5 h-3.5" />
                Programme officiel — {{ sectionLabel }}
              </p>
              <h2 class="text-2xl sm:text-3xl font-extrabold text-white flex items-center gap-3">
                Python {{ section === 'informatique' ? 'Bac Informatique' : 'Bac Scientifique' }}
              </h2>
              <p class="text-sm text-slate-400 mt-2 max-w-lg">
                {{ section === 'informatique'
                  ? 'Maîtrise l\'intégralité du programme Sciences de l\'Informatique : algorithmes avancés, structures de données et préparation Bac.'
                  : 'Programme essentiel pour les sections scientifiques : Python appliqué aux mathématiques, algorithmes fondamentaux et préparation Bac.' }}
              </p>
            </div>
            <div class="flex items-center gap-3">
              <div class="bg-[#0a0a12]/80 border rounded-xl px-4 py-3 text-center"
                   :class="section === 'informatique' ? 'border-brandCyber/20' : 'border-brandMint/20'">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Chapitres</p>
                <p class="text-2xl font-extrabold"
                   :class="section === 'informatique' ? 'text-brandCyber' : 'text-brandMint'">
                  {{ chapters.length }}
                </p>
              </div>
              <div class="bg-[#0a0a12]/80 border border-slate-800 rounded-xl px-4 py-3 text-center">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Progression</p>
                <p class="text-2xl font-extrabold text-white">{{ overallProgress }}%</p>
              </div>
            </div>
          </div>

          <div class="mt-6 max-w-2xl">
            <div class="flex items-center justify-between mb-2">
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Progression globale</span>
              <span class="text-[11px] font-bold"
                    :class="section === 'informatique' ? 'text-brandCyber' : 'text-brandMint'">
                {{ completedCount }}/{{ chapters.length }} chapitres
              </span>
            </div>
            <div class="w-full bg-slate-900/60 rounded-full h-2 overflow-hidden">
              <div class="h-full rounded-full transition-all duration-1000"
                   :class="section === 'informatique'
                     ? 'bg-gradient-to-r from-brandCyber to-amber-500'
                     : 'bg-gradient-to-r from-brandMint to-emerald-400'"
                   :style="{ width: overallProgress + '%' }"></div>
            </div>
          </div>
        </div>

        <!-- Barre de recherche + filtres -->
        <div class="flex flex-col sm:flex-row gap-3 sm:items-center">
          <div class="relative flex-1">
            <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500" />
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Rechercher un chapitre..."
              class="w-full pl-10 pr-4 py-2.5 bg-[#0f0f1a]/80 border border-slate-800 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brandCyber/40 transition"
            />
          </div>

          <div class="flex gap-2 overflow-x-auto pb-1">
            <button
              v-for="filter in filters"
              :key="filter.value"
              @click="activeFilter = filter.value"
              class="px-4 py-2.5 rounded-xl text-xs font-semibold whitespace-nowrap transition border"
              :class="activeFilter === filter.value
                ? (section === 'informatique'
                    ? 'bg-brandCyber/10 text-brandCyber border-brandCyber/30'
                    : 'bg-brandMint/10 text-brandMint border-brandMint/30')
                : 'bg-[#0f0f1a]/80 text-slate-400 border-slate-800 hover:text-white'"
            >
              {{ filter.label }}
            </button>
          </div>
        </div>

        <!-- Statistiques rapides -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
          <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-xl p-4">
            <div class="flex items-center gap-3">
              <div class="w-9 h-9 rounded-lg flex items-center justify-center border"
                   :class="section === 'informatique' ? 'bg-brandCyber/10 border-brandCyber/20' : 'bg-brandMint/10 border-brandMint/20'">
                <BookOpen class="w-4 h-4"
                          :class="section === 'informatique' ? 'text-brandCyber' : 'text-brandMint'" />
              </div>
              <div>
                <p class="text-[10px] text-slate-500 font-medium uppercase tracking-wider">Total</p>
                <p class="text-lg font-extrabold text-white">{{ chapters.length }}</p>
              </div>
            </div>
          </div>
          <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-xl p-4">
            <div class="flex items-center gap-3">
              <div class="w-9 h-9 bg-brandMint/10 border border-brandMint/20 rounded-lg flex items-center justify-center">
                <CheckCircle2 class="w-4 h-4 text-brandMint" />
              </div>
              <div>
                <p class="text-[10px] text-slate-500 font-medium uppercase tracking-wider">Terminés</p>
                <p class="text-lg font-extrabold text-white">{{ completedCount }}</p>
              </div>
            </div>
          </div>
          <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-xl p-4">
            <div class="flex items-center gap-3">
              <div class="w-9 h-9 bg-orange-400/10 border border-orange-400/20 rounded-lg flex items-center justify-center">
                <PlayCircle class="w-4 h-4 text-orange-400" />
              </div>
              <div>
                <p class="text-[10px] text-slate-500 font-medium uppercase tracking-wider">En cours</p>
                <p class="text-lg font-extrabold text-white">{{ inProgressCount }}</p>
              </div>
            </div>
          </div>
          <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-xl p-4">
            <div class="flex items-center gap-3">
              <div class="w-9 h-9 bg-purple-400/10 border border-purple-400/20 rounded-lg flex items-center justify-center">
                <Clock class="w-4 h-4 text-purple-400" />
              </div>
              <div>
                <p class="text-[10px] text-slate-500 font-medium uppercase tracking-wider">Durée</p>
                <p class="text-lg font-extrabold text-white">{{ totalHours }}h</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Liste des chapitres -->
        <div v-if="filteredChapters.length > 0">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider">
              {{ getCategoryLabel(activeFilter) }} ({{ filteredChapters.length }})
            </h3>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            <router-link
              v-for="chapter in filteredChapters"
              :key="chapter.id"
              :to="`/courses/${chapter.id}`"
              class="group bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl overflow-hidden hover:-translate-y-1 transition-all duration-300"
              :class="section === 'informatique' ? 'hover:border-brandCyber/40' : 'hover:border-brandMint/40'"
            >
              <div class="relative p-5 pb-4" :class="chapter.bannerClass">
                <div class="flex items-start justify-between mb-3">
                  <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center font-extrabold text-lg border-2 transition"
                         :class="chapter.numberClass">
                      {{ String(chapter.number).padStart(2, '0') }}
                    </div>
                    <div>
                      <p class="text-[10px] font-bold uppercase tracking-wider" :class="chapter.categoryColor">
                        {{ chapter.category }}
                      </p>
                      <p class="text-[10px] text-slate-500 font-medium">Chapitre {{ String(chapter.number).padStart(2, '0') }}</p>
                    </div>
                  </div>

                  <div>
                    <span v-if="chapter.status === 'completed'"
                          class="text-[10px] font-bold text-brandMint bg-brandMint/20 border border-brandMint/40 px-2 py-1 rounded-lg flex items-center gap-1">
                      <CheckCircle2 class="w-3 h-3" />
                      Fait
                    </span>
                    <span v-else-if="chapter.status === 'in_progress'"
                          class="text-[10px] font-bold text-orange-400 bg-orange-400/20 border border-orange-400/40 px-2 py-1 rounded-lg flex items-center gap-1">
                      <PlayCircle class="w-3 h-3" />
                      En cours
                    </span>
                    <span v-else-if="chapter.status === 'locked'"
                          class="text-[10px] font-bold text-slate-500 bg-slate-800/60 border border-slate-700 px-2 py-1 rounded-lg flex items-center gap-1">
                      <Lock class="w-3 h-3" />
                    </span>
                  </div>
                </div>

                <h3 class="text-base font-bold text-white transition leading-tight"
                    :class="section === 'informatique' ? 'group-hover:text-brandCyber' : 'group-hover:text-brandMint'">
                  {{ chapter.title }}
                </h3>
              </div>

              <div class="p-5 pt-0">
                <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 min-h-[2rem]">
                  {{ chapter.description }}
                </p>

                <div class="mt-4">
                  <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Progression</span>
                    <span class="text-[10px] font-bold"
                          :class="chapter.progress > 0
                            ? (section === 'informatique' ? 'text-brandCyber' : 'text-brandMint')
                            : 'text-slate-600'">
                      {{ chapter.progress }}%
                    </span>
                  </div>
                  <div class="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-1000"
                         :class="section === 'informatique'
                           ? 'bg-gradient-to-r from-brandCyber to-amber-500'
                           : 'bg-gradient-to-r from-brandMint to-emerald-400'"
                         :style="{ width: chapter.progress + '%' }"></div>
                  </div>
                </div>

                <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-800/60">
                  <div class="flex items-center gap-3 text-[10px] text-slate-500">
                    <span class="flex items-center gap-1">
                      <Clock class="w-3 h-3" />
                      {{ chapter.duration }} min
                    </span>
                    <span class="flex items-center gap-1">
                      <Layers class="w-3 h-3" />
                      {{ chapter.lessons }} leçons
                    </span>
                  </div>
                  <ArrowRight class="w-4 h-4 text-slate-500 group-hover:translate-x-1 transition"
                              :class="section === 'informatique' ? 'group-hover:text-brandCyber' : 'group-hover:text-brandMint'" />
                </div>
              </div>
            </router-link>
          </div>
        </div>

        <div v-else class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-12 text-center">
          <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-800/60 border border-slate-700 flex items-center justify-center mb-4">
            <SearchX class="w-8 h-8 text-slate-600" />
          </div>
          <h3 class="text-base font-bold text-white mb-1">Aucun chapitre trouvé</h3>
          <p class="text-sm text-slate-500">Essaie un autre mot-clé ou change de filtre</p>
        </div>
      </div>
    </main>

    <!-- Modal de sélection de section -->
    <SectionModal
      :visible="sectionModalVisible"
      :is-mandatory="!hasSection"
      @close="sectionModalVisible = false"
      @select="handleSectionSelect"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '../plugins/axios'
import { useSection } from '../composables/useSection'
import SectionModal from './SectionModal.vue'
import {
  LayoutDashboard, BookOpen, ClipboardList, Award, BarChart3,
  Lightbulb, Bell, LogOut, Menu, Search, SearchX, Clock,
  CheckCircle2, PlayCircle, Lock, ArrowRight, Sparkles, Layers,
  Code2, FlaskConical
} from 'lucide-vue-next'

const router = useRouter()
const route = useRoute()
const mobileMenuOpen = ref(false)
const user = ref(JSON.parse(localStorage.getItem('user') || '{}'))
const userInitial = computed(() => user.value?.name?.charAt(0).toUpperCase() || 'U')

// ─── Section (composable) ─────────────────────
const { section, setSection, hasSection, sectionLabel } = useSection()
const sectionModalVisible = ref(false)

// ─── Données depuis l'API ─────────────────────
const chapters = ref([])
const loading = ref(false)

// ─── Filtres ──────────────────────────────────
const searchQuery = ref('')
const activeFilter = ref('all')

const filters = [
  { label: 'Tous', value: 'all' },
  { label: 'Non commencés', value: 'not_started' },
  { label: 'En cours', value: 'in_progress' },
  { label: 'Terminés', value: 'completed' },
]

const getCategoryLabel = (filter) => {
  return {
    all: 'Tous les chapitres',
    not_started: 'Chapitres à commencer',
    in_progress: 'Chapitres en cours',
    completed: 'Chapitres terminés',
  }[filter] || 'Chapitres'
}

// ─── Charger les cours depuis l'API ───────────
const loadCourses = async () => {
  if (!section.value) return

  loading.value = true
  try {
    const response = await api.get('/courses', {
      params: { section: section.value }
    })

    if (response.data.success) {
      chapters.value = response.data.courses.map(course => ({
        ...course,
        bannerClass: section.value === 'informatique'
          ? 'bg-gradient-to-br from-brandCyber/10 to-transparent'
          : 'bg-gradient-to-br from-brandMint/10 to-transparent',
        numberClass: section.value === 'informatique'
          ? 'bg-brandCyber/20 border-brandCyber/40 text-brandCyber'
          : 'bg-brandMint/20 border-brandMint/40 text-brandMint',
      }))
    }
  } catch (error) {
    console.error('Erreur chargement cours:', error)
    chapters.value = []
  } finally {
    loading.value = false
  }
}

// ═══════════════════════════════════════════════════════════
// ✅ SOLUTION 1 : Rechargement automatique des cours
// ═══════════════════════════════════════════════════════════

// ✅ 1. Recharge quand la page redevient visible (retour d'onglet)
const handleVisibilityChange = async () => {
  if (document.visibilityState === 'visible' && hasSection.value) {
    await loadCourses()
  }
}

// ✅ 2. Recharge quand on revient sur la route /courses
watch(
  () => route.path,
  async (newPath) => {
    if (newPath === '/courses' && hasSection.value) {
      await loadCourses()
    }
  }
)

// ─── Gérer le changement de section ───────────
const openSectionModal = () => {
  sectionModalVisible.value = true
}

const handleSectionSelect = async (selectedSection) => {
  setSection(selectedSection)
  sectionModalVisible.value = false

  try {
    await api.post('/user/section', { section_code: selectedSection })
  } catch (error) {
    console.error('Erreur sauvegarde section:', error)
  }

  await loadCourses()
}

watch(section, (newVal, oldVal) => {
  if (newVal && newVal !== oldVal) {
    loadCourses()
  }
})

// ─── Filtrage ─────────────────────────────────
const filteredChapters = computed(() => {
  return chapters.value.filter(chapter => {
    const matchSearch =
      chapter.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      chapter.description?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      String(chapter.number).padStart(2, '0').includes(searchQuery.value)

    const matchFilter = activeFilter.value === 'all' || chapter.status === activeFilter.value
    return matchSearch && matchFilter
  })
})

const completedCount = computed(() =>
  chapters.value.filter(c => c.status === 'completed').length
)
const inProgressCount = computed(() =>
  chapters.value.filter(c => c.status === 'in_progress').length
)
const totalHours = computed(() =>
  Math.round(chapters.value.reduce((sum, c) => sum + c.duration, 0) / 60)
)
const overallProgress = computed(() => {
  if (!chapters.value.length) return 0
  const total = chapters.value.reduce((sum, c) => sum + c.progress, 0)
  return Math.round(total / chapters.value.length)
})

// ─── Lifecycle ────────────────────────────────
onMounted(async () => {
  try {
    const response = await api.get('/me')
    if (response.data.success) {
      user.value = response.data.user
      localStorage.setItem('user', JSON.stringify(user.value))

      if (response.data.user.section && !hasSection.value) {
        setSection(response.data.user.section.code)
      }
    }
  } catch (error) {
    console.error('Erreur:', error)
  }

  if (!hasSection.value) {
    sectionModalVisible.value = true
  } else {
    await loadCourses()
  }

  // ✅ Ajouter les écouteurs
  document.addEventListener('visibilitychange', handleVisibilityChange)
})

onUnmounted(() => {
  // ✅ Nettoyer les écouteurs
  document.removeEventListener('visibilitychange', handleVisibilityChange)
})

// ─── Déconnexion ──────────────────────────────
const logout = async () => {
  try { await api.post('/logout') } catch (e) {}
  localStorage.removeItem('token')
  localStorage.removeItem('user')
  router.push('/')
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>