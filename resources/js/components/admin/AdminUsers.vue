<template>
  <div class="space-y-6">
    <!-- Stats rapides -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
      <div class="bg-[#0f0f1a]/60 border border-slate-800 rounded-2xl p-4">
        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Total élèves</p>
        <p class="text-2xl font-extrabold text-white mt-1">{{ pagination.total }}</p>
      </div>
      <div class="bg-[#0f0f1a]/60 border border-brandMint/20 rounded-2xl p-4">
        <p class="text-[10px] font-bold text-brandMint uppercase tracking-wider">Vérifiés</p>
        <p class="text-2xl font-extrabold text-white mt-1">{{ verifiedCount }}</p>
      </div>
      <div class="bg-[#0f0f1a]/60 border border-yellow-500/20 rounded-2xl p-4">
        <p class="text-[10px] font-bold text-yellow-400 uppercase tracking-wider">Non vérifiés</p>
        <p class="text-2xl font-extrabold text-white mt-1">{{ unverifiedCount }}</p>
      </div>
      <div class="bg-[#0f0f1a]/60 border border-purple-500/20 rounded-2xl p-4">
        <p class="text-[10px] font-bold text-purple-400 uppercase tracking-wider">Ce mois</p>
        <p class="text-2xl font-extrabold text-white mt-1">{{ newThisMonth }}</p>
      </div>
    </div>

    <!-- Barre de recherche -->
    <div class="bg-[#0f0f1a]/60 border border-slate-800 rounded-2xl p-4 flex flex-col sm:flex-row gap-3">
      <div class="relative flex-1">
        <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-600" />
        <input
          v-model="search"
          @input="debouncedSearch"
          type="text"
          placeholder="Rechercher par nom, email ou établissement..."
          class="w-full pl-10 pr-4 py-2.5 bg-slate-900/60 border border-slate-800 rounded-xl text-sm text-white placeholder-slate-600 focus:outline-none focus:border-purple-500/40 transition"
        />
      </div>
      <button
        v-if="search"
        @click="clearSearch"
        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-900/60 border border-slate-800 rounded-xl text-xs font-semibold text-slate-400 hover:text-white hover:border-slate-700 transition"
      >
        <X class="w-3.5 h-3.5" />
        Effacer
      </button>
    </div>

    <!-- Loader -->
    <div v-if="loading" class="space-y-3">
      <div v-for="i in 5" :key="i" class="h-20 bg-slate-800/40 rounded-2xl animate-pulse"></div>
    </div>

    <!-- Liste -->
    <div v-else-if="users.length > 0" class="bg-[#0f0f1a]/60 border border-slate-800 rounded-2xl overflow-hidden">
      <!-- En-tête tableau (desktop) -->
      <div class="hidden lg:grid grid-cols-12 gap-4 px-5 py-3 bg-slate-900/40 border-b border-slate-800 text-[10px] font-bold text-slate-500 uppercase tracking-wider">
        <div class="col-span-4">Élève</div>
        <div class="col-span-3">Établissement</div>
        <div class="col-span-2">Niveau</div>
        <div class="col-span-2">Inscrit</div>
        <div class="col-span-1 text-right">Actions</div>
      </div>

      <!-- Lignes -->
      <div
        v-for="user in users"
        :key="user.id"
        class="grid grid-cols-1 lg:grid-cols-12 gap-4 px-5 py-4 border-b border-slate-800/60 last:border-0 hover:bg-slate-800/20 transition items-center"
      >
        <!-- Élève -->
        <div class="lg:col-span-4 flex items-center gap-3 min-w-0">
          <div class="w-10 h-10 rounded-full bg-brandCyber/10 border border-brandCyber/20 flex items-center justify-center flex-shrink-0">
            <span class="text-sm font-bold text-brandCyber">
              {{ user.name?.charAt(0)?.toUpperCase() || '?' }}
            </span>
          </div>
          <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2">
              <p class="text-sm font-semibold text-white truncate">{{ user.name }}</p>
              <CheckCircle2
                v-if="user.email_verified_at"
                class="w-3.5 h-3.5 text-brandMint flex-shrink-0"
                title="Email vérifié"
              />
              <Clock
                v-else
                class="w-3.5 h-3.5 text-yellow-400 flex-shrink-0"
                title="Email non vérifié"
              />
            </div>
            <p class="text-[11px] text-slate-500 truncate">{{ user.email }}</p>
          </div>
        </div>

        <!-- Établissement -->
        <div class="lg:col-span-3 min-w-0">
          <p class="text-xs text-slate-300 truncate">{{ user.school || '—' }}</p>
          <p class="text-[10px] text-slate-600">{{ user.governorate || '—' }}</p>
        </div>

        <!-- Niveau -->
        <div class="lg:col-span-2">
          <span class="inline-flex items-center gap-1 text-[10px] font-bold text-purple-400 bg-purple-500/10 border border-purple-500/20 px-2 py-1 rounded-full">
            <GraduationCap class="w-3 h-3" />
            {{ user.grade || '—' }}
          </span>
        </div>

        <!-- Date -->
        <div class="lg:col-span-2">
          <p class="text-xs text-slate-400">{{ formatDate(user.created_at) }}</p>
        </div>

        <!-- Actions -->
        <div class="lg:col-span-1 flex items-center justify-end gap-1">
          <button
            @click="openDetail(user)"
            class="p-2 text-slate-500 hover:text-white hover:bg-slate-800/60 rounded-lg transition"
            title="Voir détails"
          >
            <Eye class="w-4 h-4" />
          </button>
          <button
            @click="confirmDelete(user)"
            class="p-2 text-slate-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition"
            title="Supprimer"
          >
            <Trash2 class="w-4 h-4" />
          </button>
        </div>
      </div>
    </div>

    <!-- Aucun résultat -->
    <div v-else class="text-center py-16 bg-[#0f0f1a]/40 border border-slate-800 border-dashed rounded-2xl">
      <Users class="w-12 h-12 text-slate-700 mx-auto mb-3" />
      <p class="text-sm text-slate-500">
        {{ search ? 'Aucun élève trouvé' : 'Aucun élève inscrit' }}
      </p>
      <p v-if="search" class="text-xs text-slate-600 mt-1">
        Essaie avec un autre mot-clé
      </p>
    </div>

    <!-- Pagination -->
    <div v-if="pagination.last_page > 1" class="flex items-center justify-center gap-2">
      <button
        @click="goToPage(pagination.current_page - 1)"
        :disabled="pagination.current_page === 1"
        class="px-3 py-1.5 text-xs font-semibold bg-slate-900/60 border border-slate-800 rounded-lg text-slate-400 hover:text-white hover:border-slate-700 transition disabled:opacity-30 disabled:cursor-not-allowed"
      >
        ← Précédent
      </button>
      <span class="text-xs text-slate-500 px-3">
        Page {{ pagination.current_page }} / {{ pagination.last_page }}
      </span>
      <button
        @click="goToPage(pagination.current_page + 1)"
        :disabled="pagination.current_page === pagination.last_page"
        class="px-3 py-1.5 text-xs font-semibold bg-slate-900/60 border border-slate-800 rounded-lg text-slate-400 hover:text-white hover:border-slate-700 transition disabled:opacity-30 disabled:cursor-not-allowed"
      >
        Suivant →
      </button>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════ -->
  <!-- MODAL DÉTAIL ÉLÈVE                          -->
  <!-- ═══════════════════════════════════════════ -->
  <Teleport to="body">
    <div
      v-if="selectedUser"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
      @click.self="closeDetail"
    >
      <div class="w-full max-w-lg bg-[#0f0f1a] border border-slate-800 rounded-2xl shadow-2xl max-h-[90vh] flex flex-col">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800 flex-shrink-0">
          <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-full bg-brandCyber/10 border border-brandCyber/20 flex items-center justify-center">
              <span class="text-base font-bold text-brandCyber">
                {{ selectedUser.name?.charAt(0)?.toUpperCase() || '?' }}
              </span>
            </div>
            <div>
              <h3 class="text-sm font-bold text-white">{{ selectedUser.name }}</h3>
              <p class="text-[10px] text-slate-500">{{ selectedUser.email }}</p>
            </div>
          </div>
          <button @click="closeDetail" class="text-slate-500 hover:text-white transition">
            <X class="w-5 h-5" />
          </button>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-4 overflow-y-auto">
          <!-- Statut vérification -->
          <div
            :class="['flex items-center gap-3 p-3 rounded-xl border',
              selectedUser.email_verified_at
                ? 'bg-brandMint/5 border-brandMint/20'
                : 'bg-yellow-500/5 border-yellow-500/20']"
          >
            <CheckCircle2 v-if="selectedUser.email_verified_at" class="w-5 h-5 text-brandMint flex-shrink-0" />
            <Clock v-else class="w-5 h-5 text-yellow-400 flex-shrink-0" />
            <p :class="['text-xs font-semibold',
              selectedUser.email_verified_at ? 'text-brandMint' : 'text-yellow-400']">
              {{ selectedUser.email_verified_at ? 'Email vérifié' : 'Email non vérifié' }}
            </p>
          </div>

          <!-- Infos -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="p-3 bg-slate-900/40 border border-slate-800 rounded-xl">
              <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Établissement</p>
              <p class="text-sm text-slate-200">{{ selectedUser.school || '—' }}</p>
            </div>
            <div class="p-3 bg-slate-900/40 border border-slate-800 rounded-xl">
              <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Niveau</p>
              <p class="text-sm text-slate-200">{{ selectedUser.grade || '—' }}</p>
            </div>
            <div class="p-3 bg-slate-900/40 border border-slate-800 rounded-xl">
              <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Gouvernorat</p>
              <p class="text-sm text-slate-200">{{ selectedUser.governorate || '—' }}</p>
            </div>
            <div class="p-3 bg-slate-900/40 border border-slate-800 rounded-xl">
              <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Âge</p>
              <p class="text-sm text-slate-200">{{ selectedUser.age || '—' }} ans</p>
            </div>
            <div class="p-3 bg-slate-900/40 border border-slate-800 rounded-xl">
              <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">XP Total</p>
              <p class="text-sm text-brandCyber font-bold">{{ selectedUser.total_xp || 0 }}</p>
            </div>
            <div class="p-3 bg-slate-900/40 border border-slate-800 rounded-xl">
              <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Série</p>
              <p class="text-sm text-orange-400 font-bold">{{ selectedUser.streak_days || 0 }} jours</p>
            </div>
          </div>

          <!-- Date d'inscription -->
          <div class="p-3 bg-slate-900/40 border border-slate-800 rounded-xl">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Inscrit le</p>
            <p class="text-sm text-slate-200">{{ formatDateFull(selectedUser.created_at) }}</p>
          </div>
        </div>

        <!-- Footer -->
        <div class="flex items-center justify-between gap-3 px-6 py-4 border-t border-slate-800 flex-shrink-0">
          <button
            @click="confirmDelete(selectedUser)"
            class="inline-flex items-center gap-2 px-3 py-2 text-xs font-semibold text-red-400 hover:bg-red-500/10 rounded-lg transition"
          >
            <Trash2 class="w-3.5 h-3.5" />
            Supprimer
          </button>
          <button
            @click="closeDetail"
            class="px-4 py-2 text-sm font-semibold text-slate-400 hover:text-white transition"
          >
            Fermer
          </button>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '../../plugins/axios'
