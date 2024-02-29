<script setup>
defineProps({
    value: String,
});
</script>

<template>
    <label class="block font-semibold uppercase text-sm text-black">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
