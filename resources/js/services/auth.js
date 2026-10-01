import api from '../plugins/axios'

const authService = {
    async register(userData) {
        try {
            const response = await api.post('/register', userData)
            if (response.data.success) {
                localStorage.setItem('token', response.data.token)
                localStorage.setItem('user', JSON.stringify(response.data.user))
            }
            return response.data
        } catch (error) {
            console.error('Erreur d\'inscription:', error)
            throw error
        }
    },

    async login(credentials) {
        try {
            const response = await api.post('/login', credentials)
            if (response.data.success) {
                localStorage.setItem('token', response.data.token)
                localStorage.setItem('user', JSON.stringify(response.data.user))
            }
            return response.data
        } catch (error) {
            console.error('Erreur de connexion:', error)
            throw error
        }
    },

    async logout() {
        try {
            await api.post('/logout')
        } catch (error) {
            console.error('Erreur de déconnexion:', error)
        } finally {
            localStorage.removeItem('token')
            localStorage.removeItem('user')
        }
    },

    async getUser() {
        try {
            const response = await api.get('/user')
            if (response.data.success) {
                localStorage.setItem('user', JSON.stringify(response.data.user))
                return response.data.user
            }
            return null
        } catch (error) {
            console.error('Erreur de récupération utilisateur:', error)
            return null
        }
    },

    isAuthenticated() {
        return !!localStorage.getItem('token')
    },

    getCurrentUser() {
        const user = localStorage.getItem('user')
        return user ? JSON.parse(user) : null
    }
}

export default authService