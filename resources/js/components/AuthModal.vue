<!-- components/AuthModal.vue -->
<template>
  <div v-if="visible" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#0a0a0f]/95 backdrop-blur-md" @click.self="close">
    <div ref="modalCard" class="w-full max-w-[400px] sm:max-w-[420px] md:max-w-[400px] bg-[#0f0f1a] border border-slate-800 rounded-2xl p-5 sm:p-6 shadow-2xl relative max-h-[90vh] overflow-y-auto mx-auto">
      <!-- Bouton Fermer -->
      <button @click="close" class="absolute top-2 right-2 text-slate-500 hover:text-white p-1 rounded-lg hover:bg-slate-800/60 transition z-10">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>

      <!-- En-tête -->
      <div class="flex flex-col items-center text-center mb-4">
        <div class="relative w-12 h-12 mb-2">
          <div class="absolute inset-0 flex items-center justify-center">
            <svg class="w-9 h-9 text-brandCyber" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
            </svg>
          </div>
          <div class="absolute inset-0 rounded-full border-2 border-brandCyber/20 animate-spin-slow"></div>
        </div>
        
        <h3 ref="modalTitle" class="text-lg font-extrabold text-white">
          {{ localMode === 'login' ? 'Bienvenue' : 'Rejoins la communauté' }}
        </h3>
        <p ref="modalSubtitle" class="text-[10px] text-slate-400 mt-0.5">
          {{ localMode === 'login' ? "Connecte-toi pour continuer" : 'Crée ton compte et commence à coder' }}
        </p>
      </div>

      <!-- Formulaire -->
      <form @submit.prevent="handleSubmit" class="space-y-3">
        <!-- Nom - Uniquement en mode register -->
        <div v-if="localMode === 'register'" ref="fieldName" class="field-item" style="opacity: 1;">
          <label class="text-[10px] font-semibold text-slate-400 block mb-0.5 flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Nom complet
          </label>
          <input type="text" v-model="form.name" placeholder="Fadwa Dhemaid" autocomplete="name"
                 class="w-full bg-[#0a0a12] border border-slate-800 rounded-lg px-3 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-brandCyber transition hover:border-slate-700">
        </div>

        <!-- Email - Toujours visible -->
        <div ref="fieldEmail" class="field-item" style="opacity: 1;">
          <label class="text-[10px] font-semibold text-slate-400 block mb-0.5 flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Email
          </label>
          <input type="email" v-model="form.email" placeholder="fadwa@lycee.tn" autocomplete="email"
                 class="w-full bg-[#0a0a12] border border-slate-800 rounded-lg px-3 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-brandCyber transition hover:border-slate-700">
        </div>

        <!-- Mot de passe - Toujours visible -->
        <div ref="fieldPassword" class="field-item" style="opacity: 1;">
          <label class="text-[10px] font-semibold text-slate-400 block mb-0.5 flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
            Mot de passe (min. 8 caractères)
          </label>
          <input type="password" v-model="form.password" placeholder="••••••••" autocomplete="new-password"
                 class="w-full bg-[#0a0a12] border border-slate-800 rounded-lg px-3 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-brandCyber transition hover:border-slate-700">
        </div>

        <!-- Lycée - Uniquement en mode register -->
        <div v-if="localMode === 'register'" ref="fieldSchool" class="field-item" style="opacity: 1;">
          <label class="text-[10px] font-semibold text-slate-400 block mb-0.5 flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
            </svg>
            Lycée / Établissement
          </label>
          <input type="text" v-model="form.school" placeholder="Lycée Pilote Bourguiba" autocomplete="organization"
                 class="w-full bg-[#0a0a12] border border-slate-800 rounded-lg px-3 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-brandCyber transition hover:border-slate-700">
        </div>

        <!-- Niveau - Uniquement en mode register -->
        <div v-if="localMode === 'register'" ref="fieldGrade" class="field-item" style="opacity: 1;">
          <label class="text-[10px] font-semibold text-slate-400 block mb-0.5 flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            Niveau
          </label>
          <select v-model="form.grade" 
                  class="w-full bg-[#0a0a12] border border-slate-800 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-brandCyber transition">
            <option value="">Sélectionnez votre niveau</option>
            <option value="1ere">1ère année</option>
            <option value="2eme">2ème année</option>
            <option value="3eme">3ème année</option>
            <option value="4eme">4ème année</option>
            <option value="Bac">Bac</option>
          </select>
        </div>

        <!-- Gouvernorat - Uniquement en mode register -->
        <div v-if="localMode === 'register'" ref="fieldGovernorate" class="field-item" style="opacity: 1;">
          <label class="text-[10px] font-semibold text-slate-400 block mb-0.5 flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
            </svg>
            Gouvernorat
          </label>
          <select v-model="form.governorate" 
                  class="w-full bg-[#0a0a12] border border-slate-800 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-brandCyber transition">
            <option value="">Sélectionnez votre gouvernorat</option>
            <option value="Tunis">Tunis</option>
            <option value="Ariana">Ariana</option>
            <option value="Ben Arous">Ben Arous</option>
            <option value="Manouba">Manouba</option>
            <option value="Nabeul">Nabeul</option>
            <option value="Zaghouan">Zaghouan</option>
            <option value="Bizerte">Bizerte</option>
            <option value="Béja">Béja</option>
            <option value="Jendouba">Jendouba</option>
            <option value="Kef">Kef</option>
            <option value="Siliana">Siliana</option>
            <option value="Sousse">Sousse</option>
            <option value="Monastir">Monastir</option>
            <option value="Mahdia">Mahdia</option>
            <option value="Sfax">Sfax</option>
            <option value="Kairouan">Kairouan</option>
            <option value="Kasserine">Kasserine</option>
            <option value="Sidi Bouzid">Sidi Bouzid</option>
            <option value="Gabès">Gabès</option>
            <option value="Médenine">Médenine</option>
            <option value="Tataouine">Tataouine</option>
            <option value="Gafsa">Gafsa</option>
            <option value="Tozeur">Tozeur</option>
            <option value="Kébili">Kébili</option>
          </select>
        </div>

        <!-- Dans le formulaire, après le champ Gouvernorat -->
