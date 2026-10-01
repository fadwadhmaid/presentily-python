<!-- resources/js/components/CoursePresentation.vue -->
<template>
  <div class="min-h-screen bg-[#0a0a0f] text-white">
    <div class="fixed top-[-10%] left-[-5%] w-[45vw] max-w-[500px] h-[500px] bg-brandCyber/5 rounded-full blur-[120px] pointer-events-none"></div>

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
            <router-link to="/courses" class="text-slate-400 hover:text-white p-2 transition">
              <ArrowLeft class="w-5 h-5" />
            </router-link>
            <div>
              <p class="text-[10px] text-slate-500 uppercase tracking-wider font-bold">Présentation</p>
              <h1 class="text-sm sm:text-base font-bold text-white truncate">{{ course.title }}</h1>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brandCyber to-amber-500 flex items-center justify-center text-slate-950 font-bold text-sm">
              {{ userInitial }}
            </div>
          </div>
        </div>
      </header>

      <div class="p-4 sm:p-6 lg:p-8 space-y-6">
        <!-- HERO : Bannière du cours -->
        <div class="relative overflow-hidden rounded-3xl border border-slate-800" :class="course.bannerClass">
          <div class="absolute top-0 right-0 w-96 h-96 bg-brandCyber/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>

          <div class="relative grid grid-cols-1 lg:grid-cols-3 gap-6 p-6 sm:p-8 lg:p-10">
            <!-- Colonne gauche : Infos -->
            <div class="lg:col-span-2">
              <div class="flex flex-wrap items-center gap-2 mb-4">
                <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-lg backdrop-blur-md border" :class="course.levelClass">
                  {{ course.level }}
                </span>
                <span class="text-[10px] font-bold text-slate-400 bg-slate-800/60 backdrop-blur-md px-2.5 py-1 rounded-lg flex items-center gap-1">
                  <BookOpen class="w-3 h-3" />
                  {{ course.chapters }} chapitres
                </span>
                <span class="text-[10px] font-bold text-slate-400 bg-slate-800/60 backdrop-blur-md px-2.5 py-1 rounded-lg flex items-center gap-1">
                  <Clock class="w-3 h-3" />
                  {{ course.hours }}h de contenu
                </span>
                <span class="text-[10px] font-bold text-brandMint bg-brandMint/20 backdrop-blur-md px-2.5 py-1 rounded-lg flex items-center gap-1">
                  <Zap class="w-3 h-3" />
                  +{{ course.xpReward }} XP
                </span>
              </div>

              <h2 class="text-3xl sm:text-4xl font-extrabold text-white leading-tight">{{ course.title }}</h2>
              <p class="text-sm sm:text-base text-slate-300 mt-4 max-w-2xl leading-relaxed">{{ course.description }}</p>

              <!-- Boutons -->
              <div class="flex flex-wrap items-center gap-3 mt-6">
                <button
                  @click="goToContent"
                  class="inline-flex items-center gap-2 bg-gradient-to-r from-brandCyber to-amber-400 text-slate-950 font-bold px-6 py-3.5 rounded-xl shadow-[0_0_20px_rgba(253,224,71,0.3)] hover:shadow-[0_0_35px_rgba(253,224,71,0.5)] hover:scale-[1.02] transition"
                >
                  <PlayCircle class="w-5 h-5" />
                  {{ course.progress > 0 ? 'Continuer le cours' : 'Commencer le cours' }}
                </button>
                <button class="inline-flex items-center gap-2 bg-slate-800/60 hover:bg-slate-800 text-white font-bold px-5 py-3.5 rounded-xl border border-slate-700/60 transition">
                  <Bookmark class="w-4 h-4" />
                  Enregistrer
                </button>
              </div>

              <!-- Stats rapides -->
              <div class="flex flex-wrap gap-4 mt-6 pt-6 border-t border-slate-800/60">
                <div class="flex items-center gap-2">
                  <div class="w-8 h-8 rounded-lg bg-brandMint/10 border border-brandMint/20 flex items-center justify-center">
                    <Users class="w-4 h-4 text-brandMint" />
                  </div>
                  <div>
                    <p class="text-[10px] text-slate-500 font-medium">Élèves inscrits</p>
                    <p class="text-xs font-bold text-white">1 248</p>
                  </div>
                </div>
                <div class="flex items-center gap-2">
                  <div class="w-8 h-8 rounded-lg bg-brandCyber/10 border border-brandCyber/20 flex items-center justify-center">
                    <Star class="w-4 h-4 text-brandCyber" />
                  </div>
                  <div>
                    <p class="text-[10px] text-slate-500 font-medium">Note moyenne</p>
                    <p class="text-xs font-bold text-white">4.8 / 5</p>
                  </div>
                </div>
                <div class="flex items-center gap-2">
                  <div class="w-8 h-8 rounded-lg bg-purple-400/10 border border-purple-400/20 flex items-center justify-center">
                    <Award class="w-4 h-4 text-purple-400" />
                  </div>
                  <div>
                    <p class="text-[10px] text-slate-500 font-medium">Certificat</p>
                    <p class="text-xs font-bold text-white">Oui</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Colonne droite : Aperçu / Preview -->
            <div class="lg:col-span-1">
              <div class="bg-[#0a0a12]/80 backdrop-blur-xl rounded-2xl border border-slate-800 overflow-hidden">
                <!-- Fake preview -->
                <div class="relative aspect-video bg-gradient-to-br from-brandCyber/20 to-transparent flex items-center justify-center">
                  <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-16 h-16 rounded-full bg-brandCyber/20 backdrop-blur-md border-2 border-brandCyber flex items-center justify-center hover:scale-110 transition cursor-pointer">
                      <PlayCircle class="w-8 h-8 text-brandCyber" />
                    </div>
                  </div>
                  <span class="absolute bottom-3 left-3 text-[10px] font-bold text-slate-400 bg-black/40 backdrop-blur-md px-2 py-1 rounded">
                    Aperçu 2 min
                  </span>
                </div>

                <div class="p-5">
                  <h4 class="text-sm font-bold text-white mb-3">Ce cours inclut :</h4>
                  <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-xs text-slate-400">
                      <CheckCircle2 class="w-3.5 h-3.5 text-brandMint flex-shrink-0" />
                      <span>{{ course.hours }}h de vidéo à la demande</span>
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-400">
                      <CheckCircle2 class="w-3.5 h-3.5 text-brandMint flex-shrink-0" />
                      <span>{{ course.chapters }} chapitres structurés</span>
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-400">
                      <CheckCircle2 class="w-3.5 h-3.5 text-brandMint flex-shrink-0" />
                      <span>Exercices pratiques corrigés</span>
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-400">
                      <CheckCircle2 class="w-3.5 h-3.5 text-brandMint flex-shrink-0" />
                      <span>Fiches de révision téléchargeables</span>
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-400">
                      <CheckCircle2 class="w-3.5 h-3.5 text-brandMint flex-shrink-0" />
                      <span>Accès à vie sur mobile et desktop</span>
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-400">
                      <CheckCircle2 class="w-3.5 h-3.5 text-brandMint flex-shrink-0" />
                      <span>Certificat de réussite</span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- CONTENU DE PRÉSENTATION -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Colonne gauche (2/3) -->
          <div class="lg:col-span-2 space-y-6">
            <!-- Ce que tu vas apprendre -->
            <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-6">
              <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
                <Sparkles class="w-4 h-4 text-brandCyber" />
                Ce que tu vas apprendre
              </h3>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div v-for="(item, i) in course.objectives" :key="i" class="flex items-start gap-3 p-3 rounded-xl bg-slate-800/30 border border-slate-800">
                  <div class="w-5 h-5 rounded-full bg-brandMint/20 border border-brandMint/30 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <Check class="w-3 h-3 text-brandMint" />
                  </div>
                  <span class="text-xs text-slate-300 leading-relaxed">{{ item }}</span>
                </div>
              </div>
            </div>


          </div>

          <!-- Colonne droite -->
          <div class="lg:col-span-1 space-y-6">
           

            <!-- Instructeur -->
            <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-6">
              <h3 class="text-sm font-bold text-white mb-4">Instructeur</h3>
              <div class="flex items-center gap-3 mb-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-brandCyber to-amber-500 flex items-center justify-center text-slate-950 font-bold text-lg">
                  P
                </div>
                <div>
                  <p class="text-sm font-bold text-white">Équipe Presentily</p>
                  <p class="text-[10px] text-slate-500">Experts en programmation</p>
                </div>
              </div>
              <p class="text-xs text-slate-400 leading-relaxed">
                Une équipe de développeurs et professeurs passionnés qui enseignent Python aux lycéens tunisiens depuis 2023.
              </p>
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
  Check, Sparkles, ListChecks, Trophy, Lock, Circle, Zap,
  Bookmark, Users, Star, Info
} from 'lucide-vue-next'

