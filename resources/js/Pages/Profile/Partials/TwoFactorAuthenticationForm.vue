<script setup lang="ts" >
import { ref, computed, watch } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import JetActionSection from '@component/ActionSection.vue';
import JetButton from '@component/Button.vue';
import JetConfirmsPassword from '@component/ConfirmsPassword.vue';
import JetDangerButton from '@component/DangerButton.vue';
import JetInput from '@component/Input.vue';
import JetInputError from '@component/InputError.vue';
import JetLabel from '@component/Label.vue';
import JetSecondaryButton from '@component/SecondaryButton.vue';
import axios from 'axios';
import { propsUserI } from '../../../interfaces/usePage';

const props = defineProps({
    requiresConfirmation: Boolean,
});

const page:propsUserI = usePage();

const enabling = ref(false);
const confirming = ref(false);
const disabling = ref(false);
const qrCode = ref(null);
const setupKey = ref(null);
const recoveryCodes = ref([]);

const confirmationForm = useForm({
    code: '',
});

const twoFactorEnabled = computed(
    () => ! enabling.value && page.props.auth.user?.two_factor_enabled,
);

watch(twoFactorEnabled, () => {
    if (! twoFactorEnabled.value) {
        confirmationForm.reset();
        confirmationForm.clearErrors();
    }
});

const enableTwoFactorAuthentication = () => {
    enabling.value = true;

    router.post('/user/two-factor-authentication', {}, {
        preserveScroll: true,
        onSuccess: () => Promise.all([
            showQrCode(),
            showSetupKey(),
            showRecoveryCodes(),
        ]),
        onFinish: () => {
            enabling.value = false;
            confirming.value = props.requiresConfirmation;
        },
    });
};

const showQrCode = () => {
    return axios.get('/user/two-factor-qr-code').then(response => {
        qrCode.value = response.data.svg;
    });
};

const showSetupKey = () => {
    return axios.get('/user/two-factor-secret-key').then(response => {
        setupKey.value = response.data.secretKey;
    });
}

const showRecoveryCodes = () => {
    return axios.get('/user/two-factor-recovery-codes').then(response => {
        recoveryCodes.value = response.data;
    });
};

const confirmTwoFactorAuthentication = () => {
    confirmationForm.post('/user/confirmed-two-factor-authentication', {
        errorBag: "confirmTwoFactorAuthentication",
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            confirming.value = false;
            qrCode.value = null;
            setupKey.value = null;
        },
    });
};

const regenerateRecoveryCodes = () => {
    axios
        .post('/user/two-factor-recovery-codes')
        .then(() => showRecoveryCodes());
};

const disableTwoFactorAuthentication = () => {
    disabling.value = true;

    router.delete('/user/two-factor-authentication', {
        preserveScroll: true,
        onSuccess: () => {
            disabling.value = false;
            confirming.value = false;
        },
    });
};
</script>

