import { defineStore } from "pinia";

export const useRequestStore = defineStore('requestParams', () => {
    
    async function postRequest(path, body) {
        let response = await fetch(import.meta.env.VITE_BACKEND_DOMAIN + path, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8',
                'Authorization': 'Bearer ' + localStorage.getItem('apiToken')
            },
            body: JSON.stringify(body)
        })
        
        return await response.json()
    }

    async function getRequest(path) {
        let response = await fetch(import.meta.env.VITE_BACKEND_DOMAIN + path, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('apiToken')
            }
        })

        return await response.json()
    }

    return { postRequest, getRequest }
})