import router from "@/router";
import { defineStore } from "pinia";

export const useRequestStore = defineStore('requestParams', () => {
    
    async function postRequest(path, body) {
        try {
            let response = await fetch(import.meta.env.VITE_BACKEND_DOMAIN + path, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8',
                    'Authorization': 'Bearer ' + localStorage.getItem('apiToken')
                },
                body: JSON.stringify(body)
            })
            
            if(response.ok) {
                return await response.json()
            } else {
                console.error(response.status);
                if(response.status === 401) {
                    router.push({name: 'login'})
                }
            }
            
        } catch (error) {
            console.error(error);
        }
        
    }

    async function getRequest(path) {
        try {
            let response = await fetch(import.meta.env.VITE_BACKEND_DOMAIN + path, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('apiToken')
                }
            })
    
            if(response.ok) {
                return await response.json()
            } else {
                console.error(response.status);
                if(response.status === 401) {
                    router.push({name: 'login'})
                }
            }

        } catch (error) {
            console.error(error);
        }
        
    }

    return { postRequest, getRequest }
})