<div v-if="localMode === 'register'" ref="fieldAge" class="field-item" style="opacity: 1;">
  <label class="text-[10px] font-semibold text-slate-400 block mb-0.5 flex items-center gap-1">
    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
    </svg>
    Âge
  </label>
  <input type="number" v-model="form.age" placeholder="16" min="13" max="120"
         class="w-full bg-[#0a0a12] border border-slate-800 rounded-lg px-3 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-brandCyber transition hover:border-slate-700">
</div>

<!-- Confirmation du mot de passe -->
<div v-if="localMode === 'register'" ref="fieldPasswordConfirmation" class="field-item" style="opacity: 1;">
  <label class="text-[10px] font-semibold text-slate-400 block mb-0.5 flex items-center gap-1">
    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
    </svg>
    Confirmer le mot de passe
  </label>
  <input type="password" v-model="form.password_confirmation" placeholder="••••••••" autocomplete="new-password"
         class="w-full bg-[#0a0a12] border border-slate-800 rounded-lg px-3 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-brandCyber transition hover:border-slate-700">
</div>

<!-- Terms checkbox -->
<div v-if="localMode === 'register'" ref="fieldTerms" class="field-item" style="opacity: 1;">
  <label class="flex items-center gap-2 text-[10px] text-slate-400 cursor-pointer">
    <input type="checkbox" v-model="form.terms" class="w-3.5 h-3.5 rounded border-slate-700 bg-[#0a0a12] text-brandCyber focus:ring-brandCyber/20 focus:ring-offset-0">
    <span>J'accepte les <a href="#" class="text-brandCyber hover:underline">conditions générales</a></span>
  </label>
