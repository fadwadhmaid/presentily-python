<template>
  <div class="space-y-6">
    <!-- Stats rapides -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
      <button
        @click="setFilter('status', '')"
        :class="['text-left bg-[#0f0f1a]/60 border rounded-2xl p-4 transition',
          filters.status === '' ? 'border-purple-500/40 bg-purple-500/5' : 'border-slate-800 hover:border-slate-700']"
      >
        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Tous</p>
        <p class="text-xl font-extrabold text-white mt-1">{{ stats.total }}</p>
      </button>

      <button
        @click="setFilter('status', 'en_attente')"
        :class="['text-left bg-[#0f0f1a]/60 border rounded-2xl p-4 transition',
          filters.status === 'en_attente' ? 'border-yellow-500/40 bg-yellow-500/5' : 'border-slate-800 hover:border-yellow-500/30']"
      >
        <p class="text-[10px] font-bold text-yellow-400 uppercase tracking-wider">En attente</p>
        <p class="text-xl font-extrabold text-white mt-1">{{ stats.en_attente }}</p>
      </button>

      <button
        @click="setFilter('status', 'en_cours')"
        :class="['text-left bg-[#0f0f1a]/60 border rounded-2xl p-4 transition',
          filters.status === 'en_cours' ? 'border-blue-500/40 bg-blue-500/5' : 'border-slate-800 hover:border-blue-500/30']"
      >
        <p class="text-[10px] font-bold text-blue-400 uppercase tracking-wider">En cours</p>
        <p class="text-xl font-extrabold text-white mt-1">{{ stats.en_cours }}</p>
      </button>

      <button
        @click="setFilter('status', 'resolu')"
        :class="['text-left bg-[#0f0f1a]/60 border rounded-2xl p-4 transition',
          filters.status === 'resolu' ? 'border-brandMint/40 bg-brandMint/5' : 'border-slate-800 hover:border-brandMint/30']"
      >
        <p class="text-[10px] font-bold text-brandMint uppercase tracking-wider">Résolus</p>
        <p class="text-xl font-extrabold text-white mt-1">{{ stats.resolu }}</p>
      </button>
    </div>

    <!-- Barre de filtres -->
    <div class="bg-[#0f0f1a]/60 border border-slate-800 rounded-2xl p-4 flex flex-col sm:flex-row gap-3">
      <!-- Recherche -->
      <div class="relative flex-1">
        <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-600" />
        <input
          v-model="filters.search"
          @input="debouncedSearch"
          type="text"
          placeholder="Rechercher par sujet, contenu ou élève..."
          class="w-full pl-10 pr-4 py-2.5 bg-slate-900/60 border border-slate-800 rounded-xl text-sm text-white placeholder-slate-600 focus:outline-none focus:border-purple-500/40 transition"
        />
      </div>

      <!-- Type -->
      <select
        v-model="filters.type"
        @change="loadMessages"
        class="px-4 py-2.5 bg-slate-900/60 border border-slate-800 rounded-xl text-sm text-white focus:outline-none focus:border-purple-500/40 transition"
      >
        <option value="">Tous les types</option>
        <option value="avis">Avis</option>
        <option value="reclamation">Réclamations</option>
      </select>

      <!-- Reset -->
      <button
        v-if="hasActiveFilters"
        @click="resetFilters"
        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-900/60 border border-slate-800 rounded-xl text-xs font-semibold text-slate-400 hover:text-white hover:border-slate-700 transition"
      >
        <X class="w-3.5 h-3.5" />
        Réinitialiser
      </button>
    </div>

    <!-- Liste des messages -->
    <div v-if="loading" class="space-y-3">
      <div v-for="i in 3" :key="i" class="h-32 bg-slate-800/40 rounded-2xl animate-pulse"></div>
    </div>

    <div v-else-if="messages.length > 0" class="space-y-3">
      <div
        v-for="msg in messages"
        :key="msg.id"
        class="bg-[#0f0f1a]/60 border border-slate-800 rounded-2xl p-5 hover:border-slate-700 transition"
      >
        <div class="flex items-start justify-between gap-4 mb-3">
          <div class="flex items-start gap-3 flex-1 min-w-0">
            <!-- Avatar élève -->
            <div class="w-10 h-10 rounded-full bg-brandCyber/10 border border-brandCyber/20 flex items-center justify-center flex-shrink-0">
              <span class="text-sm font-bold text-brandCyber">
                {{ msg.user?.name?.charAt(0)?.toUpperCase() || '?' }}
              </span>
            </div>

            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 flex-wrap mb-1.5">
                <span :class="['text-[10px] font-bold px-2 py-0.5 rounded-full border', getTypeClass(msg.type)]">
                  {{ getTypeLabel(msg.type) }}
                </span>
                <span :class="['text-[10px] font-bold px-2 py-0.5 rounded-full border', getStatusClass(msg.status)]">
                  {{ getStatusLabel(msg.status) }}
                </span>
                <span class="text-[10px] text-slate-500">#{{ msg.id }}</span>
              </div>

              <h3 class="text-sm font-bold text-white mb-1 truncate">{{ msg.subject }}</h3>
              <p class="text-xs text-slate-500">
                <span class="font-semibold text-slate-400">{{ msg.user?.name || 'Anonyme' }}</span>
                · {{ msg.user?.email }}
                <span v-if="msg.user?.school"> · {{ msg.user.school }}</span>
              </p>
            </div>
          </div>

          <div class="flex items-center gap-1 flex-shrink-0">
            <button
              @click="openDetail(msg)"
              class="p-2 text-slate-500 hover:text-white hover:bg-slate-800/60 rounded-lg transition"
              title="Voir / Répondre"
            >
              <Eye class="w-4 h-4" />
            </button>
            <button
              @click="confirmDelete(msg)"
              class="p-2 text-slate-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition"
              title="Supprimer"
            >
              <Trash2 class="w-4 h-4" />
            </button>
          </div>
        </div>

        <p class="text-xs text-slate-400 line-clamp-2 mb-3">{{ msg.content }}</p>

        <!-- Réponse admin (si existante) -->
        <div v-if="msg.admin_reply" class="p-3 bg-brandMint/5 border border-brandMint/20 rounded-xl">
          <p class="text-[10px] font-bold text-brandMint uppercase tracking-wider mb-1 flex items-center gap-1.5">
            <CheckCircle2 class="w-3 h-3" />
            Réponse envoyée
          </p>
          <p class="text-xs text-slate-300 line-clamp-2">{{ msg.admin_reply }}</p>
        </div>

        <div class="flex items-center justify-between mt-3 pt-3 border-t border-slate-800/60">
          <span class="text-[10px] text-slate-600">{{ formatDate(msg.created_at) }}</span>

          <!-- Actions rapides de statut -->
          <div class="flex items-center gap-1">
            <button
              v-for="s in statusOptions"
              :key="s.value"
              @click="quickChangeStatus(msg, s.value)"
              :disabled="msg.status === s.value"
              :class="['text-[10px] font-bold px-2 py-1 rounded-lg border transition disabled:opacity-30 disabled:cursor-not-allowed',
                s.class]"
            >
              {{ s.label }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="text-center py-16 bg-[#0f0f1a]/40 border border-slate-800 border-dashed rounded-2xl">
      <MessageSquare class="w-12 h-12 text-slate-700 mx-auto mb-3" />
      <p class="text-sm text-slate-500">Aucun message trouvé</p>
      <p class="text-xs text-slate-600 mt-1">Essayez de modifier vos filtres</p>
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
  <!-- MODAL DÉTAIL + RÉPONSE                      -->
  <!-- ═══════════════════════════════════════════ -->
  <Teleport to="body">
    <div
      v-if="selectedMessage"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
      @click.self="closeDetail"
    >
      <div class="w-full max-w-2xl bg-[#0f0f1a] border border-slate-800 rounded-2xl shadow-2xl max-h-[90vh] flex flex-col">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800 flex-shrink-0">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center">
              <MessageSquare class="w-5 h-5 text-purple-400" />
            </div>
            <div>
              <h3 class="text-sm font-bold text-white">Message #{{ selectedMessage.id }}</h3>
              <p class="text-[10px] text-slate-500">
                {{ formatDate(selectedMessage.created_at) }}
              </p>
            </div>
          </div>
          <button @click="closeDetail" class="text-slate-500 hover:text-white transition">
            <X class="w-5 h-5" />
          </button>
        </div>

        <!-- Body scrollable -->
        <div class="p-6 space-y-5 overflow-y-auto flex-1">
          <!-- Badges -->
          <div class="flex items-center gap-2 flex-wrap">
            <span :class="['text-[10px] font-bold px-2.5 py-1 rounded-full border', getTypeClass(selectedMessage.type)]">
              {{ getTypeLabel(selectedMessage.type) }}
            </span>
            <span :class="['text-[10px] font-bold px-2.5 py-1 rounded-full border', getStatusClass(selectedMessage.status)]">
              {{ getStatusLabel(selectedMessage.status) }}
            </span>
          </div>

          <!-- Infos élève -->
          <div class="p-4 bg-slate-900/40 border border-slate-800 rounded-xl">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">
              Élève
            </p>
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-brandCyber/10 border border-brandCyber/20 flex items-center justify-center flex-shrink-0">
                <span class="text-sm font-bold text-brandCyber">
                  {{ selectedMessage.user?.name?.charAt(0)?.toUpperCase() || '?' }}
                </span>
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white">{{ selectedMessage.user?.name }}</p>
                <p class="text-xs text-slate-500 truncate">{{ selectedMessage.user?.email }}</p>
              </div>
            </div>
            <div v-if="selectedMessage.user?.school || selectedMessage.user?.grade" class="mt-3 pt-3 border-t border-slate-800 flex items-center gap-4 text-xs text-slate-500">
              <span v-if="selectedMessage.user?.school">🏫 {{ selectedMessage.user.school }}</span>
              <span v-if="selectedMessage.user?.grade">🎓 {{ selectedMessage.user.grade }}</span>
            </div>
          </div>

          <!-- Sujet -->
          <div>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Sujet</p>
            <p class="text-sm font-bold text-white">{{ selectedMessage.subject }}</p>
          </div>

          <!-- Contenu -->
          <div>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Message</p>
            <div class="p-4 bg-slate-900/40 border border-slate-800 rounded-xl">
              <p class="text-sm text-slate-300 whitespace-pre-line leading-relaxed">{{ selectedMessage.content }}</p>
            </div>
          </div>

          <!-- Réponse existante -->
          <div v-if="selectedMessage.admin_reply" class="p-4 bg-brandMint/5 border border-brandMint/20 rounded-xl">
            <p class="text-[10px] font-bold text-brandMint uppercase tracking-wider mb-2 flex items-center gap-1.5">
              <CheckCircle2 class="w-3.5 h-3.5" />
              Réponse envoyée
            </p>
            <p class="text-sm text-slate-300 whitespace-pre-line">{{ selectedMessage.admin_reply }}</p>
            <p v-if="selectedMessage.replied_at" class="text-[10px] text-slate-600 mt-2">
              Le {{ formatDate(selectedMessage.replied_at) }}
            </p>
          </div>

          <!-- Formulaire de réponse -->
          <div class="pt-4 border-t border-slate-800">
            <label class="block text-xs font-semibold text-slate-400 mb-2">
              {{ selectedMessage.admin_reply ? 'Modifier la réponse' : 'Votre réponse' }}
              <span class="text-slate-600 font-normal ml-1">({{ replyForm.admin_reply.length }}/2000)</span>
            </label>
            <textarea
              v-model="replyForm.admin_reply"
              rows="4"
              maxlength="2000"
              placeholder="Rédigez votre réponse à l'élève..."
              class="w-full px-4 py-2.5 bg-slate-900/60 border border-slate-800 rounded-xl text-sm text-white placeholder-slate-600 focus:outline-none focus:border-purple-500/40 transition resize-none"
            ></textarea>

            <!-- Statut associé -->
            <div class="mt-3">
              <label class="block text-xs font-semibold text-slate-400 mb-2">
                Statut à appliquer
              </label>
              <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                <button
                  v-for="s in statusOptions"
                  :key="s.value"
                  @click="replyForm.status = s.value"
                  :class="['py-2 rounded-xl border text-xs font-semibold transition',
                    replyForm.status === s.value ? s.class + ' ring-1 ring-white/10' : 'bg-slate-900/40 border-slate-800 text-slate-400 hover:border-slate-700']"
                >
                  {{ s.label }}
                </button>
              </div>
            </div>

            <!-- Feedback -->
            <div v-if="replyError" class="mt-3 p-3 bg-red-500/10 border border-red-500/20 rounded-xl flex items-start gap-2">
              <AlertCircle class="w-4 h-4 text-red-400 flex-shrink-0 mt-0.5" />
              <p class="text-xs text-red-400">{{ replyError }}</p>
            </div>
            <div v-if="replySuccess" class="mt-3 p-3 bg-brandMint/10 border border-brandMint/20 rounded-xl flex items-start gap-2">
              <CheckCircle2 class="w-4 h-4 text-brandMint flex-shrink-0 mt-0.5" />
              <p class="text-xs text-brandMint">{{ replySuccess }}</p>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div class="flex items-center justify-between gap-3 px-6 py-4 border-t border-slate-800 flex-shrink-0">
          <button
            @click="confirmDelete(selectedMessage)"
            class="inline-flex items-center gap-2 px-3 py-2 text-xs font-semibold text-red-400 hover:bg-red-500/10 rounded-lg transition"
          >
            <Trash2 class="w-3.5 h-3.5" />
            Supprimer
          </button>

          <div class="flex items-center gap-2">
            <button
              @click="closeDetail"
              class="px-4 py-2 text-sm font-semibold text-slate-400 hover:text-white transition"
            >
              Annuler
            </button>
            <button
              @click="submitReply"
              :disabled="sendingReply || !replyForm.admin_reply.trim()"
              class="inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-purple-500 to-brandCyber text-white font-bold text-sm rounded-xl hover:shadow-[0_0_20px_rgba(168,85,247,0.3)] transition disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <Send class="w-4 h-4" />
              {{ sendingReply ? 'Envoi...' : 'Envoyer la réponse' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import api from '../../plugins/axios'
import {
  MessageSquare, Search, X, Eye, Trash2, Send,
  CheckCircle2, AlertCircle
} from 'lucide-vue-next'

// ─── État ─────────────────────────────────────
const route = useRoute()

const loading = ref(true)
const messages = ref([])
const stats = ref({
  total: 0,
  en_attente: 0,
  en_cours: 0,
  resolu: 0,
  avis: 0,
  reclamation: 0,
})

const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 20,
  total: 0,
})

