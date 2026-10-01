<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="visible"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/70 backdrop-blur-md"
        @click.self="$emit('close')"
      >
        <div class="relative w-full max-w-4xl max-h-[90vh] bg-[#0f0f1a] border border-slate-800 rounded-3xl shadow-2xl shadow-black/60 overflow-hidden flex flex-col">

          <!-- ═══════════ HEADER ═══════════ -->
          <div class="flex-shrink-0 p-5 sm:p-6 border-b border-slate-800/60 flex items-center justify-between">
            <div>
              <h2 class="text-lg sm:text-xl font-extrabold text-white">Personnalise ton avatar</h2>
              <p class="text-xs text-slate-400 mt-0.5">Crée un avatar qui te ressemble</p>
            </div>
            <button
              @click="$emit('close')"
              class="text-slate-400 hover:text-white p-2 rounded-lg hover:bg-slate-800/50 transition"
            >
              <X class="w-5 h-5" />
            </button>
          </div>

          <!-- ═══════════ CORPS SCROLLABLE ═══════════ -->
          <div class="flex-1 overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-[280px_1fr] gap-5 p-5 sm:p-6">

              <!-- Aperçu (colonne gauche, sticky) -->
              <div class="md:sticky md:top-0 md:self-start">
                <div class="flex flex-col items-center justify-center bg-[#0a0a12]/60 rounded-2xl border border-slate-800 p-6">
                  <div class="relative">
                    <UserAvatar :config="localConfig" :size="180" />
                  </div>
                  <p class="text-[10px] text-slate-500 mt-4 text-center">Aperçu en temps réel</p>
                </div>
              </div>

              <!-- Contrôles (colonne droite) -->
              <div class="space-y-4">

                <!-- Cheveux -->
                <div>
                  <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 block">Cheveux</label>
                  <div class="grid grid-cols-6 gap-2">
                    <button
                      v-for="hair in hairStyles"
                      :key="hair.value"
                      @click="localConfig.hair = hair.value"
                      class="aspect-square rounded-lg border-2 flex items-center justify-center text-lg transition"
                      :class="localConfig.hair === hair.value
                        ? 'border-brandCyber bg-brandCyber/10'
                        : 'border-slate-800 bg-slate-800/30 hover:border-slate-600'"
                      :title="hair.label"
                    >
                      {{ hair.emoji }}
                    </button>
                  </div>
                </div>

                <!-- Couleur cheveux -->
                <div>
                  <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 block">Couleur cheveux</label>
                  <div class="flex gap-2 flex-wrap">
                    <button
                      v-for="color in hairColors"
                      :key="color"
                      @click="localConfig.hairColor = color"
                      class="w-7 h-7 rounded-full border-2 transition"
                      :class="localConfig.hairColor === color ? 'border-brandCyber scale-110' : 'border-slate-700'"
                      :style="{ background: color }"
                    ></button>
                  </div>
                </div>

                <!-- Teint -->
                <div>
                  <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 block">Teint</label>
                  <div class="flex gap-2 flex-wrap">
                    <button
                      v-for="skin in skinColors"
                      :key="skin"
                      @click="localConfig.skin = skin"
                      class="w-7 h-7 rounded-full border-2 transition"
                      :class="localConfig.skin === skin ? 'border-brandCyber scale-110' : 'border-slate-700'"
                      :style="{ background: skin }"
                    ></button>
                  </div>
                </div>

                <!-- Tenue -->
                <div>
                  <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 block">Tenue</label>
                  <div class="grid grid-cols-4 gap-2">
                    <button
                      v-for="outfit in outfits"
                      :key="outfit.value"
                      @click="localConfig.outfit = outfit.value"
                      class="py-1.5 px-2 rounded-lg border-2 text-[10px] font-bold uppercase transition"
                      :class="localConfig.outfit === outfit.value
                        ? 'border-brandCyber bg-brandCyber/10 text-brandCyber'
                        : 'border-slate-800 text-slate-400 hover:border-slate-600'"
                    >
                      {{ outfit.label }}
                    </button>
                  </div>
                </div>

                <!-- Couleur tenue -->
                <div>
                  <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 block">Couleur tenue</label>
                  <div class="flex gap-2 flex-wrap">
                    <button
                      v-for="color in outfitColors"
                      :key="color"
                      @click="localConfig.outfitColor = color"
                      class="w-7 h-7 rounded-full border-2 transition"
                      :class="localConfig.outfitColor === color ? 'border-brandCyber scale-110' : 'border-slate-700'"
                      :style="{ background: color }"
                    ></button>
                  </div>
                </div>

                <!-- Accessoire -->
                <div>
                  <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 block">Accessoire</label>
                  <div class="grid grid-cols-4 gap-2">
                    <button
                      v-for="acc in accessories"
                      :key="acc.value"
                      @click="localConfig.accessory = acc.value"
                      class="py-1.5 px-2 rounded-lg border-2 text-[10px] font-bold uppercase transition"
                      :class="localConfig.accessory === acc.value
                        ? 'border-brandCyber bg-brandCyber/10 text-brandCyber'
                        : 'border-slate-800 text-slate-400 hover:border-slate-600'"
                    >
                      {{ acc.label }}
                    </button>
                  </div>
                </div>

                <!-- ✅ Couleur de fond -->
                <div>
                  <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 block">Fond</label>
                  <div class="flex gap-2 flex-wrap">
                    <button
                      v-for="color in backgroundColors"
                      :key="color"
                      @click="localConfig.background = color"
                      class="w-7 h-7 rounded-full border-2 transition"
                      :class="localConfig.background === color ? 'border-brandCyber scale-110' : 'border-slate-700'"
                      :style="{ background: color }"
                    ></button>
                  </div>
                </div>

              </div>
            </div>
          </div>

          <!-- ═══════════ FOOTER FIXE ═══════════ -->
          <div class="flex-shrink-0 px-5 sm:px-6 py-4 border-t border-slate-800/60 bg-[#0a0a12]/60 flex flex-col sm:flex-row items-center justify-between gap-3">
            <button
              @click="randomize"
              class="inline-flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-white px-4 py-2 rounded-xl border border-slate-800 hover:border-slate-600 transition"
            >
              <Shuffle class="w-3.5 h-3.5" />
              Aléatoire
            </button>

            <div class="flex items-center gap-2 w-full sm:w-auto">
              <button
                @click="$emit('close')"
                class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-sm font-bold text-slate-400 hover:text-white border border-slate-800 hover:border-slate-600 transition"
              >
                Annuler
              </button>
              <button
                @click="save"
                :disabled="saving"
                class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-gradient-to-r from-brandCyber to-amber-400 text-slate-950 font-bold text-sm px-5 py-2.5 rounded-xl shadow-[0_0_20px_rgba(253,224,71,0.2)] hover:shadow-[0_0_30px_rgba(253,224,71,0.4)] transition disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <Loader2 v-if="saving" class="w-4 h-4 animate-spin" />
                <Save v-else class="w-4 h-4" />
                {{ saving ? 'Enregistrement...' : 'Enregistrer' }}
              </button>
            </div>
          </div>

        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { ref, watch } from 'vue'
