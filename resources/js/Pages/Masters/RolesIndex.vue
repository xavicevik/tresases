<template>
    <AppLayout title="Roles">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de Roles
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
                                    Roles
                                </h1>
                            </div>

                            <div class="w-1/2">
                                <div class="container flex justify-center items-center">
                                    <div class="relative">
                                        <div class="absolute top-4 left-3">
                                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                        <input type="text" v-model="buscar" @keyup="getData(buscar,'name')" class="h-8 w-96 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar">
                                        <button @click="getData(buscar,'name')">
                                            <div class="absolute top-2 right-2">
                                                <Icon icon="fe:search" class="h-4"  />
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="pr-2 w-1/3 text-center">
                                <button @click="openModal('registrar')" class="bg-blue-500 text-xs  hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ">Crear Rol</button>
                            </div>
                        </div>
                    </section>

                    <!-- Inicia SubMenu -->
                    <submenu></submenu>
                    <!-- Fin Sub Menu -->

                    <!-- Fin Encabezado y titulo -->
                    <!-- Tabla de contenido -->
                    <section>
                        <div class="lg:px-4 md:px-2 sm:px-0 py-2 pb-6 overflow-y-auto h-50">
                            <table class="table-fixed w-full">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Id
                                    </th>
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Nombre
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Grupo
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-1/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Acciones
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center" text-sm v-if="existedata > 0" v-for="(dato, id) in arrayData.data" :key="id">
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.id"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.name"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.guard_name"></td>
                                    <td class="border px-2 py-2 mx-auto text-center flex items-center">
                                        <button @click="ver(dato.id)" class="hover:bg-green-700 text-green-400 font-bold rounded" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z" />
                                            </svg>
                                        </button>
                                        <button @click="update(dato.id)" class="hover:bg-green-700 text-green-400 font-bold rounded" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </button>

                                    </td>
                                </tr>
                                <tr v-else>
                                    <td class="border px-4 py-2 text-xs text-center" colspan="3"> La consulta no obtuvo datos</td>
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


                    <!-- Ventana modal Detalles -->
                    <section> <!-- Ventana modal -->
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                                <div class="inline-block lg:w-8/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <button type="button" @click="closeModal()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                    <div class="">
                                        <h2 v-text="tituloModal" class="text-sm font-bold text-gray-900 px-4 py-4"></h2>
                                    </div>
                                    <form>


                                        <div class="lg:px-4 md:px-2 sm:px-0 py-2 pb-6 overflow-y-auto h-50">
                                            <table class="table-fixed w-full">
                                                <thead>
                                                <tr class="bg-gray-100">
                                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                        Id
                                                    </th>
                                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                        Nombre
                                                    </th>
                                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                        Descripcion
                                                    </th>
                                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                        Acciones
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="text-center" text-sm v-if="this.form.rolePermissions.data" v-for="(dato, id) in this.form.rolePermissions.data" :key="id">
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.id"></td>
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.name"></td>
                                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.guard_name"></td>
                                                    <td class="border px-2 py-2 mx-auto text-center flex items-center">
                                                        <button @click="ver(dato.id)" class="hover:bg-green-700 text-green-400 font-bold rounded" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z" />
                                                            </svg>
                                                        </button>

                                                    </td>
                                                </tr>
                                                <tr v-else>
                                                    <td class="border px-4 py-2 text-xs text-center" colspan="3"> La consulta no obtuvo datos</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <section class="mt-6">
                                                <div v-if="this.form.rolePermissions.total > 3">
                                                    <div class="flex flex-wrap -mb-1">
                                                        <template v-for="(link, p) in this.form.rolePermissions.links" :key="p">
                                                            <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                                                                 v-html="link.label" />
                                                            <a href="#" v-else
                                                                     class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                                                                     :class="{ 'bg-blue-700 text-white': link.active }"
                                                                     v-on:click="cambiarPage(link.url)"
                                                                     v-html="link.label" />
                                                        </template>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>

                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                              <button v-show="!editMode" @click="save(form)" wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" >
                                                Guardar
                                              </button>
                                            </span>
                                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                              <button v-show="editMode" @click="update(form)" wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" >
                                                Actualizar
                                              </button>
                                            </span>
                                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

                                          <button @click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                            Cancelar
                                          </button>
                                        </span>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Fin Ventana modal Detalles -->

                    <!-- Ventana modal Adicional -->
                    <section> <!-- Ventana modal -->
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpenUpdate">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                                <div class="inline-block lg:w-8/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <button type="button" @click="closeModalupdate()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                    <div class="">
                                        <h2 v-text="tituloModal" class="text-sm font-bold text-gray-900 px-4 py-4"></h2>
                                    </div>
                                    <form>


                                        <div class="lg:px-4 md:px-2 sm:px-0 py-2 pb-6 overflow-y-auto h-100">
                                            <table class="table-fixed w-full">
                                                <thead>
                                                <tr class="bg-gray-100">
                                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                        Id
                                                    </th>
                                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                        Nombre
                                                    </th>
                                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                        Descripcion
                                                    </th>
                                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                        Seleccionar
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="text-center" text-sm v-if="this.form.permission.data" v-for="(dato, id) in this.form.permission.data" :key="id">
                                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.id"></td>
                                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.name"></td>
                                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.guard_name"></td>
                                                    <td class="border px-2 py-2 mx-auto text-center flex items-center">
                                                        <input type="checkbox"
                                                               :name="this.permissiondat[dato.id]"
                                                               :value="dato.name"
                                                               class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                                               :checked="this.form.rolePermissionsjson.includes(dato.id)"
                                                               >
                                                    </td>
                                                </tr>
                                                <tr v-else>
                                                    <td class="border px-4 py-2 text-xs text-center" colspan="3"> La consulta no obtuvo datos</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <section class="mt-6">
                                                <div v-if="this.form.permission.total > 3">
                                                    <div class="flex flex-wrap -mb-1">
                                                        <template v-for="(link, p) in this.form.permission.links" :key="p">
                                                            <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                                                                 v-html="link.label" />
                                                            <a href="#" v-else
                                                               class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                                                               :class="{ 'bg-blue-700 text-white': link.active }"
                                                               v-on:click="cambiarPage(link.url)"
                                                               v-html="link.label" />
                                                        </template>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>

                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                              <button v-show="isOpen" @click="save(form)" wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" >
                                                Guardar
                                              </button>
                                            </span>
                                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                              <button v-show="isOpenUpdate" @click="edit(form)" wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" >
                                                Actualizar
                                              </button>
                                            </span>
                                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

                                          <button @click="closeModalupdate()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                            Cancelar
                                          </button>
                                        </span>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Fin Ventana modal Detalles -->

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


