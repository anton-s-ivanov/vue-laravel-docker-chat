<script setup>
    import { useUserStore } from '@/stores/user';
    import { RouterLink } from 'vue-router';

</script>

<template>
    <nav class="top-nav-menu">
        <div class="router-links">
            <div :class="{ hidden : !useUserStore().isAuth }">
                <RouterLink to="/">Чаты</RouterLink>
                <RouterLink to="/profile">Профиль</RouterLink>
            </div>
            <div :class="{ hidden : useUserStore().isAuth }">
                <RouterLink to="/login">Логин</RouterLink>
            </div>
        </div>
      </nav>   
</template>

<style>
    .top-nav-menu {
        width: 100%;
        background-color: rgb(234 234 234);
        padding: 10px 0;   
        border-radius: 5px;     
    }

    .top-nav-menu a.router-link-exact-active {
        color: whitesmoke;
        background-color: #6d78aa;
    }

    .top-nav-menu a {
        display: inline-block;
        padding: 0 1rem;
        text-decoration: none;
        font-weight: bold;
        color: #6d78aa;
        border-radius: 5px;
        margin-right: 5px;
    }

    .top-nav-menu a:hover {
        box-shadow: 0px 0px 4px;
    }

    .router-links {
        margin: 0 20px;
        display: flex;
        justify-content: space-between;
    }

    .hidden {
        visibility: hidden;
    }

</style>