</div>
        <!-- Bouton -->
        <button type="submit" :disabled="isLoading" 
                class="w-full relative group overflow-hidden bg-gradient-to-r from-brandCyber to-amber-400 text-slate-950 font-extrabold py-2.5 rounded-lg shadow-[0_0_20px_rgba(253,224,71,0.15)] hover:shadow-[0_0_35px_rgba(253,224,71,0.25)] transition-all duration-300 hover:scale-[1.01] mt-1 text-xs disabled:opacity-50 disabled:cursor-not-allowed">
          <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-shimmer"></span>
          <span class="flex items-center justify-center gap-2">
            <span v-if="isLoading" class="inline-block w-3.5 h-3.5 border-2 border-slate-950 border-t-transparent rounded-full animate-spin"></span>
            {{ isLoading ? 'Chargement...' : (localMode === 'login' ? 'Se connecter' : 'Créer mon compte') }}
            <svg v-if="!isLoading" class="w-3.5 h-3.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
          </span>
        </button>
      </form>

      <!-- Basculer -->
      <div class="mt-3 text-center text-[10px] text-slate-500">
        <span>{{ localMode === 'login' ? 'Pas encore de compte ?' : 'Déjà un compte ?' }}</span>
        <button @click="toggleMode" class="text-brandCyber font-semibold hover:underline ml-1 transition">
          {{ localMode === 'login' ? "S'inscrire" : 'Se connecter' }}
        </button>
      </div>

      <!-- Messages -->
      <div v-if="status" class="mt-2 text-center text-[10px] font-medium" :class="statusType === 'success' ? 'text-brandMint' : 'text-red-400'">
        {{ status }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, watch, nextTick, computed } from 'vue'
import gsap from 'gsap'
import api from '../plugins/axios'
import { useRouter } from 'vue-router'
const router = useRouter()
const props = defineProps({
  visible: {
    type: Boolean,
    default: false
  },
  mode: {
    type: String,
    default: 'register'
  }
})

const emit = defineEmits(['update:visible', 'update:mode', 'success'])

const localMode = ref(props.mode)

// Refs pour les éléments
const modalCard = ref(null)
const modalTitle = ref(null)
const modalSubtitle = ref(null)

// Refs pour les champs
const fieldName = ref(null)
const fieldEmail = ref(null)
const fieldPassword = ref(null)
const fieldSchool = ref(null)
const fieldGrade = ref(null)
const fieldGovernorate = ref(null)

const isLoading = ref(false)
const status = ref('')
const statusType = ref('')

const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  age: '', 
  terms: false, 
  school: '',
  grade: '',
  governorate: ''
})

// Computed pour obtenir les champs visibles
const getVisibleFields = () => {
  const fields = []
  if (fieldEmail.value) fields.push(fieldEmail.value)
  if (fieldPassword.value) fields.push(fieldPassword.value)
  
  if (localMode.value === 'register') {
    if (fieldName.value) fields.push(fieldName.value)
    if (fieldSchool.value) fields.push(fieldSchool.value)
    if (fieldGrade.value) fields.push(fieldGrade.value)
    if (fieldGovernorate.value) fields.push(fieldGovernorate.value)
  }
  
  return fields
}

watch(() => props.mode, (newVal) => {
  localMode.value = newVal
})

watch(localMode, (newVal) => {
  emit('update:mode', newVal)
})

watch(() => props.visible, (newVal) => {
  if (newVal) {
    nextTick(() => {
      // Réinitialiser les styles avant l'animation
      const fields = getVisibleFields()
      fields.forEach(field => {
        gsap.set(field, { opacity: 1, y: 0 })
      })
      
      animateOpen()
    })
  }
})

