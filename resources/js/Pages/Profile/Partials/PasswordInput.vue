<script setup lang="ts">
import {ref} from 'vue';

// La propiedades de la ventana
defineProps({
    modelValue:{
        type: String,
        required: true,
    }
});
// Emitir los datos al front
defineEmits(['update:modelValue']);

// DAtos de la ventana
const typePassword = ref("password");
const ojoIcon = ref("fa-eye");

// Funcion apra ver la clave
const showPassword = () =>{
    if(typePassword.value == "password")
    {
        // Mostrar la password del campo
        typePassword.value = "text"
        ojoIcon.value = "fa-eye-slash"
    }else{
        // Ocultar la password del campo
        typePassword.value = "password"
        ojoIcon.value = "fa-eye"

    }
}


</script>


<template>
    <!-- Para ver la password -->
    <div class="relative">
        <input
            class="input w-full pr-7"
            id="password"
            :value="modelValue"
            @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
            :type="typePassword">
        <!-- El ojo para mostrar y no mostra la password -->
        <i
            @click="showPassword"
            class="ojo fa-solid absolute inset-y-0 right-2 flex items-center "
            :class="ojoIcon">
        </i>
    </div>
</template>
