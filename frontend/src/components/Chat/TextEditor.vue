<script setup>
    import { ref, watch } from 'vue';
    import { useRequestStore } from '@/stores/request';

    const props = defineProps({
        editingMessageId: Number,
        choosedChat: Number,
        messageText: String
    })

    const emit = defineEmits(['resetTextEditor', 'getChatMessages'])

    const messageTextRef = ref(props.messageText)

    watch(props, () => messageTextRef.value = props.messageText)

    const stopMessageEditing = () => {
        emit('resetTextEditor')
    }

    const submit = async () => {
        if(!messageTextRef.value) {
            return
        }

        if(props.editingMessageId) {
            await updateMessage()
        } else {
            await storeMessage()
        }

        messageTextRef.value = ''
        emit('resetTextEditor')
        emit('getChatMessages', props.choosedChat, true)
    }

    const updateMessage = async () => {
        let result = await useRequestStore().postRequest('/update-message', 
        {
            message: messageTextRef.value,
            editingMessageId: props.editingMessageId
        })
        return result
    }

    const storeMessage = async () => {
        let result = await useRequestStore().postRequest('/store-message', 
        {
            message: messageTextRef.value,
            chatId: props.choosedChat,
        })
        return result
    }

</script>

<template>
    <div>
        <div 
            v-if="props.editingMessageId" 
            @click="stopMessageEditing()"
            class="message-editing-info"
        >
            <span class="message-editing-info-icon">&#10060;</span> 
            <span class="message-editing-info-text">Редактирование сообщения</span>
        </div>
        <form @submit.prevent="submit">
            <div v-if="props.choosedChat" class="text-editor-wrapper">
                <textarea 
                    v-model="messageTextRef" 
                    class="text-editor-textarea" name="message">
                </textarea>
                <button 
                    class="text-editor-button" 
                    :class="{ 'ready-to-push' : messageTextRef.length}"
                >&#9658;</button>                   
            </div>
        </form>
    </div>
</template>

<style scoped>
    .message-editing-info {
        margin-top: 10px;
        display: flex;
        align-items: center;
    }
    .message-editing-info-icon {
        font-size: 12px;
        border-radius: 50%;
        padding: 2px 4px;
        cursor: pointer;
    }

    .message-editing-info-icon:hover {
        box-shadow: 0 0 6px grey;
    }
    .message-editing-info-text {
        margin-left: 10px;
        font-size: 16px;
    }

    .text-editor-wrapper {
        display: flex;
        margin-top: 10px;
        height: 60px;
    }
    .text-editor-textarea {
        width: calc(100% - 2*10px);
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 0 6px #d0d0db;
        font-size: 18px;
        margin-right: 10px;
        height: calc(100% - 2*10px);
    }

    .text-editor-button {
        width: 60px;
        height: 100%;
        font-size: 30px;
        background-color: #b3b3f1;
        color: white;
        font-weight: bold;
        cursor: pointer;
        border-radius: 5px;
    }

    .text-editor-button:active {
        box-shadow: 0;
        border: 0;
    }

    .text-editor-button:focus-visible {
        box-shadow: 0;
        border: 0;
    }

    .ready-to-push{
        background-color: blue;
        box-shadow: 0 0 16px #065275;
    }

</style>