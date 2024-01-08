<script setup>
    import { useUserStore } from '@/stores/user';

    document.title = 'Профиль пользователя'

    if(!useUserStore().userId) {
        useUserStore().getUserData()
    }
</script>

<template>
    <div class="user-profile-elements-wrapper">
        <div class="user-profile-element">
            <b>Имя</b>: {{ useUserStore().userName }}
        </div>
        <div class="user-profile-element">
            <b>Логин</b> : {{ useUserStore().userEmail }}
        </div>
        <a @click="useUserStore().logout()" class="logout">Выйти</a>
    </div>
</template>

<style>
    .user-profile-element {
        margin-bottom: 10px;
    }

    .logout {
        cursor: pointer;
        color: #6d78aa;
    }
</style>