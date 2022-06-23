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
import Button from "../../Jetstream/Button";

defineProps({
    datos: [],
    username: '',
    password: '',
    _token: String
});

const form = useForm({
    username: usePage().props.value.username,
    current_password: usePage().props.value.password,
    password: '',
    password_confirmation: '',
    terms: false,
    _token: usePage().props.value._token,
});

const cambiarUser = () => {
    //form.post(route('logout'));
};

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('changepass.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
<script>

export default {

    data() {
        return {
            cartx: [],
            isMenutransac: false,
            isMenuConfig: false,
            isMenuUsers: false,
            isMenuPuntoventa: false,
            isMenuCajas: false,
            isMenuRifas: false,
            isMenuVentas: false,
            isMenuComision: false,
        }
    },

}

</script>
<template>
    <Head title="Cambiar password" />

    <JetAuthenticationCard>
        <template #logo>
            <JetAuthenticationCardLogo />
        </template>

        <JetValidationErrors class="mb-4" />
        <div class="py-2">
            Señor usuario, para poder continuar se requiere que realice el cambio de clave
        </div>
        <form @submit.prevent="submit">
            <div class="mt-4">
                <JetLabel for="username" value="Username" />
                <JetInput
                    id="username"
                    v-model="form.username"
                    type="text"
                    disabled=""
                    class="mt-1 block w-full bg-blue-200"
                    required
                />
            </div>

            <div class="mt-4">
                <JetLabel for="current_password" value="Password actual" />
                <JetInput
                    id="current_password"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
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
                    autocomplete="new-password"
                />
            </div>
            <div class="mt-4">
                <JetLabel for="password_confirmation" value="Confirm Password" />
                <JetInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="this.cambiarUser()" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Cambiar de usuario
                </Link>
                <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Cambiar
                </JetButton>
            </div>
        </form>
    </JetAuthenticationCard>
</template>
