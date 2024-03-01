<script setup>
const props = defineProps({
    type:{
        type: String,
        default: "submit"
    },
    dataLabel:{
        required: true,
        type: String,
    },
    disabled:{
        type: Boolean,
        default: false
    }
})

</script>


<template>
    <div class="pt-5">
        <button
            :disabled="disabled"
            class="bg-gray-300 px-3 py-1 rounded-md font-semibold tracking-wide
        hover:bg-gray-500 hover:text-white transition-colors duration-300 disabled:bg-rojo disabled:text-neutro disabled:cursor-not-allowed "
            :type="type">
            {{ dataLabel }}
        </button>
    </div>
</template>
