<template>
  <div class="min-h-screen bg-[#0a0a0f] text-white">
    <!-- Effets de lueur -->
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

        <router-link to="/dashboard" class="group flex items-center gap-3 px-4 py-2.5 rounded-xl bg-brandCyber/10 text-brandCyber border border-brandCyber/20 transition">
          <LayoutDashboard class="w-5 h-5" />
          <span class="font-semibold text-sm">Tableau de bord</span>
        </router-link>

        <router-link to="/courses" class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition">
          <BookOpen class="w-5 h-5" />
          <span class="font-medium text-sm">Mes cours</span>
          <span v-if="completedCourses > 0" class="ml-auto text-[10px] bg-slate-800 text-slate-400 px-2 py-0.5 rounded-full">
            {{ completedCourses }}/{{ totalCourses }}
          </span>
        </router-link>

        <router-link to="/exercises" class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition">
          <ClipboardList class="w-5 h-5" />
          <span class="font-medium text-sm">Exercices</span>
        </router-link>

        <p class="text-[10px] font-bold text-slate-600 uppercase tracking-wider px-4 mt-6 mb-3">Progression</p>

        <router-link to="/badges" class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition">
          <Award class="w-5 h-5" />
          <span class="font-medium text-sm">Badges</span>
          <span v-if="userBadges.length" class="ml-auto text-[10px] bg-brandCyber/20 text-brandCyber px-2 py-0.5 rounded-full">
            {{ userBadges.length }}
          </span>
        </router-link>

        <router-link to="/leaderboard" class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition">
          <BarChart3 class="w-5 h-5" />
          <span class="font-medium text-sm">Classement</span>
        </router-link>
        <p class="text-[10px] font-bold text-slate-600 uppercase tracking-wider px-4 mt-6 mb-3">Support</p>

<router-link to="/messages" class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition">
  <MessageSquare class="w-5 h-5" />
  <span class="font-medium text-sm">Mes messages</span>
  <span v-if="unreadMessages > 0" class="ml-auto text-[10px] bg-red-500/20 text-red-400 px-2 py-0.5 rounded-full">
    {{ unreadMessages }}
  </span>
