<script setup>
  import { RouterView } from 'vue-router'
  import NavMenuTop from './components/NavMenuTop.vue';
  import { useUserStore } from '@/stores/user';
  import router from './router';

  router.beforeEach(async (to, from, next) => {
    if(!useUserStore().isAuth && to.name != 'login') {
      const tryRestoreAuth = await useUserStore().tryRestoreAuth()
      if(!tryRestoreAuth?.value) {
        next({name: 'login'})
      }
    } 
    next()
  })

</script>

<template>
    <div class="container">

      <nav-menu-top />
  
      <div class="page-content-wrapper">
        <router-view v-slot=" {Component}">
          <transition name="fade">
            <component :is="Component" />
          </transition>
        </router-view>
      </div>
            
    </div>
</template>

<style scoped>
  .container {
    max-width: 1024px;
    max-height: 100vh;
    margin: auto;
  }

  .page-content-wrapper {
    padding: 20px 0;
  }

</style>
