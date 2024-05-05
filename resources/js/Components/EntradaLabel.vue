<script setup>
import { ref, onMounted} from 'vue';

/**
 * TODO: definir las props
 */
const props = defineProps({
    dataLabel:{
        required: true,
        type: String,
    },
    modelValue:{
        type: [String, Number, Object]
    },
    type: {
        type: String,
        default: "text"
    },
    password:{
        type: Boolean,
        default: false
    },
    issetError:{
        default: false,
        required: {}
    },
    readonly:{
        type: Boolean,
        default: false
    }
});
/**
 * TODO: data de la app
 *
 */
const input = ref(null);
const seePassword = ref(false);
const seeClass = ref("");
const typeData = ref("text")

/**
 * TODO: al momento de cargar
 */
onMounted(() => {
    // if (input.value.hasAttribute('autofocus')) {
    //     input.value.focus();
    // }
    if(!props.password)
    {
        typeData.value = props.type
    }else{
        typeData.value = "password"
    }

    seeClass.value = "fa-solid fa-eye"

});
/**
 * TODO: emitir los eventos
 */
const emit = defineEmits(['update:modelValue','sendFile','sendChange']);
defineExpose({ focus: () => input.value.focus() });
/**
 * TODO: funcioens
 */
const showPass = ()=>{
    if(seePassword.value)
    {
        seePassword.value = !seePassword.value;
        seeClass.value = "fa-solid fa-eye-slash";
        typeData.value = "text";
    }else{
        seePassword.value = !seePassword.value;
        seeClass.value = "fa-solid fa-eye";
        typeData.value = "password";

    }

}
// emitir los datos mediante el envento
const sendData = (e)=>{

    if(props.type == "file")
    {
        // sacar el archivo
        const file = e.target.files[0];
        // enviar el archivo a la principal
        emit('sendFile', file);
    }else{

        // enviar los datos normales
        emit('update:modelValue', e.target.value)

    }
    emit('sendChange');
}

</script>

<template>
    <div class=" relative mt-5 shadow-md rounded-md">

        <input
            :id="dataLabel"
            v-bind:type="typeData"
            :readonly="readonly"
            ref="input"
            class=" appearance-none rounded-md h-10 outline-none w-full
            focus:border-cyan-400 focus:ring-0 pl-3 pr-8 py-1 peer file:rounded-lg file:border-0 file:p-2 file:cursor-pointer "
            :class=" typeData == 'number' ? '!pr-2' : '' "
            :value="modelValue"
            @input="sendData($event)">

        <!-- mensaje de error -->
        <span v-if="issetError"
            class="text-red-500 px-3 text-xs" >
            {{ issetError }}
        </span>
        <!-- icono de ver la password -->
        <i
            @click="showPass"
            v-if="password"
            class=" absolute inset-y-2 right-2 p-1 cursor-pointer hover:text-cyan-300 duration-300 "
            :class="seeClass"
            >
        </i>
        <!-- mensaje de error -->
        <label
            :for="dataLabel"
            class="absolute left-4 top-[-15px] border-[1px] font-bold tracking-wider bg-white px-3 shadow-md focus-within:bg-white rounded-md  peer-focus:border-cyan-400  transition-colors duration-300 ">
            {{ dataLabel }}
        </label>
    </div>

</template>
