<template>
    <AppLayout title="Numerosreservados">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de Paises
            </h2>
        </template>
        <div class="py-4 lg:px-8 md:px-6 sm:px-2">
            <div class="mx-auto 2xl:8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- Fin Mensajes Flash -->
                    <!-- Encabezado y titulo -->
                    <section>
                        <div class="flex justify-between mx-auto p-4">
                            <div class="w-1/2">
                                <h1 class="font-bold text-xl text-black-800 leading-tight">
                                    Paises
                                </h1>
                            </div>

                            <div class="w-1/2">
                                <div class="container flex justify-center items-center">
                                    <div class="relative">
                                        <div class="absolute top-4 left-3">
                                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                        <input type="text" v-model="buscar" @keyup="getData(buscar,'nombre')" class="h-8 w-96 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar">
                                        <button @click="getData(buscar,'nombre')">
                                            <div class="absolute top-2 right-2">
                                                <Icon icon="fe:search" class="h-4"  />
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Inicia SubMenu -->
                    <submenu></submenu>
                    <!-- Fin Sub Menu -->
                    <!-- Fin Encabezado y titulo -->
                    <!-- Tabla de contenido -->
                    <section>
                        <div class="lg:px-4 md:px-2 sm:px-0 py-2 pb-6 overflow-y-auto h-40">
                            <table class="table-fixed w-full">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Nombre
                                    </th>
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Zona
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Descripción
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Moneda
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center hover:bg-blue-100" @click="selectPais(dato.departamentos)" text-sm v-if="existedata > 0" v-for="(dato, id) in arrayData.data" :key="id">
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.nombre"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.zona"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.descripcion"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.moneda"></td>
                                </tr>
                                <tr v-else>
                                    <td class="border px-4 py-2 text-xs text-center" colspan="4"> La consulta no obtuvo datos</td>
                                </tr>
                                </tbody>
                            </table>
                            <section class="mt-6">
                                <div v-if="arrayData.links.length > 3">
                                    <div class="flex flex-wrap -mb-1">
                                        <template v-for="(link, p) in arrayData.links" :key="p">
                                            <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                                                 v-html="link.label" />
                                            <button  v-else
                                                     class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                                                     :class="{ 'bg-blue-700 text-white': link.active }"
                                                     v-on:click="cambiarPage(link.url)"
                                                     v-html="link.label" />
                                        </template>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </section>
                    <!-- Fin Tabla de contenido -->
                    <!-- Departamentos -->
                    <section>
                        <div class="flex justify-between mx-auto p-4">
                            <div class="w-1/2">
                                <h1 class="font-bold text-xl text-black-800 leading-tight">
                                    Departamentos
                                </h1>
                            </div>

                            <div class="w-1/2">
                                <div class="container flex justify-center items-center">
                                    <div class="relative">
                                        <div class="absolute top-4 left-3">
                                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                        <input type="text" v-model="buscar" @keyup="getData2(buscar,'nombre')" class="h-8 w-96 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar">
                                        <button @click="getData2(buscar,'nombre')">
                                            <div class="absolute top-2 right-2">
                                                <Icon icon="fe:search" class="h-4"  />
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Fin Encabezado y titulo -->
                    <!-- Tabla de contenido -->
                    <section>
                        <div class="lg:px-4 md:px-2 sm:px-0 py-2 pb-6 overflow-y-auto h-40">
                            <table class="table-fixed w-full">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Nombre
                                    </th>
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Descripción
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Pais
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center hover:bg-blue-100" @click="selectDepartamento(dato.ciudades)" text-sm v-if="existedata2 > 0" v-for="(dato, id) in arrayData2.data" :key="id">
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.nombre"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.descripcion"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.idpais"></td>
                                </tr>
                                <tr v-else>
                                    <td class="border px-4 py-2 text-xs text-center" colspan="3"> La consulta no obtuvo datos</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </section>
                    <!-- Fin Departamentos -->


                    <!-- Ciudades -->
                    <section>
                        <div class="flex justify-between mx-auto p-4">
                            <div class="w-1/2">
                                <h1 class="font-bold text-xl text-black-800 leading-tight">
                                    Ciudades
                                </h1>
                            </div>

                            <div class="w-1/2">
                                <div class="container flex justify-center items-center">
                                    <div class="relative">
                                        <div class="absolute top-4 left-3">
                                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                        <input type="text" v-model="buscar" @keyup="getData3(buscar,'nombre')" class="h-8 w-96 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar">
                                        <button @click="getData3(buscar,'nombre')">
                                            <div class="absolute top-2 right-2">
                                                <Icon icon="fe:search" class="h-4"  />
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Fin Encabezado y titulo -->
                    <!-- Tabla de contenido -->
                    <section>
                        <div class="lg:px-4 md:px-2 sm:px-0 py-2 pb-6 overflow-y-auto h-40">
                            <table class="table-fixed w-full">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Nombre
                                    </th>
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Descripción
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Departamento
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center" text-sm v-if="existedata3 > 0" v-for="(dato, id) in arrayData3.data" :key="id">
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.nombre"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.descripcion"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.iddepartamento"></td>
                                </tr>
                                <tr v-else>
                                    <td class="border px-4 py-2 text-xs text-center" colspan="3"> La consulta no obtuvo datos</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </section>
                    <!-- Fin Ciudades -->
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


