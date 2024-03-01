<script setup lang="ts" >
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import JetActionMessage from "@component/ActionMessage.vue";
import JetFormSection from '@component/FormSection.vue';
import JetInput from '@component/Input.vue';
import JetInputError from '@component/InputError.vue';
import JetLabel from '@component/Label.vue';
import Error from '@partials/Error.vue';
import PasswordInput from '@partials/PasswordInput.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <JetFormSection @submitted="updatePassword">
        <template #title>
            Actualizar contraseña
        </template>

        <template #description>
            Asegúrate de que tu cuenta utiliza una contraseña larga y aleatoria para mantener la seguridad.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <label
                    for="current_password">
                    Contraseña anterior
                </label>
                <PasswordInput
                    v-model="form.current_password"
                    autocomplete="current-password"
                    id="current_password"/>

                <Error
                    :data="form.errors.current_password"
                    />

            </div>

            <div class="col-span-6 sm:col-span-4">
                <label for="password">
                    Nueva contraseña
                </label>
                <PasswordInput
                    v-model="form.password"
                    autocomplete="current-password"
                    id="current_password"/>
                <Error
                    :data="form.errors.password"
                    />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <label
                    for="password_confirmation">
                    Confirmar contraseña
                </label>
                <PasswordInput
                    v-model="form.password_confirmation"
                    autocomplete="password_confirmation"
                    id="password_confirmation"/>
                <Error
                    :data="form.errors.password_confirmation"/>
            </div>
        </template>

        <template #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </JetActionMessage>
            <!-- Boton para enviar -->
            <div class="box-btn">
                <button
                    :disabled="form.processing"
                    class=" boton-send"
                    type="submit">
                    Guardar
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </div>
        </template>
    </JetFormSection>
</template>