function animateOpen() {
  const card = modalCard.value
  
  if (card) {
    // Reset des styles
    gsap.set(card, { 
      opacity: 0, 
      scale: 0.85, 
      rotationY: 15,
      transformPerspective: 600,
      transformOrigin: 'center center'
    })
    
    // Animation de la carte
    const tl = gsap.timeline()
    
    tl.to(card, { 
      duration: 0.6, 
      opacity: 1, 
      scale: 1, 
      rotationY: 0, 
      ease: 'back.out(1.7)',
      transformPerspective: 600,
      transformOrigin: 'center center'
    })
    
    // Animation du titre
    if (modalTitle.value) {
      tl.from(modalTitle.value, {
        duration: 0.4,
        opacity: 0,
        y: -20,
        scale: 0.8,
        ease: 'back.out(1.2)',
      }, '-=0.3')
    }
    
    // Animation du sous-titre
    if (modalSubtitle.value) {
      tl.from(modalSubtitle.value, {
        duration: 0.3,
        opacity: 0,
        y: -10,
        ease: 'power2.out',
      }, '-=0.2')
    }
    
    // Animation des champs - NE PAS CACHER, just animer depuis leur état actuel
    const fields = getVisibleFields()
    if (fields.length > 0) {
      // S'assurer que les champs sont visibles avant l'animation
      fields.forEach(field => {
        gsap.set(field, { opacity: 0, y: 15 })
      })
      
      tl.to(fields, {
        duration: 0.4,
        opacity: 1,
        y: 0,
        stagger: 0.08,
        ease: 'power2.out',
      }, '-=0.1')
    }
  }
}

function close() {
  const card = modalCard.value
  
  if (card) {
    gsap.to(card, { 
      duration: 0.3, 
      opacity: 0, 
      scale: 0.9, 
      rotationY: -15, 
      ease: 'power2.in',
      transformPerspective: 600,
      transformOrigin: 'center center',
      onComplete: () => {
        emit('update:visible', false)
        status.value = ''
        isLoading.value = false
        resetForm()
      }
    })
  } else {
    emit('update:visible', false)
    status.value = ''
    isLoading.value = false
    resetForm()
  }
}

function resetForm() {
  form.name = ''
  form.email = ''
  form.password = ''
  form.school = ''
  form.grade = ''
  form.governorate = ''
}

function toggleMode() {
  const newMode = localMode.value === 'login' ? 'register' : 'login'
  localMode.value = newMode
  status.value = ''
  statusType.value = ''
  resetForm()
  
  // Animation de transition
  nextTick(() => {
    // Mettre à jour le titre immédiatement
    if (modalTitle.value) {
      modalTitle.value.textContent = localMode.value === 'login' ? 'Bienvenue' : 'Rejoins la communauté'
    }
    if (modalSubtitle.value) {
      modalSubtitle.value.textContent = localMode.value === 'login' 
        ? "Connecte-toi pour continuer" 
        : 'Crée ton compte et commence à coder'
    }
    
    // Animer les nouveaux champs
    const fields = getVisibleFields()
    if (fields.length > 0) {
      // S'assurer que tous les champs sont visibles au départ
      fields.forEach(field => {
        gsap.set(field, { opacity: 0, y: 10 })
      })
      
      gsap.to(fields, {
        duration: 0.3,
        opacity: 1,
        y: 0,
        stagger: 0.06,
        ease: 'power2.out'
      })
    }
  })
}

function shakeForm() {
  const card = modalCard.value
  if (card) {
    gsap.fromTo(card, { x: 0 }, { 
      duration: 0.4, 
      x: 12, 
      ease: 'power2.inOut', 
      yoyo: true, 
      repeat: 3,
      onComplete: () => {
        gsap.set(card, { x: 0 })
      }
    })
  }
}