const filters = ref({
  status: '',
  type: '',
  search: '',
})

// Modal détail
const selectedMessage = ref(null)
const replyForm = ref({ admin_reply: '', status: 'resolu' })
const sendingReply = ref(false)
const replyError = ref('')
const replySuccess = ref('')

// Options de statut réutilisables
const statusOptions = [
  { value: 'en_attente', label: 'En attente', class: 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' },
  { value: 'en_cours',   label: 'En cours',   class: 'bg-blue-500/10 text-blue-400 border-blue-500/20' },
  { value: 'resolu',     label: 'Résolu',     class: 'bg-brandMint/10 text-brandMint border-brandMint/20' },
  { value: 'ferme',      label: 'Fermé',      class: 'bg-slate-500/10 text-slate-400 border-slate-500/20' },
]

// ─── Computed ─────────────────────────────────
const hasActiveFilters = computed(() =>
  filters.value.status || filters.value.type || filters.value.search
)

// ─── Helpers ──────────────────────────────────
const getStatusLabel = (s) => ({
  en_attente: 'En attente', en_cours: 'En cours',
  resolu: 'Résolu', ferme: 'Fermé',
}[s] || s)

const getStatusClass = (s) => ({
  en_attente: 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
  en_cours: 'bg-blue-500/10 text-blue-400 border-blue-500/20',
  resolu: 'bg-brandMint/10 text-brandMint border-brandMint/20',
  ferme: 'bg-slate-500/10 text-slate-400 border-slate-500/20',
}[s] || '')

const getTypeLabel = (t) => t === 'avis' ? 'Avis' : 'Réclamation'
const getTypeClass = (t) => t === 'avis'
  ? 'bg-brandCyber/10 text-brandCyber border-brandCyber/20'
  : 'bg-red-500/10 text-red-400 border-red-500/20'

const formatDate = (d) => new Date(d).toLocaleDateString('fr-FR', {
  day: '2-digit', month: 'short', year: 'numeric',
  hour: '2-digit', minute: '2-digit'
})

// ─── Chargement ───────────────────────────────
const loadMessages = async (page = 1) => {
  loading.value = true
  try {
    const params = {
      page,
      per_page: 20,
      ...(filters.value.status && { status: filters.value.status }),
      ...(filters.value.type && { type: filters.value.type }),
      ...(filters.value.search && { search: filters.value.search }),
    }
    const { data } = await api.get('/admin/messages', { params })
    if (data.success) {
      messages.value = data.messages.data
      pagination.value = {
        current_page: data.messages.current_page,
        last_page: data.messages.last_page,
        per_page: data.messages.per_page,
        total: data.messages.total,
      }
      if (data.stats) stats.value = data.stats
    }
  } catch (error) {
    console.error('Erreur chargement messages admin:', error)
  } finally {
    loading.value = false
  }
}

// ─── Filtres ──────────────────────────────────
const setFilter = (key, value) => {
  filters.value[key] = value
  loadMessages(1)
}

const resetFilters = () => {
  filters.value = { status: '', type: '', search: '' }
  loadMessages(1)
}

// Debounce pour la recherche
let searchTimeout = null
const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => loadMessages(1), 400)
}

