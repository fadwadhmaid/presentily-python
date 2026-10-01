<template>
  <div class="min-h-screen bg-[#0a0a0f] text-white">
    <div class="fixed top-[-10%] left-[-5%] w-[45vw] h-[500px] bg-purple-500/5 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- SIDEBAR ADMIN -->
    <aside class="fixed top-0 left-0 h-full w-64 bg-[#0f0f1a]/95 backdrop-blur-xl border-r border-slate-800 hidden md:flex flex-col z-30">
      <div class="flex items-center gap-2 px-6 py-6 border-b border-slate-800/60">
        <ShieldCheck class="w-6 h-6 text-purple-400" />
        <span class="text-lg font-extrabold tracking-tight text-white">
          Admin<span class="text-purple-400">Panel</span>
        </span>
      </div>

      <nav class="flex-1 px-4 py-6 space-y-1">
        <router-link to="/admin/dashboard" class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition" active-class="bg-purple-500/10 text-purple-400 border border-purple-500/20">
          <LayoutDashboard class="w-5 h-5" />
          <span class="font-medium text-sm">Dashboard</span>
        </router-link>

        <router-link to="/admin/messages" class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition" active-class="bg-purple-500/10 text-purple-400 border border-purple-500/20">
          <MessageSquare class="w-5 h-5" />
          <span class="font-medium text-sm">Messages</span>
          <span v-if="pendingCount > 0" class="ml-auto text-[10px] bg-red-500/20 text-red-400 px-2 py-0.5 rounded-full">
            {{ pendingCount }}
          </span>
        </router-link>

        <router-link to="/admin/users" class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition" active-class="bg-purple-500/10 text-purple-400 border border-purple-500/20">
          <Users class="w-5 h-5" />
          <span class="font-medium text-sm">Utilisateurs</span>
        </router-link>
      </nav>

      <div class="px-4 py-4 border-t border-slate-800/60">
        <div class="flex items-center gap-3 px-3 py-2 mb-2">
          <div class="w-8 h-8 rounded-full bg-purple-500/20 border border-purple-500/30 flex items-center justify-center">
            <User class="w-4 h-4 text-purple-400" />
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-xs font-semibold text-white truncate">{{ adminUser.name }}</p>
            <p class="text-[10px] text-slate-500">Administrateur</p>
          </div>
        </div>
        <button @click="logout" class="flex items-center gap-3 px-4 py-2.5 w-full rounded-xl text-red-400 hover:bg-red-500/10 transition">
          <LogOut class="w-5 h-5" />
          <span class="font-medium text-sm">Déconnexion</span>
        </button>
      </div>
    </aside>

    <!-- CONTENU -->
    <main class="md:ml-64 relative z-10">
      <header class="sticky top-0 z-20 bg-[#0a0a0f]/80 backdrop-blur-xl border-b border-slate-800/60 px-6 py-4">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-lg font-bold text-white">{{ pageTitle }}</h1>
            <p class="text-xs text-slate-500">Panneau d'administration</p>
          </div>
          <span class="text-[10px] font-bold text-purple-400 bg-purple-500/10 border border-purple-500/20 px-3 py-1.5 rounded-full flex items-center gap-2">
            <ShieldCheck class="w-3.5 h-3.5" />
            ADMIN
          </span>
        </div>
      </header>

      <div class="p-6">
        <router-view />
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import api from '../../plugins/axios'
import {
  ShieldCheck, LayoutDashboard, MessageSquare, Users,
  LogOut, User
} from 'lucide-vue-next'

const router = useRouter()
const route = useRoute()
const adminUser = ref(JSON.parse(localStorage.getItem('user') || '{}'))
const pendingCount = ref(0)

const pageTitle = computed(() => {
  const titles = {
    AdminDashboard: 'Tableau de bord',
    AdminMessages: 'Gestion des messages',
    AdminUsers: 'Gestion des utilisateurs',
  }
  return titles[route.name] || 'Admin'
})

const loadPendingCount = async () => {
  try {
    const { data } = await api.get('/admin/stats')
    if (data.success) {
      pendingCount.value = data.stats.pending_messages
    }
  } catch (e) {}
}

const logout = async () => {
  try { await api.post('/logout') } catch (e) {}
  localStorage.removeItem('token')
  localStorage.removeItem('user')
  router.push('/')          // 👈 retour à l'accueil (login commun)
}

onMounted(loadPendingCount)
</script>