export default {

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
            editMode: false,
            verMode: false,
            isOpen: false,
            isOpenUpdate: false,
            buscar: '',
            sortOrder: 1,
            sortBy: '',
            errornumerosreservados: 0,
            existedata: 0,
            form:{
                role: null,
                permission: null,
                rolePermissions: null,
                rolePermissionsjson: []
            },
            permissiondat: []
        }
    },
    methods: {
        cambiarPage: function (url = '') {
            axios.get(url, {
                params: {
                    paginate: true,
                    ispage: true,
                    id: this.form.role.id
                }
            }).then((res) => {
                //console.log(res);
                var respuesta = res.data;
                this.form.role = respuesta.role;
                this.form.rolePermissions = respuesta.rolePermissions;
                this.form.permission = respuesta.permission;
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
            var url= '/master/rolesshow';
            axios.get(url, {
                params: {
                    id: data,
                }
            }).then((res) => {
                //console.log(res.data);
                var respuesta = res.data;
                this.form.role = respuesta.role;
                this.form.rolePermissions = respuesta.rolePermissions;
                this.openModal('ver');
            })
        },
        update: function (data) {
            var url= '/master/rolesedit';
            axios.get(url, {
                params: {
                    id: data,
                }
            }).then((res) => {
                //console.log(res.data);
                var respuesta = res.data;
                this.form.role = respuesta.role;
                this.form.permission = respuesta.permission;
                this.form.rolePermissions = respuesta.rolePermissions;
                this.form.rolePermissionsjson = respuesta.rolePermissionsjson;
                this.openModal('update');
            })
        },
        edit: function (data) {
            //console.log(data);
            var url= '/master/rolesupdate';
            axios.post(url, {
                params: {
                    data: data,
                }
            }).then((res) => {
                //console.log(res.data);
                var respuesta = res.data;
                this.form.role = respuesta.role;
                this.form.permission = respuesta.permission;
                this.form.rolePermissions = respuesta.rolePermissions;
                this.form.rolePermissionsjson = respuesta.rolePermissionsjson;
                this.openModal('update');
            })
        },

        getData: async function (buscar = '', filtro = 'nombre', paginate = true) {

            var url= '/master/index';
            axios.get(url, {
                params: {
                    buscar: buscar,
                    filtro: filtro,
                    paginate: paginate,
                    ispage: true,
                }
            }).then((res) => {
                //console.log(res.data);
                var respuesta = res.data;
                this.arrayData = respuesta.data;

                if (this.arrayData.data.length > 0) {
                    this.existedata = 1;
                } else {
                    this.existedata = 0;
                }
            })
        },
        openModal: function (accion, data = []) {

            switch (accion) {
                case 'registrar':
                {
                    this.form = [];
                    this.tituloModal = 'Crear nuevo Rol';
                    break;
                }
                case 'ver':
                {
                    this.tituloModal = 'Ver Rol ' + this.form.role.name;
                    this.isOpen = true;
                    break;
                }
                case 'update': {
                    this.tituloModal = 'Actualizar el rol ' + this.form.role.name;
                    this.isOpenUpdate = true;
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
        closeModalupdate: function () {
            this.isOpenUpdate = false;
            this.reset();
            this.editMode = false;
            this.verMode  = false;
            this.$page.props.errors = [];
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
        //console.log('Component mounted.');
    },
}
</script>
