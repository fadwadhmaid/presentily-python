<template>
  <div class="min-h-screen bg-[#0a0a0f] text-white p-4 sm:p-6 lg:p-8">
    <!-- Header -->
    <div class="max-w-4xl mx-auto">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h1 class="text-2xl font-extrabold text-white flex items-center gap-3">
            <MessageSquare class="w-7 h-7 text-brandCyber" />
            Mes messages
          </h1>
          <p class="text-xs text-slate-500 mt-1">
            Tes avis et réclamations
          </p>
        </div>
        <div class="flex gap-2">
          <button
            @click="openMessageModal('avis')"
            class="inline-flex items-center gap-2 text-xs font-semibold text-brandCyber bg-brandCyber/10 border border-brandCyber/20 px-3 py-2 rounded-lg hover:bg-brandCyber/20 transition"
          >
            <MessageSquare class="w-3.5 h-3.5" />
            Donner un avis
          </button>
          <button
            @click="openMessageModal('reclamation')"
            class="inline-flex items-center gap-2 text-xs font-semibold text-red-400 bg-red-500/10 border border-red-500/20 px-3 py-2 rounded-lg hover:bg-red-500/20 transition"
          >
            <AlertCircle class="w-3.5 h-3.5" />
            Réclamation
          </button>
        </div>
      </div>

      <!-- Liste des messages -->
      <div v-if="loading" class="text-center py-10 text-slate-500">
        Chargement...
      </div>

      <div v-else-if="messages.length > 0" class="space-y-3">
        <div
          v-for="msg in messages"
          :key="msg.id"
          class="p-5 bg-[#0f0f1a]/60 border border-slate-800 rounded-2xl hover:border-slate-700 transition"
        >
          <div class="flex items-start justify-between gap-3 mb-3">
            <div class="flex items-center gap-2 flex-wrap">
              <span :class="['text-[10px] font-bold px-2 py-1 rounded-full border', getTypeClass(msg.type)]">
                {{ getTypeLabel(msg.type) }}
              </span>
              <span :class="['text-[10px] font-bold px-2 py-1 rounded-full border', getStatusClass(msg.status)]">
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

          <h4 class="text-base font-bold text-white mb-2">{{ msg.subject }}</h4>
          <p class="text-sm text-slate-400 whitespace-pre-line">{{ msg.content }}</p>
          <p class="text-[10px] text-slate-600 mt-3">{{ formatDate(msg.created_at) }}</p>

          <!-- Réponse admin -->
          <div
            v-if="msg.admin_reply"
            class="mt-4 p-4 bg-brandMint/5 border border-brandMint/20 rounded-xl"
          >
            <p class="text-[10px] font-bold text-brandMint uppercase tracking-wider mb-2 flex items-center gap-2">
              <CheckCircle2 class="w-3.5 h-3.5" />
              Réponse de l'administration
            </p>
            <p class="text-sm text-slate-300 whitespace-pre-line">{{ msg.admin_reply }}</p>
            <p v-if="msg.replied_at" class="text-[10px] text-slate-600 mt-2">
              {{ formatDate(msg.replied_at) }}
            </p>
          </div>
        </div>
      </div>

      <div v-else class="text-center py-16 bg-[#0f0f1a]/40 border border-slate-800 border-dashed rounded-2xl">
        <MessageSquare class="w-12 h-12 text-slate-700 mx-auto mb-3" />
        <p class="text-sm text-slate-500">Aucun message pour l'instant</p>
        <p class="text-xs text-slate-600 mt-1">Donne ton avis ou signale un problème</p>
      </div>
    </div>

    <!-- MODAL (réutilise le même que dans le dashboard) -->
    <Teleport to="body">
      <div
        v-if="showMessageModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
        @click.self="showMessageModal = false"
      >
        <div class="w-full max-w-lg bg-[#0f0f1a] border border-slate-800 rounded-2xl shadow-2xl">
          <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800">
            <h3 class="text-sm font-bold text-white">
              {{ messageForm.type === 'avis' ? 'Donner mon avis' : 'Signaler un problème' }}
            </h3>
            <button @click="showMessageModal = false" class="text-slate-500 hover:text-white">
              <X class="w-5 h-5" />
            </button>
          </div>

          <div class="p-6 space-y-4">
            <div>
              <label class="block text-xs font-semibold text-slate-400 mb-2">Type</label>
              <div class="grid grid-cols-2 gap-2">
                <button
                  @click="messageForm.type = 'avis'"
                  :class="['py-2.5 rounded-xl border text-xs font-semibold transition',
                    messageForm.type === 'avis'
                      ? 'bg-brandCyber/15 border-brandCyber/40 text-brandCyber'
                      : 'bg-slate-900/40 border-slate-800 text-slate-400']"
                >
                  Avis
                </button>
                <button
                  @click="messageForm.type = 'reclamation'"
                  :class="['py-2.5 rounded-xl border text-xs font-semibold transition',
                    messageForm.type === 'reclamation'
                      ? 'bg-red-500/15 border-red-500/40 text-red-400'
                      : 'bg-slate-900/40 border-slate-800 text-slate-400']"
                >
                  Réclamation
                </button>
              </div>
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-400 mb-2">Sujet</label>
              <input
                v-model="messageForm.subject"
                type="text"
                maxlength="255"
                placeholder="Ex: Problème d'accès au cours"
                class="w-full px-4 py-2.5 bg-slate-900/60 border border-slate-800 rounded-xl text-sm text-white placeholder-slate-600 focus:outline-none focus:border-brandCyber/40"
              />
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-400 mb-2">
                Message <span class="text-slate-600">({{ messageForm.content.length }}/2000)</span>
              </label>
              <textarea
                v-model="messageForm.content"
                rows="5"
                maxlength="2000"
                placeholder="Décris ton avis ou ton problème..."
                class="w-full px-4 py-2.5 bg-slate-900/60 border border-slate-800 rounded-xl text-sm text-white placeholder-slate-600 focus:outline-none focus:border-brandCyber/40 resize-none"
              ></textarea>
            </div>

            <div v-if="messageFormError" class="p-3 bg-red-500/10 border border-red-500/20 rounded-xl">
              <p class="text-xs text-red-400">{{ messageFormError }}</p>
            </div>

            <div v-if="messageSuccess" class="p-3 bg-brandMint/10 border border-brandMint/20 rounded-xl">
              <p class="text-xs text-brandMint">{{ messageSuccess }}</p>
            </div>
          </div>

          <div class="flex justify-end gap-3 px-6 py-4 border-t border-slate-800">
            <button @click="showMessageModal = false" class="px-4 py-2 text-sm text-slate-400 hover:text-white">
              Annuler
            </button>
            <button
              @click="submitMessage"
              :disabled="sendingMessage"
              class="inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-brandCyber to-amber-400 text-slate-950 font-bold text-sm rounded-xl hover:shadow-[0_0_20px_rgba(253,224,71,0.3)] disabled:opacity-50"
            >
              <Send class="w-4 h-4" />
              {{ sendingMessage ? 'Envoi...' : 'Envoyer' }}
            </button>
          </div>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../plugins/axios'
