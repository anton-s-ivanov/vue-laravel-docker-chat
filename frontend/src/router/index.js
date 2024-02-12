import { createRouter, createWebHistory, beforeRouteLeave } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: () => import('@/components/Chat/ChatLayout.vue'),
      name: 'main',
    },
    {
      path: '/profile',
      component: () => import('@/components/Auth/UserProfile.vue'),
      name: 'profile'
    },
    {
      path: '/login',
      component: () => import('@/components/Auth/LoginForm.vue'),
      name: 'login'
    }, 
  ]
})

export default router
