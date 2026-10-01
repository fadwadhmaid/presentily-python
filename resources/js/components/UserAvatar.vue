<template>
  <div
    class="relative rounded-full overflow-hidden flex items-center justify-center select-none"
    :style="{ background: config.background || '#1E1B4B' }"
  >
    <svg
      :width="size"
      :height="size"
      viewBox="0 0 200 200"
      xmlns="http://www.w3.org/2000/svg"
    >
      <defs>
        <!-- Dégradé de fond -->
        <radialGradient :id="`bgGrad-${uid}`" cx="50%" cy="30%" r="80%">
          <stop offset="0%" :stop-color="lighten(config.background || '#1E1B4B', 25)" />
          <stop offset="100%" :stop-color="config.background || '#1E1B4B'" />
        </radialGradient>

        <!-- Dégradé du visage -->
        <radialGradient :id="`faceGrad-${uid}`" cx="45%" cy="40%" r="70%">
          <stop offset="0%" :stop-color="lighten(config.skin || '#F3D2B3', 15)" />
          <stop offset="100%" :stop-color="config.skin || '#F3D2B3'" />
        </radialGradient>

        <!-- Dégradé des cheveux -->
        <radialGradient :id="`hairGrad-${uid}`" cx="50%" cy="20%" r="70%">
          <stop offset="0%" :stop-color="lighten(config.hairColor || '#1E1B4B', 20)" />
          <stop offset="100%" :stop-color="config.hairColor || '#1E1B4B'" />
        </radialGradient>

        <!-- Dégradé tenue -->
        <linearGradient :id="`outfitGrad-${uid}`" x1="0%" y1="0%" x2="0%" y2="100%">
          <stop offset="0%" :stop-color="lighten(config.outfitColor || '#FDE047', 10)" />
          <stop offset="100%" :stop-color="shade(config.outfitColor || '#FDE047', 25)" />
        </linearGradient>

        <!-- Ombre du visage -->
        <filter :id="`softShadow-${uid}`" x="-20%" y="-20%" width="140%" height="140%">
          <feGaussianBlur in="SourceAlpha" stdDeviation="2" />
          <feOffset dx="0" dy="2" result="offsetblur" />
          <feComponentTransfer>
            <feFuncA type="linear" slope="0.15" />
          </feComponentTransfer>
          <feMerge>
            <feMergeNode />
            <feMergeNode in="SourceGraphic" />
          </feMerge>
        </filter>

        <!-- Reflet brillant sur les cheveux -->
        <linearGradient :id="`hairShine-${uid}`" x1="0%" y1="0%" x2="0%" y2="100%">
          <stop offset="0%" stop-color="#ffffff" stop-opacity="0.25" />
          <stop offset="40%" stop-color="#ffffff" stop-opacity="0" />
        </linearGradient>
      </defs>

      <!-- ═══════════════════════════════════ -->
      <!-- FOND                                 -->
      <!-- ═══════════════════════════════════ -->
      <rect width="200" height="200" :fill="`url(#bgGrad-${uid})`" />

      <!-- Cercles décoratifs subtils dans le fond -->
      <circle cx="30" cy="40" r="15" fill="white" opacity="0.05" />
      <circle cx="170" cy="160" r="25" fill="white" opacity="0.04" />
      <circle cx="180" cy="30" r="10" fill="white" opacity="0.06" />

      <!-- ═══════════════════════════════════ -->
      <!-- CORPS / ÉPAULES                      -->
      <!-- ═══════════════════════════════════ -->
      <g :filter="`url(#softShadow-${uid})`">
        <!-- Épaules -->
        <path
          d="M 30 200 Q 35 155 70 145 L 130 145 Q 165 155 170 200 Z"
          :fill="`url(#outfitGrad-${uid})`"
        />

        <!-- Ombre col -->
        <path
          d="M 70 145 Q 100 160 130 145 L 130 150 Q 100 165 70 150 Z"
          :fill="shade(config.outfitColor || '#FDE047', -30)"
          opacity="0.5"
        />

        <!-- Détail hoodie : capuche + cordons -->
        <template v-if="config.outfit === 'hoodie'">
          <path
            d="M 68 148 Q 75 175 100 180 Q 125 175 132 148 Q 120 165 100 168 Q 80 165 68 148 Z"
            :fill="shade(config.outfitColor || '#FDE047', -15)"
          />
          <line x1="88" y1="160" x2="85" y2="180" :stroke="shade(config.outfitColor || '#FDE047', -40)" stroke-width="2.5" stroke-linecap="round" />
          <line x1="112" y1="160" x2="115" y2="180" :stroke="shade(config.outfitColor || '#FDE047', -40)" stroke-width="2.5" stroke-linecap="round" />
          <circle cx="85" cy="180" r="2.5" :fill="shade(config.outfitColor || '#FDE047', -40)" />
          <circle cx="115" cy="180" r="2.5" :fill="shade(config.outfitColor || '#FDE047', -40)" />
        </template>

        <!-- Détail t-shirt : col rond -->
        <template v-else-if="config.outfit === 'tshirt'">
          <path
            d="M 82 145 Q 100 158 118 145"
            :stroke="shade(config.outfitColor || '#FDE047', -35)"
            stroke-width="2.5"
            fill="none"
            stroke-linecap="round"
          />
        </template>

        <!-- Détail chemise : col en V + boutons -->
        <template v-else-if="config.outfit === 'shirt'">
          <path
            d="M 80 145 L 100 175 L 120 145"
            :fill="shade(config.outfitColor || '#FDE047', -35)"
          />
          <line x1="100" y1="175" x2="100" y2="200" :stroke="shade(config.outfitColor || '#FDE047', -40)" stroke-width="1.5" stroke-dasharray="2,3" />
          <circle cx="100" cy="185" r="1.5" fill="white" opacity="0.5" />
        </template>

        <!-- Détail pull : lignes horizontales -->
        <template v-else-if="config.outfit === 'sweater'">
          <line x1="55" y1="170" x2="145" y2="170" :stroke="shade(config.outfitColor || '#FDE047', -30)" stroke-width="1" opacity="0.6" />
          <line x1="50" y1="185" x2="150" y2="185" :stroke="shade(config.outfitColor || '#FDE047', -30)" stroke-width="1" opacity="0.6" />
        </template>
      </g>

      <!-- ═══════════════════════════════════ -->
      <!-- COU                                  -->
      <!-- ═══════════════════════════════════ -->
      <path
        d="M 88 118 L 88 148 Q 100 152 112 148 L 112 118 Z"
        :fill="shade(config.skin || '#F3D2B3', -20)"
      />

      <!-- ═══════════════════════════════════ -->
      <!-- OREILLES                             -->
      <!-- ═══════════════════════════════════ -->
      <ellipse cx="58" cy="98" rx="6" ry="11" :fill="shade(config.skin || '#F3D2B3', -10)" />
      <ellipse cx="142" cy="98" rx="6" ry="11" :fill="shade(config.skin || '#F3D2B3', -10)" />
      <ellipse cx="58" cy="98" rx="3" ry="6" :fill="shade(config.skin || '#F3D2B3', -25)" opacity="0.6" />
      <ellipse cx="142" cy="98" rx="3" ry="6" :fill="shade(config.skin || '#F3D2B3', -25)" opacity="0.6" />

      <!-- ═══════════════════════════════════ -->
      <!-- VISAGE                               -->
      <!-- ═══════════════════════════════════ -->
      <g :filter="`url(#softShadow-${uid})`">
        <!-- Forme du visage -->
        <path
          d="M 60 90
             Q 60 60 100 60
             Q 140 60 140 90
             Q 140 125 100 145
             Q 60 125 60 90 Z"
          :fill="`url(#faceGrad-${uid})`"
        />

        <!-- Joues (rosissement) -->
        <ellipse cx="78" cy="112" rx="10" ry="6" fill="#FF8B8B" opacity="0.25" />
        <ellipse cx="122" cy="112" rx="10" ry="6" fill="#FF8B8B" opacity="0.25" />
      </g>

      <!-- ═══════════════════════════════════ -->
      <!-- CHEVEUX                              -->
      <!-- ═══════════════════════════════════ -->
      <g>
        <!-- COURT (short) -->
        <template v-if="config.hair === 'short'">
          <path
            d="M 58 88
               Q 55 55 100 52
               Q 145 55 142 88
               Q 138 72 130 68
               Q 122 62 100 62
               Q 78 62 70 68
               Q 62 72 58 88 Z"
            :fill="`url(#hairGrad-${uid})`"
          />
          <!-- Reflet -->
          <path
            d="M 70 68 Q 85 60 100 60 Q 115 60 130 68 Q 115 64 100 64 Q 85 64 70 68 Z"
            :fill="`url(#hairShine-${uid})`"
          />
        </template>

        <!-- LONG (long) -->
        <template v-else-if="config.hair === 'long'">
          <path
            d="M 55 90
               Q 52 50 100 48
               Q 148 50 145 90
               L 148 135 Q 152 145 145 145
               L 142 120 Q 140 90 138 75
               Q 130 62 100 62
               Q 70 62 62 75
               Q 60 90 58 120
               L 55 145 Q 48 145 52 135 Z"
            :fill="`url(#hairGrad-${uid})`"
          />
          <path
            d="M 70 68 Q 85 58 100 58 Q 115 58 130 68 Q 115 62 100 62 Q 85 62 70 68 Z"
            :fill="`url(#hairShine-${uid})`"
          />
        </template>

        <!-- BOUCLÉ (curly) -->
        <template v-else-if="config.hair === 'curly'">
          <circle cx="65" cy="70" r="14" :fill="config.hairColor || '#1E1B4B'" />
          <circle cx="82" cy="58" r="15" :fill="config.hairColor || '#1E1B4B'" />
          <circle cx="100" cy="54" r="16" :fill="config.hairColor || '#1E1B4B'" />
          <circle cx="118" cy="58" r="15" :fill="config.hairColor || '#1E1B4B'" />
          <circle cx="135" cy="70" r="14" :fill="config.hairColor || '#1E1B4B'" />
          <circle cx="58" cy="86" r="10" :fill="config.hairColor || '#1E1B4B'" />
          <circle cx="142" cy="86" r="10" :fill="config.hairColor || '#1E1B4B'" />
          <!-- Reflets -->
          <circle cx="92" cy="52" r="6" fill="white" opacity="0.15" />
          <circle cx="108" cy="52" r="4" fill="white" opacity="0.15" />
        </template>

        <!-- RASÉ (buzz) -->
        <template v-else-if="config.hair === 'buzz'">
          <path
            d="M 62 82 Q 62 62 100 60 Q 138 62 138 82 Q 130 68 100 68 Q 70 68 62 82 Z"
            :fill="`url(#hairGrad-${uid})`"
            opacity="0.9"
          />
          <!-- Texture rasée -->
          <path
            d="M 68 76 Q 100 68 132 76"
            :stroke="shade(config.hairColor || '#1E1B4B', -20)"
            stroke-width="0.8"
            fill="none"
            opacity="0.4"
          />
        </template>

        <!-- QUEUE DE CHEVAL (ponytail) -->
        <template v-else-if="config.hair === 'ponytail'">
          <path
            d="M 58 88 Q 55 55 100 52 Q 145 55 142 88 Q 138 72 130 68 Q 122 62 100 62 Q 78 62 70 68 Q 62 72 58 88 Z"
            :fill="`url(#hairGrad-${uid})`"
          />
          <!-- Queue sur le côté -->
          <path
            d="M 142 82 Q 160 95 158 125 Q 156 145 148 145 Q 152 125 150 105 Q 148 90 142 82 Z"
            :fill="config.hairColor || '#1E1B4B'"
          />
          <path
            d="M 70 68 Q 85 60 100 60 Q 115 60 130 68 Q 115 64 100 64 Q 85 64 70 68 Z"
            :fill="`url(#hairShine-${uid})`"
          />
        </template>

        <!-- CHAUVE (bald) -->
        <template v-else-if="config.hair === 'bald'">
          <!-- Rien -->
        </template>
      </g>

      <!-- ═══════════════════════════════════ -->
      <!-- SOURCILS                             -->
      <!-- ═══════════════════════════════════ -->
      <path
        d="M 76 88 Q 84 84 92 87"
        :stroke="shade(config.hairColor || '#1E1B4B', -10)"
        stroke-width="2.5"
        fill="none"
        stroke-linecap="round"
      />
      <path
        d="M 108 87 Q 116 84 124 88"
        :stroke="shade(config.hairColor || '#1E1B4B', -10)"
        stroke-width="2.5"
        fill="none"
        stroke-linecap="round"
      />

      <!-- ═══════════════════════════════════ -->
      <!-- YEUX                                 -->
      <!-- ═══════════════════════════════════ -->
      <!-- Sclera (blanc) -->
      <ellipse cx="84" cy="100" rx="5" ry="6" fill="white" />
      <ellipse cx="116" cy="100" rx="5" ry="6" fill="white" />

      <!-- Iris -->
      <circle cx="84" cy="100" r="3" :fill="config.eyeColor || '#3B2716'" />
      <circle cx="116" cy="100" r="3" :fill="config.eyeColor || '#3B2716'" />

      <!-- Pupille -->
      <circle cx="84" cy="100" r="1.5" fill="#0a0a0f" />
      <circle cx="116" cy="100" r="1.5" fill="#0a0a0f" />

      <!-- Reflet -->
      <circle cx="85.5" cy="98.5" r="1" fill="white" />
      <circle cx="117.5" cy="98.5" r="1" fill="white" />

      <!-- Paupière supérieure -->
      <path
        d="M 79 97 Q 84 94 89 97"
        :stroke="shade(config.skin || '#F3D2B3', -40)"
        stroke-width="1.2"
        fill="none"
        stroke-linecap="round"
      />
      <path
        d="M 111 97 Q 116 94 121 97"
        :stroke="shade(config.skin || '#F3D2B3', -40)"
        stroke-width="1.2"
        fill="none"
        stroke-linecap="round"
      />

      <!-- ═══════════════════════════════════ -->
      <!-- NEZ                                  -->
      <!-- ═══════════════════════════════════ -->
      <path
        d="M 100 108 L 100 116 Q 100 119 103 119"
        :stroke="shade(config.skin || '#F3D2B3', -35)"
        stroke-width="1.5"
        fill="none"
        stroke-linecap="round"
      />
      <ellipse cx="97" cy="117" rx="1.2" ry="0.8" :fill="shade(config.skin || '#F3D2B3', -40)" opacity="0.5" />

      <!-- ═══════════════════════════════════ -->
      <!-- BOUCHE (sourire)                     -->
      <!-- ═══════════════════════════════════ -->
      <path
        d="M 88 128 Q 100 137 112 128"
        :stroke="'#C25D5D'"
        stroke-width="2.5"
        fill="none"
        stroke-linecap="round"
      />
      <!-- Petite lueur sur la lèvre -->
      <path
        d="M 92 130 Q 100 134 108 130"
        stroke="white"
        stroke-width="0.8"
        fill="none"
        stroke-linecap="round"
        opacity="0.3"
      />

      <!-- ═══════════════════════════════════ -->
      <!-- ACCESSOIRES                          -->
      <!-- ═══════════════════════════════════ -->

      <!-- LUNETTES -->
      <template v-if="config.accessory === 'glasses'">
        <rect
          x="72" y="93" width="24" height="20" rx="8"
          fill="none"
          stroke="#1a1a1a"
          stroke-width="2.5"
        />
        <rect
          x="104" y="93" width="24" height="20" rx="8"
          fill="none"
          stroke="#1a1a1a"
          stroke-width="2.5"
        />
        <line x1="96" y1="102" x2="104" y2="102" stroke="#1a1a1a" stroke-width="2.5" />
        <line x1="72" y1="100" x2="58" y2="98" stroke="#1a1a1a" stroke-width="2" stroke-linecap="round" />
        <line x1="128" y1="100" x2="142" y2="98" stroke="#1a1a1a" stroke-width="2" stroke-linecap="round" />
        <!-- Reflet -->
        <path d="M 76 97 L 82 97" stroke="white" stroke-width="1" opacity="0.4" />
        <path d="M 108 97 L 114 97" stroke="white" stroke-width="1" opacity="0.4" />
      </template>

      <!-- CASQUETTE -->
      <template v-else-if="config.accessory === 'cap'">
        <path
          d="M 56 82 Q 56 48 100 48 Q 144 48 144 82 Q 144 78 100 78 Q 56 78 56 82 Z"
          :fill="config.capColor || '#EF4444'"
        />
        <path
          d="M 56 82 Q 40 82 40 90 L 100 78 Q 56 78 56 82 Z"
          :fill="shade(config.capColor || '#EF4444', -20)"
        />
        <circle cx="100" cy="52" r="3" :fill="shade(config.capColor || '#EF4444', -30)" />
      </template>

      <!-- BOUCLES D'OREILLES -->
      <template v-else-if="config.accessory === 'earrings'">
        <circle cx="58" cy="108" r="3.5" fill="#FDE047" stroke="#B8860B" stroke-width="0.8" />
        <circle cx="142" cy="108" r="3.5" fill="#FDE047" stroke="#B8860B" stroke-width="0.8" />
        <circle cx="58" cy="108" r="1.5" fill="#FFFBEB" opacity="0.8" />
        <circle cx="142" cy="108" r="1.5" fill="#FFFBEB" opacity="0.8" />
      </template>

      <!-- ═══════════════════════════════════ -->
      <!-- VIGNETTE (assombrit les bords)       -->
      <!-- ═══════════════════════════════════ -->
      <radialGradient :id="`vignette-${uid}`" cx="50%" cy="50%" r="70%">
        <stop offset="60%" stop-color="#000" stop-opacity="0" />
        <stop offset="100%" stop-color="#000" stop-opacity="0.15" />
      </radialGradient>
      <rect width="200" height="200" :fill="`url(#vignette-${uid})`" />
    </svg>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  config: {
    type: Object,
    default: () => ({
      hair: 'short',
      hairColor: '#1E1B4B',
      skin: '#F3D2B3',
      eyeColor: '#3B2716',
      outfit: 'hoodie',
      outfitColor: '#FDE047',
      accessory: 'none',
      background: '#1E1B4B',
    })
  },
  size: { type: Number, default: 96 },
})

// UID unique pour éviter les conflits entre plusieurs avatars sur la même page
const uid = Math.random().toString(36).substr(2, 9)

// Fonction : assombrir une couleur
function shade(color, percent) {
  const num = parseInt(color.replace('#', ''), 16)
  const amt = Math.round(2.55 * percent)
  const R = Math.max(0, Math.min(255, (num >> 16) + amt))
  const G = Math.max(0, Math.min(255, ((num >> 8) & 0x00ff) + amt))
  const B = Math.max(0, Math.min(255, (num & 0x0000ff) + amt))
  return '#' + (0x1000000 + R * 0x10000 + G * 0x100 + B).toString(16).slice(1)
}

// Fonction : éclaircir une couleur
function lighten(color, percent) {
  return shade(color, Math.abs(percent))
}
</script>
