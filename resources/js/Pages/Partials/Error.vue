<script setup lang="ts">

const props = defineProps({
    data:{
        type: String,
        default: "",
    }
})

</script>


<template>
    <div
        class=" text-sm text-red-600 text-center"
        v-if="data !== ''">
        {{ data }}
        <i class="fa-solid fa-circle-exclamation"></i>
    </div>
</template>