</router-link>
      </nav>

      <!-- Astuce du jour -->
      <div class="mx-4 mb-4 p-4 bg-gradient-to-br from-brandCyber/10 to-amber-500/5 border border-brandCyber/20 rounded-xl">
        <div class="flex items-start gap-3">
          <div class="w-8 h-8 rounded-lg bg-brandCyber/15 border border-brandCyber/30 flex items-center justify-center flex-shrink-0">
            <Lightbulb class="w-4 h-4 text-brandCyber" />
          </div>
          <div>
            <p class="text-xs font-bold text-brandCyber mb-1">Astuce du jour</p>
            <p class="text-[11px] text-slate-400 leading-relaxed">Pratique 15 min par jour pour garder ta série active !</p>
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

    <!-- CONTENU PRINCIPAL -->
    <main class="md:ml-64 relative z-10">
      <!-- Header -->
      <header class="sticky top-0 z-20 bg-[#0a0a0f]/80 backdrop-blur-xl border-b border-slate-800/60 px-4 sm:px-6 py-4">
        <div class="flex items-center justify-between gap-4">
          <div class="flex items-center gap-3">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-slate-400 hover:text-white p-2">
              <Menu class="w-6 h-6" />
            </button>
            <div>
              <h1 class="text-lg sm:text-xl font-bold text-white">Tableau de bord</h1>
              <p class="text-xs text-slate-500 hidden sm:block">Bienvenue dans ton espace d'apprentissage</p>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <button class="relative p-2 text-slate-400 hover:text-white hover:bg-slate-800/50 rounded-lg transition">
              <Bell class="w-5 h-5" />
            </button>
            <button class="flex items-center gap-3 pl-2 pr-3 py-1.5 rounded-xl hover:bg-slate-800/50 transition">
              <div class="relative">
                <div class="w-9 h-9 rounded-full overflow-hidden">
                  <UserAvatar :config="avatarConfig" :size="36" />
                </div>
                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-brandMint rounded-full border-2 border-[#0a0a0f]"></div>
              </div>
              <div class="hidden sm:block text-left">
                <p class="text-sm font-semibold text-white leading-tight">{{ user.name || 'Élève' }}</p>
                <p class="text-[10px] text-slate-500">Niveau {{ userLevel }}</p>
              </div>
            </button>
          </div>
        </div>
      </header>

      <!-- Loader -->
      <div v-if="loading" class="p-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
          <div v-for="i in 4" :key="i" class="h-32 bg-slate-800/40 rounded-2xl animate-pulse"></div>
        </div>
      </div>

      <!-- CONTENU -->
      <div v-else class="p-4 sm:p-6 lg:p-8 space-y-6">

        <!-- HERO DE BIENVENUE -->
        <div class="relative overflow-hidden bg-gradient-to-br from-brandCyber/10 via-transparent to-brandMint/5 border border-brandCyber/20 rounded-2xl p-5 sm:p-6 lg:p-8">
          <div class="absolute top-0 right-0 w-64 h-64 bg-brandCyber/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
          <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
              <p class="text-xs font-bold text-brandCyber uppercase tracking-wider mb-2 flex items-center gap-2">
                <Sparkles class="w-3.5 h-3.5" />
                Bienvenue
              </p>
              <h2 class="text-2xl sm:text-3xl font-extrabold text-white">
                Bonjour, {{ user.name || 'Élève' }} !
              </h2>
              <p class="text-sm text-slate-400 mt-2 max-w-lg">
                Tu es à <span class="text-brandCyber font-bold">{{ xpProgress }}%</span> du niveau suivant.
                <span v-if="xpRemaining > 0">Encore <span class="text-brandMint font-bold">{{ xpRemaining }} XP</span> pour monter !</span>
                <span v-else>Continue comme ça, tu progresses super bien !</span>
              </p>
            </div>
            <div class="flex items-center gap-3">
              <div class="bg-[#0a0a12]/80 border border-brandCyber/20 rounded-xl px-4 py-3 text-center">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Niveau</p>
                <p class="text-2xl font-extrabold text-brandCyber">{{ userLevel }}</p>
              </div>
              <div class="bg-[#0a0a12]/80 border border-brandMint/20 rounded-xl px-4 py-3 text-center">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">XP</p>
                <p class="text-2xl font-extrabold text-brandMint">{{ user.total_xp || 0 }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- STATISTIQUES -->
        <div>
          <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-3">Tes statistiques</h3>
          <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">

            <!-- XP Total -->
            <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-4 sm:p-5 hover:border-brandCyber/30 transition">
              <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-brandCyber/10 border border-brandCyber/20 rounded-xl flex items-center justify-center">
                  <Zap class="w-5 h-5 text-brandCyber" />
                </div>
                <span v-if="xpRemaining > 0" class="text-[10px] font-bold text-brandMint bg-brandMint/10 px-2 py-0.5 rounded-full">
                  +{{ xpRemaining }} pour niv. {{ userLevel + 1 }}
                </span>
              </div>
              <p class="text-xs text-slate-500 font-medium">XP Total</p>
              <p class="text-2xl font-extrabold text-white mt-1">{{ user.total_xp || 0 }}</p>
              <div class="mt-3 w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
                <div class="bg-gradient-to-r from-brandCyber to-amber-500 h-full rounded-full transition-all duration-1000"
                     :style="{ width: xpProgress + '%' }"></div>
              </div>
            </div>

            <!-- Niveau -->
            <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-4 sm:p-5 hover:border-purple-400/30 transition">
              <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-purple-400/10 border border-purple-400/20 rounded-xl flex items-center justify-center">
                  <TrendingUp class="w-5 h-5 text-purple-400" />
                </div>
              </div>
              <p class="text-xs text-slate-500 font-medium">Niveau</p>
              <p class="text-2xl font-extrabold text-white mt-1">{{ userLevel }}</p>
              <p class="text-[10px] text-slate-500 mt-3">sur 100 niveaux</p>
            </div>

            <!-- Série -->
            <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-4 sm:p-5 hover:border-orange-400/30 transition">
              <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-orange-400/10 border border-orange-400/20 rounded-xl flex items-center justify-center">
                  <Flame class="w-5 h-5 text-orange-400" />
                </div>
              </div>
              <p class="text-xs text-slate-500 font-medium">Série active</p>
              <p class="text-2xl font-extrabold text-white mt-1">
                {{ user.streak_days || 0 }} <span class="text-sm font-medium text-slate-500">jours</span>
              </p>
             <p class="text-[10px] text-orange-400 mt-3 font-medium">
  {{ streakMessage }}
</p>
            </div>

            <!-- Badges -->
            <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-4 sm:p-5 hover:border-brandMint/30 transition">
              <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-brandMint/10 border border-brandMint/20 rounded-xl flex items-center justify-center">
                  <Award class="w-5 h-5 text-brandMint" />
                </div>
              </div>
              <p class="text-xs text-slate-500 font-medium">Badges gagnés</p>
              <p class="text-2xl font-extrabold text-white mt-1">{{ userBadges.length }}</p>
              <p class="text-[10px] text-slate-500 mt-3">{{ lockedBadgesCount }} à découvrir</p>
            </div>
          </div>
        </div>

        <!-- REPRENDRE L'APPRENTISSAGE -->
        <div v-if="nextChapter">
          <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-3">Reprendre l'apprentissage</h3>
          <div class="bg-gradient-to-r from-[#0f0f1a] to-[#0f0f1a]/60 border border-slate-800 hover:border-brandCyber/40 rounded-2xl p-5 sm:p-6 transition">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
              <div class="flex items-center gap-4 flex-1">
                <div class="w-14 h-14 bg-brandCyber/10 border border-brandCyber/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                  <Code2 class="w-7 h-7 text-brandCyber" />
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-[10px] font-bold text-brandCyber uppercase tracking-wider">
                    {{ nextChapter.progress > 0 ? 'Chapitre en cours' : 'Prochain chapitre' }}
                  </p>
                  <h4 class="text-base sm:text-lg font-bold text-white mt-0.5 truncate">
                    {{ nextChapter.title }}
                  </h4>
                  <div class="flex items-center gap-3 mt-2">
                    <div class="flex-1 max-w-xs bg-slate-800 rounded-full h-1.5 overflow-hidden">
                      <div class="bg-gradient-to-r from-brandCyber to-amber-500 h-full rounded-full transition-all"
                           :style="{ width: nextChapter.progress + '%' }"></div>
                    </div>
                    <span class="text-xs font-bold text-brandCyber">{{ nextChapter.progress }}%</span>
                  </div>
                </div>
              </div>
              <router-link
                :to="`/courses/${nextChapter.id}`"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-brandCyber to-amber-400 text-slate-950 font-bold px-6 py-3 rounded-xl shadow-[0_0_20px_rgba(253,224,71,0.2)] hover:shadow-[0_0_30px_rgba(253,224,71,0.4)] transition whitespace-nowrap"
              >
                {{ nextChapter.progress > 0 ? 'Continuer' : 'Commencer' }}
                <ArrowRight class="w-4 h-4" />
              </router-link>
            </div>
          </div>
        </div>

        <!-- MESSAGES / AVIS / RÉCLAMATIONS -->
<div>
  <div class="flex items-center justify-between mb-3">
    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider">
      Support & Messages
    </h3>
    <div class="flex items-center gap-2">
      <button
        @click="openMessageModal('avis')"
        class="inline-flex items-center gap-2 text-xs font-semibold text-brandCyber bg-brandCyber/10 border border-brandCyber/20 px-3 py-1.5 rounded-lg hover:bg-brandCyber/20 transition"
      >
        <MessageSquare class="w-3.5 h-3.5" />
        Donner un avis
      </button>
      <button
        @click="openMessageModal('reclamation')"
        class="inline-flex items-center gap-2 text-xs font-semibold text-red-400 bg-red-500/10 border border-red-500/20 px-3 py-1.5 rounded-lg hover:bg-red-500/20 transition"
      >
        <AlertCircle class="w-3.5 h-3.5" />
        Réclamation
      </button>
    </div>
  </div>

  <!-- Stats messages -->
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
    <div class="bg-[#0f0f1a]/60 border border-slate-800 rounded-xl p-3 text-center">
      <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Total</p>
      <p class="text-xl font-extrabold text-white mt-1">{{ messageStats.total }}</p>
    </div>
    <div class="bg-[#0f0f1a]/60 border border-yellow-500/20 rounded-xl p-3 text-center">
      <p class="text-[10px] font-bold text-yellow-400 uppercase tracking-wider">En attente</p>
      <p class="text-xl font-extrabold text-white mt-1">{{ messageStats.en_attente }}</p>
    </div>
    <div class="bg-[#0f0f1a]/60 border border-blue-500/20 rounded-xl p-3 text-center">
      <p class="text-[10px] font-bold text-blue-400 uppercase tracking-wider">En cours</p>
      <p class="text-xl font-extrabold text-white mt-1">{{ messageStats.en_cours }}</p>
    </div>
    <div class="bg-[#0f0f1a]/60 border border-brandMint/20 rounded-xl p-3 text-center">
      <p class="text-[10px] font-bold text-brandMint uppercase tracking-wider">Résolus</p>
      <p class="text-xl font-extrabold text-white mt-1">{{ messageStats.resolu }}</p>
    </div>
  </div>

  <!-- Liste des messages -->
  <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-6">
    <div v-if="messages.length > 0" class="space-y-3">
      <div v-for="msg in messages.slice(0, 5)" :key="msg.id"
           class="p-4 bg-slate-900/40 border border-slate-800 rounded-xl hover:border-slate-700 transition">
        <div class="flex items-start justify-between gap-3 mb-2">
          <div class="flex items-center gap-2 flex-wrap">
            <span :class="['text-[10px] font-bold px-2 py-0.5 rounded-full border', getTypeClass(msg.type)]">
              {{ getTypeLabel(msg.type) }}
            </span>
            <span :class="['text-[10px] font-bold px-2 py-0.5 rounded-full border', getStatusClass(msg.status)]">
              {{ getStatusLabel(msg.status) }}
            </span>
          </div>
          <button
            v-if="msg.status === 'en_attente'"
            @click="deleteMessage(msg.id)"
            class="text-slate-500 hover:text-red-400 transition"
            title="Supprimer"
          >
            <Trash2 class="w-4 h-4" />
          </button>
        </div>
        <h4 class="text-sm font-bold text-white mb-1">{{ msg.subject }}</h4>
        <p class="text-xs text-slate-400 line-clamp-2">{{ msg.content }}</p>
        <p class="text-[10px] text-slate-600 mt-2">{{ formatDate(msg.created_at) }}</p>

        <!-- Réponse admin -->
        <div v-if="msg.admin_reply" class="mt-3 p-3 bg-brandMint/5 border border-brandMint/20 rounded-lg">
          <p class="text-[10px] font-bold text-brandMint uppercase tracking-wider mb-1">Réponse de l'administration</p>
          <p class="text-xs text-slate-300">{{ msg.admin_reply }}</p>
        </div>
      </div>
    </div>
    <p v-else class="text-xs text-slate-500 italic text-center py-6">
      Aucun message pour l'instant. Donne ton avis ou signale un problème !
    </p>
  </div>
</div>

        <!-- GRILLE -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

          <!-- Colonne gauche : Profil + Progression -->
          <div class="lg:col-span-1 space-y-6">

            <!-- Profil -->
            <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-6">
              <div class="flex flex-col items-center text-center">
                <div class="relative">
                  <div class="w-28 h-28 rounded-full overflow-hidden shadow-[0_0_30px_rgba(253,224,71,0.2)] border-2 border-brandCyber/20">
                    <UserAvatar :config="avatarConfig" :size="112" />
                  </div>
                  <button
                    @click="openAvatarEditor"
                    class="absolute bottom-1 right-1 w-9 h-9 bg-brandCyber rounded-full border-4 border-[#0f0f1a] flex items-center justify-center shadow-lg hover:scale-110 transition"
                  >
                    <Pencil class="w-4 h-4 text-slate-950" />
                  </button>
                  <div class="absolute bottom-1 right-11 w-4 h-4 bg-brandMint rounded-full border-2 border-[#0f0f1a]"></div>
                </div>

                <h3 class="text-lg font-bold text-white mt-4">{{ user.name || 'Élève' }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ user.email }}</p>

                <div class="flex items-center gap-2 mt-3">
                  <span class="text-[10px] font-bold text-brandCyber bg-brandCyber/10 border border-brandCyber/20 px-2.5 py-1 rounded-full">
                    Niveau {{ userLevel }}
                  </span>
                  <span class="text-[10px] font-bold text-brandMint bg-brandMint/10 border border-brandMint/20 px-2.5 py-1 rounded-full">
                    {{ user.total_xp || 0 }} XP
                  </span>
                </div>

                <div class="w-full mt-6 space-y-2 text-left">
                  <div class="flex items-center gap-3 py-2 border-b border-slate-800/60">
                    <Building2 class="w-4 h-4 text-slate-600 flex-shrink-0" />
                    <span class="text-xs text-slate-500 flex-1">Établissement</span>
                    <span class="text-xs font-semibold text-slate-300 truncate">{{ user.school || 'Non défini' }}</span>
                  </div>
                  <div class="flex items-center gap-3 py-2 border-b border-slate-800/60">
                    <GraduationCap class="w-4 h-4 text-slate-600 flex-shrink-0" />
                    <span class="text-xs text-slate-500 flex-1">Niveau scolaire</span>
                    <span class="text-xs font-semibold text-slate-300 truncate">{{ user.grade || 'Non défini' }}</span>
                  </div>
                  <div class="flex items-center gap-3 py-2 border-b border-slate-800/60">
                    <MapPin class="w-4 h-4 text-slate-600 flex-shrink-0" />
                    <span class="text-xs text-slate-500 flex-1">Gouvernorat</span>
                    <span class="text-xs font-semibold text-slate-300 truncate">{{ user.governorate || 'Non défini' }}</span>
                  </div>
                  <div class="flex items-center gap-3 py-2">
                    <BookOpen class="w-4 h-4 text-slate-600 flex-shrink-0" />
                    <span class="text-xs text-slate-500 flex-1">Section</span>
                    <span class="text-xs font-semibold text-slate-300 truncate">
                      {{ user.section?.name || 'Non défini' }}
                    </span>
                  </div>
                </div>

                <router-link to="/profile" class="mt-5 w-full inline-flex items-center justify-center gap-2 py-2.5 px-4 bg-brandCyber/10 text-brandCyber rounded-xl hover:bg-brandCyber/20 transition font-semibold text-sm">
                  <Pencil class="w-4 h-4" />
                  Modifier mon profil
                </router-link>
              </div>
            </div>

            <!-- Progression des cours -->
            <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-6">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-white">Progression des cours</h3>
                <router-link to="/courses" class="text-[10px] text-brandCyber hover:underline font-medium">Voir tout</router-link>
              </div>

              <div v-if="coursesProgress.length > 0" class="space-y-4">
                <div v-for="course in coursesProgress" :key="course.id">
                  <div class="flex items-center justify-between mb-1.5">
                    <div class="flex items-center gap-2 min-w-0">
                      <div class="w-6 h-6 rounded-md flex items-center justify-center bg-slate-800/60 border border-slate-700/60 flex-shrink-0">
                        <FileCode2 class="w-3.5 h-3.5 text-brandCyber" />
                      </div>
                      <span class="text-xs font-medium text-slate-300 truncate">{{ course.title }}</span>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400 flex-shrink-0">{{ course.progress }}%</span>
                  </div>
                  <div class="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-1000"
                         :class="course.progress === 100
                           ? 'bg-gradient-to-r from-brandMint to-emerald-400'
                           : 'bg-gradient-to-r from-brandCyber to-amber-500'"
                         :style="{ width: course.progress + '%' }"></div>
                  </div>
                </div>
              </div>

              <p v-else class="text-xs text-slate-500 italic text-center py-4">
                Aucun cours commencé pour l'instant
              </p>
            </div>
          </div>

          <!-- Colonne droite : Badges + Activité -->
          <div class="lg:col-span-2 space-y-6">

            <!-- Badges -->
            <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-6">
              <div class="flex items-center justify-between mb-5">
                <div>
                  <h3 class="text-sm font-bold text-white">Mes badges</h3>
                  <p class="text-[10px] text-slate-500 mt-0.5">
                    {{ userBadges.length }} débloqués • {{ lockedBadgesCount }} à découvrir
                  </p>
                </div>
                <router-link to="/badges" class="text-[10px] text-brandCyber hover:underline font-medium">Voir tout</router-link>
              </div>

              <div v-if="userBadges.length > 0" class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                <div v-for="badge in userBadges" :key="badge.id"
                     class="group flex flex-col items-center p-3 bg-gradient-to-br from-brandCyber/10 to-transparent border border-brandCyber/20 rounded-xl hover:border-brandCyber/40 transition cursor-pointer">
                  <div class="w-12 h-12 rounded-full bg-gradient-to-br from-brandCyber/20 to-amber-500/20 flex items-center justify-center group-hover:scale-110 transition">
                    <component :is="badge.iconComponent" class="w-6 h-6 text-brandCyber" />
                  </div>
                  <p class="text-[10px] font-bold mt-2 text-center text-slate-300 leading-tight">{{ badge.name }}</p>
                </div>

                <div v-if="lockedBadgesCount > 0"
                     class="flex flex-col items-center p-3 bg-slate-800/30 border border-slate-800 border-dashed rounded-xl opacity-50">
                  <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center">
                    <Lock class="w-5 h-5 text-slate-600" />
                  </div>
                  <p class="text-[10px] font-medium mt-2 text-center text-slate-600">
                    +{{ lockedBadgesCount }}
                  </p>
                </div>
              </div>

              <p v-else class="text-xs text-slate-500 italic text-center py-4">
                Aucun badge débloqué pour l'instant
              </p>
            </div>

            <!-- Activité récente -->
            <div class="bg-[#0f0f1a]/60 backdrop-blur border border-slate-800 rounded-2xl p-6">
              <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-bold text-white">Activité récente</h3>
                <span class="text-[10px] text-slate-500">7 derniers jours</span>
              </div>

              <div v-if="recentActivities.length > 0" class="space-y-3">
                <div v-for="activity in recentActivities" :key="activity.id"
                     class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-800/30 transition">
                  <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 border"
                       :class="activity.bgClass">
                    <component :is="activity.iconComponent" class="w-4 h-4" :class="activity.iconClass" />
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-200">{{ activity.title }}</p>
                    <p class="text-[10px] text-slate-500 mt-0.5">{{ activity.time }}</p>
                  </div>
                </div>
              </div>

              <p v-else class="text-xs text-slate-500 italic text-center py-4">
                Aucune activité récente
              </p>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Modal Avatar -->
    <AvatarEditor
      :visible="avatarEditorVisible"
      :current-config="avatarConfig"
      @close="avatarEditorVisible = false"
      @saved="handleAvatarSaved"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted, h } from 'vue'
