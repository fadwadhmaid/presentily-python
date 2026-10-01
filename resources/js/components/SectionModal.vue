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
        @click.self="!isMandatory && $emit('close')"
      >
        <Transition
          enter-active-class="transition duration-300 ease-out"
          enter-from-class="opacity-0 scale-95 translate-y-4"
          enter-to-class="opacity-100 scale-100 translate-y-0"
        >
          <div
            class="relative w-full max-w-3xl bg-[#0f0f1a] border border-slate-800 rounded-3xl shadow-2xl shadow-black/60 overflow-hidden"
          >
            <!-- Glow décoratif -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-96 h-96 bg-brandCyber/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Header -->
            <div class="relative p-6 sm:p-8 text-center border-b border-slate-800/60">
              <div class="inline-flex items-center gap-2 bg-brandCyber/10 border border-brandCyber/20 text-brandCyber text-[10px] font-bold px-3 py-1.5 rounded-full mb-4">
                <Sparkles class="w-3 h-3" />
                Bienvenue sur Presentily
              </div>
              <h2 class="text-2xl sm:text-3xl font-extrabold text-white">
                Quelle est ta section ?
              </h2>
              <p class="text-sm text-slate-400 mt-2 max-w-lg mx-auto">
                Choisis ta section pour accéder au programme adapté à ton Bac. Tu pourras changer à tout moment.
              </p>
            </div>

            <!-- Choix des sections -->
            <div class="relative p-6 sm:p-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
              <!-- Bac Informatique -->
              <button
                @click="selectSection('informatique')"
                class="group relative overflow-hidden text-left p-6 rounded-2xl border-2 transition-all duration-300"
                :class="selected === 'informatique'
                  ? 'border-brandCyber bg-brandCyber/10 shadow-[0_0_30px_rgba(253,224,71,0.2)]'
                  : 'border-slate-800 bg-[#0a0a12]/60 hover:border-brandCyber/40 hover:bg-brandCyber/5'"
              >
                <div class="absolute top-0 right-0 w-32 h-32 bg-brandCyber/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

                <div class="relative">
                  <!-- Icône -->
                  <div class="w-14 h-14 rounded-2xl bg-brandCyber/15 border border-brandCyber/30 flex items-center justify-center mb-4">
                    <Code2 class="w-7 h-7 text-brandCyber" />
                  </div>

                  <!-- Titre -->
                  <div class="flex items-center gap-2 mb-2">
                    <h3 class="text-lg font-extrabold text-white">Bac Informatique</h3>
                    <span v-if="selected === 'informatique'" class="text-[9px] font-bold text-brandCyber bg-brandCyber/20 border border-brandCyber/40 px-2 py-0.5 rounded">
                      SÉLECTIONNÉ
                    </span>
                  </div>

                  <!-- Description -->
                  <p class="text-xs text-slate-400 leading-relaxed mb-4">
                    Programme complet de la section Sciences de l'Informatique.
                  </p>

                  <!-- Caractéristiques -->
                  <div class="space-y-2">
                    <div class="flex items-center gap-2 text-[11px] text-slate-400">
                      <CheckCircle2 class="w-3.5 h-3.5 text-brandCyber flex-shrink-0" />
                      <span><strong class="text-slate-300">20 chapitres</strong> structurés</span>
                    </div>
                    <div class="flex items-center gap-2 text-[11px] text-slate-400">
                      <CheckCircle2 class="w-3.5 h-3.5 text-brandCyber flex-shrink-0" />
                      <span>Algorithmes avancés & récursivité</span>
                    </div>
                    <div class="flex items-center gap-2 text-[11px] text-slate-400">
                      <CheckCircle2 class="w-3.5 h-3.5 text-brandCyber flex-shrink-0" />
                      <span>Sujets Bac info + corrections</span>
                    </div>
                  </div>

                  <!-- CTA -->
                  <div class="mt-5 inline-flex items-center gap-2 text-xs font-bold text-brandCyber">
                    <span>Choisir cette section</span>
                    <ArrowRight class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" />
                  </div>
                </div>
              </button>

              <!-- Bac Scientifique -->
              <button
                @click="selectSection('scientifique')"
                class="group relative overflow-hidden text-left p-6 rounded-2xl border-2 transition-all duration-300"
                :class="selected === 'scientifique'
                  ? 'border-brandMint bg-brandMint/10 shadow-[0_0_30px_rgba(74,222,128,0.2)]'
                  : 'border-slate-800 bg-[#0a0a12]/60 hover:border-brandMint/40 hover:bg-brandMint/5'"
              >
                <div class="absolute top-0 right-0 w-32 h-32 bg-brandMint/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

                <div class="relative">
                  <!-- Icône -->
                  <div class="w-14 h-14 rounded-2xl bg-brandMint/15 border border-brandMint/30 flex items-center justify-center mb-4">
                    <FlaskConical class="w-7 h-7 text-brandMint" />
                  </div>

                  <!-- Titre -->
                  <div class="flex items-center gap-2 mb-2">
                    <h3 class="text-lg font-extrabold text-white">Bac Scientifique</h3>
                    <span v-if="selected === 'scientifique'" class="text-[9px] font-bold text-brandMint bg-brandMint/20 border border-brandMint/40 px-2 py-0.5 rounded">
                      SÉLECTIONNÉ
                    </span>
                  </div>

                  <!-- Description -->
                  <p class="text-xs text-slate-400 leading-relaxed mb-4">
                    Programme adapté aux sections Mathématiques, Sciences Expérimentales et Techniques.
                  </p>

                  <!-- Caractéristiques -->
                  <div class="space-y-2">
                    <div class="flex items-center gap-2 text-[11px] text-slate-400">
                      <CheckCircle2 class="w-3.5 h-3.5 text-brandMint flex-shrink-0" />
                      <span><strong class="text-slate-300">15 chapitres</strong> essentiels</span>
                    </div>
                    <div class="flex items-center gap-2 text-[11px] text-slate-400">
                      <CheckCircle2 class="w-3.5 h-3.5 text-brandMint flex-shrink-0" />
                      <span>Python appliqué aux maths</span>
                    </div>
                    <div class="flex items-center gap-2 text-[11px] text-slate-400">
                      <CheckCircle2 class="w-3.5 h-3.5 text-brandMint flex-shrink-0" />
                      <span>Sujets Bac sci + corrections</span>
                    </div>
                  </div>

                  <!-- CTA -->
                  <div class="mt-5 inline-flex items-center gap-2 text-xs font-bold text-brandMint">
                    <span>Choisir cette section</span>
                    <ArrowRight class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" />
                  </div>
                </div>
              </button>
            </div>

            <!-- Footer -->
            <div class="relative px-6 sm:px-8 py-5 border-t border-slate-800/60 bg-[#0a0a12]/60">
              <div class="flex items-center justify-between gap-4">
                <p class="text-[10px] text-slate-500 flex items-center gap-2">
                  <Info class="w-3 h-3" />
                  Tu pourras modifier ton choix dans ton profil.
                </p>
                <button
                  v-if="selected"
                  @click="confirm"
                  class="inline-flex items-center gap-2 bg-gradient-to-r from-brandCyber to-amber-400 text-slate-950 font-bold text-sm px-5 py-2.5 rounded-xl shadow-[0_0_20px_rgba(253,224,71,0.2)] hover:shadow-[0_0_30px_rgba(253,224,71,0.4)] transition"
                >
                  Continuer
                  <ArrowRight class="w-4 h-4" />
                </button>
              </div>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Sparkles, Code2, FlaskConical, CheckCircle2, ArrowRight, Info } from 'lucide-vue-next'

const props = defineProps({
  visible: { type: Boolean, default: false },
  isMandatory: { type: Boolean, default: false },
})

const emit = defineEmits(['close', 'select'])

const selected = ref(null)

// Reset la sélection quand le modal s'ouvre
watch(() => props.visible, (v) => {
  if (v) selected.value = null
})

const selectSection = (section) => {
  selected.value = section
}

const confirm = () => {
  if (!selected.value) return
  emit('select', selected.value)
}
</script>