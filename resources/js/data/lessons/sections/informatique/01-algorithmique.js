// resources/js/data/lessons/sections/informatique/01-algorithmique.js
export default {
  id: 'informatique-1',
  title: 'Algorithmique',
  subtitle: 'Apprendre à penser comme un ordinateur',
  duration: 30,
  xp: 100,

  objectives: [
    'Comprendre ce qu\'est un algorithme',
    'Reconnaître les 3 qualités d\'un bon algorithme',
    'Appliquer la méthode en 5 étapes',
    'Lire et écrire du pseudo-code',
    'Traduire un algorithme en Python',
    'Éviter les erreurs classiques',
  ],

  parts: [
    // ═══════════════════════════════════════════════════════
    // PARTIE 1 : L'ANALOGIE DU SANDWICH 
    // ═══════════════════════════════════════════════════════
    {
      title: 'Un robot qui fait des sandwichs',
      emoji: '',
      steps: [
        {
          prof: 'Imagine que tu as un robot à la maison. Il est très fort, mais il comprend RIEN tout seul.',
          student: 'Comme un petit enfant en fait ?',
          code: `<span class="code-comment"># Notre robot s'appelle "Robert" </span>
<span class="code-comment"># Il sait faire des actions</span>
<span class="code-comment"># Mais il ne devine rien !</span>`,
          explanation: 'Un ordinateur, c\'est pareil : il exécute ce qu\'on lui dit, sans réfléchir.',
          highlight: -1,
          console: 'Robert en ligne',
        },
        {
          prof: 'Tu lui dis : "Robert, fais-moi un sandwich !"',
          student: 'Facile, il va prendre du pain, du fromage...',
          code: `<span class="code-comment"># On donne l'ordre à Robert :</span>
<span class="code-string">"Fais-moi un sandwich !"</span>`,
          explanation: 'En français, c\'est très clair pour nous. Mais pour le robot...',
          highlight: -1,
          console: 'Robert réfléchit...',
        },
        {
          prof: 'Et là, Robert te répond : "Erreur. Je ne sais pas ce qu\'est un sandwich."',
          student: 'Ah oui ! Il ne connaît pas le mot !',
          code: `<span class="code-string">"Erreur : je ne connais pas 'sandwich'"</span>
<span class="code-comment"># Le robot est bloqué </span>`,
          explanation: 'L\'ordinateur ne devine jamais. Il a besoin d\'étapes TRÈS précises.',
          highlight: -1,
          console: 'Erreur : commande incomprise',
        },
        {
          prof: 'Alors on va lui expliquer ÉTAPE par ÉTAPE. Tu veux essayer ?',
          student: 'Oui, allons-y !',
          code: `<span class="code-comment"># On va tout décomposer</span>
<span class="code-comment"># Chaque petite action</span>
<span class="code-comment"># Dans l'ordre !</span>`,
          explanation: 'Décomposer un problème en petites étapes, c\'est ça la base de l\'algorithmique.',
          highlight: -1,
          console: 'Prêt à décomposer',
        },
        {
          prof: 'Étape 1 : "Prends 2 tranches de pain"',
          student: 'Ok facile !',
          code: `<span class="code-number">1.</span> Prendre 2 tranches de pain
   → main droite : 1 tranche
   → main gauche : 1 tranche`,
          explanation: 'On est très précis : combien de tranches, où les prendre.',
          highlight: -1,
          console: '2 tranches en main',
        },
        {
          prof: 'Étape 2 : "Pose du fromage sur la première tranche"',
          student: 'D\'accord, j\'imagine !',
          code: `<span class="code-number">2.</span> Poser 1 tranche de fromage
   sur la tranche de droite
   → fromage au centre`,
          explanation: 'Encore une fois, on précise QUOI, OÙ et COMBIEN.',
          highlight: 1,
          console: 'Fromage posé',
        },
        {
          prof: 'Étape 3 : "Referme le sandwich avec la tranche de gauche"',
          student: 'Presque fini !',
          code: `<span class="code-number">3.</span> Poser la tranche de gauche
   sur la tranche avec fromage`,
          explanation: 'On enchaîne les étapes dans l\'ordre.',
          highlight: 0,
          console: 'Sandwich refermé !',
        },
        {
          prof: 'Étape 4 : "C\'est prêt !"',
          student: 'Génial, il a compris !',
          code: `<span class="code-comment"># Robert a fini ! </span>
<span class="code-comment"># On lui a donné :</span>
<span class="code-comment"># → une suite d'étapes</span>
<span class="code-comment"># → dans le bon ordre</span>
<span class="code-comment"># → avec assez de détails</span>`,
          explanation: 'Et voilà ! Robert a fait exactement ce qu\'on lui a dit, étape par étape.',
          highlight: -1,
          console: 'Sandwich terminé ',
        },
        {
          prof: 'Cette suite d\'étapes qu\'on vient de donner à Robert... ça a un nom !',
          student: 'C\'est quoi ?',
          code: `<span class="code-keyword">Un ALGORITHME</span> !
<span class="code-comment"># = une suite d'étapes précises</span>
<span class="code-comment">#   pour résoudre un problème</span>`,
          explanation: 'Tu viens de créer ton premier algorithme sans le savoir !',
          highlight: -1,
          console: 'Bravo ! ',
        },
      ],
    },

    // ═══════════════════════════════════════════════════════
    // PARTIE 2 : LA VRAIE DÉFINITION 
    // ═══════════════════════════════════════════════════════
    {
      title: 'La définition officielle',
      emoji: '',
      steps: [
        {
          prof: 'Maintenant qu\'on a bien compris l\'idée, voici la définition du Bac :',
          student: 'D\'accord, donne-la moi.',
          code: `<span class="code-keyword">Algorithme</span> :
<span class="code-comment"># Une suite FINIE et ORDONNÉE d'étapes</span>
<span class="code-comment"># qui permet de résoudre un problème.</span>`,
          explanation: 'C\'est exactement ce qu\'on a fait pour le sandwich, mais formulé proprement.',
          highlight: -1,
          console: 'Définition notée',
        },
        {
          prof: 'Il y a 3 mots-clés dans cette définition. Regarde bien :',
          student: 'Je les cherche...',
          code: `Une suite <span class="code-string">FINIE</span> et <span class="code-string">ORDONNÉE</span> d'<span class="code-string">ÉTAPES</span>
qui résout un problème.`,
          explanation: 'FINIE, ORDONNÉE, ÉTAPES → ces 3 mots cachent les 3 règles d\'or qu\'on va voir.',
          highlight: -1,
          console: '3 mots clés trouvés',
        },
        {
          prof: 'Un algorithme, ça marche pour TOUT. Pas juste pour l\'informatique !',
          student: 'Ah bon ? Donne des exemples !',
          code: `<span class="code-comment"># Algorithmes du quotidien :</span>
<span class="code-comment"># → Recette de cuisine</span>
<span class="code-comment"># → Itinéraire de GPS</span>
<span class="code-comment"># → Calcul d'une moyenne</span>
<span class="code-comment"># → Ranger sa chambre</span>`,
          explanation: 'Chaque fois qu\'on suit des étapes dans l\'ordre, on exécute un algorithme.',
          highlight: -1,
          console: '4 exemples identifiés',
        },
        {
          prof: 'Mais en informatique, l\'algorithme est exécuté par... l\'ordinateur !',
          student: 'Donc il faut lui écrire super précisément.',
          code: `<span class="code-comment"># Recette pour un HUMAIN :</span>
"Mets du sel"

<span class="code-comment"># Recette pour un ORDINATEUR :</span>
Prendre la salière
Retirer le bouchon
Verser exactement 3 grammes`,
          explanation: 'L\'ordinateur ne devine JAMAIS. Il exécute à la lettre, même si c\'est absurde.',
          highlight: -1,
          console: 'Différence comprise',
        },
      ],
    },

    // ═══════════════════════════════════════════════════════
    // PARTIE 3 : LES RÈGLES D'OR (découverte par l'erreur)
    // ═══════════════════════════════════════════════════════
    {
      title: 'Les 3 règles d\'or',
      emoji: '',
      steps: [
        {
          prof: 'Regardons cette recette bizarre. Qu\'est-ce qui ne va pas ?',
          student: 'Euh... ça a l\'air de tourner en rond ?',
          code: `<span class="code-string">Recette du gâteau infini :</span>
<span class="code-number">1.</span> Casse un œuf
<span class="code-number">2.</span> Retourne à l'étape 1
<span class="code-number">3.</span> ...`,
          explanation: 'L\'étape 2 renvoie à l\'étape 1. On ne s\'arrête JAMAIS. On n\'aura jamais de gâteau.',
          highlight: -1,
          console: 'Boucle infinie détectée',
        },
        {
          prof: 'Donc un bon algorithme doit être... **FINI** !',
          student: 'Il doit toujours se terminer.',
          code: `<span class="code-string">Règle 1 : FINI</span>
<span class="code-comment"># L'algorithme doit se terminer</span>
<span class="code-comment"># dans un nombre fini d'étapes.</span>`,
          explanation: 'Sinon c\'est une "boucle infinie" → le programme plante.',
          highlight: -1,
          console: 'Règle 1 ✓',
        },
        {
          prof: 'Maintenant cette recette : "Mets du sel". Combien ? Où ? Comment ?',
          student: 'C\'est pas clair du tout !',
          code: `<span class="code-string">Recette floue :</span>
<span class="code-number">1.</span> Mets du sel
<span class="code-number">2.</span> Cuis un peu
<span class="code-number">3.</span> Assaisonne`,
          explanation: '"Un peu", "du sel"... c\'est trop vague pour un ordinateur.',
          highlight: -1,
          console: 'Erreur : commandes ambigües',
        },
        {
          prof: 'Donc un bon algorithme doit être... **PRÉCIS** !',
          student: 'Chaque étape doit être claire.',
          code: `<span class="code-string">Règle 2 : PRÉCIS</span>
<span class="code-comment"># Chaque étape doit être claire</span>
<span class="code-comment"># et sans ambiguïté.</span>`,
          explanation: 'On doit pouvoir exécuter chaque étape sans se poser de questions.',
          highlight: -1,
          console: 'Règle 2 ✓',
        },
        {
          prof: 'Dernier exemple : "Chauffe le four 3 heures pour cuire un œuf".',
          student: 'C\'est beaucoup trop long pour un œuf !',
          code: `<span class="code-string">Recette inefficace :</span>
<span class="code-number">1.</span> Chauffe le four 3 heures
<span class="code-number">2.</span> Casse un œuf
<span class="code-number">3.</span> Fais cuire 5 minutes`,
          explanation: 'On gaspille 3 heures de four pour rien. Le résultat est le même en 5 minutes.',
          highlight: -1,
          console: 'Gaspillage détecté',
        },
        {
          prof: 'Donc un bon algorithme doit être... **EFFICACE** !',
          student: 'Il doit utiliser le moins de ressources possible.',
          code: `<span class="code-string">Règle 3 : EFFICACE</span>
<span class="code-comment"># L'algorithme doit utiliser</span>
<span class="code-comment"># le minimum de ressources</span>
<span class="code-comment"># (temps, mémoire...)</span>`,
          explanation: 'Au Bac, un algorithme efficace gagne plus de points !',
          highlight: -1,
          console: 'Règle 3 ✓',
        },
        {
          prof: 'Récap : un bon algorithme est FINI, PRÉCIS et EFFICACE. Retiens bien ces 3 mots !',
          student: 'FINI-PRÉCIS-EFFICACE. Noté !',
          code: `<span class="code-keyword">Les 3 règles d'or :</span>
<span class="code-number">1.</span> <span class="code-string">FINI</span>      → il se termine
<span class="code-number">2.</span> <span class="code-string">PRÉCIS</span>    → étapes claires
<span class="code-number">3.</span> <span class="code-string">EFFICACE</span>  → peu de ressources`,
          explanation: 'Ces 3 règles reviennent dans TOUS les exercices du Bac.',
          highlight: -1,
          console: '3 règles retenues ✓',
        },
      ],
    },

    // ═══════════════════════════════════════════════════════
    // PARTIE 4 : LA MÉTHODE EN 5 ÉTAPES 
    // ═══════════════════════════════════════════════════════
    {
      title: 'La méthode en 5 étapes',
      emoji: '',
      steps: [
        {
          prof: 'Maintenant, comment on crée un algorithme à partir de zéro ? Voici LA méthode.',
          student: 'J\'écoute attentivement.',
          code: `<span class="code-keyword">La méthode en 5 étapes :</span>
<span class="code-number">1.</span> Comprendre
<span class="code-number">2.</span> Analyser
<span class="code-number">3.</span> Concevoir
<span class="code-number">4.</span> Écrire
<span class="code-number">5.</span> Vérifier`,
          explanation: 'On suit toujours ces 5 étapes, dans cet ordre. À chaque exercice du Bac.',
          highlight: -1,
          console: 'Méthode affichée',
        },
        {
          prof: 'ÉTAPE 1 : COMPRENDRE. On lit l\'énoncé 2 fois. On identifie ce qu\'on demande.',
          student: 'Donc pas de code tout de suite !',
          code: `<span class="code-keyword">Étape 1 : COMPRENDRE</span>
<span class="code-comment"># → Lire 2 fois l'énoncé</span>
<span class="code-comment"># → Identifier ce qu'on veut</span>
<span class="code-comment"># → Repérer les pièges</span>`,
          explanation: '80% des erreurs viennent d\'un énoncé mal lu. Prends ton temps.',
          highlight: -1,
          console: 'Énoncé compris',
        },
        {
          prof: 'ÉTAPE 2 : ANALYSER. Quelles sont les entrées ? Quelle est la sortie ?',
          student: 'Entrées = ce qu\'on reçoit. Sortie = ce qu\'on produit.',
          code: `<span class="code-keyword">Étape 2 : ANALYSER</span>
<span class="code-comment"># Entrées : les données fournies</span>
<span class="code-comment"># Sorties : le résultat attendu</span>

<span class="code-comment"># Exemple : moyenne de 3 notes</span>
<span class="code-comment"># Entrées → note1, note2, note3</span>
<span class="code-comment"># Sortie  → moyenne</span>`,
          explanation: 'Bien distinguer entrées et sorties évite beaucoup de confusion.',
          highlight: -1,
          console: 'Analyse terminée',
        },
        {
          prof: 'ÉTAPE 3 : CONCEVOIR. Comment passer des entrées aux sorties ?',
          student: 'C\'est là qu\'on cherche la méthode !',
          code: `<span class="code-keyword">Étape 3 : CONCEVOIR</span>
<span class="code-comment"># Trouver la méthode mathématique</span>
<span class="code-comment"># ou logique qui résout le problème</span>

<span class="code-comment"># Exemple :</span>
<span class="code-comment"># moyenne = (n1 + n2 + n3) / 3</span>`,
          explanation: 'La conception, c\'est le "cerveau" de l\'algorithme.',
          highlight: -1,
          console: 'Méthode trouvée',
        },
        {
          prof: 'ÉTAPE 4 : ÉCRIRE. On traduit en pseudo-code, puis en Python.',
          student: 'Enfin on code !',
          code: `<span class="code-keyword">Étape 4 : ÉCRIRE</span>
<span class="code-comment"># D'abord en pseudo-code (facile à lire)</span>
<span class="code-comment"># Puis en Python (exécutable)</span>

moyenne = (n1 + n2 + n3) / 3`,
          explanation: 'Le pseudo-code est proche du français. Python, c\'est pour l\'ordinateur.',
          highlight: -1,
          console: 'Code écrit',
        },
        {
          prof: 'ÉTAPE 5 : VÉRIFIER. On teste avec plusieurs exemples.',
          student: 'Avec des grandes, des petites valeurs, et 0 !',
          code: `<span class="code-keyword">Étape 5 : VÉRIFIER</span>
<span class="code-comment"># Test 1 : (10 + 15 + 20) / 3 = 15 ✓</span>
<span class="code-comment"># Test 2 : (0 + 0 + 0) / 3 = 0   ✓</span>
<span class="code-comment"># Test 3 : (20 + 20 + 20) / 3 = 20 ✓</span>`,
          explanation: 'Un seul test ne suffit JAMAIS. Il faut plusieurs cas.',
          highlight: -1,
          console: 'Tous les tests passent',
        },
      ],
    },

    // ═══════════════════════════════════════════════════════
    // PARTIE 5 : EXEMPLE COMPLET 
    // ═══════════════════════════════════════════════════════
    {
      title: 'Exemple : calculer une moyenne',
      emoji: '',
      steps: [
        {
          prof: 'On va appliquer la méthode ! Problème : un élève a 3 notes, on veut sa moyenne.',
          student: 'J\'applique la méthode en 5 étapes !',
          code: `<span class="code-keyword">Le problème :</span>
<span class="code-comment"># Entrées : 3 notes (15, 12, 18)</span>
<span class="code-comment"># Sortie  : la moyenne</span>`,
          explanation: 'On commence toujours par bien poser le problème.',
          memory: [],
          highlight: -1,
          console: 'Problème posé',
        },
        {
          prof: 'Étape 1 : COMPRENDRE. On lit 2 fois. On veut la moyenne de 3 notes.',
          student: 'C\'est clair, pas de piège.',
          code: `<span class="code-keyword">Étape 1 : COMPRENDRE</span>
<span class="code-comment"># → 3 notes données</span>
<span class="code-comment"># → Calculer leur moyenne</span>
<span class="code-comment"># → Afficher le résultat</span>`,
          explanation: 'On identifie clairement ce qu\'on doit faire.',
          memory: [],
          highlight: -1,
          console: 'Compris',
        },
        {
          prof: 'Étape 2 : ANALYSER. Entrées : note1, note2, note3. Sortie : moyenne.',
          student: 'Simple et clair.',
          code: `<span class="code-keyword">Étape 2 : ANALYSER</span>
<span class="code-comment"># Entrées :</span>
<span class="code-comment">#   note1 = 15</span>
<span class="code-comment">#   note2 = 12</span>
<span class="code-comment">#   note3 = 18</span>
<span class="code-comment"># Sortie :</span>
<span class="code-comment">#   moyenne</span>`,
          explanation: 'On note les entrées (données qu\'on a) et la sortie (résultat à produire).',
          memory: ['15', '12', '18'],
          highlight: -1,
          console: 'Entrées identifiées',
        },
        {
          prof: 'Étape 3 : CONCEVOIR. La méthode : (note1 + note2 + note3) / 3',
          student: 'C\'est la formule de la moyenne !',
          code: `<span class="code-keyword">Étape 3 : CONCEVOIR</span>
<span class="code-comment"># Méthode :</span>
moyenne = (note1 + note2 + note3) / 3`,
          explanation: 'La conception, c\'est trouver LA formule qui donne le résultat.',
          memory: ['15', '12', '18'],
          highlight: -1,
          console: 'Méthode prête',
        },
        {
          prof: 'Étape 4a : ÉCRIRE en pseudo-code. C\'est proche du français.',
          student: 'Je peux lire à voix haute !',
          code: `<span class="code-keyword">Algorithme</span> <span class="code-variable">Moyenne</span>
<span class="code-keyword">Variables</span> note1, note2, note3, moyenne : <span class="code-keyword">réel</span>
<span class="code-keyword">Début</span>
    <span class="code-function">Écrire</span> <span class="code-string">"Entrez les 3 notes"</span>
    <span class="code-function">Lire</span> note1, note2, note3
    moyenne <span class="code-operator">←</span> (note1 <span class="code-operator">+</span> note2 <span class="code-operator">+</span> note3) <span class="code-operator">/</span> <span class="code-number">3</span>
    <span class="code-function">Écrire</span> <span class="code-string">"La moyenne est : "</span>, moyenne
<span class="code-keyword">Fin</span>`,
          explanation: 'Le pseudo-code est la traduction en français structuré de notre méthode.',
          memory: ['note1', 'note2', 'note3', 'moyenne'],
          highlight: -1,
          console: 'Pseudo-code écrit',
        },
        {
          prof: 'Étape 4b : Traduire en Python.',
          student: 'C\'est du vrai code là !',
          code: `<span class="code-comment"># Demander les 3 notes</span>
note1 <span class="code-operator">=</span> <span class="code-function">float</span>(<span class="code-function">input</span>(<span class="code-string">"Note 1 : "</span>))
note2 <span class="code-operator">=</span> <span class="code-function">float</span>(<span class="code-function">input</span>(<span class="code-string">"Note 2 : "</span>))
note3 <span class="code-operator">=</span> <span class="code-function">float</span>(<span class="code-function">input</span>(<span class="code-string">"Note 3 : "</span>))

<span class="code-comment"># Calculer la moyenne</span>
moyenne <span class="code-operator">=</span> (note1 <span class="code-operator">+</span> note2 <span class="code-operator">+</span> note3) <span class="code-operator">/</span> <span class="code-number">3</span>

<span class="code-comment"># Afficher</span>
<span class="code-function">print</span>(<span class="code-string">"La moyenne est :"</span>, moyenne)`,
          explanation: 'float() convertit le texte saisi en nombre décimal.',
          memory: ['note1', 'note2', 'note3', 'moyenne'],
          highlight: -1,
          console: 'Code Python prêt',
        },
        {
          prof: 'Regarde la mémoire pendant l\'exécution. Chaque variable est une boîte !',
          student: 'Je vois les valeurs qui s\'ajoutent.',
          code: `<span class="code-comment"># Exécution pas à pas :</span>
<span class="code-comment"># 1. Lire note1 → 15.0</span>
<span class="code-comment"># 2. Lire note2 → 12.5</span>
<span class="code-comment"># 3. Lire note3 → 18.0</span>
<span class="code-comment"># 4. Calculer moyenne</span>`,
          explanation: 'L\'ordinateur stocke chaque valeur dans une "case" mémoire.',
          memory: ['15.0', '12.5', '18.0'],
          highlight: 2,
          console: 'Variables remplies',
        },
        {
          prof: 'Et voilà le résultat final : la moyenne est calculée et affichée !',
          student: 'Ça marche ! 15 + 12.5 + 18 = 45.5, divisé par 3 = 15.17',
          code: `<span class="code-comment"># Résultat final :</span>
moyenne <span class="code-operator">=</span> <span class="code-number">15.17</span>
<span class="code-function">print</span>(<span class="code-string">"La moyenne est :"</span>, moyenne)`,
          explanation: 'On a transformé un problème en algorithme, puis en code qui marche !',
          memory: ['15.0', '12.5', '18.0', '15.17'],
          highlight: 3,
          console: 'La moyenne est : 15.166666666666666',
        },
        {
          prof: 'Étape 5 : VÉRIFIER. Testons avec d\'autres valeurs pour être sûr.',
          student: 'Avec 20, 20, 20 on doit avoir 20.',
          code: `<span class="code-comment"># Test 1 : (10 + 15 + 20) / 3 = 15   ✓</span>
<span class="code-comment"># Test 2 : (0 + 0 + 0) / 3 = 0       ✓</span>
<span class="code-comment"># Test 3 : (20 + 20 + 20) / 3 = 20   ✓</span>`,
          explanation: 'On teste avec plusieurs cas pour vérifier que ça marche toujours.',
          memory: ['15.0', '12.5', '18.0', '15.17'],
          highlight: -1,
          console: 'Tous les tests passent ✓',
        },
      ],
    },

    // ═══════════════════════════════════════════════════════
    // PARTIE 6 : EXEMPLE 2 — PAIR OU IMPAIR 
    // ═══════════════════════════════════════════════════════
    {
      title: 'Exemple 2 : pair ou impair ?',
      emoji: '',
      steps: [
        {
          prof: 'Nouveau défi : comment savoir si un nombre est pair ou impair ?',
          student: 'Je regarde s\'il se divise par 2 ?',
          code: `<span class="code-comment"># Problème :</span>
<span class="code-comment"># Un nombre est donné</span>
<span class="code-comment"># Dire s'il est pair ou impair</span>`,
          explanation: 'C\'est un grand classique du Bac. On va utiliser l\'opérateur %.',
          memory: [],
          highlight: -1,
          console: 'Nouveau défi',
        },
        {
          prof: 'En Python, l\'opérateur % donne le RESTE d\'une division.',
          student: 'Ah oui, modulo !',
          code: `<span class="code-comment"># Modulo %</span>
<span class="code-number">10</span> <span class="code-operator">%</span> <span class="code-number">2</span> <span class="code-operator">=</span> <span class="code-number">0</span>   <span class="code-comment"># 10 = 5×2 + 0</span>
<span class="code-number">7</span>  <span class="code-operator">%</span> <span class="code-number">2</span> <span class="code-operator">=</span> <span class="code-number">1</span>   <span class="code-comment"># 7  = 3×2 + 1</span>
<span class="code-number">15</span> <span class="code-operator">%</span> <span class="code-number">2</span> <span class="code-operator">=</span> <span class="code-number">1</span>   <span class="code-comment"># impair</span>`,
          explanation: 'Si n % 2 == 0, le nombre est pair. Sinon, il est impair.',
          memory: ['10 % 2 = 0', '7 % 2 = 1', '15 % 2 = 1'],
          highlight: -1,
          console: 'Modulo compris',
        },
        {
          prof: 'Donc l\'algorithme : si n % 2 == 0 → pair, sinon → impair.',
          student: 'Logique !',
          code: `<span class="code-keyword">Algorithme</span> <span class="code-variable">PairOuImpair</span>
<span class="code-keyword">Variables</span> n : entier
<span class="code-keyword">Début</span>
    <span class="code-function">Lire</span> n
    <span class="code-keyword">Si</span> n <span class="code-operator">%</span> <span class="code-number">2</span> <span class="code-operator">=</span> <span class="code-number">0</span> <span class="code-keyword">Alors</span>
        <span class="code-function">Écrire</span> <span class="code-string">"Pair"</span>
    <span class="code-keyword">Sinon</span>
        <span class="code-function">Écrire</span> <span class="code-string">"Impair"</span>
    <span class="code-keyword">FinSi</span>
<span class="code-keyword">Fin</span>`,
          explanation: 'Si... Alors... Sinon... : la structure conditionnelle de base.',
          memory: ['n = ?', 'n % 2 = ?'],
          highlight: -1,
          console: 'Algorithme écrit',
        },
        {
          prof: 'En Python :',
          student: 'J\'écris la même chose !',
          code: `n <span class="code-operator">=</span> <span class="code-function">int</span>(<span class="code-function">input</span>(<span class="code-string">"Entrez un nombre : "</span>))

<span class="code-keyword">if</span> n <span class="code-operator">%</span> <span class="code-number">2</span> <span class="code-operator">==</span> <span class="code-number">0</span>:
    <span class="code-function">print</span>(n, <span class="code-string">"est pair"</span>)
<span class="code-keyword">else</span>:
    <span class="code-function">print</span>(n, <span class="code-string">"est impair"</span>)`,
          explanation: 'int() convertit le texte en nombre entier.',
          memory: ['n = 7'],
          highlight: 0,
          console: 'Entrez un nombre : 7\n7 est impair',
        },
        {
          prof: 'Testons avec plusieurs valeurs !',
          student: 'Je prédis : 12 → pair, 7 → impair, 0 → pair.',
          code: `<span class="code-comment"># Test 1 : 12 → pair   ✓</span>
<span class="code-comment"># Test 2 : 7  → impair ✓</span>
<span class="code-comment"># Test 3 : 0  → pair   ✓</span>`,
          explanation: '3 tests, 3 résultats corrects → l\'algorithme est validé !',
          memory: ['12 → pair', '7 → impair', '0 → pair'],
          highlight: -1,
          console: 'Tous les tests passent ✓',
        },
      ],
    },

    // ═══════════════════════════════════════════════════════
// PARTIE 7 : QUIZ FINAL 
// ═══════════════════════════════════════════════════════
{
  title: 'Vérifions ta compréhension',
  emoji: '',
  steps: [
    {
      prof: 'Premier quiz ! C\'est quoi un algorithme ?',
      student: 'Hmm... je réfléchis...',
      quiz: {
        question: 'Qu\'est-ce qu\'un algorithme ?',
        options: [
          { id: 'a', text: 'Un langage de programmation' },
          { id: 'b', text: 'Une suite d\'étapes précises pour résoudre un problème' },
          { id: 'c', text: 'Un logiciel informatique' },
          { id: 'd', text: 'Un ordinateur puissant' },
        ],
        correctId: 'b',
        explanation: 'C\'est exactement ça : une suite d\'étapes précises et ordonnées.',
      },
    },
    {
      prof: 'Deuxième quiz ! Quelles sont les 3 qualités d\'un bon algorithme ?',
      student: 'Je crois que je les ai retenues...',
      quiz: {
        question: 'Quelles sont les 3 règles d\'or d\'un bon algorithme ?',
        options: [
          { id: 'a', text: 'Rapide, joli, court' },
          { id: 'b', text: 'Fini, précis, efficace' },
          { id: 'c', text: 'Long, compliqué, secret' },
          { id: 'd', text: 'Simple, court, gratuit' },
        ],
        correctId: 'b',
        explanation: 'FINI (se termine), PRÉCIS (étapes claires), EFFICACE (peu de ressources).',
      },
    },
    {
      prof: 'Troisième quiz ! Quelle est la 1ère étape de la méthode ?',
      student: 'Laisse-moi me souvenir...',
      quiz: {
        question: 'Quelle est la 1ère étape pour créer un algorithme ?',
        options: [
          { id: 'a', text: 'Écrire le code Python' },
          { id: 'b', text: 'Allumer l\'ordinateur' },
          { id: 'c', text: 'Comprendre l\'énoncé' },
          { id: 'd', text: 'Chercher sur internet' },
        ],
        correctId: 'c',
        explanation: 'Sans comprendre l\'énoncé, on écrit du code inutile. Toujours commencer par COMPRENDRE.',
      },
    },
    {
      prof: 'Dernier quiz ! Que fait ce code : `n % 2 == 0` ?',
      student: 'Je regarde bien l\'expression...',
      quiz: {
        question: 'Que teste l\'expression `n % 2 == 0` ?',
        options: [
          { id: 'a', text: 'Si n est plus grand que 2' },
          { id: 'b', text: 'Si n est divisible par 2 (pair)' },
          { id: 'c', text: 'Si n vaut 0' },
          { id: 'd', text: 'Si n est négatif' },
        ],
        correctId: 'b',
        explanation: 'n % 2 = reste de la division par 2. S\'il vaut 0, n est pair.',
      },
    },
    {
      prof: 'Bravo ! Tu as terminé cette leçon. Tu sais maintenant ce qu\'est un algorithme, ses 3 règles d\'or, et la méthode en 5 étapes.',
      student: 'Merci Prof ! J\'ai tout compris ',
      code: `<span class="code-keyword"> Leçon terminée !</span>
<span class="code-comment"># Tu as appris :</span>
<span class="code-comment"># ✓ Ce qu'est un algorithme</span>
<span class="code-comment"># ✓ Les 3 règles d'or</span>
<span class="code-comment"># ✓ La méthode en 5 étapes</span>
<span class="code-comment"># ✓ 2 exemples concrets</span>`,
      explanation: 'Dans la prochaine leçon, on verra les VARIABLES et les TYPES.',
      highlight: -1,
      console: 'Félicitations ! +100 XP ',
    },
  ],
},
  ],
}