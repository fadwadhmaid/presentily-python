import { createRouter, createWebHistory } from 'vue-router'
import WelcomeComponent from '../components/WelcomeComponent.vue'
import DashboardComponent from '../components/DashboardComponent.vue'
import CoursesList from '../components/CoursesList.vue'
import CourseDetail from '../components/CourseDetail.vue'
import ChapterView from '../components/ChapterView.vue'
import LessonView from '../components/LessonView.vue'

const routes = [
  { path: '/', name: 'welcome', component: WelcomeComponent },

  // ─── Routes élève ──────────────────────────
  { path: '/dashboard',  name: 'dashboard',     component: DashboardComponent, meta: { requiresAuth: true } },
  { path: '/courses',    name: 'courses',       component: CoursesList,        meta: { requiresAuth: true } },
  { path: '/courses/:id',name: 'course-detail', component: CourseDetail,       meta: { requiresAuth: true } },
  { path: '/courses/:id/chapters/:chapterId', name: 'chapter-view', component: ChapterView, meta: { requiresAuth: true } },
  { path: '/courses/:id/lesson', name: 'lesson-view', component: LessonView, meta: { requiresAuth: true } },
  { path: '/messages',   name: 'Messages', component: () => import('../components/MessagesView.vue'), meta: { requiresAuth: true } },

  // ─── Routes admin ──────────────────────────
 {
  path: '/admin',
  component: () => import('../components/admin/AdminLayout.vue'),
  meta: { requiresAdmin: true },
  children: [
    { path: '', redirect: '/admin/dashboard' },
    { path: 'dashboard', name: 'AdminDashboard', component: () => import('../components/admin/AdminDashboard.vue') },
    { path: 'messages',  name: 'AdminMessages',  component: () => import('../components/admin/AdminMessages.vue') },
    { path: 'users',     name: 'AdminUsers',     component: () => import('../components/admin/AdminUsers.vue') },
  ]
},
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// ─── GUARD GLOBAL ─────────────────────────────
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  const user = JSON.parse(localStorage.getItem('user') || 'null')
  const isAdmin = user?.role === 'admin'

  // 1. Admin essaie d'accéder au dashboard élève
  if (isAdmin && to.path === '/dashboard') {
    return next('/admin/dashboard')
  }

  // 2. Admin essaie d'accéder aux autres routes élève
  const studentRoutes = ['/courses', '/exercises', '/badges', '/leaderboard', '/messages', '/profile']
  if (isAdmin && studentRoutes.some(r => to.path.startsWith(r))) {
    return next('/admin/dashboard')
  }

  // 3. Route admin mais pas admin
  if (to.meta.requiresAdmin && !isAdmin) {
    return next(token ? '/dashboard' : '/')
  }

  // 4. Route protégée sans token
  if (to.meta.requiresAuth && !token) {
    return next('/')
  }

  // 5. Admin connecté qui va sur "/" (welcome)
  if (isAdmin && to.path === '/') {
    return next('/admin/dashboard')
  }

  // 6. Élève connecté qui va sur "/" (welcome)
  if (token && !isAdmin && to.path === '/') {
    return next('/dashboard')
  }

  next()
})

export default router