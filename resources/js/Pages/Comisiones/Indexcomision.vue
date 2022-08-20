<template>
    <AppLayout title="Comisiones">

        <Statscards></Statscards>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Comisiones
            </h2>
        </template>
        <div class="py-4 lg:px-4 md:px-2 sm:px-2">
            <div class="mx-auto 2xl:8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- Fin Mensajes Flash -->
                    <!-- Encabezado y titulo -->
                    <section>
                        <div class="flex justify-between mx-auto p-4">
                            <div class="w-1/3">
                                <h1 class="font-bold text-xl text-black-800 leading-tight">
                                    Lista de comisiones
                                </h1>
                            </div>

                            <div class="w-1/3">

                            </div>

                        </div>

                        <section>
                            <div class="px-4">
                                <form>
                                    <div class="grid xl:grid-cols-2 xl:gap-6">
                                        <div class="relative z-0 w-full mb-4 group">
                                            <input type="text" v-model="form.venta" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <label class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                                # Venta
                                            </label>
                                        </div>
                                        <div class="relative z-0 w-full mb-4 group">
                                            <input type="text" v-model="form.cliente" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <label class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                                Cliente
                                            </label>
                                        </div>
                                    </div>
                                    <div class="grid xl:grid-cols-2 xl:gap-6">
                                        <div class="relative z-0 w-full mb-4 group">
                                            <input type="text" v-model="form.vendedor" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <label class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                                Vendedor
                                            </label>
                                        </div>
                                        <div class="relative z-0 w-full mb-4 group">
                                            <input type="text" v-model="form.puntoventa" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <label class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                                Punto de venta
                                            </label>
                                        </div>
                                    </div>
                                    <div class="grid xl:grid-cols-2 xl:gap-6">
                                        <div class="relative z-0 w-full mb-4 group">
                                            <input type="text" v-model="form.comprobante" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <label class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                                Comprobante
                                            </label>
                                        </div>
                                        <div class="relative z-0 w-full mb-4 group">
                                            <input type="text" v-model="form.rifa" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <label class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                                Rifa
                                            </label>
                                        </div>
                                    </div>
                                    <div class="grid xl:grid-cols-2 xl:gap-6">
                                        <div class="relative z-0 w-full mb-4 group">
                                            <Datepicker v-model="form.fechainicio" autoApply placeholder="Fecha inicio" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"/>
                                        </div>
                                        <div class="relative z-0 w-full mb-4 group">
                                            <Datepicker v-model="form.fechafin" autoApply placeholder="Fecha fin" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"/>
                                        </div>
                                    </div>
                                    <button type="button" @click="getData(form)" class="mx-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Buscar</button>
                                </form>
                            </div>
                        </section>
                    </section>
                    <!-- Fin Encabezado y titulo -->
                    <!-- Tabla de contenido -->
                    <section>
                        <div class="lg:px-4 md:px-2 sm:px-0 py-2 pb-6">
                            <table class="table-fixed w-full">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-1/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            ID
                                            <div v-show="sortBy == 'nombre'">
                                                <span v-show="!sortOrder">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                                <span v-show="sortOrder">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                      <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </button>
                                    </th>
                                    <th class="px-4 py-2 w-1/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Mayorista
                                            <div v-show="sortBy == 'nombre'">
                                                <span v-show="!sortOrder">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                                <span v-show="sortOrder">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                      <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </button>
                                    </th>
                                    <th class="px-4 py-2 w-1/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Distribuidor
                                            <div v-show="sortBy == 'nombre'">
                                                <span v-show="!sortOrder">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                                <span v-show="sortOrder">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                      <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </button>
                                    </th>
                                    <th class="px-4 py-2 text-sm w-1/12 font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Vendedor
                                            <div v-show="sortBy == 'ciudad.precio'">
                                                <span v-show="!sortOrder">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                                <span v-show="sortOrder">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                      <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </button>
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-1/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Venta
                                            <div v-show="sortBy == 'fechafin'">
                                                <span v-show="!sortOrder">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                                <span v-show="sortOrder">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                      <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </button>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center" text-sm v-if="arrayData.data" v-for="(dato, id) in arrayData.data" :key="id">
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.id"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="formatPrice(dato.comisionmayorista)"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="formatPrice(dato.comisiondistribuidor)"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="formatPrice(dato.comisionvendedor)"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.idventa"></td>
                                </tr>
                                <tr v-else>
                                    <td class="border px-4 py-2 text-xs text-center" colspan="7"> La consulta no obtuvo datos</td>
                                </tr>
                                </tbody>
                            </table>
                            <!-- Paginacion -->
                            <section class="mt-6">
                                <div v-if="arrayData.links.length > 3">
                                    <div class="flex flex-wrap -mb-1">
                                        <template v-for="(link, p) in arrayData.links" :key="p">
                                            <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                                                 v-html="link.label" />
                                            <button  v-else
                                                     class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                                                     :class="{ 'bg-blue-700 text-white': link.active }"
                                                     v-on:click="this.cambiarPage(link.url, 'comisiones', form)"
                                                     v-html="link.label" />
                                        </template>
                                    </div>
                                </div>
                            </section>
                            <!-- Paginacion -->
                        </div>
                    </section>
                    <!-- Fin Tabla de contenido -->



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
import Input from "../../Jetstream/Input";
import Statscards from "../../Components/Statscards";

