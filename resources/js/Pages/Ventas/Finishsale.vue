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
                    <!-- Fin Mensajes Flash -->

                            <div class="w-full mx-auto pb-5">
                                <h1 class="sr-only">Resumen de la transacción</h1>
                                    <!-- Order summary -->
                                    <div class="mt-5 mb-10 lg:mt-0">
                                        <h2 class="text-lg font-bold font-medium text-gray-900">Resumen de la transacción</h2>

                                        <div class="mt-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                                            <ul role="list" class="divide-y divide-gray-200">
                                                <li class="flex py-3 px-4 sm:px-6 font-bold">
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            Rifa
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            Número
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            promocional
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            Valor
                                                        </h4>
                                                    </div>
                                                </li>
                                                <li class="flex py-6 px-4 sm:px-6" v-for="(dato, id) in checkouts" :key="id">
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            <a href="#" class="font-medium text-gray-700 hover:text-gray-800"> {{ dato.valor }} </a>
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            <a href="#" class="font-medium text-gray-700 hover:text-gray-800"> {{ dato.valor }} </a>
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            <a href="#" class="font-medium text-gray-700 hover:text-gray-800"> {{ dato.valor }} </a>
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            <p class="mt-1 text-sm font-medium text-gray-900">{{ formatPrice(dato.valor) }}</p>
                                                        </h4>
                                                    </div>
                                                </li>
                                                <!-- More products... -->
                                            </ul>
                                            <dl class="border-t border-gray-200 py-6 px-4 space-y-6 sm:px-6">
                                                <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                                                    <dt class="text-base font-medium font-bold">Total</dt>
                                                    <dd class="text-base font-medium text-gray-900 font-bold">total</dd>
                                                </div>
                                            </dl>
                                            <div class="flex w-10/12 mx-auto justify-items-center pb-4">
                                                <label class="block text-sm font-medium font-bold text-gray-700">Comprobante de pago</label>
                                                {{ checkouts[0].payment_id }}
                                                <label class="block text-sm font-medium font-bold text-gray-700">Estatus</label>
                                                <div class="mt-1 px-2">
                                                    {{ checkouts[0].status }}
                                                </div>
                                                <div class="cho-container">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                    <div class="flex items-center justify-center p-5 bg-blue-100 min-w-screen">
                        <div class="max-w-xl p-8 text-center text-gray-800 bg-white shadow-xl lg:max-w-3xl rounded-3xl lg:p-12">
                            <h3 class="text-2xl">Gracias por compra en TresAses!</h3>
                            <div class="flex justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-green-400" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                          d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                                </svg>
                            </div>

                            <p>A continuación recibirá un mensaje de correo electrónico al: {{ form.cliente.correo}}</p>
                            <div class="mt-4">
                                <a :href="'/ventas/reportpdf?id=' + checkouts[0].idventa" target="_blank" class="px-2 py-2 text-blue-200 bg-blue-600 rounded">Imprimir</a>
                                <p class="mt-4 text-sm">Si tiene problemas para poder acceder al correo, puede ver el resumen de la compra en:
                                    <a :href="'/ventas/sumary?id=' + checkouts[0].idventa" target="_blank" class="text-blue-600 underline">Resumen</a>
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
        checkouts : [],
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
