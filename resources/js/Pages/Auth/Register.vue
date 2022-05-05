<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';

const form = useForm({
    nombre: '',
    apellido: '',
    idrol: 0,
    correo: '',
    username: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />

    <JetAuthenticationCard>
        <template #logo>
            <JetAuthenticationCardLogo />
        </template>

        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <JetLabel for="name" value="Nombre" />
                <JetInput
                    id="name"
                    v-model="form.nombre"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="nombre"
                />
            </div>
            <div>
                <JetLabel for="apellido" value="Apellido" />
                <JetInput
                    id="apellido"
                    v-model="form.apellido"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="apellido"
                />
            </div>

            <div class="mt-4">
            <JetLabel for="correo" value="Correo" />
            <JetInput
                id="correo"
                v-model="form.correo"
                type="email"
                class="mt-1 block w-full"
                required
            />
            </div>

            <div class="mt-4">
                <JetLabel for="username" value="Username" />
                <JetInput
                    id="username"
                    v-model="form.username"
                    type="text"
                    class="mt-1 block w-full"
                    required
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

            <div class="mt-4">
                <JetLabel for="idrol" value="Rol" />
                <select
                    id="idrol"
                    v-model="form.idrol"
                    type="text"
                    class="block w-full rounded-lg text-gray-700 text-sm"
                    required
                    autocomplete="rol"
                >
                    <option value="3" >Distribuidor</option>
                    <option value="4" >Mayorista</option>
                    <option value="4" >Vendedor</option>
                </select>
            </div>

            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <JetLabel for="terms">
                    <div class="flex items-center">
                        <JetCheckbox id="terms" v-model:checked="form.terms" name="terms" />

                        <div class="ml-2">
                            I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                        </div>
                    </div>
                </JetLabel>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Ya está registrado?
                </Link>

                <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrar
                </JetButton>
            </div>
        </form>
    </JetAuthenticationCard>
</template>
