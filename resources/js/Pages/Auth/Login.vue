<script setup>
import { useForm, usePage, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import Error from '@partials/Error.vue';


defineProps({
    canResetPassword: Boolean,
    status: String,
    errors:Object
});
/**
 * TODO: datos de la ventana
 */
const ojoIcon = ref("fa-eye")
const typePassword = ref("password")
const ulrLogo = window.location.origin+'/storage/images/maluhia.svg'

const form = useForm({
    user: '',
    password: '',
    remember: false,
    _token: usePage().props.csrf_token
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
// Funciones
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
    <Head title="Inicio" />
    <div class="pt-20">
        <form
            class="mx-3 sm:max-w-sm sm:mx-auto bg-gray-300 p-6 rounded-md shadow-lg"
            @submit.prevent="submit">
            <!-- titulo de la app -->
            <h3 class=" text-5xl font-bold text-center">
                AVANCE
            </h3>
            <div>
                <label
                    class=""
                    for="user" >Usuario
                </label>
                <input
                    class="input w-full "
                    id="user"
                    v-model="form.user"
                    type="text">
                <!-- Mensaje de error -->
                <Error
                    v-if="form.errors.user"
                    :data="form.errors.user" />

            </div>

            <!-- Password -->
            <div class="box-password">
                <label
                    for="password" >
                    Contaseña
                </label>
                <!-- Para ver la password -->
                <div class="relative">
                    <input
                        class="input w-full pr-7"
                        id="password"
                        v-model="form.password"
                        :type="typePassword">
                    <!-- El ojo para mostrar y no mostra la password -->
                    <i
                        @click="showPassword"
                        class="ojo fa-solid absolute inset-y-0 right-2 flex items-center "
                        :class="ojoIcon">
                    </i>

                </div>
                <!-- Mensaje de error -->
                <Error
                    v-if="form.errors.password"
                    :data="form.errors.password" />
            </div>
            <!-- Boton de recuerdame -->
            <!-- <div class="mt-3">
                <input
                    class=" peer sr-only"
                    type="checkbox"
                    v-model="form.remember"
                    id="remember">
                <label
                    class="px-2 rounded-md bg-blue-400 py-1"
                    for="remember">
                    Recuerdame
                    <i class="fa-solid fa-brain"></i>
                </label>
            </div> -->
            <!-- Botones -->
            <div class="text-right mt-4">
                <!-- <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="">
                    Olvide mi contraseña?
                </Link> -->

                <button
                    :disabled="form.processing"
                    class=" boton-send"
                    type="submit">
                    Iniciar
                    <i class="ml-1 fa-solid fa-right-to-bracket"></i>
                </button>
            </div>
        </form>
    </div>
</template>
