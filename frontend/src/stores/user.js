import { defineStore } from "pinia";
import { ref } from "vue";
import router from '../router';

export const useUserStore = defineStore('user', () => {
    const isAuth = ref(false)
    const userId = ref(null)
    const userName = ref(null)
    const userEmail = ref(null)

    async function getUserData() {
        let response = await fetch(import.meta.env.VITE_BACKEND_DOMAIN + '/user-profile', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('apiToken')
            }
        })

        let result = await response.json()
        userId.value = result.id
        userName.value = result.name
        userEmail.value = result.email
    }

    function logout() {
        localStorage.removeItem('apiToken')
        isAuth.value = false
        router.push('/login')
    }
    
    return {userId, userName, userEmail, isAuth, getUserData, logout}
})