<!-- pages/WelcomePage.vue -->
<template>
  <div class="relative overflow-x-hidden min-h-screen">
    <!-- Effets de lueur en arrière-plan -->
    <div class="absolute top-[-10%] left-[-5%] w-[45vw] max-w-[500px] h-[500px] bg-brandCyber/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute top-[35%] right-[-5%] w-[50vw] max-w-[600px] h-[600px] bg-brandMint/5 rounded-full blur-[150px] pointer-events-none"></div>
    <div class="absolute bottom-[10%] left-[-5%] w-[45vw] max-w-[500px] h-[500px] bg-brandCyber/3 rounded-full blur-[150px] pointer-events-none"></div>

    <!-- Fond principal ultra-sombre -->
    <div class="fixed inset-0 bg-[#0a0a0f] -z-10"></div>

    <!-- HEADER / NAVIGATION -->
    <header class="container mx-auto px-4 sm:px-6 py-4 sm:py-6 max-w-7xl relative z-10 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <span class="text-xl sm:text-2xl font-extrabold tracking-tight bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent">
          Presenti<span class="text-brandCyber">ly</span>
        </span>
      </div>
      
      <!-- Navigation desktop -->
      <nav class="hidden md:flex items-center gap-6 lg:gap-8 text-sm font-medium text-slate-400">
        <a href="#features" class="hover:text-brandCyber transition">Cours Interactifs</a>
        <a href="#testimonials" class="hover:text-brandCyber transition">Témoignages</a>
        <a href="#tarifs" class="hover:text-brandCyber transition">Tarifs</a>
      </nav>
      
      <!-- Boutons desktop -->
      <div class="hidden md:flex items-center gap-2 sm:gap-4">
        <button @click="openAuthModal('login')" class="text-xs sm:text-sm font-semibold text-slate-400 hover:text-white transition">Connexion</button>
        <button @click="openAuthModal('register')" class="bg-slate-800/60 hover:bg-slate-700/80 text-white text-xs sm:text-sm font-bold px-2 sm:px-4 py-1.5 sm:py-2 rounded-xl border border-slate-700/60 transition whitespace-nowrap">
          Créer un compte
        </button>
      </div>

      <!-- Menu hamburger pour mobile -->
      <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-slate-400 hover:text-white transition p-2">
        <svg v-if="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </header>

    <!-- Menu mobile -->
    <div v-if="mobileMenuOpen" class="md:hidden fixed inset-x-0 top-[72px] sm:top-[80px] bg-[#0f0f1a]/98 backdrop-blur-xl border-b border-slate-800/60 py-6 px-4 z-50 shadow-2xl">
      <nav class="flex flex-col items-center gap-4 text-sm font-medium text-slate-400">
        <a href="#features" @click="mobileMenuOpen = false" class="hover:text-brandCyber transition py-2 w-full text-center border-b border-slate-800/50">Cours Interactifs</a>
        <a href="#testimonials" @click="mobileMenuOpen = false" class="hover:text-brandCyber transition py-2 w-full text-center border-b border-slate-800/50">Témoignages</a>
        <a href="#tarifs" @click="mobileMenuOpen = false" class="hover:text-brandCyber transition py-2 w-full text-center border-b border-slate-800/50">Tarifs</a>
        
        <div class="w-full border-t border-slate-800/50 my-2"></div>
        
        <div class="flex flex-col w-full gap-3 pt-2">
          <button @click="openAuthModal('login'); mobileMenuOpen = false" class="w-full text-center text-sm font-semibold text-slate-400 hover:text-white transition py-2.5 px-4 rounded-xl border border-slate-700/60 hover:border-slate-600">
            Connexion
          </button>
          <button @click="openAuthModal('register'); mobileMenuOpen = false" class="w-full text-center bg-gradient-to-r from-brandCyber to-amber-400 text-slate-950 font-bold text-sm py-2.5 px-4 rounded-xl shadow-[0_0_20px_rgba(253,224,71,0.15)] hover:shadow-[0_0_30px_rgba(253,224,71,0.25)] transition">
            Créer un compte
          </button>
        </div>
      </nav>
    </div>

    <!-- HERO SECTION -->
    <main class="container mx-auto px-4 sm:px-6 pt-6 sm:pt-8 lg:pt-12 pb-12 sm:pb-16 lg:pb-24 max-w-7xl relative z-10">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 lg:gap-12 items-center">
        <!-- TEXTE HERO -->
        <div class="lg:col-span-5 space-y-4 sm:space-y-6 lg:space-y-8 text-center lg:text-left">
          <div class="inline-flex items-center gap-2 bg-brandCyber/10 border border-brandCyber/20 text-brandCyber text-[10px] sm:text-xs font-bold px-2 sm:px-3 py-1 sm:py-1.5 rounded-full mx-auto lg:mx-0">
            <span>La plateforme Python N°1 en Tunisie</span>
          </div>
          <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-extrabold tracking-tight leading-[1.1] text-white">
            Ne lis plus ton cours de code. <br>
            <span class="bg-gradient-to-r from-brandCyber to-amber-400 bg-clip-text text-transparent">Manipule-le.</span>
          </h1>
          <p class="text-sm sm:text-base lg:text-lg text-slate-400 max-w-xl mx-auto lg:mx-0 leading-relaxed">
            Apprends Python pour le lycée à travers des modules interactifs, des animations en temps réel et des jeux. Conçu spécifiquement pour la génération tech tunisienne.
          </p>
          <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 sm:gap-4">
            <button @click="openAuthModal('register')" class="relative group overflow-hidden px-5 sm:px-6 lg:px-8 py-2.5 sm:py-3 lg:py-4 rounded-xl bg-gradient-to-r from-brandCyber to-amber-400 text-slate-950 font-extrabold text-sm sm:text-base lg:text-lg shadow-[0_0_20px_rgba(253,224,71,0.2)] transition-all duration-300 hover:shadow-[0_0_35px_rgba(253,224,71,0.45)] hover:scale-[1.02] w-full sm:w-auto">
              <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:animate-shimmer"></span>
              <span class="flex items-center justify-center gap-2">
                Commencer l'aventure gratuitement 
                <svg class="w-4 h-4 sm:w-5 sm:h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </span>
            </button>
          </div>
        </div>

        <!-- DASHBOARD INTERACTIF -->
        <div ref="dashboardMockup" class="hidden lg:block lg:col-span-7 flex-col items-center justify-center opacity-0 transform translate-y-8 mt-6 lg:mt-0">
          <div class="w-full max-w-2xl bg-[#0f0f1a]/90 backdrop-blur-xl p-3 sm:p-4 md:p-6 lg:p-8 rounded-2xl sm:rounded-3xl border border-slate-800/60 shadow-2xl shadow-black/50 relative overflow-hidden">
            <div class="flex items-center justify-between mb-4 sm:mb-6 lg:mb-8 pb-3 sm:pb-4 border-b border-slate-800/80">
              <div class="flex items-center gap-1.5 sm:gap-2">
                <span class="w-2 h-2 sm:w-3 sm:h-3 rounded-full bg-red-500/80"></span>
                <span class="w-2 h-2 sm:w-3 sm:h-3 rounded-full bg-yellow-500/80"></span>
                <span class="w-2 h-2 sm:w-3 sm:h-3 rounded-full bg-green-500/80"></span>
              </div>
              <div class="flex items-center gap-1.5 sm:gap-2 bg-[#0a0a12] px-2 sm:px-3 lg:px-4 py-0.5 sm:py-1 rounded-full border border-slate-800">
                <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-brandMint animate-pulse"></span>
                <span class="text-[8px] sm:text-[10px] lg:text-xs font-semibold text-slate-400 truncate max-w-[60px] sm:max-w-[100px] lg:max-w-none">presentily.com/accueil</span>
              </div>
              <div class="w-6 sm:w-8 lg:w-12"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 sm:gap-4 lg:gap-6">
              <div ref="xpCard" class="md:col-span-5 bg-[#0a0a12]/80 p-3 sm:p-4 lg:p-5 rounded-xl sm:rounded-2xl border border-slate-800 flex flex-col items-center justify-center text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 bg-brandCyber/10 text-brandCyber text-[8px] sm:text-[10px] font-bold px-1.5 sm:px-2 py-0.5 rounded-bl-lg border-l border-b border-brandCyber/20">NIVEAU 4</div>
                <div class="relative w-20 h-20 sm:w-24 sm:h-24 lg:w-28 lg:h-28 flex items-center justify-center mb-2 sm:mb-3">
                  <svg class="w-full h-full transform -rotate-90">
                    <circle class="text-slate-700" stroke-width="5" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50"/>
                    <circle ref="progressCircle" class="text-brandMint" stroke-width="5" stroke-linecap="round" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" stroke-dasharray="251.2" stroke-dashoffset="87.92" style="transition: stroke-dashoffset 1.5s ease-out;"/>
                  </svg>
                  <div class="absolute flex flex-col items-center justify-center">
                    <span ref="xpCount" class="text-lg sm:text-xl lg:text-2xl font-extrabold text-white">1250</span>
                    <span class="text-[6px] sm:text-[8px] lg:text-[10px] text-slate-500 font-semibold tracking-wider">TOTAL XP</span>
                  </div>
                </div>
                <h3 class="font-bold text-[10px] sm:text-xs lg:text-sm text-slate-300">Fadwa Dhemaid</h3>
                <p class="text-[8px] sm:text-[10px] lg:text-xs text-brandMint font-medium mt-0.5 sm:mt-1 bg-brandMint/10 px-1.5 sm:px-2 py-0.5 rounded-full">+150 XP</p>
              </div>

              <div class="md:col-span-7 space-y-2 sm:space-y-3 lg:space-y-4 flex flex-col justify-between">
                <div ref="chapterCard" class="bg-[#0a0a12]/80 p-2.5 sm:p-3 lg:p-4 rounded-lg sm:rounded-xl border border-slate-800 flex items-center justify-between">
                  <div class="flex items-center gap-2 sm:gap-3">
                    <div class="p-1.5 sm:p-2 bg-brandCyber/10 rounded-lg sm:rounded-xl border border-brandCyber/20 text-brandCyber">
                      <svg class="w-3 h-3 sm:w-4 sm:h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" /></svg>
                    </div>
                    <div class="text-left">
                      <p class="text-[7px] sm:text-[8px] lg:text-[10px] font-bold text-brandCyber uppercase tracking-wider">Chapitre en cours</p>
                      <p class="text-[10px] sm:text-xs lg:text-sm font-bold text-slate-300">Les Boucles & Répétitions</p>
                    </div>
                  </div>
                  <span class="text-[8px] sm:text-[10px] lg:text-xs bg-slate-800/60 text-slate-400 font-bold px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-lg border border-slate-700">65%</span>
                </div>

                <div ref="leaderboardCard" class="bg-[#0a0a12]/60 p-2.5 sm:p-3 lg:p-4 rounded-lg sm:rounded-xl border border-slate-800/60 space-y-2 sm:space-y-3">
                  <div class="flex items-center justify-between border-b border-slate-800/80 pb-1.5 sm:pb-2">
                    <span class="text-[8px] sm:text-[10px] lg:text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1 sm:gap-1.5">
                      <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 lg:w-3.5 lg:h-3.5 text-brandCyber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                      Classement National
                    </span>
                    <span class="text-[7px] sm:text-[8px] lg:text-[10px] bg-brandCyber/10 text-brandCyber px-1 sm:px-1.5 lg:px-2 py-0.5 rounded font-bold">EN DIRECT 🇹🇳</span>
                  </div>
                  <div class="space-y-1.5 sm:space-y-2 font-medium text-[10px] sm:text-xs">
                    <div class="flex items-center justify-between py-1 px-1.5 sm:px-2 rounded bg-brandMint/5 border border-brandMint/10">
                      <span class="text-slate-300 text-[8px] sm:text-[10px] lg:text-xs truncate">1. Lycée Pilote Bourguiba</span>
                      <span class="font-bold text-brandMint text-[8px] sm:text-[10px] lg:text-xs">14 820 XP</span>
                    </div>
                    <div class="flex items-center justify-between py-1 px-1.5 sm:px-2 rounded hover:bg-slate-800/30 transition">
                      <span class="text-slate-400 text-[8px] sm:text-[10px] lg:text-xs truncate">2. Lycée Pilote Sousse</span>
                      <span class="font-bold text-slate-500 text-[8px] sm:text-[10px] lg:text-xs">12 400 XP</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- SECTION GRILLE BENTO -->
    <section id="features" class="py-12 sm:py-16 lg:py-20 border-t border-slate-800/60 bg-[#0a0a0f]/80 relative z-10">
      <div class="container mx-auto px-4 sm:px-6 max-w-7xl">
        <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-12 lg:mb-16">
          <h2 class="text-xl sm:text-2xl lg:text-3xl xl:text-4xl font-extrabold bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent mb-2 sm:mb-3 lg:mb-4">
            Une nouvelle façon de maîtriser Python
          </h2>
          <p class="text-sm sm:text-base text-slate-500">Oublie les fiches de révision interminables. Ici, chaque concept devient un jeu d'enfant.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
          <!-- Carte 1 -->
          <div class="md:col-span-2 bg-[#0f0f1a]/60 border border-slate-800 p-4 sm:p-5 lg:p-8 rounded-2xl sm:rounded-3xl flex flex-col justify-between relative group hover:border-brandCyber/30 transition-all duration-300">
            <div class="max-w-md space-y-2">
              <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-brandCyber/10 border border-brandCyber/20 flex items-center justify-center text-brandCyber mb-2 sm:mb-3 lg:mb-4">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              </div>
              <h3 class="text-base sm:text-lg lg:text-xl font-bold text-slate-200">Visualisation de la Mémoire</h3>
              <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">Manipule directement des boîtes virtuelles pour comprendre comment les variables, les listes et les dictionnaires stockent tes données dans l'ordinateur.</p>
            </div>
            <div class="mt-4 sm:mt-6 lg:mt-8 border border-slate-800 bg-[#0a0a12]/60 p-2 sm:p-3 lg:p-4 rounded-lg sm:rounded-xl font-mono text-[8px] sm:text-[10px] lg:text-xs text-brandCyber flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-0">
              <span>score = 100 # Une boîte se crée tout seule</span>
              <span class="text-brandMint font-bold text-[8px] sm:text-[10px] lg:text-xs">[Mémoire OK]</span>
            </div>
          </div>

          <!-- Carte 2 -->
          <div class="bg-[#0f0f1a]/60 border border-slate-800 p-4 sm:p-5 lg:p-8 rounded-2xl sm:rounded-3xl flex flex-col justify-between hover:border-brandMint/30 transition-all duration-300">
            <div class="space-y-2">
              <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-brandMint/10 border border-brandMint/20 flex items-center justify-center text-brandMint mb-2 sm:mb-3 lg:mb-4">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
              </div>
              <h3 class="text-base sm:text-lg lg:text-xl font-bold text-slate-200">Code Direct en Navigateur</h3>
              <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">Rien à installer sur ton ordinateur. Écris ton vrai code Python directement sur notre éditeur en ligne sécurisé.</p>
            </div>
            <span class="text-[8px] sm:text-[10px] lg:text-xs text-brandMint font-bold bg-brandMint/5 border border-brandMint/10 px-2 sm:px-3 py-1 rounded-lg w-max mt-3 sm:mt-4 lg:mt-6">Zéro configuration</span>
          </div>

          <!-- Carte 3 -->
          <div class="bg-[#0f0f1a]/60 border border-slate-800 p-4 sm:p-5 lg:p-8 rounded-2xl sm:rounded-3xl flex flex-col justify-between hover:border-brandMint/30 transition-all duration-300">
            <div class="space-y-2">
              <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-brandMint/10 border border-brandMint/20 flex items-center justify-center text-brandMint mb-2 sm:mb-3 lg:mb-4">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
              </div>
              <h3 class="text-base sm:text-lg lg:text-xl font-bold text-slate-200">Système de Quêtes</h3>
              <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">Gagne des points d'expérience à chaque exercice validé, débloque des succès exclusifs et monte en compétences comme dans un RPG.</p>
            </div>
            <span class="text-[8px] sm:text-[10px] lg:text-xs text-brandCyber font-bold bg-brandCyber/5 border border-brandCyber/10 px-2 sm:px-3 py-1 rounded-lg w-max mt-3 sm:mt-4 lg:mt-6">Niveau Supérieur</span>
          </div>

          <!-- Carte 4 -->
          <div class="md:col-span-2 bg-[#0f0f1a]/60 border border-slate-800 p-4 sm:p-5 lg:p-8 rounded-2xl sm:rounded-3xl flex flex-col justify-between hover:border-brandCyber/30 transition-all duration-300">
            <div class="max-w-md space-y-2">
              <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-brandCyber/10 border border-brandCyber/20 flex items-center justify-center text-brandCyber mb-2 sm:mb-3 lg:mb-4">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
              </div>
              <h3 class="text-base sm:text-lg lg:text-xl font-bold text-slate-200">Classement Inter-Lycées</h3>
              <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">Représente fièrement ton établissement scolaire au niveau de ton gouvernorat et grimpe dans le classement e-sport national en résolvant des énigmes de code.</p>
            </div>
            <div class="flex gap-1.5 sm:gap-2 mt-3 sm:mt-4 lg:mt-6">
              <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-brandMint"></span>
              <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-brandMint/60"></span>
              <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-brandMint/30"></span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION TEMOIGNAGES -->
    <section id="testimonials" class="py-12 sm:py-16 lg:py-24 border-t border-slate-800/60 bg-[#0a0a0f]/80 relative z-10">
      <div class="container mx-auto px-4 sm:px-6 max-w-7xl">
        <div class="text-center max-w-3xl mx-auto mb-8 sm:mb-12 lg:mb-20 space-y-2 sm:space-y-3 lg:space-y-4">
          <h2 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-extrabold bg-gradient-to-r from-white via-slate-200 to-slate-400 bg-clip-text text-transparent tracking-tight">
            Adopté par les élèves, approuvé par les parents
          </h2>
          <p class="text-sm sm:text-base text-slate-500 max-w-xl mx-auto">
            Découvre comment Presentily transforme l'apprentissage du code à travers la Tunisie.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8 items-start">
          <!-- Témoignage 1 -->
          <div class="group relative bg-[#0f0f1a]/60 backdrop-blur-xl border border-slate-800 p-4 sm:p-6 lg:p-8 rounded-2xl sm:rounded-3xl flex flex-col justify-between transition-all duration-300 hover:border-brandCyber/40 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(253,224,71,0.05)]">
            <div class="space-y-3 sm:space-y-4 lg:space-y-6">
              <div class="flex items-center justify-between">
                <span class="text-[8px] sm:text-[10px] font-bold tracking-wider uppercase px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-md bg-brandCyber/10 text-brandCyber border border-brandCyber/20">+1 400 XP</span>
                <div class="flex gap-0.5 text-brandCyber">
                  <span class="text-[10px] sm:text-xs">★</span><span class="text-[10px] sm:text-xs">★</span><span class="text-[10px] sm:text-xs">★</span><span class="text-[10px] sm:text-xs">★</span><span class="text-[10px] sm:text-xs">★</span>
                </div>
              </div>
              <p class="text-xs sm:text-sm text-slate-400 italic leading-relaxed font-medium">
                "En classe, j'avais vraiment du mal avec la logique des boucles imbriquées en Python. Sur Presentily, le fait de voir visuellement les compteurs s'incrémenter à l'écran a tout changé."
              </p>
            </div>
            <div class="flex items-center gap-3 sm:gap-3.5 mt-4 sm:mt-6 lg:mt-8 pt-4 sm:pt-6 border-t border-slate-800/60">
              <div class="w-8 h-8 sm:w-10 sm:h-10 lg:w-11 lg:h-11 rounded-xl bg-brandCyber/10 border border-brandCyber/20 flex items-center justify-center font-bold text-brandCyber text-xs sm:text-sm font-mono shadow-inner">YB</div>
              <div>
                <h4 class="text-xs sm:text-sm font-bold text-slate-200 group-hover:text-brandCyber transition-colors">Yassine B.</h4>
                <p class="text-[8px] sm:text-[10px] lg:text-[11px] text-slate-500 font-semibold">Élève en 3ème année — Sousse</p>
              </div>
            </div>
          </div>

          <!-- Témoignage 2 -->
          <div class="group relative bg-[#0f0f1a]/80 backdrop-blur-xl border-2 border-brandMint/30 p-4 sm:p-6 lg:p-8 rounded-2xl sm:rounded-3xl flex flex-col justify-between transition-all duration-300 hover:border-brandMint/60 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(74,222,128,0.08)] lg:-translate-y-3">
            <div class="absolute -top-2.5 sm:-top-3.5 left-4 sm:left-6 lg:left-8 bg-brandMint text-slate-950 text-[8px] sm:text-[10px] font-black tracking-widest px-2 sm:px-3 py-0.5 sm:py-1 rounded-md shadow-md">EXCELLENCE</div>
            <div class="space-y-3 sm:space-y-4 lg:space-y-6 mt-4 sm:mt-0">
              <div class="flex items-center justify-between">
                <span class="text-[8px] sm:text-[10px] font-bold tracking-wider uppercase px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-md bg-brandMint/20 text-brandMint border border-brandMint/30">Note : 20/20</span>
                <div class="flex gap-0.5 text-brandMint">
                  <span class="text-[10px] sm:text-xs">★</span><span class="text-[10px] sm:text-xs">★</span><span class="text-[10px] sm:text-xs">★</span><span class="text-[10px] sm:text-xs">★</span><span class="text-[10px] sm:text-xs">★</span>
                </div>
              </div>
              <p class="text-xs sm:text-sm lg:text-base text-slate-200 italic leading-relaxed font-semibold">
                "C'est la première fois que je m'exerce sans avoir l'impression de travailler. Le système de points d'XP et le classement amical entre les lycées pilotes m'a super motivée."
              </p>
            </div>
            <div class="flex items-center gap-3 sm:gap-3.5 mt-4 sm:mt-6 lg:mt-8 pt-4 sm:pt-6 border-t border-slate-800/60">
              <div class="w-8 h-8 sm:w-10 sm:h-10 lg:w-11 lg:h-11 rounded-xl bg-brandMint/20 border border-brandMint/30 flex items-center justify-center font-bold text-brandMint text-xs sm:text-sm font-mono shadow-inner">SM</div>
              <div>
                <h4 class="text-xs sm:text-sm font-bold text-slate-200 group-hover:text-brandMint transition-colors">Sarra M.</h4>
                <p class="text-[8px] sm:text-[10px] lg:text-[11px] text-slate-400 font-semibold">Bachelière Math — Sfax</p>
              </div>
            </div>
          </div>

          <!-- Témoignage 3 -->
          <div class="group relative bg-[#0f0f1a]/60 backdrop-blur-xl border border-slate-800 p-4 sm:p-6 lg:p-8 rounded-2xl sm:rounded-3xl flex flex-col justify-between transition-all duration-300 hover:border-brandCyber/40 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(253,224,71,0.05)]">
            <div class="space-y-3 sm:space-y-4 lg:space-y-6">
              <div class="flex items-center justify-between">
                <span class="text-[8px] sm:text-[10px] font-bold tracking-wider uppercase px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-md bg-slate-800/60 text-slate-400 border border-slate-700/50">Parent</span>
                <div class="flex gap-0.5 text-brandCyber">
                  <span class="text-[10px] sm:text-xs">★</span><span class="text-[10px] sm:text-xs">★</span><span class="text-[10px] sm:text-xs">★</span><span class="text-[10px] sm:text-xs">★</span><span class="text-[10px] sm:text-xs">★</span>
                </div>
              </div>
              <p class="text-xs sm:text-sm text-slate-400 italic leading-relaxed font-medium">
                "Mon fils passait tout son temps sur les jeux vidéo. Avec cette plateforme, il combine enfin sa passion avec le programme du lycée."
              </p>
            </div>
            <div class="flex items-center gap-3 sm:gap-3.5 mt-4 sm:mt-6 lg:mt-8 pt-4 sm:pt-6 border-t border-slate-800/60">
              <div class="w-8 h-8 sm:w-10 sm:h-10 lg:w-11 lg:h-11 rounded-xl bg-slate-800/60 border border-slate-700 flex items-center justify-center font-bold text-slate-500 text-xs sm:text-sm font-mono shadow-inner">MR</div>
              <div>
                <h4 class="text-xs sm:text-sm font-bold text-slate-200 group-hover:text-brandCyber transition-colors">Mr. Mohamed R.</h4>
                <p class="text-[8px] sm:text-[10px] lg:text-[11px] text-slate-500 font-semibold">Parent — Tunis</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION TARIFICATION -->
    <section id="tarifs" class="py-12 sm:py-16 lg:py-24 relative z-10 border-t border-slate-800/40">
      <div class="container mx-auto px-4 sm:px-6 max-w-7xl">
        <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-12 lg:mb-16 space-y-2 sm:space-y-3 lg:space-y-4">
          <h2 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-extrabold bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent tracking-tight">
            Un tarif simple et adapté
          </h2>
          <p class="text-sm sm:text-base text-slate-500">
            Débute l'apprentissage gratuitement ou débloque le programme complet au rythme qui te convient.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8 items-stretch">
          <!-- Option 1 -->
          <div class="bg-[#0f0f1a]/60 border border-slate-800 p-5 sm:p-6 lg:p-8 rounded-2xl sm:rounded-3xl flex flex-col justify-between transition duration-300 hover:border-slate-700">
            <div class="space-y-3 sm:space-y-4 lg:space-y-6">
              <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-300">Accès Découverte</h3>
                <p class="text-[10px] sm:text-xs text-slate-500 mt-0.5 sm:mt-1">Idéal pour faire ses premiers pas</p>
              </div>
              <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-white">0 DT <span class="text-[10px] sm:text-xs font-normal text-slate-500">/ à vie</span></div>
              <ul class="space-y-1.5 sm:space-y-2 lg:space-y-3 text-xs sm:text-sm text-slate-400 border-t border-slate-800/80 pt-3 sm:pt-4 lg:pt-6">
                <li class="flex items-center gap-2 sm:gap-2.5">✔ Les 3 premiers chapitres de base</li>
                <li class="flex items-center gap-2 sm:gap-2.5">✔ Éditeur de code en ligne standard</li>
                <li class="flex items-center gap-2 sm:gap-2.5">✔ Mini-jeux d'initiation aux variables</li>
              </ul>
            </div>
            <button @click="openAuthModal('register')" class="w-full mt-4 sm:mt-6 lg:mt-8 bg-slate-800/60 hover:bg-slate-700/60 text-white font-bold py-2.5 sm:py-3 px-4 rounded-lg sm:rounded-xl border border-slate-700/60 transition text-sm sm:text-base">
              Commencer gratuitement
            </button>
          </div>

          <!-- Option 2 -->
          <div class="bg-[#0f0f1a]/60 border border-slate-800 p-5 sm:p-6 lg:p-8 rounded-2xl sm:rounded-3xl flex flex-col justify-between transition duration-300 hover:border-brandCyber/20">
            <div class="space-y-3 sm:space-y-4 lg:space-y-6">
              <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-300">Abonnement Semestriel</h3>
                <p class="text-[10px] sm:text-xs text-slate-500 mt-0.5 sm:mt-1">Pour valider un semestre</p>
              </div>
              <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-white">29 DT <span class="text-[10px] sm:text-xs font-normal text-slate-500">/ semestre</span></div>
              <ul class="space-y-1.5 sm:space-y-2 lg:space-y-3 text-xs sm:text-sm text-slate-400 border-t border-slate-800/80 pt-3 sm:pt-4 lg:pt-6">
                <li class="flex items-center gap-2 sm:gap-2.5 text-brandMint">✔ Accès complet aux modules du semestre</li>
                <li class="flex items-center gap-2 sm:gap-2.5">✔ Éditeur de code avancé et quêtes</li>
                <li class="flex items-center gap-2 sm:gap-2.5">✔ Sujets d'examens et fiches récapitulatives</li>
              </ul>
            </div>
            <button @click="openAuthModal('login')" class="w-full mt-4 sm:mt-6 lg:mt-8 bg-[#0a0a12] hover:bg-slate-800/80 text-white font-bold py-2.5 sm:py-3 px-4 rounded-lg sm:rounded-xl border border-slate-700 transition text-sm sm:text-base">
              S'abonner
            </button>
          </div>

          <!-- Option 3 -->
          <div class="bg-gradient-to-b from-[#0f0f1a] via-[#0f0f1a] to-[#0a0a12] border-2 border-brandCyber p-5 sm:p-6 lg:p-8 rounded-2xl sm:rounded-3xl flex flex-col justify-between relative shadow-2xl shadow-brandCyber/5 transition duration-300 hover:shadow-[0_20px_50px_rgba(253,224,71,0.05)] md:col-span-2 lg:col-span-1">
            <div class="absolute -top-2.5 sm:-top-3.5 right-3 sm:right-4 lg:right-6 bg-brandCyber text-slate-950 text-[8px] sm:text-[10px] font-black tracking-widest px-2 sm:px-3 py-0.5 sm:py-1 rounded-md shadow-md">MEILLEUR RAPPORT</div>
            <div class="space-y-3 sm:space-y-4 lg:space-y-6">
              <div>
                <h3 class="text-base sm:text-lg font-bold text-brandCyber">Pass Annuel Premium</h3>
                <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5 sm:mt-1">Tout le programme officiel</p>
              </div>
              <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-white">49 DT <span class="text-[10px] sm:text-xs font-normal text-slate-400">/ année</span></div>
              <ul class="space-y-1.5 sm:space-y-2 lg:space-y-3 text-xs sm:text-sm text-slate-300 border-t border-slate-800/80 pt-3 sm:pt-4 lg:pt-6">
                <li class="flex items-center gap-2 sm:gap-2.5 text-brandMint">✔ Programme officiel Python complet</li>
                <li class="flex items-center gap-2 sm:gap-2.5 text-brandMint">✔ Économise plus de 15%</li>
                <li class="flex items-center gap-2 sm:gap-2.5">✔ Accès illimité à tous les défis</li>
                <li class="flex items-center gap-2 sm:gap-2.5">✔ Sujets du bac pratique et corrections</li>
              </ul>
            </div>
            <div class="mt-4 sm:mt-6 lg:mt-8 space-y-2 sm:space-y-3 lg:space-y-4">
              <button @click="openAuthModal('register')" class="w-full bg-gradient-to-r from-brandCyber to-amber-400 text-slate-950 font-extrabold py-2.5 sm:py-3 px-4 rounded-lg sm:rounded-xl shadow-[0_0_15px_rgba(253,224,71,0.15)] hover:shadow-[0_0_25px_rgba(253,224,71,0.3)] transition text-sm sm:text-base">
                Débloquer l'accès
              </button>
              <p class="text-[8px] sm:text-[10px] text-slate-500 text-center tracking-wide">
                Paiement sécurisé via carte bancaire, E-Dinar, Flouci ou coupons.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FOOTER -->
    <footer class="border-t border-slate-800/60 py-6 sm:py-8 lg:py-12 bg-[#0a0a0f]/80 relative z-10 text-[10px] sm:text-xs text-slate-600">
      <div class="container mx-auto px-4 sm:px-6 max-w-7xl flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4 lg:gap-6">
        <div class="text-center sm:text-left">
          <span class="text-sm sm:text-base font-bold text-slate-300">Presenti<span class="text-brandCyber">ly</span></span>
          <p class="mt-0.5 sm:mt-1 text-[8px] sm:text-[10px]">© 2026. Tous droits réservés.</p>
        </div>
        <div class="flex flex-wrap justify-center gap-3 sm:gap-4 lg:gap-6 font-medium text-slate-500 text-[8px] sm:text-[10px] lg:text-xs">
          <a href="#" class="hover:text-brandCyber transition">Conditions d'utilisation</a>
          <a href="#" class="hover:text-brandCyber transition">Support & Contact</a>
        </div>
        <div class="flex items-center gap-1 text-slate-500 text-[8px] sm:text-[10px] lg:text-xs">
          <span>Codé avec</span>
          <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 lg:w-3.5 lg:h-3.5 text-red-500 fill-current" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
          <span>en Tunisie</span>
        </div>
      </div>
    </footer>

    <!-- MODAL D'AUTHENTIFICATION -->
    <AuthModal 
      :visible="authModalVisible"
      :mode="authModalMode"
      @update:visible="authModalVisible = $event"
      @update:mode="authModalMode = $event"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'
