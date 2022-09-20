<template>
    <AppLayout title="Ventas" :total="total">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Resumen de venta
            </h2>
        </template>
        <div class="py-2 w-10/12 mx-auto lg:px-8 md:px-6 sm:px-2">
            <div class="mx-auto 2xl:8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex items-center justify-center p-5 bg-blue-100 min-w-screen">
                        <div class="max-w-xl p-8 text-center text-gray-800 bg-white shadow-xl lg:max-w-3xl rounded-3xl lg:p-12">
                            <h3 class="text-2xl">{{ mensajePago }}</h3>
                            <div class="flex justify-center">
                                <svg v-if="estado == 'aprobado'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 text-green-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg v-else-if="estado=='rechazado'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 text-red-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 text-yellow-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>

                            </div>

                            <p>Comprobante de pago {{ payment_id }} </p>
                            <p>A continuación recibirá un mensaje de correo electrónico </p>
                            <div class="mt-4" v-if="estado == 'aprobado'">
                                <a :href="'/ventas/reportpdf?id=' + idventa" target="_blank" class="px-2 py-2 text-blue-200 bg-blue-600 rounded">Imprimir</a>
                                <p class="mt-4 text-sm">Si tiene problemas para poder acceder al correo, puede ver el resumen de la compra en:
                                    <a :href="'/ventas/sumary?id=' + idventa" target="_blank" class="text-blue-600 underline">Resumen</a>
                                </p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </AppLayout>
</template>


<script>

import AppLayout from '@/Layouts/AppLayout.vue';
import Swal from "sweetalert2";
import { Icon } from '@iconify/vue';
import Pagination from '@/Components/Pagination';

import Toggle from '@vueform/toggle';
import '@vueform/toggle/themes/default.css';
import Button from "../../Jetstream/Button";

import moment from 'moment'
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { ref, onMounted } from 'vue';
import { Money3Component } from 'v-money3'

import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetNavLink from '@/Jetstream/NavLink.vue';
import NavLink from "../../Jetstream/NavLink";
import Submenu from "../../Components/Submenu";


import {FormWizard, TabContent} from 'vue3-form-wizard';
import 'vue3-form-wizard/dist/style.css';
import ThemifyIcon from "vue-themify-icons";

import VueQrcode from '@chenfengyuan/vue-qrcode';
import VueCountdown from '@chenfengyuan/vue-countdown';

export default {
    name: 'App',

    components: {
        Submenu,
        Button,
        AppLayout,
        Icon,
        Pagination,
        Toggle,
        QuillEditor,
        money3: Money3Component,
        Link,
        FormWizard,
        TabContent,
        VueQrcode,
        ThemifyIcon,
        VueCountdown
    },
    props:{
        idventa : null,
        payment_id: null,
        estado: null,
        mensajePago:'',
        errors: Object,
    },
    computed: {
    },
    data() {
        return {
            inputValue: null,
            configMoney: {
                masked: false,
                prefix: '$ ',
                suffix: '',
                thousands: ',',
                decimal: '.',
                precision: 0,
                disableNegative: false,
                disabled: false,
                min: null,
                max: null,
                allowBlank: false,
                minimumNumberOfCharacters: 0,
            },
            ispage: true,
            tituloModal: '',
            arrayData: {
                data: [],
                links: []
            },
            configMoney2: {
                masked: true,
                prefix: '',
                suffix: '',
                thousands: '',
                decimal: '',
                precision: 0,
                disableNegative: true,
                disabled: false,
                min: 0,
                max: 9999,
                allowBlank: false,
                minimumNumberOfCharacters: 4,
            },
            editMode: false,
            verMode: false,
            isOpen: false,
            buscar: '',
            sortOrder: 1,
            sortBy: '',
            errornumerosreservados: 0,
            existedata: 0,
            existecliente: 0,
            arrayRifas: {
                data: [],
                links: []
            },
            arrayClientes: {
                data: [],
                links: []
            },
            isOpenRifa: false,
            isOpenCliente: false,
            valboleta: [],
            promoboleta: [],
            isRandom: 0,
            isCliente: false,
            arrayPaises: [],
            arrayDepartamentos: [],
            arrayCiudades: [],
            arrayTiposdocumento: [],
            cart: [],
            numerotmp: null,
            boleta: [],
            total: 0.0,
            totalnoparseado: 0.0,
            subtotal: 0.0,
            isComplete: false,
            isBussyCart: 0,
            isNewCliente: false,
            asignarMode: true
        }
    },
    methods: {
        selectNumero: async function(tipo) {
            this.numerotmp = this.form.numero;
            const { value: ipAddress } = await Swal.fire({
                title: 'Ingrese el número deseado',
                input: 'text',
                inputLabel: 'Número boleta',
                inputValue: this.numerotmp,
                showCancelButton: true,
                /*
                inputValidator: (value) => {
                    if (!value) {
                        return 'Por favor ingrese un número!'
                    }
                */
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.boleta.numero = this.form.numero;
                    this.form.boleta.idrifa = this.form.idrifa.id;
                }
            })
        },



    },
    created: function () {

    },
    mounted() {
    },
}
</script>


<style>
* {
    margin: 0;
    padding: 0;
}
fieldset label span {
    min-width: 125px;
}
fieldset .select::after {
    content: '';
    position: absolute;
    width: 9px;
    height: 5px;
    right: 20px;
    top: 50%;
    margin-top: -2px;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='9' height='5' viewBox='0 0 9 5'><title>Arrow</title><path d='M.552 0H8.45c.58 0 .723.359.324.795L5.228 4.672a.97.97 0 0 1-1.454 0L.228.795C-.174.355-.031 0 .552 0z' fill='%23CFD7DF' fill-rule='evenodd'/></svg>");
    pointer-events: none;
}
</style>
