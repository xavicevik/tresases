<template>
    <AppLayout title="Comisiones">

        <Statscards></Statscards>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Configuración de comisiones
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
                                    Configuración de comisiones
                                </h1>
                            </div>

                            <div class="w-1/3">
                                <div class="container flex justify-center items-center">
                                    <div class="relative">
                                        <div class="absolute top-4 left-3">
                                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                        <input type="text" v-model="buscar" @keyup.enter="getConfcomisiones(buscar,'id')" class="h-8 w-96 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar">
                                        <button @click="getConfcomisiones(buscar,'id')">
                                            <div class="absolute top-2 right-2">
                                                <Icon icon="fe:search" class="h-4"  />
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="pr-2 w-1/3 text-center">
                                <button @click="openModal('registrar')" class="bg-blue-500 text-xs  hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ">Crear Nueva</button>
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
                                            Comisión total (mayorista)
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
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Comisión distribuidor
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
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Comisión vendedor
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
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Tipo Comisión
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

                                    <th class="lg:px-4 md:px-1 mx-auto py-2 text-sm font-bold lg:w-1/12 md:w-1/11 hover:bg-blue-500 hover:text-gray-50 rounded-b">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center" text-sm v-if="arrayData.data" v-for="(dato, id) in arrayData.data" :key="id">
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.id"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.mayorista.razon_social"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.distribuidor.razon_social"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="(dato.estado == 1)?dato.vendedor.razon_social:dato.agente.full_name"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.comisionmayorista+'%'"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.comisiondistribuidor+'%'"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.comisionvendedor+'%'"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-if="dato.estado == 1">
                                        <span class="inline-flex px-2 text-sm font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                            Empresa
                                        </span>
                                    </td>
                                    <td class="border px-2 py-2 text-sm" v-else>
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                            Vendedor
                                        </span>
                                    </td>

                                    <td class="border px-1 py-1 mx-auto text-center flex items-center">
                                        <button @click="editar(dato)" class="hover:bg-green-700 text-green-400 font-bold rounded" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                                            </svg>
                                        </button>

                                    </td>
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


                    <!-- Ventana modal crear comision -->
                    <!-- Main modal -->
                    <section> <!-- Ventana modal -->
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpennuevo">
                            <div class="items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>

                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                                <div class="inline-block lg:w-6/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <button type="button" @click="closeModal()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                    <div class="">
                                        <h2 v-text="tituloModal" class="text-xl font-bold text-gray-900 px-4 py-4"></h2>
                                    </div>
                                    <form>
                                        <div class="bg-white px-4 pt-2 pb-4 ">
                                            <div class="">
                                                <section>
                                                    <div class="flex mt-2 grid-cols-2 gap-y-6 py-4">
                                                        <div class="flex items-center mr-4">
                                                            <input type="radio" value="1" v-model="form.estado" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500 focus:ring-2 ">
                                                            <label class="ml-2 text-sm font-medium ">Comisión x empresa</label>
                                                        </div>
                                                        <div class="flex items-center mr-4">
                                                            <input type="radio" value="2" v-model="form.estado" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500 dark:ring-offset-gray-800 ">
                                                            <label class="ml-2 text-sm font-medium ">Comisión x vendedor</label>
                                                        </div>
                                                    </div>
                                                    <div class="flex mt-2 grid-cols-2 gap-y-6 py-4">
                                                        <div class="w-full mx-auto px-4">
                                                            <label class="block text-sm font-bold font-medium text-gray-700">Mayorista</label>
                                                            <div class="mt-1">
                                                                <select class="block w-full rounded-lg text-gray-700 text-sm" :disabled="editMode" v-model="form.idmayorista" @change="getDistribuidores()">
                                                                    <option value="0" >Seleccione Mayorista</option>
                                                                    <option v-for="mayorista in arrayMayoristas" :key="mayorista.id" :value="mayorista.id" v-text="mayorista.razon_social"></option>
                                                                </select>
                                                                <div v-if="$page.props.errors.idmayorista" class="text-red-500">{{ $page.props.errors.idmayorista }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="w-full mx-auto px-4">
                                                            <label class="block text-sm font-bold font-medium text-gray-700">Comisión mayorista (total)</label>
                                                            <div class="mt-1">
                                                                <money3 @change="distComisionm()"  v-model="form.comisionmayorista" v-bind="configPercent" :disabled="verMode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></money3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex mt-2 grid-cols-2 gap-y-6 py-4">
                                                        <div class="w-full mx-auto px-4">
                                                            <label class="block text-sm font-bold font-medium text-gray-700">Distribuidor</label>
                                                            <div class="mt-1">
                                                                <select class="block w-full rounded-lg text-gray-700 text-sm" :disabled="editMode" v-model="form.iddistribuidor" @change="getVendedores()">
                                                                    <option value="0" >Seleccione Distribuidor</option>
                                                                    <option v-for="distribuidor in arrayDistribuidor" :key="distribuidor.id" :value="distribuidor.id" v-text="distribuidor.razon_social"></option>
                                                                </select>
                                                                <div v-if="$page.props.errors.iddistribuidor" class="text-red-500">{{ $page.props.errors.iddistribuidor }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="w-full mx-auto px-4">
                                                            <label class="block text-sm font-bold font-medium text-gray-700">Comisión distribuidor</label>
                                                            <div class="mt-1">
                                                                <money3 @change="distComisiond()" v-model="form.comisiondistribuidor" v-bind="configPercent" :disabled="verMode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></money3>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="flex mt-2 grid-cols-2 gap-y-6 py-4">
                                                        <div class="w-full mx-auto px-4">
                                                            <label class="block text-sm font-bold font-medium text-gray-700">Vendedor</label>
                                                            <div class="mt-1">
                                                                <select class="block w-full rounded-lg text-gray-700 text-sm" :disabled="editMode" v-model="form.idvendedor" @change="getVendedores()">
                                                                    <option value="0" >Seleccione Vendedor</option>
                                                                    <option v-for="vendedor in arrayVendedores" :key="vendedor.id" :value="vendedor.id" v-text="vendedor.razon_social"></option>
                                                                </select>
                                                                <div v-if="$page.props.errors.idvendedor" class="text-red-500">{{ $page.props.errors.idvendedor }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="w-full mx-auto px-4">
                                                            <label class="block text-sm font-bold font-medium  http://127.0.0.1:8000/master/getVendedores?estado=1&idrol=5&idpadre=13


                                                            text-gray-700">Comisión vendedor</label>
                                                            <div class="mt-1">
                                                                <money3 v-model="form.comisionvendedor" v-bind="configPercent" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></money3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <span v-if="!editMode" class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                              <button wire:click.prevent="store()" @click="save(form)" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" >
                                                Crear
                                              </button>
                                            </span>
                                            <span v-else class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                              <button wire:click.prevent="update()" @click="update(form)" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" >
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
                    <!-- Fin Ventana modal crear comision -->


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
                max: this.maxcomision.valornum,
                allowBlank: false,
                minimumNumberOfCharacters: 0,
            },

            ispage: true,
            tituloModal: '',
            form: {
                idmayorista: 0,
                iddistribuidor: 0,
                idvendedor: 0,
                comisionmayorista: this.maxcomision.valornum,
                comisiondistribuidor: 0.0,
                comisionvendedor: 0.0,
                estado: 2,
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
        distComisionm: function() {
            this.form.comisiondistribuidor = this.maxcomision.valornum - (this.form.comisionmayorista);
            this.form.comisionvendedor = 0;
        },
        distComisiond: function() {
            this.form.comisionvendedor = this.maxcomision.valornum - this.form.comisionmayorista - this.form.comisiondistribuidor;
        },
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
            this.form.idmayorista = null;
            this.form.iddistribuidor = null;
            this.form.idvendedor = null;
            this.form.comisionmayorista = this.maxcomision.valornum;
            this.form.comisiondistribuidor = 0;
            this.form.comisionvendedor = 0;
            this.form.estado = 1;
        },
        save: function (data) {
            //console.log(data);
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
            //console.log(data);
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
            axios.get('/master/getEmpresas?estado='+this.form.estado+'&idrol=5&idpadre=' + this.form.iddistribuidor,
            ).then((res) => {
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
