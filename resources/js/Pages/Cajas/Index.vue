<template>
    <AppLayout title="Cajas">
        <Statscards></Statscards>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de Cajas
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
                                    Cajas
                                </h1>
                            </div>

                            <div class="pr-2 w-1/3 text-center">
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
                                            Punto de venta
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
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Vendedor
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
                                    <th class="px-4 py-2 text-sm w-2/12 font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Fecha apertura
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
                                            Fecha cierre
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
                                            Recaudo
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
                                    <th class="lg:px-4 md:px-1 mx-auto py-2 text-sm font-bold lg:w-1/12 md:w-1/11 hover:bg-blue-500 hover:text-gray-50 rounded-b">Abrir/Cerrar</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center" text-sm v-if="arrayCajas.data" v-for="(caja, id) in arrayCajas.data" :key="id">
                                    <td class="border px-1 py-2 text-sm truncate" v-text="caja.id"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="caja.puntoventa.nombre"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="caja.username?caja.username:'-'"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="caja.fechaapertura"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="caja.fechacierre"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="caja.montocierre"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-if="caja.estado">
                                        <span class="inline-flex px-2 text-sm font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                            Abierta
                                        </span>
                                    </td>
                                    <td class="border px-2 py-2 text-sm" v-else>
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                            Cerrada
                                        </span>
                                    </td>
                                    <td class="border px-2 py-2 mx-auto text-center flex items-center">
                                        <button v-if="!caja.estado" @click="abrir(caja)" class="hover:bg-green-700 text-green-400 font-bold rounded" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                                            </svg>
                                        </button>
                                        <button v-else @click="cerrar(caja)" class="hover:bg-blue-700 text-blue-400 font-bold rounded" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </button>

                                    </td>
                                </tr>
                                <tr v-else>
                                    <td class="border px-4 py-2 text-xs text-center" colspan="7"> La consulta no obtuvo datos</td>
                                </tr>
                                </tbody>
                            </table>
                            <pagination class="mt-6" :links="arrayCajas.links" />
                        </div>
                    </section>
                    <!-- Fin Tabla de contenido -->

                    <!-- Ventana modal Abrir Caja -->
                    <!-- Main modal -->
                    <section> <!-- Ventana modal -->
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpenAbrir">
                            <div class="items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>

                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                                <div class="inline-block lg:w-6/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <button type="button" @click="isOpenAbrir = false" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                    <div class="">
                                        <h2 v-text="tituloModal" class="text-xl font-bold text-gray-900 px-4 py-4"></h2>
                                    </div>
                                    <form>
                                        <div class="bg-white px-4 pt-2 pb-4 ">
                                            <div class="">
                                                <section>
                                                    <div class="mt-2 grid gap-y-6 ">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">Punto de venta</label>
                                                            <div class="mt-1">
                                                                <input type="text" disabled :class="{'bg-blue-100' : editMode}" v-model="form.puntoventa.nombre" autocomplete="given-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">Cantidad inicial ($)</label>
                                                            <div class="mt-1">
                                                                <money3 v-model="form.montoapertura" v-bind="configMoney" :disabled="verMode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></money3>
                                                                <div v-if="$page.props.errors.apellido" class="text-red-500">{{ $page.props.errors.apellido }}</div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                              <button wire:click.prevent="apertura()" @click="apertura(form)" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" >
                                                Abrir
                                              </button>
                                            </span>
                                         <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

                                          <button @click="isOpenAbrir = false" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                            Cancelar
                                          </button>
                                        </span>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Fin Ventana modal Abrir Caj -->

                    <!-- Ventana modal Cerrar Caja -->
                    <!-- Main modal -->
                    <section> <!-- Ventana modal -->
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpenCerrar">
                            <div class="items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>

                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                                <div class="inline-block lg:w-6/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <button type="button" @click="isOpenCerrar = false" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                    <div class="">
                                        <h2 v-text="tituloModal" class="text-xl font-bold text-gray-900 px-4 py-4"></h2>
                                    </div>
                                    <form>
                                        <div class="bg-white px-4 pt-2 pb-4 ">
                                            <div class="">
                                                <section>
                                                    <div class="mt-2 grid gap-y-6 ">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">Punto de venta</label>
                                                            <div class="mt-1">
                                                                <input type="text" disabled :class="{'bg-blue-100' : editMode}" v-model="form.puntoventa.nombre" autocomplete="given-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">Cantidad final ($)</label>
                                                            <div class="mt-1">
                                                                <money3 v-model="form.montocierre" v-bind="configMoney" :disabled="verMode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></money3>
                                                                <div v-if="$page.props.errors.apellido" class="text-red-500">{{ $page.props.errors.apellido }}</div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                              <button wire:click.prevent="cierre()" @click="cierre(form)" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" >
                                                Cerrar
                                              </button>
                                            </span>
                                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

                                          <button @click="isOpenCerrar = !isOpenCerrar" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                            Cancelar
                                          </button>
                                        </span>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Fin Ventana modal Cerrar Caja -->


                    <!-- Ventana modal Deatlle cierre -->
                    <!-- Main modal -->
                    <section> <!-- Ventana modal -->
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpenDetalle">
                            <div class="items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>

                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                                <div class="inline-block lg:w-6/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <button type="button" @click="isOpenDetalle = false" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>

                                    <div class="">
                                        <h5 v-text="tituloModal" class="border-b-2 border-gray-500 text-xl font-bold text-gray-900 px-4 py-4"></h5>
                                    </div>
                                        <div class="bg-white px-4 pt-4 pb-4 ">
                                            <div class="">
                                                <section>
                                                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                                        <table class="w-full text-sm text-left text-gray-500 ">
                                                            <tr class="bg-white border-b ">
                                                                <th scope="col" class="px-6 py-2">
                                                                    Fecha de operación
                                                                </th>
                                                                <th scope="col" class="px-6 py-2">
                                                                    {{ recaudocaja.fechaapertura }}
                                                                </th>
                                                            </tr>
                                                            <tr class="bg-white border-b ">
                                                                <th scope="col" class="px-6 py-2">
                                                                    Nombre vendedor
                                                                </th>
                                                                <th scope="col" class="px-6 py-2">
                                                                    {{ recaudocaja.vendedor.nombre + ' ' + recaudocaja.vendedor.apellido }}
                                                                </th>
                                                            </tr>
                                                            <tr class="bg-white border-b ">
                                                                <th scope="col" class="px-6 py-2">
                                                                    Punto de venta
                                                                </th>
                                                                <th scope="col" class="px-6 py-2">
                                                                    {{ recaudocaja.puntoventa.nombre }}
                                                                </th>
                                                            </tr>
                                                            <tbody>
                                                            <tr class="bg-white border-b ">
                                                                <th colspan="2" scope="row" class="px-6 mx-auto py-4 font-medium text-black font-bold whitespace-nowrap">
                                                                    Movimientos
                                                                </th>
                                                            </tr>
                                                            <tr class="bg-white border-b ">
                                                                <th scope="col" class="px-6 py-2">
                                                                    Fonde de caja
                                                                </th>
                                                                <td class="px-6 py-2">
                                                                    {{ formatPrice(recaudocaja.montoapertura) }}
                                                                </td>
                                                            </tr>
                                                            <tr class="bg-white border-b ">
                                                                <th scope="col" class="px-6 py-2">
                                                                    Efectivo en caja
                                                                </th>
                                                                <td class="px-6 py-2">
                                                                    {{ formatPrice(recaudocaja.montocierre) }}
                                                                </td>
                                                            </tr>
                                                            <tr class="bg-white border-b ">
                                                                <th scope="col" class="px-6 py-2">
                                                                    Ventas en efectivo
                                                                </th>
                                                                <td class="px-6 py-2">
                                                                    {{ formatPrice(recaudocaja.recaudoefectivo) }}
                                                                </td>
                                                            </tr>
                                                            <tr class="bg-white border-b ">
                                                                <th scope="col" class="px-6 py-2">
                                                                    Faltante
                                                                </th>
                                                                <td class="px-6 py-2 text-red-700">
                                                                    {{ formatPrice(recaudocaja.faltante) }}
                                                                </td>
                                                            </tr>
                                                            <tr class="bg-white border-b ">
                                                                <th scope="col" class="px-6 py-2">
                                                                    Sobrante
                                                                </th>
                                                                <td class="px-6 py-2">
                                                                    {{ formatPrice(recaudocaja.sobrante) }}
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                            </table>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                              <button wire:click.prevent="printcierre()" @click="printcierre(recaudocaja)" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" >
                                                Imprimir
                                              </button>
                                            </span>
                                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

                                          <button @click="isOpenDetalle = !isOpenDetalle" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                            Cerrar
                                          </button>
                                        </span>
                                        </div>

                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Fin Ventana modal Detalle cierre -->


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
        cajas : [],
        errors: Object,
        estado: 0
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
            form: {
                id: null,
                fechaapertura: null,
                fechacierre: null,
                montoapertura: 0.0,
                montocierre: 0.0,
                estado: 0,
            },
            editMode: false,
            verMode: false,
            isOpenAbrir: false,
            isOpenCerrar: false,
            isOpenDetalle: false,
            existeuser: 1,
            buscar: '',
            arrayCajas: {
                data: [],
                links: []
            },
            sortOrder: 1,
            sortBy: '',
            activetab: '1',
            resumencajas: [],
            cajasopen: 0,
            cajasclose: 0,
            valorventasdia: 0,
            cantidadventasdia: 0,
            recaudocaja: []
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
        abrir: function (data) {
            this.isOpenAbrir = true;
            this.form = data;
            this.tituloModal = 'Apertura de caja';
        },
        cerrar: function (data) {
            this.isOpenCerrar = true;
            this.form = data;
            this.tituloModal = 'Cierre de caja';
        },
        openModal: function (accion, data = []) {
            switch (accion) {
                case 'registrar':
                {
                    //this.form = [];
                    this.tituloModal = 'Crear nuevo Usuario';
                    this.form.idpais = 0;
                    this.form.iddepartamento = 0;
                    this.form.idciudad = 0;
                    this.form.idtipos_documento = 0;
                    this.form.idrol = 0;
                    this.form.idempresa = 0;
                    this.getRoles();
                    this.getPaises();
                    this.getCiudades();
                    this.getDepartamentos();
                    this.getTiposdocumento();
                    break;
                }
                case 'actualizar': {
                    this.tituloModal = 'Actualizar el punto de venta ' + data['nombre'];
                    this.form.id = data['id'];
                    this.form.nombre = data['nombre'];
                    this.form.direccion = data['direccion'];
                    this.form.idpais = data['idpais'];
                    this.form.iddepartamento = data['iddepartamento'];
                    this.form.idciudad = data['idciudad'];
                    this.form.latitud = data['latitud'];
                    this.form.altitud = data['altitud'];
                    this.form.codigo = data['codigo'];
                    this.form.descripcion = data['descripcion'];
                    this.form.url = data['url'];
                    this.form.estado = data['estado'];
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
        apertura: function (data) {
            var url= '/cajas/apertura';
            axios.post(url, data
            ).then((res) => {
                let status = res.data.status;
                let msg;
                if (status) {
                    msg = 'Se ha realizado la apertura de caja';
                } else {
                    msg = 'El usuario cuenta con la caja #' + res.data.caja + ' abierta';
                }
                Swal.fire({
                    icon: 'success',
                    title: msg,
                    showConfirmButton: true,
                })
                this.isOpenAbrir = false;
                window.location.replace('/cajas/movimientos');
                //this.getCajas();
            })
        },
        cierre: function (data) {
            var url= '/cajas/cierre';
            axios.get(url, {
                params: {
                    idcaja: data.id,
                    montocierre: data.montocierre
                }
            }).then((res) => {
                //console.log(res.data);
                Swal.fire({
                    icon: 'success',
                    title: 'Se ha realizado el cierre de caja',
                    showConfirmButton: true,
                })
                this.recaudocaja = res.data.histocaja;
                this.isOpenCerrar = false;
                this.tituloModal = 'Detalle del cierre de caja'
                this.isOpenDetalle = true;
                this.getCajas();
            }).catch(function (error) {
                //console.log(error);
            });
        },
        ver: function (data) {
            this.verMode = true;
            this.openModal('ver', data);
        },
        getCajas: function (buscar = '', sortBy = 'id') {
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

            var url= '/cajas';
            axios.get(url, {
                params: {
                    buscar: this.buscar,
                    sortBy: this.sortBy,
                    sortOrder: sortOrderdesc,
                    ispage: this.ispage
                }
            }).then((res) => {
                //console.log(res);
                var respuesta = res.data;
                this.arrayCajas = respuesta.cajas;
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
                        this.getCajas('','nombre');
                        Swal.fire(
                            title,
                            html,
                            'success'
                        )
                    }).catch(function (error) {
                    //console.log(error);
                });
            })

        },
        printcierre: function (recaudocaja) {
            var url = '/cajas/printcierre';
            axios.get(url, {
                params: {
                    recaudocaja: recaudocaja
                }
            }).then((res) => {
                window.open(res.data.url, '_blank');
                window.location.replace("/cajas");
            })
        },
        cajasAbiertas: async function () {
            var url= '/cajas/open';
            axios.get(url, {
            }).then((res) => {
                var respuesta = res.data;
                this.resumencajas = respuesta.cajas;
                this.cajasopen = 0;
                this.cajasclose = 0;
                this.valorventasdia = respuesta.stats[0].valor;
                this.cantidadventasdia = respuesta.stats[0].cantidad;

                for (var i = 0; i < this.resumencajas.length; i++) {
                    if (this.resumencajas[i].estado == 1) {
                        this.cajasopen = this.resumencajas[i].cantidad;
                    } else if (this.resumencajas[i].estado == 0) {
                        this.cajasclose = this.resumencajas[i].cantidad;
                    }
                }

            });
            setInterval(() => {
                var url= '/cajas/open';
                axios.get(url, {
                }).then((res) => {
                    var respuesta = res.data;
                    this.resumencajas = respuesta.cajas;
                    this.cajasopen = 0;
                    this.cajasclose = 0;
                    this.valorventasdia = respuesta.stats[0].valor;
                    this.cantidadventasdia = respuesta.stats[0].cantidad;

                    for (var i = 0; i < this.resumencajas.length; i++) {
                        if (this.resumencajas[i].estado == 1) {
                            this.cajasopen = this.resumencajas[i].cantidad;
                        } else if (this.resumencajas[i].estado == 0) {
                            this.cajasclose = this.resumencajas[i].cantidad;
                        }
                    }

                });
            }, (5000));
        }
    },
    created: function () {
        //console.log('inicio');
        this.arrayCajas = this.cajas;
        this.cajasAbiertas();

    },
    mounted() {
        //console.log('Component mounted.');

        if (this.estado == 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Primero debe realizar la apertura de la caja del día para continuar.',
                showConfirmButton: true,
            })
        }
    },
}
</script>