import { useRouter } from 'vue-router'
import api from '../plugins/axios'
import UserAvatar from './UserAvatar.vue'
import AvatarEditor from './AvatarEditor.vue'
import {
  LayoutDashboard, BookOpen, ClipboardList, Award, BarChart3,
  LogOut, Menu, Bell, Lightbulb, Sparkles, Zap, TrendingUp,
  Flame, Pencil, ArrowRight, Building2, GraduationCap, MapPin,
  Lock, Code2, FileCode2,
  MessageSquare, Send, AlertCircle, CheckCircle2, Clock, X, Trash2
} from 'lucide-vue-next'

// ─── Icônes inline pour les badges ────────────
const IconStar = (props) => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24', ...props }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z' })
])

const IconBook = (props) => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24', ...props }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253' })
])

const IconCode = (props) => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24', ...props }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4' })
])

const IconCheck = (props) => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2.5', viewBox: '0 0 24 24', ...props }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M5 13l4 4L19 7' })
])

const IconTarget = (props) => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24', ...props }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' })
])

const IconTrophy = (props) => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24', ...props }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M8 21h8m-4-4v4m-7-13V6a2 2 0 012-2h10a2 2 0 012 2v2M5 8H4a1 1 0 00-1 1v1a4 4 0 004 4m12 0a4 4 0 004-4V9a1 1 0 00-1-1h-1' })
])

