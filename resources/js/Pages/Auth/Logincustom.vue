<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import { usePage } from '@inertiajs/inertia-vue3'

defineProps({
    canResetPassword: Boolean,
    status: String,
    _token: String
});

const form = useForm({
    username: '',
    password: '',
    remember: false,
    terms: true,
    _token: usePage().props.value._token,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login.authenticate'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <JetAuthenticationCard>
        <template #logo>
            <JetAuthenticationCardLogo />
        </template>

        <JetValidationErrors class="mb-4" />

        <div mx-auto class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-show="$page.props.flash.message">
            <div class="flex">
                <div>
                    <p class="text-sm">{{ $page.props.flash.message }}</p>
                </div>
            </div>
        </div>

        <form @submit.prevent="submit">
            <div>
                <JetLabel for="username" value="Nombre de Usuario" />
                <JetInput
                    id="username"
                    v-model="form.username"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                />
            </div>

            <div class="mt-4">
                <JetLabel for="password" value="Password" />
                <JetInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password"
                />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <JetCheckbox v-model:checked="form.remember" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                </label>
            </div>

            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <JetLabel for="terms">
                    <div class="flex items-center">
                        <JetCheckbox id="terms" v-model:checked="form.terms" name="terms" />

                        <div class="ml-2">
                            Estoy de acuerdo con <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Términos de servicio</a> y <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Política de privacidad</a>
                        </div>
                    </div>
                </JetLabel>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900 mx-4">
                    Olvido el passsword?
                </Link>

                <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing || !form.terms">
                    Ingresar
                </JetButton>
            </div>
        </form>
    </JetAuthenticationCard>
</template>
