<script setup >
import { onMounted, ref } from 'vue';


const img = ref("")

onMounted(()=>{
    img.value = window.location.origin+'/storage/images/logo.png'
})

</script>

<template>
    <img :src="img" alt="">
</template>