// ─── État ─────────────────────────────────────
const router = useRouter()
const mobileMenuOpen = ref(false)
const loading = ref(true)
const avatarEditorVisible = ref(false)

const user = ref(JSON.parse(localStorage.getItem('user') || '{}'))
const allCourses = ref([])
const userBadges = ref([])
const recentActivities = ref([])
const streakMessage = computed(() => {
  return (user.value.streak_days || 0) > 0
    ? 'Ne casse pas ta série !'
    : "Commence ta série aujourd'hui !"
})
// ─── Avatar config ────────────────────────────
const avatarConfig = computed(() => user.value.avatar_config || {
  hair: 'short',
  hairColor: '#1E1B4B',
  skin: '#F3D2B3',
  outfit: 'hoodie',
  outfitColor: '#FDE047',
  accessory: 'none',
  background: '#FDE047',
})

// ─── Niveau & XP ──────────────────────────────
const XP_PER_LEVEL = 500

const userLevel = computed(() => {
  const xp = user.value.total_xp || 0
  return Math.floor(xp / XP_PER_LEVEL) + 1
})

const xpInCurrentLevel = computed(() => {
  return (user.value.total_xp || 0) % XP_PER_LEVEL
})

const xpProgress = computed(() => {
  return Math.round((xpInCurrentLevel.value / XP_PER_LEVEL) * 100)
})

