<script setup>
    import { useUserStore } from '@/stores/user';
    import { useRequestStore } from '@/stores/request';
    import { onMounted, ref } from 'vue';
    import router from '@/router';
    import TextEditor from './TextEditor.vue'
    import ChatsList from './ChatsList.vue';

    document.title = 'Чаты'

    if(!useUserStore().userId) {
        useUserStore().getUserData()
    }

    const userChats = ref({})
    const choosedChat = ref(null)
    const chatMessages = ref({})
    const chatMessagesQty = ref(50)
    const messageText = ref('')
    const editingMessageId = ref(null)
    
    const getUserChats = async () => {
        userChats.value = await useRequestStore().getRequest('/user-chats')
    }

    onMounted(() => {
        getUserChats()

        if(location.search.includes('chatId=')) {
            const chatId = Number(location.search.split('chatId=')[1])
            choosedChat.value = chatId
            chatChoosed(chatId)
        }
       
    })

    let  chatUpdateinterval = null;

    const chatChoosed = (chatId) => {
        clearInterval(chatUpdateinterval)

        router.push('/?chatId=' + chatId)
        
        choosedChat.value = chatId
        getChatMessages(chatId, true)

        chatUpdateinterval = setInterval(() => {
            if(!document.getElementById('messagesContainer')) {
                clearInterval(chatUpdateinterval)
            }
            getChatMessages(chatId)
        }, 5000)
    }

    const getChatMessages = async (chatId, needScrollMessagesDown = false) => {
        
        if(!document.getElementById('messagesContainer')) {
            return
        }

        const response = await useRequestStore().getRequest('/chat-messages/' + chatId + '?take=' + chatMessagesQty.value)
        chatMessages.value = response
        
        if(needScrollMessagesDown) {
            scrollMessages()
        }
    } 

    const scrollMessages = () => {
        const interval = setInterval(() => {
            const scrollValue = window.getComputedStyle(messagesContainer, null).height.split('px')[0]
            if(scrollValue) {
                clearInterval(interval)
                messagesAria.scroll(0, scrollValue)
            }
        })
    }

    const editMessage = (chatMessage) => {

        if(chatMessage.sender_id != useUserStore().userId) {
            return
        }

        if(Math.abs(new Date(chatMessage.updated_at) - new Date()) / 1000 / 60 > 5) {
            return
        }

        editingMessageId.value = chatMessage.id
        messageText.value = chatMessage.message
    }

    const getHtml = (message) => {
        return message.replaceAll("\n", "<br>")
    }

    const handleScrollMessages = () => {
        const topMessage = document.getElementById('topMessage')
        
        if(topMessage.getBoundingClientRect().top > 0) {
            messagesAria.scroll(0, 1)
        }
        
        const triggerElement = document.getElementById('triggerQueryMessage')

        if(!triggerElement) {
            return
        }

        if(triggerElement.getBoundingClientRect().top > 0) {
            chatMessagesQty.value += 50
            triggerElement.id = ""
        }
    }

    const resetTextEditor = () => {
        editingMessageId.value = null
        messageText.value = ''
    }
</script>

<template>
    <div class="chats-aria">
        
        <ChatsList 
            :userChats="userChats"
            :choosedChat="choosedChat"
            @chatChoosed="chatChoosed"
        />

        <div v-show="!chatMessages.length" class="emty-chat-messages-info">Выберите собеседника</div>

        <!-- <div v-show="chatMessages.length" style="font-size: 30px; padding: 10px; color: red"> {{ chatMessagesQty }}</div> -->
        
        <div v-show="chatMessages.length" class="messages-wrapper">
            <div 
                class="messages-aria" 
                id="messagesAria"
                @scroll="handleScrollMessages()"
            >
                <div  class="messages-container" id="messagesContainer">
                    <div
                        v-for="(chatMessage, index) in chatMessages" :key="chatMessage.id"
                        class="chat-message-item"
                        :class="{'current-user-is-message-sender' : (chatMessage.sender_id === useUserStore().userId)}"
                        @dblclick="editMessage(chatMessage)"
                    >
                        <div v-if="index===20" id="triggerQueryMessage"></div>
                        <div v-if="index===0" id="topMessage"></div>
                        <div
                            class="chat-message-text"
                            v-html="getHtml(chatMessage.message)"
                        ></div>
                    
                        <div 
                            class="chat-message-date-time"
                        >{{ new Date(chatMessage.updated_at).toLocaleString() }}</div>
                    </div>
                </div>
            </div>
            
            <TextEditor 
                :editingMessageId="editingMessageId"
                :choosedChat="choosedChat"
                :messageText="messageText"
                @resetTextEditor="resetTextEditor"
                @getChatMessages="getChatMessages"
            />
            
        </div>
        
    </div>
</template>

<style scoped>
    .chats-aria {
        display: flex;
        height: 70vh;
    }

    .messages-wrapper {
        display: flex;
        flex-direction: column;
    }

    .emty-chat-messages-info {
        margin-left: 100px;
        color: #89a0dd;
    }

    .messages-aria {
        width: 700px;
        min-height: 100%;
        max-height: 75vh;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        padding: 10px 0;
        border-radius: 5px;
    }
    
    .messages-container {
        margin: auto;
        width: 500px;
        margin-left: 100px;
    }

    .chat-message-item {
        border: 1px solid grey;
        background-color: #eeeeee;
        margin-bottom: 10px;
        padding: 10px;
        max-width: 75%;
        border-radius: 10px;
    }

    .current-user-is-message-sender {
        margin-left: auto;
        background-color: white;
    }

    .chat-message-date-time {
        margin-top: 5px;
        font-size: 80%;
    }
     
</style>