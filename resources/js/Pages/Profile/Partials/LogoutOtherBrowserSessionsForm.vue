<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetActionSection from '@/Jetstream/ActionSection.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';

defineProps({
    sessions: Array,
});

const confirmingLogout = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmLogout = () => {
    confirmingLogout.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const logoutOtherBrowserSessions = () => {
    form.delete(route('other-browser-sessions.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingLogout.value = false;

    form.reset();
};
</script>

<template>
    <JetActionSection>
        <template #title>
            Sessions de usuario
        </template>

        <template #description>
            Administre y cierre las sesiones activas en otros navegadores y dispositivos.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Si es necesario, puede cerrar todas las sesiones de los navegadores donde se encuentre logueado en loas diferentes dispositivos. Algunas de las sesiones recientes se muestran a continuación, sin embargo esta lista no es exaustiva.
                Si desea puede cambiar el password para tener mayor seguridad.
            </div>

            <!-- Other Browser Sessions -->
            <div v-if="sessions.length > 0" class="mt-5 space-y-6">
                <div v-for="(session, i) in sessions" :key="i" class="flex items-center">
                    <div>
                        <svg
                            v-if="session.agent.is_desktop"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            class="w-8 h-8 text-gray-500"
                        >
                            <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>

                        <svg
                            v-else
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="w-8 h-8 text-gray-500"
                        >
                            <path d="M0 0h24v24H0z" stroke="none" /><rect
                                x="7"
                                y="4"
                                width="10"
                                height="16"
                                rx="1"
                            /><path d="M11 5h2M12 17v.01" />
                        </svg>
                    </div>

                    <div class="ml-3">
                        <div class="text-sm text-gray-600">
                            {{ session.agent.platform ? session.agent.platform : 'Unknown' }} - {{ session.agent.browser ? session.agent.browser : 'Unknown' }}
                        </div>

                        <div>
                            <div class="text-xs text-gray-500">
                                {{ session.ip_address }},

                                <span v-if="session.is_current_device" class="text-green-500 font-semibold">Este dispositivo</span>
                                <span v-else>Activo desde {{ session.last_active }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center mt-5">
                <JetButton @click="confirmLogout">
                    Cerrar sesión de otros navegadores
                </JetButton>

                <JetActionMessage :on="form.recentlySuccessful" class="ml-3">
                    Realizado.
                </JetActionMessage>
            </div>

            <!-- Log Out Other Devices Confirmation Modal -->
            <JetDialogModal :show="confirmingLogout" @close="closeModal">
                <template #title>
                    Cerrar sesión de otros navegadores
                </template>

                <template #content>
                    Por favor ingrese el password para confirmar que desea cerrar todas las sesiones de otros navegadores y dispositivos.

                    <div class="mt-4">
                        <JetInput
                            ref="passwordInput"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-3/4"
                            placeholder="Password"
                            @keyup.enter="logoutOtherBrowserSessions"
                        />

                        <JetInputError :message="form.errors.password" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <JetSecondaryButton @click="closeModal">
                        Cancelar
                    </JetSecondaryButton>

                    <JetButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="logoutOtherBrowserSessions"
                    >
                        Cerrar sesión de otros navegadores
                    </JetButton>
                </template>
            </JetDialogModal>
        </template>
    </JetActionSection>
</template>