const xpRemaining = computed(() => {
  return XP_PER_LEVEL - xpInCurrentLevel.value
})

// ─── Statistiques des cours ───────────────────
const totalCourses = computed(() => allCourses.value.length)

const completedCourses = computed(() =>
  allCourses.value.filter(c => c.progress === 100).length
)

// ─── Messages (avis / réclamations) ────────────
const messages = ref([])
const messageStats = ref({ total: 0, en_attente: 0, en_cours: 0, resolu: 0 })
const showMessageModal = ref(false)
const sendingMessage = ref(false)
const messageForm = ref({
  type: 'avis',
  subject: '',
  content: '',
})
const messageFormError = ref('')
const messageSuccess = ref('')

const unreadMessages = computed(() =>
  messageStats.value.en_attente + messageStats.value.en_cours
)

// Charger les messages
const loadMessages = async () => {
  try {
    const { data } = await api.get('/messages')
    if (data.success) {
      messages.value = data.messages
      messageStats.value = data.stats
    }
  } catch (error) {
    console.error('Erreur chargement messages:', error)
  }
}

// Ouvrir le modal
const openMessageModal = (type = 'avis') => {
  messageForm.value = { type, subject: '', content: '' }
  messageFormError.value = ''
  messageSuccess.value = ''
  showMessageModal.value = true
}