import {
  Users, Search, X, Eye, Trash2,
  CheckCircle2, Clock, GraduationCap
} from 'lucide-vue-next'

// ─── État ─────────────────────────────────────
const loading = ref(true)
const users = ref([])
const search = ref('')
const selectedUser = ref(null)

const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 20,
  total: 0,
})

// ─── Computed ─────────────────────────────────
const verifiedCount = computed(() =>
  users.value.filter(u => u.email_verified_at).length
)

const unverifiedCount = computed(() =>
  users.value.filter(u => !u.email_verified_at).length
)

const newThisMonth = computed(() => {
  const now = new Date()
  const firstOfMonth = new Date(now.getFullYear(), now.getMonth(), 1)
  return users.value.filter(u => new Date(u.created_at) >= firstOfMonth).length
})

// ─── Helpers ──────────────────────────────────
const formatDate = (d) => new Date(d).toLocaleDateString('fr-FR', {
  day: '2-digit', month: 'short', year: 'numeric'
})

const formatDateFull = (d) => new Date(d).toLocaleDateString('fr-FR', {
  day: '2-digit', month: 'long', year: 'numeric',
  hour: '2-digit', minute: '2-digit'
})

// ─── Chargement ───────────────────────────────
const loadUsers = async (page = 1) => {
  loading.value = true
  try {
    const params = { page, per_page: 20 }
    if (search.value.trim()) params.search = search.value.trim()

    const { data } = await api.get('/admin/users', { params })
    if (data.success) {
      users.value = data.users.data
      pagination.value = {
        current_page: data.users.current_page,
        last_page: data.users.last_page,
        per_page: data.users.per_page,
        total: data.users.total,
      }
    }
  } catch (error) {
    console.error('Erreur chargement utilisateurs:', error)
  } finally {
    loading.value = false
  }
}

// ─── Recherche (debounce) ─────────────────────
let searchTimeout = null
const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => loadUsers(1), 400)
}

const clearSearch = () => {
  search.value = ''
  loadUsers(1)
}

// ─── Pagination ───────────────────────────────
const goToPage = (page) => {
  if (page < 1 || page > pagination.value.last_page) return
  loadUsers(page)
}

// ─── Détail ───────────────────────────────────
const openDetail = (user) => { selectedUser.value = user }
const closeDetail = () => { selectedUser.value = null }

// ─── Suppression ──────────────────────────────
const confirmDelete = async (user) => {
  if (!confirm(`Supprimer définitivement l'élève "${user.name}" ?\n\nCette action est irréversible.`)) return
  try {
    const { data } = await api.delete(`/admin/users/${user.id}`)
    if (data.success) {
      if (selectedUser.value?.id === user.id) closeDetail()
      users.value = users.value.filter(u => u.id !== user.id)
      loadUsers(pagination.value.current_page)
    }
  } catch (error) {
    console.error('Erreur suppression:', error)
    alert(error.response?.data?.message || 'Impossible de supprimer cet élève.')
  }
}

// ─── Lifecycle ────────────────────────────────
onMounted(() => loadUsers())
</script>