export default {

    components: {
        Statscards,
        Input,
        NavLink,
        Button,
        AppLayout,
        Icon,
        Pagination,
        Toggle,
        QuillEditor,
        JetNavLink,
        Link,
        money3: Money3Component,

    },
    props:{
        datos : [],
        errors: Object,
        maxcomision: 0,
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
            configPercent: {
                masked: false,
                prefix: '',
                suffix: '%',
                thousands: ',',
                decimal: '.',
                precision: 2,
                disableNegative: true,
                disabled: false,
                min: 0,
                allowBlank: false,
                minimumNumberOfCharacters: 0,
            },

            ispage: true,
            tituloModal: '',
            form: {
                idmayorista: 0,
                iddistribuidor: 0,
                idvendedor: 0,
                comisiondistribuidor: 0.0,
                comisionvendedor: 0.0,
                estado: 1,
            },
            editMode: false,
            verMode: false,
            isOpennuevo: false,
            isOpenCerrar: false,
            isOpenDetalle: false,
            existeuser: 1,
            buscar: '',
            arrayData: {
                data: [],
                links: []
            },
            arrayMayoristas: [],
            arrayDistribuidor: [],
            arrayVendedores: [],
            sortOrder: 1,
            sortBy: '',
            activetab: '1',
            resumencajas: [],
            cajasopen: 0,
            cajasclose: 0,
            recaudocaja: []
        }
    },
    methods: {
        editar: function (data){
            this.openModal('actualizar', data)
        },
        openModal: function (accion, data = []) {
            this.isOpennuevo = true;
            switch (accion) {
                case 'registrar':
                {
                    //this.form = [];
                    this.tituloModal = 'Crear nueva Configuración de comisiones';
                    this.form.idmayorista = 0;
                    this.form.idvendedor = 0;
                    this.form.comisionmayorista = this.maxcomision.valornum;
                    this.form.comisiondistribuidor = 0;
                    this.form.comisionvendedor = 0;
                    this.form.estado = 1;
                    this.getMayoristas();
                    break;
                }
                case 'actualizar':
                {
                    this.editMode = true;
                    this.tituloModal = 'Editar nueva Configuración de comisiones';
                    this.form = data;
                    this.getMayoristas();
                    this.getDistribuidores();
                    this.getVendedores();
                    break;
                }
            }
        },
        closeModal: function () {
            this.isOpennuevo = false;
            this.reset();
            this.editMode = false;
            this.verMode  = false;
            this.$page.props.errors = [];
        },
        reset: function () {
            this.tituloModal = '';
            this.form.idmayorista = 0;
            this.form.iddistribuidor = 0;
            this.form.idvendedor = 0;
            this.form.comisionmayorista = this.maxcomision.valornum;
            this.form.comisiondistribuidor = 0;
            this.form.comisionvendedor = 0;
            this.form.estado = 1;
        },
        save: function (data) {
            console.log(data);
            this.$inertia.post('/confcomisiones', data, {
                onSuccess: (page) => {
                    Swal.fire({
                        //position: 'top-end',
                        icon: 'success',
                        title: this.$page.props.flash.message,
                        showConfirmButton: false,
                        timer: 2000
                    })
                    this.closeModal();
                    this.getConfcomisiones();
                },
            });
        },
        update: function (data) {
            console.log(data);
            this.$inertia.put('/confcomisiones/' + data.id, data, {
                onSuccess: (page) => {
                    Swal.fire({
                        //position: 'top-end',
                        icon: 'success',
                        title: this.$page.props.flash.message,
                        showConfirmButton: false,
                        timer: 2000
                    })
                    this.closeModal();
                    this.getConfcomisiones();
                },
            });
        },

        ver: function (data) {
            this.verMode = true;
            this.openModal('ver', data);
        },
        getConfcomisiones: function (buscar = '', sortBy = 'id') {
            this.buscar = buscar;

            if (sortBy == this.sortBy){
                this.sortOrder = !this.sortOrder;
            }
            let sortOrderdesc;
            if (this.sortOrder){
                sortOrderdesc = 'asc';
            } else {
                sortOrderdesc = 'desc';
            }
            this.sortBy = sortBy;
            this.ispage = true;

            var url= '/confcomisiones';
            axios.get(url, {
                params: {
                    buscar: this.buscar,
                    sortBy: this.sortBy,
                    sortOrder: sortOrderdesc,
                    ispage: this.ispage
                }
            }).then((res) => {
                var respuesta = res.data;
                this.arrayData = respuesta.datos;
            })
        },
        getMayoristas: function () {
            axios.get('/master/getEmpresas?idrol=4', ).then((res) => {
                this.arrayMayoristas = res.data.data;
            })
        },
        getDistribuidores: function () {
            axios.get('/master/getEmpresas?idrol=3&idpadre=' + this.form.idmayorista, ).then((res) => {
                this.arrayDistribuidor = res.data.data;
            })
        },
        getVendedores: function () {
            axios.get('/master/getEmpresas?idrol=5&idpadre=' + this.form.iddistribuidor, ).then((res) => {
                this.arrayVendedores = res.data.data;
            })
        },
    },
    created: function () {
        this.arrayData = this.datos;
    },
    mounted() {
    },
}
</script>