// Envoyer un message
const submitMessage = async () => {
  messageFormError.value = ''
  messageSuccess.value = ''

  // Validations côté client
  if (!messageForm.value.subject.trim()) {
    messageFormError.value = 'Le sujet est obligatoire.'
    return
  }
  if (messageForm.value.content.trim().length < 10) {
    messageFormError.value = 'Le contenu doit contenir au moins 10 caractères.'
    return
  }

  sendingMessage.value = true
  try {
    const { data } = await api.post('/messages', messageForm.value)
    if (data.success) {
      messageSuccess.value = data.message
      messageForm.value = { type: 'avis', subject: '', content: '' }
      await loadMessages()
      // Fermer après 1.5s
      setTimeout(() => {
        showMessageModal.value = false
        messageSuccess.value = ''
      }, 1500)
    }
  } catch (error) {
    if (error.response?.data?.errors) {
      messageFormError.value = Object.values(error.response.data.errors).flat().join(' ')
    } else {
      messageFormError.value = 'Une erreur est survenue. Réessaie plus tard.'
    }
  } finally {
    sendingMessage.value = false
  }
}

// Supprimer un message
const deleteMessage = async (id) => {
  if (!confirm('Voulez-vous vraiment supprimer ce message ?')) return
  try {
    const { data } = await api.delete(`/messages/${id}`)
    if (data.success) {
      await loadMessages()
    }
  } catch (error) {
    console.error('Erreur suppression:', error)
  }
}

