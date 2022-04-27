<template>
    <AppLayout title="Usuarios">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de Usuarios
            </h2>
        </template>
        <div class="py-4">
            <div class="mx-auto 2xl:8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <section>
                        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-show="isOpen">
                            <div class="flex">
                                <div>
                                    <p class="text-sm">mensajes flash</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="flex justify-between mx-auto p-4">
                            <div class="flex p-2 w-3">
                                <h1 class="font-bold text-xl text-black-800 leading-tight">
                                    Usuarios
                                </h1>
                            </div>

                            <div class="flex p-2 ">
                                <div class="container flex justify-center items-center">
                                    <div class="relative">
                                        <div class="absolute top-4 left-3">
                                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                        <input type="text" v-model="buscar" @keyup="getUsers(buscar,'detalle_users.num_documento')" class="h-8 w-96 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar (Nombre, Email, Documento)">
                                        <button @click="getUsers(buscar,'detalle_users.num_documento')">
                                            <div class="absolute top-2 right-2">
                                                <Icon icon="fe:search" class="h-4"  />
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button @click="openModal()" class="bg-blue-500 text-xs left-0 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">CREAR USUARIO</button>
                            </div>

                        </div>
                    </section>
                    <section>
                        <div class="px-4 py-2 pb-8">
                            <table class="table-fixed w-full">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 text-xs font-bold w-1/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getUsers(buscar, 'detalle_users.num_documento')">
                                            No DOC
                                            <div v-show="sortBy == 'detalle_users.num_documento'">
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
                                    <th class="px-4 py-2 text-xs font-bold  hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getUsers(buscar, 'users.name')">
                                            NOMBRE
                                            <div v-show="sortBy == 'users.name'">
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
                                    <th class="px-4 py-2 text-xs font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getUsers(buscar, 'detalle_users.movil')">
                                            CELULAR
                                            <div v-show="sortBy == 'detalle_users.movil'">
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
                                    <th class="px-4 py-2 text-xs font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getUsers(buscar, 'users.email')">
                                            CORREO
                                            <div v-show="sortBy == 'users.email'">
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
                                    <th class="px-4 py-2 text-xs font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getUsers(buscar, 'ciudades.nombre')">
                                            CIUDAD
                                            <div v-show="sortBy == 'ciudades.nombre'">
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
                                    <th class="px-4 py-2 text-xs font-bold w-1/8 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getUsers(buscar, 'roles.nombre')">
                                            PERFIL
                                            <div v-show="sortBy == 'roles.nombre'">
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
                                    <th class="px-4 py-2 text-xs font-bold w-1/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getUsers(buscar, 'detalle_users.estado')">
                                            ESTADO
                                            <div v-show="sortBy == 'detalle_users.estado'">
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
                                    <th class="px-4 py-2 text-xs font-bold w-1/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">ACCIONES</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="existeUsers > 0" v-for="(user, id) in arrayUsers.data" :key="index">
                                    <td class="border px-4 py-2 text-xs" v-text="user.documento"></td>
                                    <td class="border px-4 py-2 text-xs" v-text="user.nombre"></td>
                                    <td class="border px-4 py-2 text-xs" v-text="user.celular"></td>
                                    <td class="border px-4 py-2 text-xs" v-text="user.correo"></td>
                                    <td class="border px-4 py-2 text-xs" v-text="user.ciudad"></td>
                                    <td class="border px-4 py-2 text-xs" v-text="user.perfil"></td>
                                    <td class="border px-4 py-2 text-xs" v-if="user.estado">
                                        <span
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">Activo
                                        </span>
                                    </td>
                                    <td class="border px-4 py-2 text-xs" v-else>
                                        <span
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-green-100 rounded-full">Inactivo
                                        </span>
                                    </td>
                                    <td class="border px-1 py-1 mx-auto text-center flex items-center">
                                        <button @click="edit(user)" class="hover:bg-blue-700 text-white font-bold rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button @click="deleteRow(user.id)" class="hover:bg-red-700 text-white font-bold rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td class="border px-4 py-2 text-xs text-center" colspan="8"> La consulta no obtuvo datos</td>
                                </tr>
                                </tbody>
                            </table>
                            <pagination class="mt-6" :links="arrayUsers.links" />
                        </div>
                    </section>
                    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                            <div class="fixed inset-0 transition-opacity">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>
                            <!-- This element is to trick the browser into centering the modal contents. -->
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                <form>
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="">
                                            <div class="mb-4">
                                                <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Title" v-model="form.title">
                                            </div>
                                            <div class="mb-4">
                                                <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Documento:</label>
                                                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput2" v-model="form.body" placeholder="Enter Body"></textarea>
                                            </div>
                                            <div class="mb-4">
                                                <select class="form-control" v-model="idpais" @change="getDepartamentos()">
                                                    <option value="0" >Seleccione País</option>
                                                    <option v-for="pais in arrayPaises" :key="pais.id" :value="pais.id" v-text="pais.nombre"></option>
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <select class="form-control" v-model="iddepartamento" @change="getCiudades()">
                                                    <option value="0" >Departamentos</option>
                                                    <option v-for="departamento in arrayDepartamentos" :key="departamento.id" :value="departamento.id" v-text="departamento.nombre"></option>
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <select class="form-control" v-model="idciudad" >
                                                    <option value="0" >Ciudad</option>
                                                    <option v-for="ciudad in arrayCiudades" :key="ciudad.id" :value="ciudad.id" v-text="ciudad.nombre"></option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                              <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="!editMode" @click="save(form)">
                                Save
                              </button>
                            </span>
                                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                              <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="editMode" @click="update(form)">
                                Update
                              </button>
                            </span>
                                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

                              <button @click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Cancel
                              </button>
                            </span>
                                    </div>
                                </form>

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
import Pagination from '@/Components/Pagination'