import gsap from 'gsap'
import AuthModal from './AuthModal.vue'

// Menu mobile
const mobileMenuOpen = ref(false)

// État du modal
const authModalVisible = ref(false)
const authModalMode = ref('register')

// Refs pour les animations
const dashboardMockup = ref(null)
const xpCard = ref(null)
const chapterCard = ref(null)
const leaderboardCard = ref(null)
const progressCircle = ref(null)
const xpCount = ref(null)

// Fonctions pour ouvrir/fermer le modal
function openAuthModal(mode = 'register') {
  authModalMode.value = mode
  authModalVisible.value = true
  mobileMenuOpen.value = false
}

// Animations au montage
onMounted(() => {
  const tl = gsap.timeline({ delay: 0.2 })
  
  tl.to(dashboardMockup.value, { 
    duration: 0.8, 
    opacity: 1, 
    y: 0, 
    ease: 'power3.out' 
  })
  
  tl.from([xpCard.value, chapterCard.value, leaderboardCard.value], { 
    duration: 0.5, 
    opacity: 0, 
    scale: 0.95, 
    y: 15, 
    stagger: 0.15, 
    ease: 'back.out(1.2)' 
  }, '-=0.4')
  
  tl.to(xpCount.value, { 
    duration: 1.5, 
    innerText: 1250, 
    snap: { innerText: 1 }, 
    ease: 'power2.out' 
  }, '-=0.2')
  
  const strokeDasharray = 251.2
  const targetOffset = strokeDasharray * (1 - 0.65)
  tl.to(progressCircle.value, { 
    duration: 1.5, 
    strokeDashoffset: targetOffset, 
    ease: 'power2.out' 
  }, '-=1.5')
})