// Helpers statut
const getStatusLabel = (status) => {
  const labels = {
    en_attente: 'En attente',
    en_cours: 'En cours',
    resolu: 'Résolu',
    ferme: 'Fermé',
  }
  return labels[status] || status
}

const getStatusClass = (status) => {
  const classes = {
    en_attente: 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
    en_cours: 'bg-blue-500/10 text-blue-400 border-blue-500/20',
    resolu: 'bg-brandMint/10 text-brandMint border-brandMint/20',
    ferme: 'bg-slate-500/10 text-slate-400 border-slate-500/20',
  }
  return classes[status] || ''
}

const getTypeLabel = (type) => type === 'avis' ? 'Avis' : 'Réclamation'
const getTypeClass = (type) => type === 'avis'
  ? 'bg-brandCyber/10 text-brandCyber border-brandCyber/20'
  : 'bg-red-500/10 text-red-400 border-red-500/20'

const formatDate = (dateStr) => {
  const d = new Date(dateStr)
  return d.toLocaleDateString('fr-FR', {
    day: '2-digit', month: 'short', year: 'numeric',
    hour: '2-digit', minute: '2-digit'
  })
}

const coursesProgress = computed(() => {
  // Cours commencés, triés par progression décroissante
  return allCourses.value
    .filter(c => c.progress > 0)
    .sort((a, b) => b.progress - a.progress)
    .slice(0, 5) // on affiche max 5 cours
})

