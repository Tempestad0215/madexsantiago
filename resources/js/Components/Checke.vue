<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        default: false,
    },
    dataLabel:{
        required: true,
        type: String,
    },
    value: {
        type: [String, Boolean],
        default: null,
    },
    id:{
        type: String,
        required: true
    }
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>

<template>
    <div class="pt-3">
        <input
            v-model="proxyChecked"
            :value="value"
            class=" hidden appearance-none focus:ring-0 ring-offset-0 peer"
            :id="id"
            :name="dataLabel"
            type="checkbox">
        <label
            class=" peer-checked:bg-gray-300 border-black peer-checked:border-cyan-400 duration-300 rounded-md border-[1px] px-3 py-1 cursor-pointer select-none shadow-md"
            :for="id">
            {{ dataLabel }}
        </label>
    </div>
</template>