export default {
    components: {
        AppLayout,
        Icon,
        Pagination,
    },
    props:{
       users : [],
       errors: Object
    },
    data() {
        return {
            arrayPaises: [],
            arrayDepartamentos: [],
            arrayCiudades: [],
            idpais: 0,
            iddepartamento: 0,
            editMode: false,
            isOpen: false,
            form: {
                title: null,
                body: null,
            },
            existeUsers: 1,
            buscar: '',
            arrayUsers: [],
            sortOrder: 1,
            sortBy: ''
        }
    },
    methods: {
        openModal: function () {
            this.isOpen = true;
        },
        closeModal: function () {
            this.isOpen = false;
            this.reset();
            this.editMode=false;
        },
        reset: function () {
            this.form = {
                title: null,
                body: null,
            }
        },
        save: function (data) {
            this.$inertia.post('/posts', data)
            this.reset();
            this.closeModal();
            this.editMode = false;
        },
        edit: function (data) {
            this.form = Object.assign({}, data);
            this.editMode = true;
            this.openModal();
        },
        update: function (data) {
            data._method = 'PUT';
            this.$inertia.post('/posts/' + data.id, data)
            this.reset();
            this.closeModal();
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

            var url= '/users/buscaUsers';
            axios.get(url, {
                params: {
                    buscar: this.buscar,
                    sortBy: this.sortBy,
                    sortOrder: sortOrderdesc
                }
            }).then((res) => {
                var respuesta = res.data;
                this.arrayUsers = respuesta.users;
                console.log(this.arrayUsers);
                console.log(url);

                if (this.arrayUsers.data.length > 0) {
                    this.existeUsers = 1;
                } else {
                    this.existeUsers = 0;
                }
            })
        },
        getPaises: function () {
            axios.get('/paises',).then((res) => {
                this.arrayPaises = res.data.paises;
                console.log(res.data.paises)
            })
            this.reset();
            this.closeModal();
            this.editMode = false;
        },
        getDepartamentos: function () {
            axios.get('/paises/departamentos', {
                params: {
                    idpais: this.idpais
                }
            }).then((res) => {
                this.arrayDepartamentos = res.data.departamentos;
                console.log(res.data.departamentos)
            })
        },
        getCiudades: function () {
            axios.get('/paises/ciudades', {
                params: {
                    idpais: this.idpais,
                    iddepartamento: this.iddepartamento
                }
            }).then((res) => {
                this.arrayCiudades = res.data.ciudades;
                console.log(res.data.ciudades)
            })
        },
        deleteRow: function (data) {
            Swal.fire({
                title: 'Esta seguro?',
                text: "Esta acción no se podrá revertir!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Desactivar!'
            }).then((result) => {
                Swal.fire(
                    'Desactivado!',
                    'El articulo ha sido desactivado con éxito.',
                    'success'
                )
            })
            data._method = 'DELETE';
            this.$inertia.post('/posts/' + data.id, data)
            this.reset();
            this.closeModal();
        },
    },
    created: function () {
        //this.getPaises();
        console.log('Component mounted.')
        this.arrayUsers = this.users;
    },
    mounted() {
        console.log('Component mounted.');
    },
}
</script>
