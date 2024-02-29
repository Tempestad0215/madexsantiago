<script setup lang="ts" >
import JetSectionBorder from '../../Jetstream/SectionBorder.vue';
import LogoutOtherBrowserSessionsForm from './Partials/LogoutOtherBrowserSessionsForm.vue';
import TwoFactorAuthenticationForm from './Partials/TwoFactorAuthenticationForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import Inicio from '../Partials/Inicio.vue'
import AnclaHeader from '../Partials/AnclaHeader.vue';
import {  usePage } from '@inertiajs/vue3';
import { isDeparmentCorrect  } from "../../Global/helpers";
import { useUserAuth } from '../../store/userAuthStore';
import type {propsUserI} from "../../interfaces/usePage"
import { sessionI } from '../../interfaces/session';

// Definiar el estore
const storeUserAuth = useUserAuth();

// Definiar la props
defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array<sessionI>,
});

const page:propsUserI = usePage();




</script>

<template>
    <Inicio>
        <template #header>
            <AnclaHeader
                v-if="isDeparmentCorrect(storeUserAuth.userAuth.deparment,'ADMINFULL')"
                icono="fa-solid fa-user-plus"
                data-label="Registrar"
                :url="route('user.registrar')"/>
            <AnclaHeader
                :class="true ? '' : 'col-span-full'"
                icono="fa-solid fa-user"
                data-label="Perfil"
                :active="true"
                url="/user/profile"/>
        </template>
        <hr>
        <div class="mt-3">
            <div>
                <h4 class="titulo text-lg">
                    Perfil de usuario</h4>
            </div>
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

                <div v-if="page.props.jetstream.canManageTwoFactorAuthentication">
                    <TwoFactorAuthenticationForm
                        :requires-confirmation="confirmsTwoFactorAuthentication"
                        class=""
                    />

                    <JetSectionBorder />
                </div>

                <LogoutOtherBrowserSessionsForm
                     :sessions="sessions" class="" />

                <!-- <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
                    <JetSectionBorder />

                    <DeleteUserForm class="mt-10 sm:mt-0" />
                </template> -->
            </div>

        </div>
    </Inicio>
</template>
