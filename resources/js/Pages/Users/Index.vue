<template>
    <AppLayout title="Usuarios">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de Usuarios
            </h2>
        </template>
        <div class="py-4 lg:px-4 md:px-2 sm:px-2">
            <div class="mx-auto 2xl:8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- Mensajes Flash -->
                    <section>
                        <div @click="cleanMessage()" mx-auto class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-show="$page.props.flash.message">
                            <div class="flex">
                                <div>
                                    <p class="text-sm">{{ $page.props.flash.message }}</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Fin Mensajes Flash -->
                    <!-- Encabezado y titulo -->
                    <section>
                        <div class="flex justify-between mx-auto p-4">
                            <div class="w-1/3">
                                <h1 class="font-bold text-xl text-black-800 leading-tight">
                                    Usuarios
                                </h1>
                            </div>

                            <div class="w-1/3">
                                <div class="container flex justify-center items-center">
                                    <div class="relative">
                                        <div class="absolute top-4 left-3">
                                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                        <input type="text" v-model="buscar" @keyup="getUsers(buscar,'nombre')" class="h-8 w-96 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar (Nombre, Apellido, Correo, Usuario)">
                                        <button @click="getUsers(buscar,'nombre')">
                                            <div class="absolute top-2 right-2">
                                                <Icon icon="fe:search" class="h-4"  />
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="pr-2 w-1/3 text-center">
                                <button @click="openModal('registrar')" class="bg-blue-500 text-xs  hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ">CREAR USUARIO</button>
                            </div>
                        </div>

                        <div class="flex justify-left mx-auto ml-4 p-2 space-x-4">
                            <div class="flex pr-1 w-1/12 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <Link :href="route('numerosreservados.index')" class="text-xs hover:text-blue-700 text-blue-400 font-bold py-1 px-1 rounded ">
                                    Perfil
                                </Link>


                            </div>

                        </div>
                    </section>
                    <!-- Fin Encabezado y titulo -->
                    <!-- Tabla de contenido -->
                    <section>
                        <div class="lg:px-4 md:px-2 sm:px-0 py-2 pb-6">
                            <table class="table-fixed w-full">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-1/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getUsers(buscar, 'documento')" class="font-bold">
                                            Documento
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
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getUsers(buscar, 'nombre')" class="font-bold">
                                            Nombre
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
                                        <button @click="getUsers(buscar, 'movil')" class="font-bold">
                                            Celular
                                            <div v-show="sortBy == 'movil'">
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
                                    <th class="px-4 py-2 text-sm w-2/12 font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getUsers(buscar, 'ciudad.precio')" class="font-bold">
                                            Correo
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
                                        <button @click="getUsers(buscar, 'fechafin')" class="font-bold">
                                            Perfil
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
                                    <th class="px-4 py-2 text-sm font-bold w-1/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getUsers(buscar, 'estado')" class="font-bold">
                                            Estado
                                            <div v-show="sortBy == 'estado'">
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
                                    <th class="lg:px-4 md:px-1 mx-auto py-2 text-sm font-bold lg:w-1/12 md:w-1/11 hover:bg-blue-500 hover:text-gray-50 rounded-b">ACCIONES</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center" text-sm v-if="existeuser > 0" v-for="(user, id) in arrayUsers.data" :key="id">
                                    <td class="border px-1 py-2 text-sm truncate" v-text="user.documento"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="user.nombre + ' ' + user.apellido"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="user.movil"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="user.correo"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="user.rol.nombre"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-if="user.estado">
                                        <span class="inline-flex px-2 text-sm font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                            Activo
                                        </span>
                                    </td>
                                    <td class="border px-2 py-2 text-sm" v-else>
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                            Inactivo
                                        </span>
                                    </td>
                                    <td class="border px-1 py-1 mx-auto text-center flex items-center">
                                        <button @click="ver(user)" class="hover:bg-green-700 text-green-400 font-bold rounded" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z" />
                                            </svg>
                                        </button>
                                        <button @click="edit(user)" class="hover:bg-blue-700 text-white font-bold rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button @click="deleteRow(user)" class="hover:bg-red-700 text-white font-bold rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path v-if="user.estado" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                <path v-else fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>

                                        </button>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td class="border px-4 py-2 text-xs text-center" colspan="7"> La consulta no obtuvo datos</td>
                                </tr>
                                </tbody>
                            </table>
                            <pagination class="mt-6" :links="arrayUsers.links" />
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

