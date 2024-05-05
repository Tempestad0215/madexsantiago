<script setup>
defineProps({
    dataLabel:{
        required: true,
        type: String,
    }
})
</script>

<template>
    <div class="pt-3 font-extrabold text-4xl tracking-widest text-center">
        <h2>{{ dataLabel }}</h2>
    </div>

</template>