async function handleSubmit() {
  if (isLoading.value) return
  
  try {
    if (localMode.value === 'register') {
      // 1. Validation des champs obligatoires
      const requiredFields = ['name', 'email', 'password', 'password_confirmation', 'age', 'school', 'grade', 'governorate']
      const missingFields = requiredFields.filter(field => !form[field] || form[field] === '')
      
      if (missingFields.length > 0) {
        status.value = ` Champs obligatoires manquants: ${missingFields.join(', ')}`
        statusType.value = 'error'
        shakeForm()
        return
      }

      // 2. Validation des termes
      if (!form.terms) {
        status.value = ' Vous devez accepter les conditions générales'
        statusType.value = 'error'
        shakeForm()
        return
      }

      // 3. Validation de l'âge
      const age = parseInt(form.age)
      if (isNaN(age) || age < 13 || age > 120) {
        status.value = ' Âge invalide (13-120 ans)'
        statusType.value = 'error'
        shakeForm()
        return
      }

      // 4. Validation de l'email
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      if (!emailRegex.test(form.email)) {
        status.value = ' Email invalide'
        statusType.value = 'error'
        shakeForm()
        return
      }

      // 5. Validation du mot de passe (au moins 12 caractères selon le backend)
      if (form.password.length < 12) {
        status.value = ' Le mot de passe doit contenir au moins 12 caractères'
        statusType.value = 'error'
        shakeForm()
        return
      }

      // 6. Vérifier que les mots de passe correspondent
      if (form.password !== form.password_confirmation) {
        status.value = ' Les mots de passe ne correspondent pas'
        statusType.value = 'error'
        shakeForm()
        return
      }

      // 7. Validation du mot de passe fort - Version plus permissive
      // Au lieu d'exiger tous les caractères spéciaux, on vérifie juste la longueur
      // et la présence de différents types de caractères
      const hasUpperCase = /[A-Z]/.test(form.password)
      const hasLowerCase = /[a-z]/.test(form.password)
      const hasNumber = /[0-9]/.test(form.password)
      const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(form.password)

      if (!hasUpperCase || !hasLowerCase || !hasNumber || !hasSpecialChar) {
        status.value = ' Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial'
        statusType.value = 'error'
        shakeForm()
        return
      }

      // 8. Préparer les données pour l'API
      const userData = {
        name: form.name.trim(),
        email: form.email.trim().toLowerCase(),
        password: form.password,
        password_confirmation: form.password_confirmation,
        age: age,
        terms: true,
        school: form.school.trim(),
        grade: form.grade,
        governorate: form.governorate
      }

      console.log(' Envoi des données:', userData)

      isLoading.value = true
      status.value = ' Création du compte en cours...'
      statusType.value = 'success'

      const response = await api.post('/register', userData)

      if (response.data.success) {
        localStorage.setItem('token', response.data.token)
        localStorage.setItem('user', JSON.stringify(response.data.user))
        
        status.value = ' Compte créé avec succès !'
        statusType.value = 'success'
        
        const card = modalCard.value
        gsap.fromTo(card, { scale: 1 }, {
          duration: 0.3,
          scale: 1.02,
          ease: 'power2.out',
          yoyo: true,
          repeat: 1
        })
        
        emit('success', response.data.user)
        setTimeout(() => {
          close()
          window.location.href = '/login'
        }, 1500)
      } else {
        status.value = ` ${response.data.message || 'Erreur lors de l\'inscription'}`
        statusType.value = 'error'
        shakeForm()
      }

    } else {
      // Mode Login
      if (!form.email || !form.password) {
        status.value = ' Email et mot de passe requis'
        statusType.value = 'error'
        shakeForm()
        return
      }

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      if (!emailRegex.test(form.email)) {
        status.value = ' Email invalide'
        statusType.value = 'error'
        shakeForm()
        return
      }

      const loginData = {
        email: form.email.trim().toLowerCase(),
        password: form.password
      }

      console.log(' Envoi des données de connexion:', loginData)

      isLoading.value = true
      status.value = 'Connexion en cours...'
      statusType.value = 'success'

      const response = await api.post('/login', loginData)

      if (response.data.success) {
        localStorage.setItem('token', response.data.token)
        localStorage.setItem('user', JSON.stringify(response.data.user))
        
        status.value = ' Connexion réussie !'
        statusType.value = 'success'
        
        const card = modalCard.value
        gsap.fromTo(card, { scale: 1 }, {
          duration: 0.3,
          scale: 1.02,
          ease: 'power2.out',
          yoyo: true,
          repeat: 1
        })
        
        emit('success', response.data.user)
setTimeout(() => {
  close()
  const role = response.data.role || response.data.user?.role
  if (role === 'admin') {
    router.push('/admin/dashboard')   // ✅
  } else {
    router.push('/dashboard')         // ✅
  }
}, 1000)
      } else {
        status.value = `❌ ${response.data.message || 'Erreur de connexion'}`
        statusType.value = 'error'
        shakeForm()
      }
    }
  } catch (error) {
    console.error('❌ Erreur complète:', error)
    
    // Gestion détaillée des erreurs
    if (error.response) {
      const { status, data } = error.response
      console.log('Status:', status)
      console.log('Données d\'erreur:', data)
      
      if (status === 422) {
        if (data.errors) {
          const errorMessages = Object.entries(data.errors)
            .map(([field, messages]) => `• ${field}: ${messages.join(', ')}`)
            .join('\n')
          status.value = `❌ ${errorMessages}`
        } else if (data.message) {
          status.value = `❌ ${data.message}`
        } else {
          status.value = `❌ Données invalides`
        }
      } else if (status === 401) {
        status.value = '❌ Email ou mot de passe incorrect'
      } else if (status === 403) {
        status.value = `❌ ${data.message || 'Accès refusé'}`
      } else if (status === 409) {
        status.value = '❌ Cet email est déjà utilisé'
      } else if (status === 429) {
        status.value = `❌ ${data.message || 'Trop de tentatives. Veuillez réessayer plus tard.'}`
      } else if (status === 500) {
        // Afficher plus de détails pour l'erreur 500
        console.error('Détails de l\'erreur 500:', data)
        if (data.message) {
          status.value = `❌ ${data.message}`
        } else {
          status.value = '❌ Erreur serveur. Veuillez réessayer plus tard.'
        }
      } else {
        status.value = `❌ Erreur ${status}: ${data.message || 'Erreur inattendue'}`
      }
    } else if (error.request) {
      status.value = '❌ Impossible de contacter le serveur. Vérifiez votre connexion.'
    } else {
      status.value = `❌ ${error.message || 'Une erreur est survenue'}`
    }
    
    statusType.value = 'error'
    shakeForm()
  } finally {
    isLoading.value = false
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap');

.font-mono { font-family: 'JetBrains Mono', monospace; }

@keyframes shimmer { 100% { transform: translateX(100%); } }
.animate-shimmer { animation: shimmer 2s infinite; }

@keyframes spin-slow {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
.animate-spin-slow {
  animation: spin-slow 6s linear infinite;
}

.brandCyber {
  color: #FDE047;
}

.border-brandCyber {
  border-color: #FDE047 !important;
}

.text-brandCyber {
  color: #FDE047;
}

.text-brandMint {
  color: #34d399;
}

.field-item {
  transition: all 0.3s ease;
  opacity: 1 !important; /* Forcer la visibilité */
}

input:focus, select:focus {
  box-shadow: 0 0 0 2px rgba(253, 224, 71, 0.2);
  outline: none;
}

select option {
  background-color: #0a0a12;
  color: white;
}

.fixed.inset-0 {
  background-color: rgba(10, 10, 15, 0.95) !important;
}

::-webkit-scrollbar {
  width: 4px;
}

::-webkit-scrollbar-track {
  background: #0a0a12;
}

::-webkit-scrollbar-thumb {
  background: #FDE047;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #facc15;
}
</style>