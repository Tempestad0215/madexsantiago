<script setup lang="ts">


defineProps({
    label:{
        type: String,
        required:true
    },
    data:{
        type: [String, Number],
        required: true
    }
})

</script>


<template>
    <div class="">
        <h5 class=" bg-gray-200 rounded-md px-3 font-bold text-blue-700">
            {{ label }}
        </h5>
        <p class=" px-4">
            {{ data ?? 'null' }}
        </p>
    </div>
</template>
