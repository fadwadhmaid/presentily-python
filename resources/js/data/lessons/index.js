// resources/js/data/lessons/index.js

// ═══════════════════════════════════════════════════════
// BAC INFORMATIQUE — 20 chapitres
// ═══════════════════════════════════════════════════════
import info01 from './sections/informatique/01-algorithmique'
import info02 from './sections/informatique/02-variables-types'
//**import info03 from './sections/informatique/03-entrees-sorties'
//import info04 from './sections/informatique/04-operateurs'
//import info05 from './sections/informatique/05-conditions'
//import info06 from './sections/informatique/06-boucles'
//import info07 from './sections/informatique/07-chaines'
//import info08 from './sections/informatique/08-tableaux'
//import info09 from './sections/informatique/09-recherche'
//import info10 from './sections/informatique/10-tri'
//import info11 from './sections/informatique/11-modularite'
//import info12 from './sections/informatique/12-recursivite'
//import info13 from './sections/informatique/13-algos-arithmetiques'
//import info14 from './sections/informatique/14-algos-recurrents'
//import info15 from './sections/informatique/15-approximation'
//import info16 from './sections/informatique/16-tableaux-2d'
//import info17 from './sections/informatique/17-enregistrements-fichiers'
//import info18 from './sections/informatique/18-revision-bac'
//import info19 from './sections/informatique/19-sujets-bac'
//import info20 from './sections/informatique/20-examens-blancs'

// ═══════════════════════════════════════════════════════
// BAC SCIENTIFIQUE — 15 chapitres
// ═══════════════════════════════════════════════════════
//import sci01 from './sections/scientifique/01-algorithmique-python'
//import sci02 from './sections/scientifique/02-variables-entrees-sorties'
//import sci03 from './sections/scientifique/03-operateurs'
//import sci04 from './sections/scientifique/04-conditions'
//import sci05 from './sections/scientifique/05-boucles-while'
//import sci06 from './sections/scientifique/06-boucles-for'
//import sci07 from './sections/scientifique/07-exercices-numeriques'
//import sci08 from './sections/scientifique/08-chaines'
//import sci09 from './sections/scientifique/09-tableaux'
//import sci10 from './sections/scientifique/10-traitement-tableaux'
//import sci11 from './sections/scientifique/11-fonctions'
//import sci12 from './sections/scientifique/12-recherche-tri'
//import sci13 from './sections/scientifique/13-problemes-bac'
//import sci14 from './sections/scientifique/14-sujet-bac-guide'
//import sci15 from './sections/scientifique/15-examen-blanc'

// ═══════════════════════════════════════════════════════
// MAP : clé = "section-number" → contenu de la leçon
// ═══════════════════════════════════════════════════════
export const LESSONS = {
  // Informatique
  'informatique-1': info01,
  'informatique-2': info02,
 
}

/**
 * Récupérer une leçon
 * @param {string} sectionCode - 'informatique' ou 'scientifique'
 * @param {number} courseNumber - numéro du chapitre (1-20 ou 1-15)
 * @returns {Object|null} - la leçon ou null si introuvable
 */
export function getLesson(sectionCode, courseNumber) {
  const key = `${sectionCode}-${courseNumber}`
  return LESSONS[key] || null
}