const goToPage = (page) => {
  if (page < 1 || page > pagination.value.last_page) return
  loadMessages(page)
}

// ─── Détail / Réponse ─────────────────────────
const openDetail = (msg) => {
  selectedMessage.value = msg
  replyForm.value = {
    admin_reply: msg.admin_reply || '',
    status: msg.status === 'en_attente' || msg.status === 'en_cours' ? 'resolu' : msg.status,
  }
  replyError.value = ''
  replySuccess.value = ''
}

const closeDetail = () => {
  selectedMessage.value = null
  replyError.value = ''
  replySuccess.value = ''
}

const submitReply = async () => {
  replyError.value = ''
  replySuccess.value = ''

  if (replyForm.value.admin_reply.trim().length < 5) {
    replyError.value = 'La réponse doit contenir au moins 5 caractères.'
    return
  }

  sendingReply.value = true
  try {
    const { data } = await api.post(
      `/admin/messages/${selectedMessage.value.id}/reply`,
      replyForm.value
    )
    if (data.success) {
      replySuccess.value = data.message || 'Réponse envoyée avec succès.'
      // Mise à jour locale
      const idx = messages.value.findIndex(m => m.id === selectedMessage.value.id)
      if (idx !== -1) messages.value[idx] = { ...messages.value[idx], ...data.data }
      selectedMessage.value = { ...selectedMessage.value, ...data.data }

      // Rafraîchit les stats
      setTimeout(() => loadMessages(pagination.value.current_page), 1200)
    }
  } catch (error) {
    if (error.response?.data?.errors) {
      replyError.value = Object.values(error.response.data.errors).flat().join(' ')
    } else {
      replyError.value = error.message || 'Une erreur est survenue.'
    }
  } finally {
    sendingReply.value = false
  }
}

