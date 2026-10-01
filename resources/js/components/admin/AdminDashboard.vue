<template>
  <div v-if="loading" class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div v-for="i in 4" :key="i" class="h-32 bg-slate-800/40 rounded-2xl animate-pulse"></div>
  </div>

  <div v-else class="space-y-6">
    <!-- Stats cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-[#0f0f1a]/60 border border-slate-800 rounded-2xl p-5">
        <div class="w-10 h-10 bg-brandCyber/10 border border-brandCyber/20 rounded-xl flex items-center justify-center mb-3">
          <Users class="w-5 h-5 text-brandCyber" />
        </div>
        <p class="text-xs text-slate-500">Élèves inscrits</p>
        <p class="text-2xl font-extrabold text-white mt-1">{{ stats.total_users }}</p>
        <p class="text-[10px] text-brandMint mt-2">+{{ stats.new_users_this_month }} ce mois</p>
      </div>

      <div class="bg-[#0f0f1a]/60 border border-slate-800 rounded-2xl p-5">
        <div class="w-10 h-10 bg-purple-500/10 border border-purple-500/20 rounded-xl flex items-center justify-center mb-3">
          <MessageSquare class="w-5 h-5 text-purple-400" />
        </div>
        <p class="text-xs text-slate-500">Messages totaux</p>
        <p class="text-2xl font-extrabold text-white mt-1">{{ stats.total_messages }}</p>
      </div>

      <div class="bg-[#0f0f1a]/60 border border-yellow-500/20 rounded-2xl p-5">
        <div class="w-10 h-10 bg-yellow-500/10 border border-yellow-500/20 rounded-xl flex items-center justify-center mb-3">
          <Clock class="w-5 h-5 text-yellow-400" />
        </div>
        <p class="text-xs text-slate-500">En attente</p>
        <p class="text-2xl font-extrabold text-white mt-1">{{ stats.pending_messages }}</p>
      </div>

      <div class="bg-[#0f0f1a]/60 border border-brandMint/20 rounded-2xl p-5">
        <div class="w-10 h-10 bg-brandMint/10 border border-brandMint/20 rounded-xl flex items-center justify-center mb-3">
          <CheckCircle2 class="w-5 h-5 text-brandMint" />
        </div>
        <p class="text-xs text-slate-500">Résolus</p>
        <p class="text-2xl font-extrabold text-white mt-1">{{ stats.resolved_messages }}</p>
      </div>
    </div>

    <!-- Répartition -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Top établissements -->
      <div class="bg-[#0f0f1a]/60 border border-slate-800 rounded-2xl p-6">
        <h3 class="text-sm font-bold text-white mb-4">Top établissements</h3>
        <div v-if="topSchools.length > 0" class="space-y-3">
          <div v-for="(school, i) in topSchools" :key="i" class="flex items-center gap-3">
            <div class="w-7 h-7 rounded-lg bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-xs font-bold text-purple-400">
              {{ i + 1 }}
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm text-slate-300 truncate">{{ school.school }}</p>
            </div>
            <span class="text-xs font-bold text-slate-400">{{ school.total }}</span>
          </div>
        </div>
        <p v-else class="text-xs text-slate-500 italic text-center py-4">Aucune donnée</p>
      </div>

      <!-- Types de messages -->
      <div class="bg-[#0f0f1a]/60 border border-slate-800 rounded-2xl p-6">
        <h3 class="text-sm font-bold text-white mb-4">Répartition des messages</h3>
        <div class="space-y-4">
          <div>
            <div class="flex items-center justify-between mb-1.5">
              <span class="text-xs text-slate-400 flex items-center gap-2">
                <MessageSquare class="w-3.5 h-3.5 text-brandCyber" /> Avis
              </span>
              <span class="text-xs font-bold text-white">{{ stats.avis }}</span>
            </div>
            <div class="w-full bg-slate-800 rounded-full h-1.5">
              <div class="bg-brandCyber h-full rounded-full transition-all duration-500" :style="{ width: percentage(stats.avis) + '%' }"></div>
            </div>
          </div>
          <div>
            <div class="flex items-center justify-between mb-1.5">
              <span class="text-xs text-slate-400 flex items-center gap-2">
                <AlertCircle class="w-3.5 h-3.5 text-red-400" /> Réclamations
              </span>
              <span class="text-xs font-bold text-white">{{ stats.reclamation }}</span>
            </div>
            <div class="w-full bg-slate-800 rounded-full h-1.5">
              <div class="bg-red-400 h-full rounded-full transition-all duration-500" :style="{ width: percentage(stats.reclamation) + '%' }"></div>
            </div>
          </div>

          <!-- Résumé statuts -->
          <div class="pt-4 mt-4 border-t border-slate-800 grid grid-cols-3 gap-2">
            <div class="text-center p-2 bg-yellow-500/5 border border-yellow-500/20 rounded-lg">
              <p class="text-[10px] font-bold text-yellow-400 uppercase">En attente</p>
              <p class="text-lg font-extrabold text-white mt-1">{{ stats.pending_messages }}</p>
            </div>
            <div class="text-center p-2 bg-blue-500/5 border border-blue-500/20 rounded-lg">
              <p class="text-[10px] font-bold text-blue-400 uppercase">En cours</p>
              <p class="text-lg font-extrabold text-white mt-1">{{ stats.en_cours || 0 }}</p>
            </div>
            <div class="text-center p-2 bg-brandMint/5 border border-brandMint/20 rounded-lg">
              <p class="text-[10px] font-bold text-brandMint uppercase">Résolus</p>
              <p class="text-lg font-extrabold text-white mt-1">{{ stats.resolved_messages }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Activité 7 derniers jours -->
    <div class="bg-[#0f0f1a]/60 border border-slate-800 rounded-2xl p-6">
      <div class="flex items-center justify-between mb-5">
        <h3 class="text-sm font-bold text-white">Messages reçus (7 derniers jours)</h3>
        <span class="text-[10px] text-slate-500">
          Total : {{ totalWeekMessages }}
        </span>
      </div>

      <div v-if="messagesPerDay.length > 0" class="flex items-end justify-between gap-2 h-32">
        <div
          v-for="(day, i) in messagesPerDay"
          :key="i"
          class="flex-1 flex flex-col items-center gap-2 group"
        >
          <div class="w-full flex-1 flex items-end">
            <div
              class="w-full bg-gradient-to-t from-purple-500 to-brandCyber rounded-t-lg transition-all duration-500 hover:from-purple-400 hover:to-brandCyber relative"
              :style="{ height: barHeight(day.total) + '%', minHeight: day.total > 0 ? '4px' : '2px' }"
            >
              <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-white opacity-0 group-hover:opacity-100 transition">
                {{ day.total }}
              </span>
            </div>
          </div>
          <span class="text-[10px] text-slate-500 font-medium">
            {{ formatDayLabel(day.date) }}
          </span>
        </div>
      </div>

      <p v-else class="text-xs text-slate-500 italic text-center py-8">
        Aucune activité sur les 7 derniers jours
      </p>
    </div>

    <!-- Actions rapides -->
    <div class="bg-gradient-to-br from-purple-500/10 via-transparent to-brandCyber/5 border border-purple-500/20 rounded-2xl p-6">
      <div class="flex items-start justify-between gap-4 mb-4">
        <div>
          <h3 class="text-sm font-bold text-white flex items-center gap-2">
            <Sparkles class="w-4 h-4 text-purple-400" />
            Actions rapides
          </h3>
          <p class="text-xs text-slate-500 mt-1">
            Accède rapidement aux tâches les plus courantes
          </p>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <router-link
          to="/admin/messages?status=en_attente"
          class="group flex items-center gap-3 p-4 bg-[#0f0f1a]/60 border border-slate-800 rounded-xl hover:border-yellow-500/40 transition"
        >
          <div class="w-10 h-10 rounded-xl bg-yellow-500/10 border border-yellow-500/20 flex items-center justify-center flex-shrink-0">
            <Clock class="w-5 h-5 text-yellow-400" />
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-bold text-white">Traiter les messages</p>
            <p class="text-[10px] text-slate-500 mt-0.5">
              {{ stats.pending_messages }} en attente
            </p>
          </div>
          <ArrowRight class="w-4 h-4 text-slate-600 group-hover:text-yellow-400 group-hover:translate-x-1 transition" />
        </router-link>

        <router-link
          to="/admin/messages?type=reclamation"
          class="group flex items-center gap-3 p-4 bg-[#0f0f1a]/60 border border-slate-800 rounded-xl hover:border-red-500/40 transition"
        >
          <div class="w-10 h-10 rounded-xl bg-red-500/10 border border-red-500/20 flex items-center justify-center flex-shrink-0">
            <AlertCircle class="w-5 h-5 text-red-400" />
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-bold text-white">Réclamations</p>
            <p class="text-[10px] text-slate-500 mt-0.5">
              {{ stats.reclamation }} au total
            </p>
          </div>
          <ArrowRight class="w-4 h-4 text-slate-600 group-hover:text-red-400 group-hover:translate-x-1 transition" />
        </router-link>

        <router-link
          to="/admin/users"
          class="group flex items-center gap-3 p-4 bg-[#0f0f1a]/60 border border-slate-800 rounded-xl hover:border-brandCyber/40 transition"
        >
          <div class="w-10 h-10 rounded-xl bg-brandCyber/10 border border-brandCyber/20 flex items-center justify-center flex-shrink-0">
            <Users class="w-5 h-5 text-brandCyber" />
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-bold text-white">Gérer les élèves</p>
            <p class="text-[10px] text-slate-500 mt-0.5">
              {{ stats.total_users }} inscrits
            </p>
          </div>
          <ArrowRight class="w-4 h-4 text-slate-600 group-hover:text-brandCyber group-hover:translate-x-1 transition" />
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '../../plugins/axios'
import {
  Users, MessageSquare, Clock, CheckCircle2, AlertCircle,
  Sparkles, ArrowRight
} from 'lucide-vue-next'

// ─── État ─────────────────────────────────────
const loading = ref(true)

const stats = ref({
  total_users: 0,
  total_messages: 0,
  pending_messages: 0,
  resolved_messages: 0,
  new_users_this_month: 0,
  avis: 0,
  reclamation: 0,
  en_cours: 0,
})

const topSchools = ref([])
const messagesPerDay = ref([])

// ─── Computed ─────────────────────────────────
const maxMessagesPerDay = computed(() => {
  if (messagesPerDay.value.length === 0) return 1
  return Math.max(...messagesPerDay.value.map(d => d.total), 1)
})

const totalWeekMessages = computed(() =>
  messagesPerDay.value.reduce((sum, d) => sum + d.total, 0)
)

// ─── Helpers ──────────────────────────────────
const percentage = (value) => {
  if (!stats.value.total_messages) return 0
  return Math.round((value / stats.value.total_messages) * 100)
}

const barHeight = (value) => {
  if (maxMessagesPerDay.value === 0) return 0
  return Math.round((value / maxMessagesPerDay.value) * 100)
}

const formatDayLabel = (dateStr) => {
  const d = new Date(dateStr)
  return d.toLocaleDateString('fr-FR', { weekday: 'short' })
}

// ─── Chargement ───────────────────────────────
const loadStats = async () => {
  loading.value = true
  try {
    const { data } = await api.get('/admin/stats')
    if (data.success) {
      stats.value = { ...stats.value, ...data.stats }
      topSchools.value = data.top_schools || []
      messagesPerDay.value = data.messages_per_day || []
    }
  } catch (error) {
    console.error('Erreur chargement stats admin:', error)
    console.error('Status:', error.response?.status)
    console.error('Data:', error.response?.data)
  } finally {
    loading.value = false
  }
}

// ─── Lifecycle ────────────────────────────────
onMounted(loadStats)
</script>