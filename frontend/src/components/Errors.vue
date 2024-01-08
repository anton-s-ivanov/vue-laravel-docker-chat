<script setup>
    const props = defineProps({
        errors: Array
    })
</script>

<template>
    <div>
        <ul>
            <li class="error" v-for="(error, index) in props.errors" :key="index">{{ error }}</li>
        </ul>
    </div>
    
</template>

<style scoped>
    .error {
        color: red;
    }
</style>