import { X, Shuffle, Save, Loader2 } from 'lucide-vue-next'
import UserAvatar from './UserAvatar.vue'
import api from '../plugins/axios'

// ═══════════════════════════════════════════════════════════
// PROPS & EMITS
// ═══════════════════════════════════════════════════════════
const props = defineProps({
  visible: { type: Boolean, default: false },
  currentConfig: { type: Object, required: true },
})

const emit = defineEmits(['close', 'saved'])

// ═══════════════════════════════════════════════════════════
// CONFIG PAR DÉFAUT (avec background)
// ═══════════════════════════════════════════════════════════
const DEFAULT_CONFIG = {
  hair: 'short',
  hairColor: '#1E1B4B',
  skin: '#F3D2B3',
  outfit: 'hoodie',
  outfitColor: '#FDE047',
  accessory: 'none',
  background: '#1E1B4B',
}

// ═══════════════════════════════════════════════════════════
// STATE
// ═══════════════════════════════════════════════════════════
const saving = ref(false)
const localConfig = ref({ ...DEFAULT_CONFIG, ...(props.currentConfig || {}) })

// Synchroniser quand le modal s'ouvre ou quand la config change
watch(() => props.visible, (v) => {
  if (v) {
    localConfig.value = { ...DEFAULT_CONFIG, ...(props.currentConfig || {}) }
  }
})

