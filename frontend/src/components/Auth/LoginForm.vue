<script setup>
    import { onMounted, ref } from 'vue';
    import { useUserStore } from '@/stores/user';
    import { useRequestStore } from '@/stores/request';
    import router from '@/router';
    import Errors from '../Errors.vue';

    document.title = 'Вход в приложение' 

    onMounted (() => setRandomUserCredentials())

    const credentials = ref({})
    const errors = ref([])

    const setRandomUserCredentials = async () => {
        let result = await useRequestStore().getRequest('/random-user-credentials')
        credentials.value = result
    }

    const submit = async () => {
        let result = await useRequestStore().postRequest('/login', credentials.value)
        handleSubmitResult(result)
    }
    
    const handleSubmitResult = (submitResult) => {

        if(submitResult.errors) {
            errors.value = submitResult.errors
            return
        }

        localStorage.setItem('apiToken', submitResult.token)
        useUserStore().isAuth = true
        useUserStore().getUserData()
        router.push({name: 'main'})
    }

</script>

<template>
    <div class="wrapper">
        
        <form class="login-form" @submit.prevent="submit">
            <input 
                type="email" 
                name="email" 
                class="form-input" 
                v-model="credentials.email"
                autocomplete="on">
                
            <input 
                type="password" 
                name="password" 
                class="form-input" 
                v-model="credentials.password"
                autocomplete="on">
                
            <button type="submit" class="form-button">Войти</button>
        </form>

        <div v-if="errors.length" class="errors">
            <Errors :errors="errors" />
        </div>

    </div>
</template>

<style scoped>
    .wrapper {
        display: flex;
    }
    .login-form {
        display: flex;
        flex-direction: column;
        width: 250px;
    }
    .form-input {
        padding: 5px;
        height: 25px;
        border: 1px solid grey;
        border-radius: 5px;
        margin-bottom: 5px;
    }
    .form-button {
        padding: 5px;
        height: 25px;
        border: 1px solid grey;
        border-radius: 5px;
    }

    .form-button:hover {
        box-shadow: 0 0 2px grey;
    }

    .errors {
        margin-left: 50px;
    }
</style>