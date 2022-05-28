import { createWebHistory, createRouter } from 'vue-router'
import { setupLayouts } from 'virtual:generated-layouts'
import routes from '~pages'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: setupLayouts(routes),
})

router.beforeEach((to) => {
  const authStore = useAuthStore()

  const pattern = new RegExp('(user|role)s/(create)')
  const requiresSuperAdmin = pattern.test(to.path)

  // const pattern2 = new RegExp('(user|role)s|(create)')
  const pattern2 = new RegExp('(user|role)s|(create)')
  const requiresAuth = pattern2.test(to.path) || requiresSuperAdmin

  if (to.path === '/login' && authStore.isLoggedIn) return { path: '/' }

  if (requiresAuth && !authStore.isLoggedIn) return { path: '/login', query: { redirect: to.fullPath } }

  if (requiresSuperAdmin && !authStore.isSuperAdmin) return { path: '/' }
})

export default router