export default {

    components: {
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
        users : [],
        errors: Object
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
            pageX1: 0,
            pageY1: 0,
            uploadDragoverTracking1: false,
            uploadDragoverEvent1: false,

            pageX2: 0,
            pageY2: 0,
            uploadDragoverTracking2: false,
            uploadDragoverEvent2: false,

            tituloModal: '',
            form: {
                id: null,
                nombre: '',
                correo: null,
                username: null,
                apellido: null,
                idrol: 0,
                estado: 0,
                idtipos_documento: 0,
                documento: null,
                direccion: 0,
                indicativo: 0,
                iddepartamento: 0,
                idciudad: 0,
                idpais: 0,
                observaciones: null,
                movil: null,
                isnatural: null,
                camaracomercio: false,
                rut: false,
                url: false,
            },
            arrayPaises: [],
            arrayDepartamentos: [],
            arrayCiudades: [],
            arrayRoles: [],
            arrayTiposdocumentos: [],
            editMode: false,
            verMode: false,
            isOpen: false,
            existeuser: 1,
            buscar: '',
            arrayUsers: {
                data: [],
                links: []
            },
            sortOrder: 1,
            sortBy: '',
            errorusers: 0,
            errorMostrarMsjrifa: []
        }
    },
    methods: {
        actualizarRangos() {
            let rango = null;
            let cantidad = 0;

            cantidad = Math.pow(10, this.form.cifras);
            rango = String(0).padStart(this.form.cifras, '0') + ' - ' + (cantidad-1);
            this.cantboletas = cantidad;
            this.rango = rango;
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
        cleanMessage: function () {
            this.$page.props.flash.message = '';
        },
        previewImage(e) {
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },
        openModal: function (accion, data = []) {
            this.isOpen = true;
            //this.getPaises();
            //this.getLoterias();
            //this.getTerminos();

            switch (accion) {
                case 'registrar':
                {
                    this.tituloModal = 'Crear nuevo rifa de venta';
                    this.form.id = null;
                    this.form.titulo = null;
                    this.form.resolucion = null;
                    this.form.estado = false;
                    this.form.nombre = null;
                    this.form.descripcion = null;
                    this.form.nombre_tecnico = null;
                    this.form.resumen = null;
                    this.form.url = null;
                    this.form.idloteria = 0;
                    this.form.idpais = 0;
                    this.form.iddepartamento = 0;
                    this.form.idciudad = 0;
                    this.form.cifras = 0;
                    this.form.precio = 0;
                    this.form.fechainicio = null;
                    this.form.fechafin = null;
                    this.form.promocional = null;
                    this.form.publicar = null;
                    this.form.destacada = null;
                    this.form.principal = null;
                    this.form.urlimagen2 = null;
                    this.form.urlimagen1 = null;
                    this.form.idterminos = 0;
                    this.form.idcreador = 0;
                    this.form.files1 = [];
                    this.form.files2 = [];
                    break;
                }
                case 'ver':
                {

                    this.tituloModal = 'Detalle  del usuario ' +  data['nombre'];
                    this.form = data;
                    /*
                    this.form.id = data['id'];
                    this.form.titulo = data['titulo'];
                    this.form.resolucion = data['resolucion'];
                    this.form.estado = data['estado'];
                    this.form.nombre = data['nombre'];
                    this.form.descripcion = data['descripcion'];
                    this.form.nombre_tecnico = data['nombre_tecnico'];
                    this.form.resumen = data['resumen'];
                    this.form.url = data['url'];
                    this.form.idloteria = data['idloteria'];
                    this.form.idpais = data['idpais'];
                    this.form.iddepartamento = data['iddepartamento'];
                    this.form.idciudad = data['idciudad'];
                    this.form.cifras = data['cifras'];
                    this.form.precio = data['precio'];
                    this.form.fechainicio = data['fechainicio'];
                    this.form.fechafin = data['fechafin'];
                    this.form.promocional = data['promocional'];
                    this.form.publicar = data['publicar'];
                    this.form.destacada = data['principal'];
                    this.form.principal = data['principal'];
                    this.form.urlimagen2 = data['urlimagen2'];
                    this.form.urlimagen1 = data['urlimagen1'];
                    this.form.idterminos = data['idterminos'];
                    this.form.idcreador = data['idcreador'];
                    this.form.files1 = [];
                    this.form.files2 = [];
                    this.getDepartamentos();
                    this.getCiudades();
                     */
                    break;
                }
                case 'actualizar': {
                    this.tituloModal = 'Actualizar el rifa de venta ' + data['nombre'];
                    this.form.id = data['id'];
                    this.form.titulo = data['titulo'];
                    this.form.resolucion = data['resolucion'];
                    this.form.estado = data['estado'];
                    this.form.nombre = data['nombre'];
                    this.form.descripcion = data['descripcion'];
                    this.form.nombre_tecnico = data['nombre_tecnico'];
                    this.form.resumen = data['resumen'];
                    this.form.url = data['url'];
                    this.form.idloteria = data['idloteria'];
                    this.form.idpais = data['idpais'];
                    this.form.iddepartamento = data['iddepartamento'];
                    this.form.idciudad = data['idciudad'];
                    this.form.cifras = data['cifras'];
                    this.form.precio = data['precio'];
                    this.form.fechainicio = data['fechainicio'];
                    this.form.fechafin = data['fechafin'];
                    this.form.promocional = data['promocional'];
                    this.form.publicar = data['publicar'];
                    this.form.destacada = data['principal'];
                    this.form.principal = data['principal'];
                    this.form.urlimagen2 = data['urlimagen2'];
                    this.form.urlimagen1 = data['urlimagen1'];
                    this.form.idterminos = data['idterminos'];
                    this.form.idcreador = data['idcreador'];
                    this.form.files1 = [];
                    this.form.files2 = [];
                    this.getDepartamentos();
                    this.getCiudades();
                    break;
                }
            }
        },
        closeModal: function () {
            this.isOpen = false;
            this.reset();
            this.editMode = false;
            this.verMode  = false;
            this.$page.props.errors = [];
        },
        reset: function () {
            this.tituloModal = 'Crear nuevo rifa de venta';
            this.form.id = null;
            this.form.titulo = null;
            this.form.resolucion = null;
            this.form.estado = false;
            this.form.nombre = null;
            this.form.descripcion = null;
            this.form.nombre_tecnico = null;
            this.form.resumen = null;
            this.form.url = null;
            this.form.idloteria = 0;
            this.form.idpais = 0;
            this.form.iddepartamento = 0;
            this.form.idciudad = 0;
            this.form.cifras = 0;
            this.form.precio = 0;
            this.form.fechainicio = null;
            this.form.fechafin = null;
            this.form.promocional = null;
            this.form.publicar = null;
            this.form.destacada = null;
            this.form.principal = null;
            this.form.urlimagen2 = null;
            this.form.urlimagen1 = null;
            this.form.idterminos = 0;
            this.form.idcreador = 0;
            this.form.files1 = [];
            this.form.files2 = [];
        },
        save: function (data) {
            data.fechainicio = this.dateTimeFull(data.fechainicio);
            data.fechafin = this.dateTimeFull(data.fechafin);
            console.log(data);
            this.$inertia.post('/rifas', data, {
                onBefore: (visit) => { console.log('onBefore');},
                onStart: (visit) => {console.log('onStart');},
                onProgress: (progress) => {console.log('onProgress');},
                onSuccess: (page) => {
                    this.reset();
                    this.closeModal();
                    this.getUsers('','nombre');
                    this.editMode = false;
                },
                onError: (errors) => {console.log('onError');},
                onCancel: () => {console.log('onCancel');},
                onFinish: visit => {console.log('onFinish');},
            });

        },
        edit: function (data) {
            //this.form = Object.assign({}, data);
            this.editMode = true;
            //console.log(this.form);
            this.openModal('actualizar', data);
        },
        ver: function (data) {
            this.verMode = true;
            this.openModal('ver', data);
        },
        update: function (data) {
            data.fechainicio = this.dateTimeFull(data.fechainicio);
            data.fechafin = this.dateTimeFull(data.fechafin);
            console.log(data);
            data._method = 'PUT';
            this.$inertia.post('/rifas/'  + data.id, data, {
                onBefore: (visit) => { console.log('onBefore');},
                onStart: (visit) => {console.log('onStart');},
                onProgress: (progress) => {console.log('onProgress');},
                onSuccess: (page) => {
                    Swal.fire(
                        'Actualización rifa',
                        'El rifa se ha actualizado!',
                        'success'
                    )
                    this.getUsers('','nombre');
                    this.closeModal();
                    this.reset();
                    this.editMode = false;
                },
                onError: (errors) => {console.log('onError');},
                onCancel: () => {console.log('onCancel');},
                onFinish: visit => {console.log('onFinish');},
            });

        },
        getUsers: async function (buscar, sortBy) {
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

            var url= '/rifas';
            axios.get(url, {
                params: {
                    buscar: this.buscar,
                    sortBy: this.sortBy,
                    sortOrder: sortOrderdesc,
                    ispage: this.ispage
                }
            }).then((res) => {
                console.log(res.data);
                var respuesta = res.data;
                this.arrayUsers = respuesta.rifas;

                if (this.arrayUsers.data.length > 0) {
                    this.existeuser = 1;
                } else {
                    this.existeuser = 0;
                }
            })
        },
        getLoterias: function () {
            axios.get('/loterias',).then((res) => {
                this.arrayLoterias = res.data.loterias;
                console.log(res.data.loterias)
            })
        },
        getTerminos: function () {
            axios.get('/terminos',).then((res) => {
                this.arrayTerminos = res.data.terminos;
                console.log(res.data.terminos)
            })
        },
        getPaises: function () {
            axios.get('/paises',).then((res) => {
                this.arrayPaises = res.data.paises;
                console.log(res.data.paises)
            })
        },
        getDepartamentos: function () {
            axios.get('/paises/departamentos', {
                params: {
                    idpais: this.form.idpais
                }
            }).then((res) => {
                this.arrayDepartamentos = res.data.departamentos;
                console.log(res.data.departamentos)
            })
        },
        getCiudades: function () {
            axios.get('/paises/ciudades', {
                params: {
                    idpais: this.form.idpais,
                    iddepartamento: this.form.iddepartamento
                }
            }).then((res) => {
                this.arrayCiudades = res.data.ciudades;
                console.log(res.data.ciudades)
            })
        },
        deleteRow: function (data) {
            let mensaje = '';
            let title = '';
            let html = '';
            if (data.estado) {
                mensaje = 'Desea desactivar la rifa?';
                title = 'Desactivada!';
                html = 'La rifa ha sido desactivada con éxito.';
            } else {
                mensaje = 'Desea activar la rifa?';
                title = 'Activada!';
                html = 'La rifa ha sido activada con éxito.';
            }
            Swal.fire({
                title: mensaje,
                text: "Solo un administrador podrá revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Proceder!'
            }).then((result) => {
                data._method = 'DELETE';
                axios.post('/rifas/' + data.id, data)
                    .then((res) => {
                        this.getUsers('','nombre');
                        Swal.fire(
                            title,
                            html,
                            'success'
                        )
                    }).catch(function (error) {
                    console.log(error);
                });
            })

        },

        onUploadDragoverEvent2(e) {
            this.uploadDragoverEvent2 = true;
            this.uploadDragoverTracking2 = true;
            this.pageX2 = e.pageX2;
            this.pageY2 = e.pageY2;
        },
        onUploadDropEvent2(e) {
            this.uploadDragoverEvent2 = false;
            this.uploadDragoverTracking2 = false;
            this.pageX2 = 0;
            this.pageY2 = 0;
            this.droppedFiles2(e)
        },
        droppedFiles2(e) {
            let droppedFiles = e.dataTransfer.files;

            if (!droppedFiles) return;

            ([...droppedFiles]).forEach(f => {
                this.form.files2.push(f);
            });
        },
        droppedFileValidator2(file) {
            return false;
        },
        removeFile2(file) {
            this.form.files1 = this.form.files1.filter(f => {
                return f != file;
            });
        },
        uploadFiles2() {
            console.log(this.form.files1);
            // This is where the magic could happen!
        },

        onUploadDragoverEvent1(e) {
            this.uploadDragoverEvent1 = true;
            this.uploadDragoverTracking1 = true;
            this.pageX1 = e.pageX1;
            this.pageY1 = e.pageY1;
        },
        onUploadDropEvent1(e) {
            this.uploadDragoverEvent1 = false;
            this.uploadDragoverTracking1 = false;
            this.pageX1 = 0;
            this.pageY1 = 0;
            this.droppedFiles1(e)
        },
        droppedFiles1(e) {
            let droppedFiles = e.dataTransfer.files;

            if (!droppedFiles) return;

            ([...droppedFiles]).forEach(f => {
                this.form.files1.push(f);
            });
        },
        droppedFileValidator1(file) {
            return false;
        },
        removeFile1(file) {
            this.form.files1 = this.form.files1.filter(f => {
                return f != file;
            });
        },
        uploadFiles1() {
            console.log(this.form.files1);
            // This is where the magic could happen!
        },
    },
    created: function () {
        //this.getPaises();
        this.arrayUsers = this.users;
        console.log(this.users);
        //this.openModal('registrar')
    },
    mounted() {
        console.log('Component mounted.');
    },
}
</script>
