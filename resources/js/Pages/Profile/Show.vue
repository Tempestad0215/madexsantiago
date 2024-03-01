<script setup lang="ts" >
import JetSectionBorder from '@component/SectionBorder.vue';
import LogoutOtherBrowserSessionsForm from './Partials/LogoutOtherBrowserSessionsForm.vue';
import TwoFactorAuthenticationForm from './Partials/TwoFactorAuthenticationForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import {  Head, usePage } from '@inertiajs/vue3';
import type {propsUserI} from "../../interfaces/usePage"
import { sessionI } from '../../interfaces/session';
// Definiar el estore

// Definiar la props
defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array<sessionI>,
});

const page:propsUserI = usePage();

// Funciones
const back = () =>{
    window.history.back();
}


</script>

<template>
    <Head title="Perfil"/>
        <div class="m-3">
            <div class="mb-3">
                <h4 class="titulo text-2xl text-center text-blue-700 font-bold">
                    Perfil de usuario
                </h4>
                <button
                    @click="back()"
                    class="bg-blue-700 px-2 rounded-md py-1 text-white"
                    title="Retroceder"
                    type="button">
                    Atras
                    <i class="fa-solid fa-arrow-left-long"></i>
                </button>
            </div>
            <hr class=" clear-both">
            <div class="content-perfil-user">
                <div v-if="page.props.jetstream.canUpdateProfileInformation">
                    <UpdateProfileInformationForm
                        class="form-update-info-user"
                        :user="page.props.auth.user" />

                    <JetSectionBorder />
                </div>

                <div v-if="page.props.jetstream.canUpdatePassword">
                    <UpdatePasswordForm class="" />

                    <JetSectionBorder />
                </div>

                <!-- <div v-if="page.props.jetstream.canManageTwoFactorAuthentication">
                    <TwoFactorAuthenticationForm
                        :requires-confirmation="confirmsTwoFactorAuthentication"
                        class=""
                    />

                    <JetSectionBorder />
                </div> -->

                <!-- <LogoutOtherBrowserSessionsForm
                     :sessions="sessions" class="" /> -->

                <!-- <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
                    <JetSectionBorder />

                    <DeleteUserForm class="mt-10 sm:mt-0" />
                </template> -->
            </div>

        </div>
</template>