// ═══════════════════════════════════════════════════════════
// OPTIONS
// ═══════════════════════════════════════════════════════════

// Styles de cheveux
const hairStyles = [
  { value: 'short',    label: 'Court',  emoji: '💇' },
  { value: 'long',     label: 'Long',   emoji: '💇‍♀️' },
  { value: 'curly',    label: 'Bouclé', emoji: '🦱' },
  { value: 'buzz',     label: 'Rasé',   emoji: '🧑‍🦲' },
  { value: 'ponytail', label: 'Queue',  emoji: '👱' },
  { value: 'bald',     label: 'Chauve', emoji: '🥚' },
]

// Couleurs
const hairColors = [
  '#1E1B4B', '#78350F', '#000000', '#92400E',
  '#FCD34D', '#DC2626', '#7C3AED', '#BE185D',
]

const skinColors = [
  '#F3D2B3', '#E8B896', '#D4A574',
  '#B8825A', '#8B5A3C', '#5C3A21',
]

const outfitColors = [
  '#FDE047', '#4ADE80', '#3B82F6', '#EC4899',
  '#8B5CF6', '#EF4444', '#0F172A', '#FFFFFF',
]

// ✅ Couleurs de fond pour l'avatar
const backgroundColors = [
  '#1E1B4B', // Bleu nuit (défaut)
  '#0F172A', // Ardoise
  '#3B82F6', // Bleu
  '#8B5CF6', // Violet
  '#EC4899', // Rose
  '#EF4444', // Rouge
  '#F59E0B', // Ambre
  '#10B981', // Émeraude
  '#FDE047', // Jaune
  '#000000', // Noir
]

// Tenues
const outfits = [
  { value: 'hoodie',  label: 'Hoodie' },
  { value: 'tshirt',  label: 'T-shirt' },
  { value: 'shirt',   label: 'Chemise' },
  { value: 'sweater', label: 'Pull' },
]

// Accessoires
const accessories = [
  { value: 'none',     label: 'Aucun' },
  { value: 'glasses',  label: 'Lunettes' },
  { value: 'cap',      label: 'Casquette' },
  { value: 'earrings', label: 'Boucles' },
]

// ═══════════════════════════════════════════════════════════
// ACTIONS
// ═══════════════════════════════════════════════════════════

// Génère un avatar aléatoire
const randomize = () => {
  const pick = arr => arr[Math.floor(Math.random() * arr.length)]
  localConfig.value = {
    hair:         pick(hairStyles).value,
    hairColor:    pick(hairColors),
    skin:         pick(skinColors),
    outfit:       pick(outfits).value,
    outfitColor:  pick(outfitColors),
    accessory:    pick(accessories).value,
    background:   pick(backgroundColors),
  }
}

// Sauvegarde de l'avatar
const save = async () => {
  saving.value = true

  // ✅ Sécurité : fusionner avec les défauts pour ne jamais envoyer undefined
  const finalConfig = { ...DEFAULT_CONFIG, ...localConfig.value }

  console.log('🔵 Envoi avatar:', JSON.stringify(finalConfig, null, 2))

  try {
    const response = await api.put('/user/avatar', {
      avatar_config: finalConfig,
    })

    console.log('🟢 Réponse succès:', response.data)

    if (response.data.success) {
      // Envoyer la config confirmée par le serveur (ou notre config locale)
      emit('saved', response.data.avatar_config || finalConfig)
      emit('close')
    }
  } catch (error) {
    console.error('🔴 Erreur complète:', error)
    console.error('🔴 Status HTTP:', error.response?.status)
    console.error('🔴 Data réponse:', error.response?.data)
    console.error('🔴 Message:', error.message)

    // Afficher un message d'erreur clair
    if (error.response?.data?.errors) {
      const errors = error.response.data.errors
      const messages = Object.entries(errors)
        .map(([field, msgs]) => `• ${field} : ${Array.isArray(msgs) ? msgs.join(', ') : msgs}`)
        .join('\n')
      alert('❌ Erreurs de validation :\n\n' + messages)
    } else if (error.response?.data?.message) {
      alert('❌ ' + error.response.data.message)
    } else if (error.message) {
      alert('❌ Erreur : ' + error.message)
    } else {
      alert('❌ Une erreur est survenue. Vérifie ta connexion.')
    }
  } finally {
    saving.value = false
  }
}
</script>