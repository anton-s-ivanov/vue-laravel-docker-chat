<script setup>

    const props = defineProps({
        userChats: Object,
        choosedChat: Number
    })

    const emit = defineEmits(['chatChoosed'])
</script>

<template>
    <div class="chats-wrapper">
        <div 
            v-for="userChat in props.userChats" :key="userChat.id"
            @click="$emit('chatChoosed', userChat.id)"
            class="chat-item"
            :class="{ 'choosed-chat' : userChat.id === props.choosedChat }"
        >{{ userChat.name }}</div>
    </div>
</template>

<style scoped>
    .chats-wrapper {
        width: calc(100% - 700px);
        height: 70vh;
        overflow-y: auto;
    }

    .chat-item {
        border: 1px solid #dddddd;
        padding: 5px;
        border-radius: 5px;
        margin-bottom: 5px;
        margin-right: 10px;
        cursor: pointer;
    }

    .chat-item:hover {
        box-shadow: 0 1px 1px gray;
    }

    .choosed-chat {
        color:white;
        font-weight: bold;
        background-color: #8ba5c4;
    }


</style>