import {
  MessageSquare, AlertCircle, CheckCircle2, Trash2, Send, X
} from 'lucide-vue-next'

const messages = ref([])
const loading = ref(true)
const showMessageModal = ref(false)
const sendingMessage = ref(false)
const messageForm = ref({ type: 'avis', subject: '', content: '' })
const messageFormError = ref('')
const messageSuccess = ref('')

const loadMessages = async () => {
  loading.value = true
  try {
    const { data } = await api.get('/messages')
    if (data.success) {
      messages.value = data.messages
    }
  } catch (error) {
    console.error('Erreur chargement messages:', error)
    console.error('Status:', error.response?.status)
    console.error('Data:', error.response?.data)
  } finally {
    loading.value = false
  }
}

const openMessageModal = (type = 'avis') => {
  messageForm.value = { type, subject: '', content: '' }
  messageFormError.value = ''
  messageSuccess.value = ''
  showMessageModal.value = true
}

const submitMessage = async () => {
  messageFormError.value = ''
  messageSuccess.value = ''

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
      setTimeout(() => {
        showMessageModal.value = false
        messageSuccess.value = ''
      }, 1500)
    }
  } catch (error) {
    if (error.response?.data?.errors) {
      messageFormError.value = Object.values(error.response.data.errors).flat().join(' ')
    } else {
      messageFormError.value = 'Une erreur est survenue.'
    }
  } finally {
    sendingMessage.value = false
  }
}

const deleteMessage = async (id) => {
  if (!confirm('Supprimer ce message ?')) return
  try {
    await api.delete(`/messages/${id}`)
    await loadMessages()
  } catch (error) {
    console.error('Erreur suppression:', error)
  }
}

const getStatusLabel = (s) => ({
  en_attente: 'En attente', en_cours: 'En cours',
  resolu: 'Résolu', ferme: 'Fermé'
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

onMounted(loadMessages)
</script>