<template>
    <JetActionSection class="mt-3">
        <template #title>
            Autenticación de dos factores
        </template>

        <template #description>
            Añada seguridad adicional a su cuenta mediante la autenticación de dos factores.
        </template>

        <template #content>
            <h3 v-if="twoFactorEnabled && ! confirming" class="text-lg font-medium text-gray-900">
                Ha activado la autenticación de dos factores.
            </h3>

            <h3 v-else-if="twoFactorEnabled && confirming" class="text-lg font-medium text-gray-900">
                Termine de habilitar la autenticación de dos factores.
            </h3>

            <h3 v-else class="text-lg font-medium text-gray-900">
                No ha activado la autenticación de dos factores.
            </h3>

            <div class="mt-3 max-w-xl text-sm text-gray-600">
                <p>
                    Cuando la autenticación de dos factores está activada, se te pedirá un token seguro y aleatorio durante la autenticación. Puede recuperar este token desde la aplicación Google Authenticator de su teléfono.
                </p>
            </div>

            <div v-if="twoFactorEnabled">
                <div v-if="qrCode">
                    <div class="mt-4 max-w-xl text-sm text-gray-600">
                        <p v-if="confirming" class="font-semibold">
                            Para terminar de activar la autenticación de dos factores, escanea el siguiente código QR utilizando la aplicación de autenticación de tu teléfono o introduce la clave de configuración y proporciona el código OTP generado.
                        </p>

                        <p v-else>
                            La autenticación de dos factores ya está activada. Escanee el siguiente código QR con la aplicación de autenticación de su teléfono o introduzca la clave de configuración.
                        </p>
                    </div>

                    <div class="mt-4" v-html="qrCode" />

                    <div class="mt-4 max-w-xl text-sm text-gray-600" v-if="setupKey">
                        <p class="font-semibold">
                            Tecla de configuración: <span v-html="setupKey"></span>
                        </p>
                    </div>

                    <div v-if="confirming" class="mt-4">
                        <JetLabel for="code" value="Code" />

                        <JetInput
                            id="code"
                            v-model="confirmationForm.code"
                            type="text"
                            name="code"
                            class="block mt-1 w-1/2"
                            inputmode="numeric"
                            autofocus
                            autocomplete="one-time-code"
                            @keyup.enter="confirmTwoFactorAuthentication"
                        />

                        <JetInputError :message="confirmationForm.errors.code" class="mt-2" />
                    </div>
                </div>

                <div v-if="recoveryCodes.length > 0 && ! confirming">
                    <div class="mt-4 max-w-xl text-sm text-gray-600">
                        <p class="font-semibold">
                            Guarde estos códigos de recuperación en un gestor de contraseñas seguro. Se pueden utilizar para recuperar el acceso a tu cuenta si pierdes el dispositivo de autenticación de dos factores.
                        </p>
                    </div>

                    <div class="">
                        <div v-for="code in recoveryCodes" :key="code">
                            {{ code }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <div v-if="! twoFactorEnabled">
                    <JetConfirmsPassword @confirmed="enableTwoFactorAuthentication">
                        <!-- Boton para enviar -->
                        <div class="box-btn">
                            <BotonS
                                :sending="enabling"
                                data-label="Activar"/>

                        </div>
                    </JetConfirmsPassword>
                </div>

                <div v-else>
                    <JetConfirmsPassword @confirmed="confirmTwoFactorAuthentication">
                        <JetButton
                            v-if="confirming"
                            type="button"
                            class="mr-3"
                            :class="{ 'opacity-25': enabling }"
                            :disabled="enabling"
                        >
                            Confirmar
                        </JetButton>
                    </JetConfirmsPassword>

                    <JetConfirmsPassword @confirmed="regenerateRecoveryCodes">
                        <JetSecondaryButton
                            v-if="recoveryCodes.length > 0 && ! confirming"
                            class="mr-3"
                        >
                            Regenerar códigos de recuperación
                        </JetSecondaryButton>
                    </JetConfirmsPassword>

                    <JetConfirmsPassword @confirmed="showRecoveryCodes">
                        <JetSecondaryButton
                            v-if="recoveryCodes.length === 0 && ! confirming"
                            class="mr-3"
                        >
                            Mostrar códigos de recuperación
                        </JetSecondaryButton>
                    </JetConfirmsPassword>

                    <JetConfirmsPassword @confirmed="disableTwoFactorAuthentication">
                        <JetSecondaryButton
                            v-if="confirming"
                            :class="{ 'opacity-25': disabling }"
                            :disabled="disabling"
                        >
                            Cancelar
                        </JetSecondaryButton>
                    </JetConfirmsPassword>

                    <JetConfirmsPassword @confirmed="disableTwoFactorAuthentication">
                        <JetDangerButton
                            v-if="! confirming"
                            :class="{ 'opacity-25': disabling }"
                            :disabled="disabling"
                        >
                            Desactivar
                        </JetDangerButton>
                    </JetConfirmsPassword>
                </div>
            </div>
        </template>
    </JetActionSection>
</template>