export default {

    components: {
        Button,
        AppLayout,
        Icon,
        Pagination,
        Toggle,
        QuillEditor,
        money3: Money3Component,
        Link
    },
    props:{
        data: [],
        errors: Object,
    },
    computed: {
    },
    data() {
        return {
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
            arrayData2: {
                data: [],
                links: []
            },
            arrayData3: {
                data: [],
                links: []
            },
            editMode: false,
            verMode: false,
            isOpen: false,
            buscar: '',
            sortOrder: 1,
            sortBy: '',
            errornumerosreservados: 0,
            existedata: 0,
            existedata2: 0,
            existedata3: 0,
        }
    },
    methods: {
        selectPais: function (data) {
            this.arrayData2.data = data;

            if (this.arrayData2.data.length > 0) {
                this.existedata2 = 1;
            } else {
                this.existedata2 = 0;
            }
        },
        selectDepartamento: function (data) {
            this.arrayData3.data = data;

            if (this.arrayData3.data.length > 0) {
                this.existedata3 = 1;
            } else {
                this.existedata3 = 0;
            }
        },
        cambiarPage: function (url = '') {
            axios.get(url, {
                params: {
                    paginate: true,
                    ispage: true
                }
            }).then((res) => {
                var respuesta = res.data;
                this.arrayData = respuesta.data;

                if (this.arrayData.data.length > 0) {
                    this.existedata = 1;
                } else {
                    this.existedata = 0;
                }
            })
        },
        formatPrice(value) {
            let val = (value/1).toFixed(0).replace('.', ',')
            return '$ '+ val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
        dateTime(value) {
            return moment(value).format('DD/MM/YYYY');
        },
        dateTimeFull(value) {
            return moment(value).format('YYYY-MM-DD HH:MM:SS');
        },
        selectRifa: function () {
            this.isOpenRifa = true;
            //this.getUsers();
            this.getRifas('','nombre_tecnico','true');
        },
        reset: function () {
            this.tituloModal = 'Crear nueva reserva';
            this.form.id = null;
            this.form.idrifa = 0;
            this.form.numero = null;
            this.form.estado = false;
            this.form.rangoinicial = null;
            this.form.rangofinal = null;
            this.form.idvendedor = 0;
            this.form.idcliente = 0;
            this.form.fecha = null;
        },
        ver: function (data) {
            this.verMode = true;
            this.openModal('ver', data);
        },
        getData: async function (buscar = '', filtro = 'nombre', paginate = true) {

            var url= '/master/paises';
            axios.get(url, {
                params: {
                    buscar: buscar,
                    filtro: filtro,
                    paginate: paginate,
                    ispage: true,
                }
            }).then((res) => {
                var respuesta = res.data;
                this.arrayData = respuesta.data;

                if (this.arrayData.data.length > 0) {
                    this.existedata = 1;
                } else {
                    this.existedata = 0;
                }
            })
        },
    },
    created: function () {
        //this.getPaises();
        this.arrayData = this.data;
        if (this.arrayData.data.length > 0) {
            this.existedata = 1;
        } else {
            this.existedata = 0;
        }
        //this.openModal('registrar')
    },
    mounted() {
    },
}
</script>