const nextChapter = computed(() => {
  // 1. Le cours "en cours" (progress entre 1 et 99)
  const inProgress = allCourses.value.find(c => c.progress > 0 && c.progress < 100)
  if (inProgress) return inProgress

  // 2. Sinon, le premier cours non commencé
  const notStarted = allCourses.value.find(c => c.progress === 0)
  if (notStarted) return notStarted

  // 3. Sinon, null (tout est terminé)
  return null
})

// ─── Badges ───────────────────────────────────
const lockedBadgesCount = computed(() => {
  // On suppose un total de 12 badges ; à adapter selon ton système
  return Math.max(0, 12 - userBadges.value.length)
})

// ─── Actions ──────────────────────────────────
const openAvatarEditor = () => {
  avatarEditorVisible.value = true
}

const handleAvatarSaved = (newConfig) => {
  user.value.avatar_config = newConfig
  localStorage.setItem('user', JSON.stringify(user.value))
}

// ─── Chargement ───────────────────────────────
const loadUser = async () => {
  try {
    const { data } = await api.get('/me')
    if (data.success) {
      user.value = data.user
      localStorage.setItem('user', JSON.stringify(user.value))

      // Badges depuis l'API (si disponible)
      if (data.user.badges) {
        userBadges.value = data.user.badges.map(b => ({
          id: b.id,
          name: b.name,
          iconComponent: getBadgeIcon(b.icon || b.name),
        }))
      }
    }
  } catch (error) {
    console.error('Erreur chargement utilisateur:', error)
  }
}

const loadCourses = async () => {
  try {
    // On récupère tous les cours de la section de l'utilisateur
    const sectionCode = user.value.section?.code || 'informatique'
    const { data } = await api.get('/courses', {
      params: { section: sectionCode }
    })
    if (data.success) {
      allCourses.value = data.courses
    }
  } catch (error) {
    console.error('Erreur chargement cours:', error)
  }
}

const loadRecentActivities = async () => {
  try {
    // Si tu as une route API dédiée :
    // const { data } = await api.get('/activities/recent')
    // if (data.success) recentActivities.value = data.activities

    // Sinon, on génère depuis l'historique des cours
    const completed = allCourses.value
      .filter(c => c.progress === 100)
      .slice(0, 5)

    recentActivities.value = completed.map((c, i) => ({
      id: c.id,
      title: `Cours terminé : ${c.title}`,
      iconComponent: IconCheck,
      iconClass: 'text-brandMint',
      bgClass: 'bg-brandMint/10 border-brandMint/20',
      time: formatRelativeTime(i),
    }))
  } catch (error) {
    console.error('Erreur activités:', error)
  }
}

// Helper : icône selon le nom du badge
const getBadgeIcon = (name) => {
  const n = (name || '').toLowerCase()
  if (n.includes('code') || n.includes('python')) return IconCode
  if (n.includes('lecture') || n.includes('cours')) return IconBook
  if (n.includes('cible') || n.includes('objectif')) return IconTarget
  if (n.includes('trophée') || n.includes('champion')) return IconTrophy
  return IconStar
}

// Helper : temps relatif simple
const formatRelativeTime = (index) => {
  const times = ['Il y a 2 heures', 'Il y a 5 heures', 'Hier', 'Il y a 2 jours', 'Il y a 3 jours']
  return times[index] || 'Récemment'
}

// ─── Lifecycle ────────────────────────────────
onMounted(async () => {
  loading.value = true
  try {
    await loadUser()
    await loadCourses()
    await loadRecentActivities()
    await loadMessages()
  } finally {
    loading.value = false
  }
})

// ─── Déconnexion ──────────────────────────────
const logout = async () => {
  try {
    await api.post('/logout')
  } catch (error) {
    console.error('Erreur déconnexion:', error)
  } finally {
    localStorage.removeItem('token')
    localStorage.removeItem('user')
    router.push('/')
  }
}
</script>