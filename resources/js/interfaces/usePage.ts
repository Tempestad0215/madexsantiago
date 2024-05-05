

export interface pageI {
    props: Object
}

// Props con el usuario
export interface propsUserI {
    props: {
        auth:{
            user: userAuthI
        },
        jetstream?: jetstreamI
    }
}
// Jetstream interface
interface jetstreamI {
    canCreateTema: Boolean,
    canManageTwoFactorAuthentication: Boolean,
    canUpdatePassword: Boolean,
    canUpdateProfileInformation: Boolean,
    hasEmailVerification: Boolean,
    flash: Array<any>,
    hasAccountDeletionFeatures: Boolean,
    hasApiFeatures: Boolean,
    hasTeamFeatures: Boolean,
    hasTermsAndPrivacyPolicyFeature: Boolean,
    managesProfilePhotos: Boolean
}
// Usare auth
export interface userAuthI{
    deparment:number,
    email: string,
    email_verified_at: string,
    id: number,
    name: string,
    profile_photo_url: string,
    two_factor_enabled: string
}
