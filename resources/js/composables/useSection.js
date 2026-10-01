// resources/js/composables/useSection.js
import { ref, computed } from 'vue'

// État global (singleton)
const section = ref(localStorage.getItem('section') || null)

export function useSection() {
  const setSection = (newSection) => {
    section.value = newSection
    localStorage.setItem('section', newSection)
  }

  const clearSection = () => {
    section.value = null
    localStorage.removeItem('section')
  }

  const hasSection = computed(() => !!section.value)

  const sectionLabel = computed(() => {
    if (section.value === 'informatique') return 'Bac Informatique'
    if (section.value === 'scientifique') return 'Bac Scientifique'
    return null
  })

  return {
    section,
    setSection,
    clearSection,
    hasSection,
    sectionLabel,
  }
}