const route = useRoute()
const router = useRouter()
const user = ref(JSON.parse(localStorage.getItem('user') || '{}'))
const userInitial = computed(() => user.value?.name?.charAt(0).toUpperCase() || 'U')

const course = ref({
  id: route.params.id,
  title: 'Python pour débutants',
  description: 'Apprends les bases de Python : variables, boucles, fonctions et structures de données. Un cours conçu pour les élèves du lycée qui veulent maîtriser la programmation.',
  level: 'Débutant',
  levelClass: 'text-brandCyber bg-brandCyber/20 border-brandCyber/40',
  bannerClass: 'bg-gradient-to-br from-brandCyber/15 via-brandCyber/5 to-transparent',
  progress: 75,
  chapters: 12,
  hours: 8,
  xpReward: 500,
  objectives: [
    'Comprendre les variables et types de données',
    'Maîtriser les boucles et conditions',
    'Créer des fonctions réutilisables',
    'Manipuler des listes et dictionnaires',
    'Gérer les fichiers et erreurs',
    'Résoudre des problèmes concrets',
  ],
  chaptersList: [
    { id: 1, title: 'Introduction à Python', description: 'Découvre Python et installe ton environnement', duration: 15, status: 'completed' },
    { id: 2, title: 'Variables et types', description: 'Strings, nombres, booléens et conversion', duration: 25, status: 'completed' },
    { id: 3, title: 'Opérateurs', description: 'Arithmétiques, comparaison et logiques', duration: 20, status: 'completed' },
    { id: 4, title: 'Les Boucles & Répétitions', description: 'For, while et contrôle de flux', duration: 35, status: 'in_progress', isNew: true },
    { id: 5, title: 'Fonctions', description: 'Définir, appeler et retourner des valeurs', duration: 30, status: 'locked' },
    { id: 6, title: 'Listes et tuples', description: 'Collections ordonnées en Python', duration: 28, status: 'locked' },
    { id: 7, title: 'Dictionnaires', description: 'Structures clé-valeur puissantes', duration: 25, status: 'locked' },
    { id: 8, title: 'Chaînes de caractères', description: 'Manipulation avancée du texte', duration: 22, status: 'locked' },
    { id: 9, title: 'Fichiers', description: 'Lire et écrire dans des fichiers', duration: 20, status: 'locked' },
    { id: 10, title: 'Gestion des erreurs', description: 'Try, except et debug', duration: 18, status: 'locked' },
    { id: 11, title: 'Modules et packages', description: 'Organiser ton code', duration: 25, status: 'locked' },
    { id: 12, title: 'Projet final', description: 'Crée ton application complète', duration: 45, status: 'locked' },
  ],
})

const getChapterStatusClass = (status) => {
  return {
    completed: 'bg-brandMint/10 border-brandMint/30 text-brandMint',
    in_progress: 'bg-brandCyber/10 border-brandCyber/30 text-brandCyber',
    locked: 'bg-slate-800/60 border-slate-700 text-slate-600',
  }[status] || 'bg-slate-800/60 border-slate-700 text-slate-600'
}

const getChapterIcon = (status) => {
  return {
    completed: CheckCircle2,
    in_progress: PlayCircle,
    locked: Lock,
  }[status] || Circle
}

const goToContent = () => {
  // ✅ Va vers la leçon interactive (fichiers JS avec cartes)
  router.push(`/courses/${route.params.id}/lesson`)
}

onMounted(async () => {
  try {
    const response = await api.get('/me')
    if (response.data.success) {
      user.value = response.data.user
    }
    // TODO: charger depuis l'API
    // const courseResponse = await api.get(`/courses/${route.params.id}`)
    // course.value = courseResponse.data
  } catch (error) {
    console.error('Erreur:', error)
  }
})

const logout = async () => {
  try { await api.post('/logout') } catch (e) {}
  localStorage.removeItem('token')
  localStorage.removeItem('user')
  router.push('/')
}
</script>