// Exposer la fonction pour l'utiliser depuis d'autres composants
defineExpose({
  openAuthModal
})
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap');

body { 
  font-family: 'Plus Jakarta Sans', sans-serif; 
  scroll-behavior: smooth; 
  background-color: #0a0a0f;
  color: #e2e8f0;
}

* {
  max-width: 100vw;
  box-sizing: border-box;
}

html, body {
  overflow-x: hidden !important;
  width: 100% !important;
  max-width: 100% !important;
  margin: 0 !important;
  padding: 0 !important;
}

.container, .max-w-7xl {
  max-width: 100% !important;
}

.fixed {
  width: 100vw !important;
  max-width: 100vw !important;
  left: 0 !important;
}

.font-mono { font-family: 'JetBrains Mono', monospace; }

@keyframes shimmer { 100% { transform: translateX(100%); } }
.animate-shimmer { animation: shimmer 2s infinite; }
.progress-ring__circle { transition: stroke-dashoffset 0.35s; transform: rotate(-90deg); transform-origin: 50% 50%; }

.border-brandCyber {
  border-color: #FDE047 !important;
}

.group {
  transition: all 0.3s ease;
}

input:focus, select:focus {
  box-shadow: 0 0 0 2px rgba(253, 224, 71, 0.2);
  outline: none;
}

select option {
  background-color: #0a0a12;
  color: white;
}
</style>