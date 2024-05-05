<script setup>

const emit = defineEmits(['submit']);

// funciones
const submit = ()=>{
    emit('submit');
}
</script>

<template>
    <form
        class="bg-white rounded-lg shadow-lg border-2 border-gray-300 border-opacity-50 p-6 "
        @submit.prevent="submit" >
        <slot/>
    </form>
</template>
