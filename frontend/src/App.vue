<script setup>
  import { RouterView } from 'vue-router'
  import NavMenuTop from './components/NavMenuTop.vue';
  import { useUserStore } from '@/stores/user';
  import router from './router';


  if(localStorage.getItem('apiToken') && !useUserStore().isAuth) {
    useUserStore().isAuth = true
  }

  if(!localStorage.getItem('apiToken') && location.pathname != '/login') {
    router.push('/login')
  }
</script>

<template>
    <div class="container">

      <NavMenuTop />
  
      <div class="page-content-wrapper">
        <RouterView />
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
