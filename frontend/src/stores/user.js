import { defineStore } from "pinia";
import { ref, watch } from "vue";
import router from '../router';
import { useRequestStore } from '@/stores/request';

export const useUserStore = defineStore('user', () => {
    const isAuth = ref(false)
    const userId = ref(null)
    const userName = ref(null)
    const userEmail = ref(null)

    async function getUserData() {
        const result = await useRequestStore().getRequest('/user-profile')
        userId.value = result.id
        userName.value = result.name
        userEmail.value = result.email
        return userId
    }

    function logout() {
        localStorage.removeItem('apiToken')
        isAuth.value = false
        router.push({name: 'login'})
    }
    
    async function tryRestoreAuth() {
        if(localStorage.getItem('apiToken')) {
            const result = await getUserData()
            if(result?.value) {
                isAuth.value = true
            } else {
                logout()
            }
            return result
        }
    }
    
    return {userId, userName, userEmail, isAuth, getUserData, logout, tryRestoreAuth}
})