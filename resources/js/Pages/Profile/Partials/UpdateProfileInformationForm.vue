<script setup lang="ts" >
import { ref } from 'vue';
import { router, usePage, Link, useForm } from '@inertiajs/vue3';
import JetFormSection from '@component/FormSection.vue';
import JetInputError from '@component/InputError.vue';
import JetLabel from '@component/Label.vue';
import JetActionMessage from '@component/ActionMessage.vue';
import JetSecondaryButton from '@component/SecondaryButton.vue';
import { propsUserI } from '../../../interfaces/usePage';
import Error from '@partials/Error.vue';

const props = defineProps({
    user: Object,
});

const page:propsUserI = usePage();

const form = useForm({
    _method: 'PUT',
    name: props.user.name,
    email: props.user.email,
    photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route('user-profile-information.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (! photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    router.delete(route('current-user-photo.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>

<template>
    <JetFormSection
        @submitted="updateProfileInformation">
        <template #title>
            Información sobre el perfil
        </template>

        <template #description>
            Actualice la información de perfil y la dirección de correo electrónico de su cuenta.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div
                class="form-update-info-user"
                v-if="page.props.jetstream.managesProfilePhotos">
                <!-- Profile Photo File Input -->
                <input
                    ref="photoInput"
                    type="file"
                    class="hidden"
                    @change="updatePhotoPreview"
                >

                <JetLabel for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div v-show="! photoPreview" class="mt-2">
                    <img :src="user.profile_photo_url" :alt="user.name" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div v-show="photoPreview" class="mt-2">
                    <span
                        class=""
                        :style="'background-image: url(\'' + photoPreview + '\');'"
                    />
                </div>

                <JetSecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                    Seleccionar una nueva foto
                </JetSecondaryButton>

                <JetSecondaryButton
                    v-if="user.profile_photo_path"
                    type="button"
                    class="mt-2"
                    @click.prevent="deletePhoto"
                >
                    Quitar foto
                </JetSecondaryButton>

                <JetInputError :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <label
                    class="label"
                    for="name">
                    Nombre
                </label>
                <input
                    class="input w-full"
                    v-model="form.name"
                    id="name"
                    type="text">
                <Error
                    v-if="form.errors.name"
                    :data="form.errors.name"/>
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <label
                    class="label"
                    for="email">
                    Email

                </label>
                <input
                    class="input w-full"
                    v-model="form.email"
                    id="email"
                    type="email">
                <Error
                    v-if="form.errors.email"
                    :data="form.errors.email"/>

                <div v-if="page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
                    <p class="text-sm mt-2">
                        Your email address is unverified.

                        <Link
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            class=""
                            @click.prevent="sendEmailVerification"
                        >
                            Click here to re-send the verification email.
                        </Link>
                    </p>

                    <div v-show="verificationLinkSent" class="">
                        A new verification link has been sent to your email address.
                    </div>
                </div>
            </div>
        </template>

        <template #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </JetActionMessage>
            <!-- boton para enviar los datos -->
            <div class="box-btn">
                <button
                    class="boton-send"
                    :disabled="form.processing"
                    type="button">
                    Guardar
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </div>
        </template>
    </JetFormSection>
</template>
