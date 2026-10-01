import '../css/app.css'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router' // Si vous utilisez Vue Router

// Import des services
import axios from './plugins/axios'
import authService from './services/auth'

// Rendre disponibles globalement (optionnel)
window.axios = axios
window.authService = authService

const app = createApp(App)

// Utiliser le router
app.use(router)

// Monter l'application
app.mount('#app')