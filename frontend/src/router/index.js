import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: () => import('@/components/Chat/ChatLayout.vue')
    },
    {
      path: '/profile',
      component: () => import('@/components/Auth/UserProfile.vue') 
    },
    {
      path: '/login',
      component: () => import('@/components/Auth/LoginForm.vue')
    }, 
  ]
})

export default router