// ─── Changement de statut rapide ──────────────
const quickChangeStatus = async (msg, newStatus) => {
  if (msg.status === newStatus) return
  try {
    const { data } = await api.patch(`/admin/messages/${msg.id}/status`, {
      status: newStatus,
    })
    if (data.success) {
      const idx = messages.value.findIndex(m => m.id === msg.id)
      if (idx !== -1) messages.value[idx].status = newStatus
      if (selectedMessage.value?.id === msg.id) {
        selectedMessage.value.status = newStatus
      }
      loadMessages(pagination.value.current_page)
    }
  } catch (error) {
    console.error('Erreur changement statut:', error)
  }
}

// ─── Suppression ──────────────────────────────
const confirmDelete = async (msg) => {
  if (!confirm(`Supprimer définitivement le message "${msg.subject}" ?`)) return
  try {
    const { data } = await api.delete(`/admin/messages/${msg.id}`)
    if (data.success) {
      if (selectedMessage.value?.id === msg.id) closeDetail()
      messages.value = messages.value.filter(m => m.id !== msg.id)
      loadMessages(pagination.value.current_page)
    }
  } catch (error) {
    console.error('Erreur suppression:', error)
    alert('Impossible de supprimer ce message.')
  }
}

// ─── Lifecycle ────────────────────────────────
onMounted(() => {
  // Pré-remplir les filtres depuis l'URL (ex: /admin/messages?status=en_attente)
  if (route.query.status) filters.value.status = route.query.status
  if (route.query.type) filters.value.type = route.query.type
  loadMessages()
})
</script>