// resources/js/data/lessons/informatique/chapter2.js

export default  {
  id: 'informatique-2',
  title: 'Variables et types en Python',
  courseNumber: 2,
  xp: 150,
  duration: 45,

  objectives: [
    "Comprendre ce qu'est une variable et la notion d'espace mémoire",
    "Déclarer, initialiser et modifier une variable en Python",
    "Reconnaître les 4 types fondamentaux : int, float, str, bool",
    "Utiliser input() avec conversion de type",
    "Effectuer des opérations sur les variables",
    "Suivre l'évolution des variables instruction par instruction"
  ],

  parts: [
    // ═══════════════════════════════════════════════
    // PARTIE 1 : COMPRENDRE LA VARIABLE
    // ═══════════════════════════════════════════════
    {
      title: 'Comprendre la variable',
      steps: [
        {
          prof: "Salut ! Aujourd'hui, on découvre la notion la PLUS importante en programmation : la variable. Imagine que tu veux retenir l'âge d'un élève. Où est-ce que l'ordinateur garde cette information ?",
          student: "Euh... dans un fichier ? Dans le processeur ?",
          code: `<span class="code-comment"># On veut mémoriser l'âge d'un élève</span>
<span class="code-variable">age</span> <span class="code-operator">=</span> <span class="code-number">17</span>`,
          explanation: "L'ordinateur a besoin d'un espace en mémoire pour retenir la valeur 17. On appelle cet espace une VARIABLE.",
          memory: ['17'],
          highlight: 0,
          console: '>>> (aucun affichage, la valeur est juste stockée)'
        },
        {
          prof: "Une variable, c'est comme une boîte étiquetée. L'étiquette c'est le NOM, et à l'intérieur il y a la VALEUR. Ici, la boîte s'appelle 'age' et contient 17.",
          student: "D'accord ! Donc si je veux retenir un nom, je fais pareil ?",
          code: `<span class="code-variable">age</span> <span class="code-operator">=</span> <span class="code-number">17</span>
<span class="code-variable">nom</span> <span class="code-operator">=</span> <span class="code-string">"Ahmed"</span>
<span class="code-variable">moyenne</span> <span class="code-operator">=</span> <span class="code-number">15.75</span>`,
          explanation: "Exact ! On peut créer autant de variables que nécessaire. Chaque nom est unique et identifie un espace mémoire.",
          memory: ['17', '"Ahmed"', '15.75'],
          highlight: null,
          console: '>>> (3 variables créées en mémoire)'
        },
        {
          prof: "Pour voir ce qu'il y a dans une variable, on utilise print(). C'est comme ouvrir la boîte pour regarder dedans.",
          student: "Donc print(age) va afficher 17 ?",
          code: `<span class="code-variable">age</span> <span class="code-operator">=</span> <span class="code-number">17</span>
<span class="code-function">print</span>(<span class="code-variable">age</span>)`,
          explanation: "Oui ! print() affiche la VALEUR contenue dans la variable, pas son nom.",
          memory: ['17'],
          highlight: 0,
          console: '>>> 17'
        }
      ]
    },

    // ═══════════════════════════════════════════════
    // PARTIE 2 : AFFECTATION
    // ═══════════════════════════════════════════════
    {
      title: 'Affectation',
      steps: [
        {
          prof: "L'affectation, c'est l'action de METTRE une valeur dans une variable. Le symbole = n'est PAS une égalité mathématique !",
          student: "Comment ça ? = c'est 'égal' normalement...",
          code: `<span class="code-variable">x</span> <span class="code-operator">=</span> <span class="code-number">10</span>`,
          explanation: "En Python, = signifie : 'mets la valeur 10 DANS la variable x'. C'est une instruction, pas une équation !",
          memory: ['10'],
          highlight: 0,
          console: '>>> (x contient maintenant 10)'
        },
        {
          prof: "Point crucial : si on réaffecte une variable, l'ANCIENNE valeur est écrasée. Regarde bien !",
          student: "Oh ! Donc la valeur 10 disparaît ?",
          code: `<span class="code-variable">x</span> <span class="code-operator">=</span> <span class="code-number">10</span>
<span class="code-variable">x</span> <span class="code-operator">=</span> <span class="code-number">20</span>`,
          explanation: "Exact ! La valeur 10 est perdue et remplacée par 20. Une variable ne contient qu'UNE SEULE valeur à la fois.",
          memory: ['20'],
          highlight: 0,
          console: '>>> (x vaut maintenant 20, la valeur 10 est perdue)'
        },
        {
          prof: "Encore plus fort : imagine trois affectations successives. Devine la valeur finale de x ?",
          student: "Hmm... la dernière ? 12 ?",
          code: `<span class="code-variable">x</span> <span class="code-operator">=</span> <span class="code-number">5</span>
<span class="code-variable">x</span> <span class="code-operator">=</span> <span class="code-number">8</span>
<span class="code-variable">x</span> <span class="code-operator">=</span> <span class="code-number">12</span>
<span class="code-function">print</span>(<span class="code-variable">x</span>)`,
          explanation: "Bravo ! x = 12. Chaque affectation remplace la précédente.",
          memory: ['12'],
          highlight: 0,
          console: '>>> 12'
        }
      ]
    },

    // ═══════════════════════════════════════════════
    // PARTIE 3 : x = x + 1 (piège du Bac)
    // ═══════════════════════════════════════════════
    {
      title: 'x = x + 1 (piège classique)',
      steps: [
        {
          prof: "Attention, on arrive au PIÈGE le plus fréquent au Bac ! Regarde bien cette instruction : x = x + 1. À ton avis, c'est possible mathématiquement ?",
          student: "Bah non ! x ne peut pas être égal à x + 1...",
          code: `<span class="code-variable">x</span> <span class="code-operator">=</span> <span class="code-number">5</span>
<span class="code-variable">x</span> <span class="code-operator">=</span> <span class="code-variable">x</span> <span class="code-operator">+</span> <span class="code-number">1</span>`,
          explanation: "Tu as raison EN MATHÉMATIQUES. Mais en programmation, = c'est une AFFECTATION. L'ordinateur lit d'abord la partie DROITE, puis l'affecte à gauche.",
          memory: ['5'],
          highlight: 0,
          console: '>>> (chargement...)'
        },
        {
          prof: "Déroulons étape par étape. D'abord Python lit 'x + 1' : il prend la valeur actuelle de x (5), ajoute 1, obtient 6. PUIS il met 6 dans x.",
          student: "Ah ok ! Donc c'est : nouvelle_valeur = ancienne_valeur + 1 ?",
          code: `<span class="code-comment"># Étape 1 : x vaut 5</span>
<span class="code-variable">x</span> <span class="code-operator">=</span> <span class="code-number">5</span>

<span class="code-comment"># Étape 2 : on calcule x + 1 → 6, puis on stocke dans x</span>
<span class="code-variable">x</span> <span class="code-operator">=</span> <span class="code-variable">x</span> <span class="code-operator">+</span> <span class="code-number">1</span>`,
          explanation: "Exactement ! C'est LA notion à retenir. Cette instruction est utilisée partout pour incrémenter un compteur.",
          memory: ['6'],
          highlight: 0,
          console: '>>> x vaut maintenant 6'
        },
        {
          prof: "Vérifions ta compréhension avec un petit défi !",
          student: "Je suis prêt !",
          quiz: {
            question: "Après ce programme, quelle est la valeur finale de n ?",
            code: `<span class="code-variable">n</span> <span class="code-operator">=</span> <span class="code-number">3</span>
<span class="code-variable">n</span> <span class="code-operator">=</span> <span class="code-variable">n</span> <span class="code-operator">*</span> <span class="code-number">2</span>
<span class="code-variable">n</span> <span class="code-operator">=</span> <span class="code-variable">n</span> <span class="code-operator">+</span> <span class="code-number">4</span>`,
            options: [
              { id: 'a', text: '3' },
              { id: 'b', text: '6' },
              { id: 'c', text: '10' },
              { id: 'd', text: '14' }
            ],
            correctId: 'c',
            explanation: "n = 3 → n = 3 × 2 = 6 → n = 6 + 4 = 10. Bravo si tu as suivi chaque étape !"
          }
        }
      ]
    },

    // ═══════════════════════════════════════════════
    // PARTIE 4 : LES TYPES DE DONNÉES
    // ═══════════════════════════════════════════════
    {
      title: 'Les 4 types fondamentaux',
      steps: [
        {
          prof: "En Python, chaque valeur a un TYPE. On va voir les 4 types à connaître absolument pour le Bac : int, float, str et bool.",
          student: "C'est quoi la différence entre tous ces types ?",
          code: `<span class="code-variable">age</span> <span class="code-operator">=</span> <span class="code-number">17</span>          <span class="code-comment"># int (entier)</span>
<span class="code-variable">prix</span> <span class="code-operator">=</span> <span class="code-number">12.5</span>       <span class="code-comment"># float (réel)</span>
<span class="code-variable">nom</span> <span class="code-operator">=</span> <span class="code-string">"Ahmed"</span>    <span class="code-comment"># str (chaîne)</span>
<span class="code-variable">majeur</span> <span class="code-operator">=</span> <span class="code-keyword">True</span>     <span class="code-comment"># bool (booléen)</span>`,
          explanation: "int = nombre entier | float = nombre décimal | str = texte | bool = True ou False",
          memory: ['17', '12.5', '"Ahmed"', 'True'],
          highlight: null,
          console: '>>> (4 variables de 4 types différents)'
        },
        {
          prof: "Détail IMPORTANT pour les float : Python utilise le POINT décimal, pas la virgule !",
          student: "Donc 12,5 en français s'écrit 12.5 en Python ?",
          code: `<span class="code-comment"># ❌ INCORRECT en Python</span>
<span class="code-variable">prix</span> <span class="code-operator">=</span> <span class="code-number">12,5</span>

<span class="code-comment"># ✅ CORRECT</span>
<span class="code-variable">prix</span> <span class="code-operator">=</span> <span class="code-number">12.5</span>`,
          explanation: "En Python, 12,5 crée en fait un TUPLE (12, 5), ce qui n'est pas du tout ce qu'on veut !",
          memory: ['12.5'],
          highlight: 0,
          console: '>>> (12.5 est bien un float)'
        },
        {
          prof: "Pour les booléens, il n'y a que DEUX valeurs possibles, et elles commencent par une MAJUSCULE !",
          student: "True et False, avec majuscule !",
          code: `<span class="code-variable">majeur</span> <span class="code-operator">=</span> <span class="code-keyword">True</span>
<span class="code-variable">connecte</span> <span class="code-operator">=</span> <span class="code-keyword">False</span>

<span class="code-comment"># ❌ Erreur : true et false en minuscules</span>
<span class="code-comment"># majeur = true</span>`,
          explanation: "True et False sont des mots-clés Python. Une majuscule mal placée = erreur NameError.",
          memory: ['True', 'False'],
          highlight: null,
          console: '>>> (les 2 valeurs booléennes en mémoire)'
        }
      ]
    },

    // ═══════════════════════════════════════════════
    // PARTIE 5 : IDENTIFIER LE TYPE — type()
    // ═══════════════════════════════════════════════
    {
      title: 'Identifier le type avec type()',
      steps: [
        {
          prof: "Python offre une fonction magique : type(). Elle te dit à quelle famille appartient une valeur.",
          student: "Pratique ! Comment on l'utilise ?",
          code: `<span class="code-variable">age</span> <span class="code-operator">=</span> <span class="code-number">17</span>
<span class="code-function">print</span>(<span class="code-function">type</span>(<span class="code-variable">age</span>))`,
          explanation: "On passe la variable à type(), puis on affiche le résultat avec print().",
          memory: ['17'],
          highlight: 0,
          console: ">>> <class 'int'>"
        },
        {
          prof: "Testons les 4 types pour bien voir la différence. Regarde bien ce que print() affiche pour chacun.",
          student: "Je note les résultats !",
          code: `<span class="code-function">print</span>(<span class="code-function">type</span>(<span class="code-number">17</span>))       <span class="code-comment"># int</span>
<span class="code-function">print</span>(<span class="code-function">type</span>(<span class="code-number">15.5</span>))     <span class="code-comment"># float</span>
<span class="code-function">print</span>(<span class="code-function">type</span>(<span class="code-string">"Ahmed"</span>))  <span class="code-comment"># str</span>
<span class="code-function">print</span>(<span class="code-function">type</span>(<span class="code-keyword">True</span>))     <span class="code-comment"># bool</span>`,
          explanation: "Python renvoie toujours <class 'type'>. Le nom entre quotes est le nom du type.",
          memory: [],
          highlight: null,
          console: ">>> <class 'int'>\n>>> <class 'float'>\n>>> <class 'str'>\n>>> <class 'bool'>"
        },
        {
          prof: "Petit piège : quel est le type de '17' (entre guillemets) ?",
          student: "Attends... si c'est entre guillemets, c'est du texte, donc str ?",
          quiz: {
            question: "Quel est le type de la valeur x = '17' ?",
            options: [
              { id: 'a', text: 'int' },
              { id: 'b', text: 'float' },
              { id: 'c', text: 'str' },
              { id: 'd', text: 'bool' }
            ],
            correctId: 'c',
            explanation: "Les guillemets font TOUTE la différence ! '17' est une chaîne de caractères, pas un entier. C'est le fameux piège entre 17 et \"17\"."
          }
        }
      ]
    },

    // ═══════════════════════════════════════════════
    // PARTIE 6 : INPUT ET CONVERSION
    // ═══════════════════════════════════════════════
    {
      title: 'input() et conversion de type',
      steps: [
        {
          prof: "Pour demander une info à l'utilisateur, on utilise input(). Mais ATTENTION : input() renvoie TOUJOURS une chaîne !",
          student: "Même si l'utilisateur tape un nombre ?",
          code: `<span class="code-variable">nom</span> <span class="code-operator">=</span> <span class="code-function">input</span>(<span class="code-string">"Votre nom : "</span>)
<span class="code-function">print</span>(<span class="code-variable">nom</span>)`,
          explanation: "L'utilisateur tape 'Ahmed'. Python stocke 'Ahmed' dans nom. Jusque-là, pas de problème.",
          memory: ['"Ahmed"'],
          highlight: 0,
          console: 'Votre nom : Ahmed\n>>> Ahmed'
        },
        {
          prof: "MAIS si l'utilisateur tape un nombre, input() le transforme quand même en CHAÎNE. Regarde bien ce piège !",
          student: "Ah oui, l'utilisateur tape 17 sans guillemets mais Python reçoit \"17\" ?",
          code: `<span class="code-variable">age</span> <span class="code-operator">=</span> <span class="code-function">input</span>(<span class="code-string">"Votre âge : "</span>)
<span class="code-function">print</span>(<span class="code-function">type</span>(<span class="code-variable">age</span>))`,
          explanation: "Résultat : <class 'str'> ! Même si l'utilisateur tape 17, age est une CHAÎNE.",
          memory: ['"17"'],
          highlight: 0,
          console: "Votre âge : 17\n>>> <class 'str'>"
        },
        {
          prof: "Solution : on CONVERTIT avec int() ou float(). C'est la fonction qui transforme la chaîne en nombre.",
          student: "Donc int(input(...)) c'est pour un entier ?",
          code: `<span class="code-variable">age</span> <span class="code-operator">=</span> <span class="code-function">int</span>(<span class="code-function">input</span>(<span class="code-string">"Votre âge : "</span>))
<span class="code-variable">prix</span> <span class="code-operator">=</span> <span class="code-function">float</span>(<span class="code-function">input</span>(<span class="code-string">"Prix : "</span>))
<span class="code-function">print</span>(<span class="code-function">type</span>(<span class="code-variable">age</span>))`,
          explanation: "Parfait ! int() pour un entier, float() pour un réel. La chaîne est transformée en nombre.",
          memory: ['17', '12.5'],
          highlight: null,
          console: "Votre âge : 17\nPrix : 12.5\n>>> <class 'int'>"
        },
        {
          prof: "Vérifions : que se passe-t-il si on oublie int() ?",
          student: "Je suppose qu'on ne peut pas calculer avec une chaîne ?",
          quiz: {
            question: "Quel est le problème dans ce code ?",
            code: `<span class="code-variable">age</span> <span class="code-operator">=</span> <span class="code-function">input</span>(<span class="code-string">"Âge : "</span>)
<span class="code-variable">futur</span> <span class="code-operator">=</span> <span class="code-variable">age</span> <span class="code-operator">+</span> <span class="code-number">1</span>`,
            options: [
              { id: 'a', text: 'Ça marche, futur = "171"' },
              { id: 'b', text: 'Erreur : on ne peut pas additionner str + int' },
              { id: 'c', text: 'Ça marche, futur = 18' },
              { id: 'd', text: 'Python convertit automatiquement' }
            ],
            correctId: 'b',
            explanation: "Python refuse d'additionner une chaîne et un entier. TypeError ! Il faut écrire : int(input(...)) + 1."
          }
        }
      ]
    },

    // ═══════════════════════════════════════════════
    // PARTIE 7 : OPÉRATEURS NUMÉRIQUES
    // ═══════════════════════════════════════════════
    {
      title: 'Opérateurs numériques',
      steps: [
        {
          prof: "Python offre 7 opérateurs numériques essentiels. On en connaît 4 en maths, mais les 3 autres sont spécifiques à la programmation.",
          student: "Lesquels sont nouveaux ?",
          code: `<span class="code-variable">a</span> <span class="code-operator">=</span> <span class="code-number">17</span>
<span class="code-variable">b</span> <span class="code-operator">=</span> <span class="code-number">5</span>

<span class="code-function">print</span>(<span class="code-variable">a</span> <span class="code-operator">+</span> <span class="code-variable">b</span>)   <span class="code-comment"># addition → 22</span>
<span class="code-function">print</span>(<span class="code-variable">a</span> <span class="code-operator">-</span> <span class="code-variable">b</span>)   <span class="code-comment"># soustraction → 12</span>
<span class="code-function">print</span>(<span class="code-variable">a</span> <span class="code-operator">*</span> <span class="code-variable">b</span>)   <span class="code-comment"># multiplication → 85</span>
<span class="code-function">print</span>(<span class="code-variable">a</span> <span class="code-operator">/</span> <span class="code-variable">b</span>)   <span class="code-comment"># division → 3.4</span>`,
          explanation: "+ - * / sont les opérateurs classiques. Attention : / renvoie TOUJOURS un float !",
          memory: ['17', '5'],
          highlight: null,
          console: '>>> 22\n>>> 12\n>>> 85\n>>> 3.4'
        },
        {
          prof: "Maintenant les 3 opérateurs spéciaux. Le premier : // (division ENTIÈRE). Il jette la partie décimale.",
          student: "Donc 17 // 5 = 3 ?",
          code: `<span class="code-variable">a</span> <span class="code-operator">=</span> <span class="code-number">17</span>
<span class="code-variable">b</span> <span class="code-operator">=</span> <span class="code-number">5</span>

<span class="code-function">print</span>(<span class="code-variable">a</span> <span class="code-operator">//</span> <span class="code-variable">b</span>)  <span class="code-comment"># division entière → 3</span>
<span class="code-function">print</span>(<span class="code-variable">a</span> <span class="code-operator">%</span> <span class="code-variable">b</span>)   <span class="code-comment"># modulo (reste) → 2</span>
<span class="code-function">print</span>(<span class="code-variable">a</span> <span class="code-operator">**</span> <span class="code-number">2</span>)  <span class="code-comment"># puissance → 289</span>`,
          explanation: "// → quotient entier | % → reste | ** → puissance. À retenir absolument !",
          memory: ['17', '5'],
          highlight: null,
          console: '>>> 3\n>>> 2\n>>> 289'
        },
        {
          prof: "Application classique : le modulo % sert à savoir si un nombre est PAIR. Un nombre est pair si n % 2 == 0.",
          student: "Ah oui ! C'est très utile pour les exercices.",
          quiz: {
            question: "Quel est le résultat de 15 % 4 ?",
            options: [
              { id: 'a', text: '3' },
              { id: 'b', text: '3.75' },
              { id: 'c', text: '4' },
              { id: 'd', text: '0' }
            ],
            correctId: 'a',
            explanation: "15 ÷ 4 = 3 reste 3. Le modulo renvoie le RESTE, donc 3."
          }
        }
      ]
    },

    // ═══════════════════════════════════════════════
    // PARTIE 8 : SUIVRE L'EXÉCUTION (Défi Bac)
    // ═══════════════════════════════════════════════
    {
      title: "Défi Bac : suivre l'exécution",
      steps: [
        {
          prof: "Voici L'EXERCICE type du Bac : suivre l'évolution des variables. On construit un tableau avec une ligne par instruction.",
          student: "C'est quoi la méthode exacte ?",
          code: `<span class="code-variable">a</span> <span class="code-operator">=</span> <span class="code-number">5</span>
<span class="code-variable">b</span> <span class="code-operator">=</span> <span class="code-number">3</span>
<span class="code-variable">a</span> <span class="code-operator">=</span> <span class="code-variable">a</span> <span class="code-operator">+</span> <span class="code-variable">b</span>
<span class="code-variable">b</span> <span class="code-operator">=</span> <span class="code-variable">a</span> <span class="code-operator">-</span> <span class="code-variable">b</span>`,
          explanation: "Méthode : on lit ligne par ligne. À chaque ligne, on note la valeur de CHAQUE variable.",
          memory: [],
          highlight: null,
          console: '>>> (à suivre...)'
        },
        {
          prof: "Ligne 1 : a = 5. Ligne 2 : b = 3. Ligne 3 : a = a + b = 5 + 3 = 8. Ligne 4 : b = a - b = 8 - 3 = 5.",
          student: "Attention ! À la ligne 4, a vaut DÉJÀ 8, pas 5 !",
          code: `<span class="code-comment"># Tableau d'exécution :</span>
<span class="code-comment"># Instruction   | a | b</span>
<span class="code-comment"># --------------|---|---</span>
<span class="code-comment"># a = 5         | 5 | —</span>
<span class="code-comment"># b = 3         | 5 | 3</span>
<span class="code-comment"># a = a + b     | 8 | 3</span>
<span class="code-comment"># b = a - b     | 8 | 5</span>

<span class="code-function">print</span>(<span class="code-variable">a</span>, <span class="code-variable">b</span>)`,
          explanation: "Valeurs finales : a = 8, b = 5. Bravo, tu as bien suivi !",
          memory: ['8', '5'],
          highlight: null,
          console: '>>> 8 5'
        },
        {
          prof: "Défi final : un vrai programme du Bac. Suis bien chaque ligne !",
          student: "Je sors mon brouillon pour faire le tableau.",
          quiz: {
            question: "Quelles sont les valeurs finales de x et y après ce programme ?",
            code: `<span class="code-variable">x</span> <span class="code-operator">=</span> <span class="code-number">10</span>
<span class="code-variable">y</span> <span class="code-operator">=</span> <span class="code-number">4</span>
<span class="code-variable">x</span> <span class="code-operator">=</span> <span class="code-variable">x</span> <span class="code-operator">-</span> <span class="code-variable">y</span>
<span class="code-variable">y</span> <span class="code-operator">=</span> <span class="code-variable">x</span> <span class="code-operator">*</span> <span class="code-number">2</span>
<span class="code-variable">x</span> <span class="code-operator">=</span> <span class="code-variable">x</span> <span class="code-operator">+</span> <span class="code-variable">y</span>`,
            options: [
              { id: 'a', text: 'x = 6, y = 12' },
              { id: 'b', text: 'x = 18, y = 12' },
              { id: 'c', text: 'x = 18, y = 6' },
              { id: 'd', text: 'x = 24, y = 12' }
            ],
            correctId: 'b',
            explanation: "x=10, y=4 → x=10-4=6 → y=6×2=12 → x=6+12=18. Réponse : x=18, y=12."
          }
        }
      ]
    }
  ]
}