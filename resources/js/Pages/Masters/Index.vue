<template>
    <AppLayout title="Rifas">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de rifas
            </h2>
        </template>
        <div class="py-4 lg:px-8 md:px-6 sm:px-2">
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
                                    Rifas
                                </h1>
                            </div>

                            <div class="w-1/3">
                                <div class="container flex justify-center items-center">
                                    <div class="relative">
                                        <div class="absolute top-4 left-3">
                                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                        <input type="text" v-model="buscar" @keyup="getRifas(buscar,'rifas.nombre')" class="h-8 w-96 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar (Nombre, Nombre técnico)">
                                        <button @click="getRifas(buscar,'rifas.nombre')">
                                            <div class="absolute top-2 right-2">
                                                <Icon icon="fe:search" class="h-4"  />
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="pr-2 w-1/3 text-center">
                                <button @click="openModal('registrar')" class="bg-blue-500 text-xs  hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ">CREAR RIFA</button>
                            </div>

                        </div>

                        <div class="flex justify-left mx-auto ml-4 p-2 space-x-4">
                            <div class="flex pr-1 w-1/12 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <Link :href="route('numerosreservados.index')" class="text-xs hover:text-blue-700 text-blue-400 font-bold py-1 px-1 rounded ">
                                    Reservas
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
                                        <button @click="getRifas(buscar, 'loteria.nombre')" class="font-bold">
                                            Loteria
                                            <div v-show="sortBy == 'loteria.nombre'">
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
                                        <button @click="getRifas(buscar, 'loteria.nombre')" class="font-bold">
                                            Oculta
                                            <div v-show="sortBy == 'loteria.nombre'">
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
                                        <button @click="getRifas(buscar, 'serie')" class="font-bold">
                                            Serie
                                            <div v-show="sortBy == 'serie'">
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
                                    <th class="px-4 py-2 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getRifas(buscar, 'rifas.nombre_tecnico')" class="font-bold">
                                            Nombre
                                            <div v-show="sortBy == 'rifas.nombre_tecnico'">
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
                                        <button @click="getRifas(buscar, 'rifas.cifras')" class="font-bold">
                                            Cifras
                                            <div v-show="sortBy == 'rifas.cifras'">
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
                                        <button @click="getRifas(buscar, 'ciudad.precio')" class="font-bold">
                                            Precio Boleta
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
                                        <button @click="getRifas(buscar, 'rifas.fechainicio')" class="font-bold">
                                            Inicio
                                            <div v-show="sortBy == 'rifas.fechainicio'">
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
                                        <button @click="getRifas(buscar, 'rifas.fechafin')" class="font-bold">
                                            Fin
                                            <div v-show="sortBy == 'rifas.fechafin'">
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
                                        <button @click="getRifas(buscar, 'rifas.estado')" class="font-bold">
                                            Estado
                                            <div v-show="sortBy == 'rifas.estado'">
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
                                    <th class="lg:px-4 md:px-1 mx-auto py-2 text-sm font-bold lg:w-1/12 md:w-1/11 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Acciones
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center" text-sm v-if="existerifa > 0" v-for="(rifa, id) in arrayRifas.data" :key="id">
                                    <td class="border px-1 py-2 text-sm truncate" v-text="rifa.loteria.nombre"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="rifa.serieoculta"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="rifa.serie"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="rifa.nombre_tecnico"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="rifa.cifras"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="formatPrice(rifa.precio)"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dateTime(rifa.fechainicio)"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dateTime(rifa.fechafin)"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-if="rifa.estado">
                                        <span class="inline-flex px-2 text-sm font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                            Activo
                                        </span>
                                    </td>
                                    <td class="border px-2 py-2 text-sm" v-else>
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                            Inactivo
                                        </span>
                                    </td>
                                    <td class="border px-2 py-2 mx-auto text-center flex items-center">
                                        <button @click="ver(rifa)" class="hover:bg-green-700 text-green-400 font-bold rounded" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z" />
                                            </svg>
                                        </button>
                                        <button @click="copiar(rifa)" class="hover:bg-green-700 text-purple-800 font-bold rounded" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                            </svg>
                                        </button>

                                        <button @click="edit(rifa)" class="hover:bg-blue-700 text-white font-bold rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button @click="deleteRow(rifa)" class="hover:bg-red-700 text-white font-bold rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path v-if="rifa.estado" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                <path v-else fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>

                                        </button>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td class="border px-4 py-2 text-xs text-center" colspan="8"> La consulta no obtuvo datos</td>
                                </tr>
                                </tbody>
                            </table>
                            <pagination class="mt-6" :links="arrayRifas.links" />
                        </div>
                    </section>
                    <!-- Fin Tabla de contenido -->
                    <!-- Ventana modal -->
                    <section>
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

                                <!-- Contenido modal -->
                                    <div class="inline-block lg:w-10/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <div class="">
                                        <h2 v-text="tituloModal" class="text-sm font-bold text-gray-900 px-4 py-2"></h2>
                                    </div>
                                    <!-- Inicio Form -->
                                    <form>
                                        <div class="bg-white px-4 pt-2 pb-2 sm:p-6 sm:pb-4">
                                            <div class="">
                                                <section v-show="!editMode">

                                                    <div class="flex">
                                                        <div class="w-1/2 mx-auto text-center px-2">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Imagen rifa Grande:</label>

                                                        </div>
                                                        <div class="w-1/2 mx-auto text-center px-2">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Imagen rifa pequeña:</label>

                                                        </div>
                                                    </div>
                                                    <section class="flex" v-show="!verMode">
                                                        <div class="w-1/2 mx-auto text-center px-2">
                                                            <div class="max-w-3xl mx-auto lg:max-w-none">
                                                                <div class="mt-2 sm:mt-0 sm:col-span-2">
                                                                    <div
                                                                        v-cloak
                                                                        v-on:dragover.prevent="onUploadDragoverEvent1($event)"
                                                                        v-on:drop.prevent="onUploadDropEvent1($event)"
                                                                        class="w-full flex justify-center items-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md h-128"
                                                                    >
                                                                        <div
                                                                            class="absolute rounded-full bg-gray-100 h-10 w-10 z-10 transition-opacity duration-500 ease-in-out"
                                                                            v-bind:class="{
                                                                                            'opacity-100': uploadDragoverTracking1,
                                                                                            'opacity-0': !uploadDragoverTracking1
                                                                                          }"
                                                                            v-bind:style="{
                                                                                            left: `calc(${pageX1}px - 2.5rem)`,
                                                                                            top: `calc(${pageY1}px - 2.5rem)`
                                                                                          }"
                                                                        >

                                                                        </div>
                                                                        <div class="relative z-20 text-center">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                            </svg>
                                                                            <p class="mt-5 text-sm text-gray-600">
                                                                                <button type="button" class="font-medium text-pink-600 hover:text-pink-500 focus:outline-none focus:underline transition duration-150 ease-in-out"
                                                                                        v-bind:disabled="uploadDisabled1"
                                                                                        v-on:click="uploadFiles1"
                                                                                >
                                                                                    Subir
                                                                                </button>
                                                                                o arrastre los archivos
                                                                            </p>
                                                                            <p class="mt-1 text-xs text-gray-500">
                                                                                .jpg, .pdf, .png y .jepg de hasta 4Mb
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="bg-white shadow overflow-hidden sm:rounded-md mt-5">
                                                                <ul>
                                                                    <li
                                                                        v-for="(file, index) in form.files1"
                                                                        v-bind:key="index"
                                                                    >
                                                                        <a href="#" class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                                                                            <div class="px-4 py-4 sm:px-6">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div class="text-sm leading-5 font-medium text-pink-600 truncate">
                                                                                        {{ file.name }} ({{ file.size | prettyBytes }})
                                                                                    </div>
                                                                                    <div class="ml-2 flex-shrink-0 flex">
                                                                                      <span @click="removeFile1(file)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                                        Eliminar
                                                                                      </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <div class="w-1/2 mx-auto text-center px-2">
                                                            <div class="max-w-3xl mx-auto lg:max-w-none">
                                                                <div class="mt-2 sm:mt-0 sm:col-span-2">
                                                                    <div
                                                                        v-cloak
                                                                        v-on:dragover.prevent="onUploadDragoverEvent2($event)"
                                                                        v-on:drop.prevent="onUploadDropEvent2($event)"
                                                                        class="w-full flex justify-center items-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md h-128"
                                                                    >
                                                                        <div
                                                                            class="absolute rounded-full bg-gray-100 h-10 w-10 z-10 transition-opacity duration-500 ease-in-out"
                                                                            v-bind:class="{
                                                                                            'opacity-100': uploadDragoverTracking2,
                                                                                            'opacity-0': !uploadDragoverTracking2
                                                                                          }"
                                                                                            v-bind:style="{
                                                                                            left: `calc(${pageX2}px - 2.5rem)`,
                                                                                            top: `calc(${pageY2}px - 2.5rem)`
                                                                                          }"
                                                                        >

                                                                        </div>
                                                                        <div class="relative z-20 text-center">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                            </svg>
                                                                            <p class="mt-5 text-sm text-gray-600">
                                                                                <button type="button" class="font-medium text-pink-600 hover:text-pink-500 focus:outline-none focus:underline transition duration-150 ease-in-out"
                                                                                    v-bind:disabled="uploadDisabled2"
                                                                                    v-on:click="uploadFiles2"
                                                                                >
                                                                                    Subir
                                                                                </button>
                                                                                o arrastre los archivos
                                                                            </p>
                                                                            <p class="mt-1 text-xs text-gray-500">
                                                                                .jpg, .pdf, .png y .jepg de hasta 4Mb
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="bg-white shadow overflow-hidden sm:rounded-md mt-5">
                                                                <ul>
                                                                    <li
                                                                        v-for="(file, index) in form.files2"
                                                                        v-bind:key="index"
                                                                    >
                                                                        <a href="#" class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                                                                            <div class="px-4 py-4 sm:px-6">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div class="text-sm leading-5 font-medium text-pink-600 truncate">
                                                                                        {{ file.name }} ({{ file.size | prettyBytes }})
                                                                                    </div>
                                                                                    <div class="ml-2 flex-shrink-0 flex">
                                                                                      <span @click="removeFile2(file)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                                        Eliminar
                                                                                      </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </section>

                                                    <section class="flex" v-show="verMode">
                                                        <div class="w-1/2 mx-auto px-2">
                                                            <img v-if="form.urlimagen1 != null" :src="'/storage/'+form.urlimagen1" alt="image" class="mx-auto w-10/12"/>
                                                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="mx-auto w-10/12 h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                            </svg>
                                                        </div>
                                                        <div class="w-1/2 mx-auto px-2">
                                                            <img v-if="form.urlimagen2 != null" :src="'/storage/'+form.urlimagen2" alt="image" class="mx-auto w-10/12"/>
                                                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="mx-auto w-10/12 h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                            </svg>
                                                        </div>
                                                    </section>

                                                    <section class="flex" v-show="!verMode">
                                                        <div v-if="$page.props.errors.files1" class="text-red-500 w-1/2 mx-auto text-center px-2">{{ $page.props.errors.files1 }}</div>
                                                        <div v-if="$page.props.errors.files1" class="text-red-500 w-1/2 mx-auto text-center px-2">{{ $page.props.errors.files1 }}</div>
                                                    </section>
                                                </section>
                                                <!-- Mensajes Flash -->
                                                <section>
                                                    <section>
                                                        <div v-show="errorrifa" mx-auto class="bg-red-300 border-t-4 border-red-500 rounded-b text-gray-900 px-4 py-2 shadow-md my-3" role="alert" >
                                                            <div class="text-sm mx-auto text-gray-50 text-center">
                                                                <div v-for="error in errorMostrarMsjrifa" :key="error" v-text="error">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </section>
                                                <!-- Fin Mensajes Flash -->
                                            <!-- Formulario -->
                                            <section>
                                                <div class="flex py-1">
                                                    <div class="mb-4 w-2/4 pr-1">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Titulo</label>
                                                        <input v-model="form.titulo" type="text" :disabled="verMode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Titulo">
                                                        <div v-if="$page.props.errors.titulo" class="text-red-500">{{ $page.props.errors.titulo }}</div>
                                                    </div>
                                                    <div class="mb-4 w-2/12 px-1">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Resolucion</label>
                                                        <input v-model="form.resolucion" type="text" :disabled="verMode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Resolución" >
                                                        <div v-if="$page.props.errors.resolucion" class="text-red-500">{{ $page.props.errors.resolucion }}</div>
                                                    </div>
                                                    <div v-if="verMode" class="mb-4 w-2/12 px-1">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Tiene serie?</label>
                                                        <div class="mx-auto self-center">
                                                            <Toggle v-model="isSerie" />
                                                        </div>
                                                    </div>
                                                    <div v-else class="mb-4 w-2/12 px-1">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Tipo serie</label>
                                                        <select @change="actTipoSerie()" class="block w-full rounded-lg text-gray-700 text-sm"  v-model="tiposerie">
                                                            <option v-for="serie in arraySeries" :key="serie.id" :value="serie" v-text="serie.nombre"></option>
                                                        </select>
                                                    </div>
                                                    <div v-show="tiposerie.id != 1 && isSerie" class="mb-4 w-2/12 pl-1">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Serie</label>

                                                        <input v-if="isNumeric" v-model="form.serie" type="text" :disabled="verMode || (tiposerie.id == 1)" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Serie" >

                                                        <select v-else class="block w-full py-2 px-3 rounded-lg text-gray-700 text-sm" :disabled="verMode" v-model="form.serie">
                                                            <option v-for="serie in tiposseriestxt" :key="serie" :value="serie" v-text="serie"></option>
                                                        </select>

                                                        <div v-if="$page.props.errors.serie" class="text-red-500">{{ $page.props.errors.serie }}</div>
                                                    </div>
                                                </div>
                                                <div class="flex py-1">
                                                    <div class="mb-4 w-1/3 pr-4">
                                                        <select class="block w-full rounded-lg text-gray-700 text-sm" :disabled="verMode" v-model="form.idpais" @change="getDepartamentos()">
                                                            <option value="0" >Seleccione País</option>
                                                            <option v-for="pais in arrayPaises" :key="pais.id" :value="pais.id" v-text="pais.nombre"></option>
                                                        </select>
                                                        <div v-if="$page.props.errors.idpais" class="text-red-500">{{ $page.props.errors.idpais }}</div>
                                                    </div>
                                                    <div class="mb-4 w-1/3 px-4">
                                                        <select class="block w-full rounded-lg text-gray-700 text-sm" :disabled="verMode" v-model="form.iddepartamento" @change="getCiudades()">
                                                            <option value="0" >Seleccione Departamento</option>
                                                            <option v-for="departamento in arrayDepartamentos" :key="departamento.id" :value="departamento.id" v-text="departamento.nombre"></option>
                                                        </select>
                                                        <div v-if="$page.props.errors.iddepartamento" class="text-red-500">{{ $page.props.errors.iddepartamento }}</div>
                                                    </div>
                                                    <div class="mb-4 w-1/3">
                                                        <select class="block w-full rounded-lg text-gray-700 text-sm" :disabled="verMode" v-model="form.idciudad">
                                                            <option value="0" >Seleccione Ciudad</option>
                                                            <option v-for="ciudad in arrayCiudades" :key="ciudad.id" :value="ciudad.id" v-text="ciudad.nombre"></option>
                                                        </select>
                                                        <div v-if="$page.props.errors.idciudad" class="text-red-500">{{ $page.props.errors.idciudad }}</div>
                                                    </div>
                                                </div>
                                                <div class="flex py-1">
                                                    <div class="mb-4 w-1/2 pr-2">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Resumen url rifa</label>
                                                        <input v-model="form.url" type="text" :disabled="verMode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Resumen">
                                                        <div v-if="$page.props.errors.url" class="text-red-500">{{ $page.props.errors.url }}</div>
                                                    </div>
                                                    <div class="mb-4 w-1/2 pl-2">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Nombre técnico</label>
                                                        <input v-model="form.nombre_tecnico" type="text" :disabled="verMode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Nombre técnico">
                                                        <div v-if="$page.props.errors.nombre_tecnico" class="text-red-500">{{ $page.props.errors.nombre_tecnico }}</div>
                                                    </div>
                                                    <div class="mb-4 w-1/2 pl-2">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Lotería</label>
                                                        <select class="block w-full rounded-lg text-gray-700 text-sm" :disabled="verMode" v-model="form.idloteria">
                                                            <option value="0" >Seleccione lotería</option>
                                                            <option v-for="loteria in arrayLoterias" :key="loteria.id" :value="loteria.id" v-text="loteria.nombre"></option>
                                                        </select>
                                                        <div v-if="$page.props.errors.idloteria" class="text-red-500">{{ $page.props.errors.idloteria }}</div>
                                                    </div>
                                                </div>
                                                <div class="flex py-1">
                                                    <div class="mb-4 w-1/2 pr-2">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Cifras</label>
                                                        <input v-model="form.cifras" @keyup="actualizarRangos()" type="text" :disabled="verMode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Cifras">
                                                        <div v-if="$page.props.errors.cifras" class="text-red-500">{{ $page.props.errors.cifras }}</div>
                                                    </div>
                                                    <div class="mb-4 w-1/2 pr-2">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Rango</label>
                                                        <input v-model="rango" type="text" disabled class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Cifras">
                                                    </div>
                                                    <div class="mb-4 w-1/2 pr-2">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Cantidad boletas</label>
                                                        <input v-model="cantboletas" type="text" disabled class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Cifras">
                                                    </div>
                                                    <div class="mb-4 w-1/2 pr-2">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Precio boleta</label>
                                                        <money3 v-model="form.precio" v-bind="configMoney" :disabled="verMode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></money3>
                                                        <div v-if="$page.props.errors.precio" class="text-red-500">{{ $page.props.errors.precio }}</div>
                                                    </div>
                                                    <div class="mb-4 w-1/2 text-center">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Activo (NO):</label>
                                                        <Toggle v-model="form.estado" :disabled="verMode" />
                                                    </div>
                                                </div>
                                                <div class="flex py-1">
                                                    <div class="mb-4 w-1/2 pr-2">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Fecha inicio</label>
                                                        <Datepicker v-model="form.fechainicio" :disabled="verMode" required  autoApply placeholder="Fecha inicio" class="border border-gray-700 rounded w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                                                        <div v-if="$page.props.errors.fechainicio" class="text-red-500">{{ $page.props.errors.fechainicio }}</div>
                                                    </div>

                                                    <div class="mb-4 w-1/2 pr-2">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Fecha finalización</label>
                                                        <Datepicker v-model="form.fechafin" :disabled="verMode" required autoApply placeholder="Fecha fin"  class="border border-gray-700 rounded w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                                                        <div v-if="$page.props.errors.fechafin" class="text-red-500">{{ $page.props.errors.fechafin }}</div>
                                                    </div>
                                                    <div class="mb-4 w-1/2 text-center mx-auto">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Promocional (NO):</label>
                                                        <Toggle v-model="form.promocional" :disabled="verMode"/>
                                                    </div>
                                                </div>
                                                <!-- seccion de promocionales -->
                                                <section v-show="form.promocional" class="bg-green-200 rounded-md px-8">
                                                    <div class="flex py-1 px-2">
                                                        <div class="mb-4 w-3/12">
                                                            <label class="block text-gray-700 text-xs font-bold mb-2">Premio</label>
                                                            <input v-show="!verMode" v-model="premiopromo" type="text" :disabled="verMode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Premio">
                                                        </div>
                                                        <div class="mb-4 w-3/12 px-2">
                                                            <label class="block text-gray-700 text-xs font-bold mb-2">Fecha</label>
                                                            <Datepicker v-show="!verMode" v-model="fechapromo" :disabled="verMode"  autoApply placeholder="Fecha inicio" class="border border-gray-700 rounded w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                                                        </div>
                                                        <div class="mb-4 w-3/12 px-2">
                                                            <label class="block text-gray-700 text-xs font-bold mb-2">Lotería</label>
                                                            <select v-show="!verMode" class="block w-full rounded-lg text-gray-700 text-sm" :disabled="verMode" v-model="idloteriapromo">
                                                                <option value="0" >Seleccione lotería</option>
                                                                <option v-for="loteria in arrayLoterias" :key="loteria.id" :value="loteria.id" v-text="loteria.nombre"></option>
                                                            </select>
                                                        </div>
                                                        <div class="mx-auto w-1/12 px-2 self-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" @click="agregarPromocional()" class="mx-auto h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                                </svg>
                                                         </div>
                                                    </div>
                                                </section>
                                                <section v-show="form.promocionales.length" class="bg-blue-200 rounded-md px-12">
                                                    <tr v-for="(promo, index) in form.promocionales" :key="promo.id" class="flex py-1 px-6 border">
                                                        <td class="mb-4 w-3/12 px-2" v-text="promo.premio"></td>
                                                        <td class="mb-4 w-3/12 px-2" v-text="promo.fecha"></td>
                                                        <td class="mb-4 w-3/12 px-2" v-text="promo.idloteria"></td>
                                                        <td v-show="!verMode" class="mx-auto w-1/12 px-2 self-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" @click="eliminarPromo(index)" class="mx-auto h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                        </td>
                                                    </tr>
                                                </section>
                                                <!-- Fin de promocionales -->
                                                <div class="flex py-1">
                                                    <div class="mb-4 w-1/2 text-center mx-auto">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Publicar (NO):</label>
                                                        <Toggle v-model="form.publicar" :disabled="verMode"/>
                                                    </div>
                                                    <div class="mb-4 w-1/2 text-center mx-auto">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Destacada (NO):</label>
                                                        <Toggle v-model="form.destacada" :disabled="verMode"/>
                                                    </div>
                                                    <div class="mb-4 w-1/2 text-center mx-auto">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Principal (NO):</label>
                                                        <Toggle v-model="form.principal" :disabled="verMode"/>
                                                    </div>
                                                </div>
                                                <div class="flex-1 py-1">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
                                                        <QuillEditor theme="snow" contentType="html" :disabled="verMode" v-model:content="form.descripcion" class="block w-full p-8  leading-tight text-gray-700 rounded-lg border focus:ring-blue-500 focus:border-blue-500 " placeholder="Descripción"/>
                                                        <div v-if="$page.props.errors.descripcion" class="text-red-500">{{ $page.props.errors.descripcion }}</div>
                                                </div>
                                                <div class="flex-1 py-1">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Términos y condiciones</label>
                                                    <select class="block w-full rounded-lg text-gray-700 text-sm" :disabled="verMode" v-model="form.idterminos">
                                                        <option value="0" >Seleccione Terminos</option>
                                                        <option v-for="termino in arrayTerminos" :key="termino.id" :value="termino.id" v-text="termino.nombre"></option>
                                                    </select>
                                                    <div v-if="$page.props.errors.idterminos" class="text-red-500">{{ $page.props.errors.idterminos }}</div>
                                                </div>
                                            </section>
                                            <!-- Fin formulario -->
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                              <button v-show="!editMode && !verMode" @click="save(form)" wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" >
                                                Crear
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
                                    <!-- Fin form -->
                                </div>
                                <!-- Fin Contenido modal -->
                            </div>
                        </div>
                    </section>
                    <!-- Fin Ventana modal -->
                    <!-- Ventana modal 2 -->
                    <section>
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpenModal2">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​


                                <!-- Contenido modal -->
                                <div class="inline-block lg:w-6/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <div class="">
                                        <h2 v-text="tituloModal2" class="text-xl font-bold text-gray-900 px-4 py-2"></h2>
                                    </div>
                                    <!-- Inicio Form -->
                                    <form>
                                        <div class="bg-white px-4 pt-2 pb-2 sm:p-6 sm:pb-4">
                                            <div class="">
                                                <!-- Mensajes Flash -->
                                                <section>
                                                    <section>
                                                        <div v-show="errorrifa" mx-auto class="bg-red-300 border-t-4 border-red-500 rounded-b text-gray-900 px-4 py-2 shadow-md my-3" role="alert" >
                                                            <div class="text-sm mx-auto text-gray-50 text-center">
                                                                <div v-for="error in errorMostrarMsjrifa" :key="error" v-text="error">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </section>
                                                <!-- Fin Mensajes Flash -->
                                                <!-- Formulario -->
                                                <section>
                                                    <div class="">
                                                        <h2 class="text-xl font-bold text-gray-900 px-4 py-2">Datos de Origen</h2>
                                                    </div>
                                                    <div class="py-1">
                                                        <div class="mb-4 w-full pr-1">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Rifa Origen</label>
                                                            <input v-model="form.titulo" type="text" disabled class="bg-blue-50 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Titulo">
                                                        </div>
                                                    </div>
                                                    <div class="flex py-1">
                                                        <div class="mb-4 w-1/2 pr-1">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Nombre Técnico</label>
                                                            <input v-model="form.nombre_tecnico" type="text" disabled class="bg-blue-50 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Nombre técnico">
                                                        </div>
                                                        <div class="mb-4 w-1/2 px-1">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Resolucion</label>
                                                            <input v-model="form.resolucion" type="text" disabled class="bg-blue-50 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Resolución" >
                                                        </div>
                                                    </div>
                                                    <div class="flex py-1">
                                                        <div class="mb-4 w-1/3 px-1">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Tipo de Serie</label>
                                                            <select @change="actTipoSerie()" disabled class="bg-blue-50 block w-full rounded-lg text-gray-700 text-sm"  v-model="tiposerie">
                                                                <option v-for="serie in arraySeries" :key="serie.id" :value="serie" v-text="serie.nombre"></option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-4 w-1/3 pl-1">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Serie</label>

                                                            <input v-if="isNumeric" disabled v-model="form.serie" type="text" class="bg-blue-50 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="-" >

                                                            <select v-else class="bg-blue-50 block w-full py-2 px-3 rounded-lg text-gray-700 text-sm" disabled v-model="form.serie">
                                                                <option v-for="serie in tiposseriestxt" :key="serie" :value="serie" v-text="serie"></option>
                                                            </select>

                                                        </div>
                                                        <div class="mb-4 w-1/3 pl-1">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Serie Oculta</label>
                                                            <input disabled v-model="form.serieoculta" type="text" class="bg-blue-50 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Serie" >
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <h2 class="text-xl font-bold text-gray-900 px-4 py-2">Datos de destino</h2>
                                                    </div>
                                                    <div class="flex flex-wrap mx-auto py-4">
                                                        <div class="flex items-center mr-4">
                                                            <input @change="selSerieOculta()" type="radio" value="1" v-model="copiaserie" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500 focus:ring-2 ">
                                                            <label class="ml-2 text-sm font-medium ">Serie Oculta</label>
                                                        </div>
                                                        <div class="flex items-center mr-4">
                                                            <input @change="selSerieOculta()" type="radio" value="0" v-model="copiaserie" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500 dark:ring-offset-gray-800 ">
                                                            <label class="ml-2 text-sm font-medium ">Serie No Oculta</label>
                                                        </div>
                                                    </div>
                                                    <div v-if="copiaserie == 1" class="flex py-1">
                                                        <div class="mb-4 w-1/2 px-1">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Tipo de Serie</label>
                                                            <select disabled class="block w-full rounded-lg text-gray-700 text-sm" >
                                                                <option value="0">Numerica</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-4 w-1/2 pl-1">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Serie</label>
                                                            <input v-model="seriedestinooculta" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Serie" >

                                                            <div v-if="$page.props.errors.serie" class="text-red-500">{{ $page.props.errors.serie }}</div>
                                                        </div>
                                                    </div>
                                                    <div v-else class="flex py-1">
                                                        <div class="mb-4 w-1/2 px-1">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Tipo de Serie</label>
                                                            <select @change="actTipoSeriecopia()" :disabled="tiposerie.id != 1" class="block w-full rounded-lg text-gray-700 text-sm"  v-model="tiposeriedestino">
                                                                <option v-for="serie in arraySeries" :key="serie.id" :value="serie" v-text="serie.nombre"></option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-4 w-1/2 pl-1">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Serie</label>

                                                            <input v-if="isNumericcopia" v-model="seriedestino" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Serie" >

                                                            <select v-else class="block w-full py-2 px-3 rounded-lg text-gray-700 text-sm" :disabled="verMode" v-model="seriedestino">
                                                                <option v-for="serie in tiposseriestxtdst" :key="serie" :value="serie" v-text="serie"></option>
                                                            </select>

                                                            <div v-if="$page.props.errors.serie" class="text-red-500">{{ $page.props.errors.serie }}</div>
                                                        </div>
                                                    </div>
                                                </section>
                                                <!-- Fin formulario -->
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                              <button v-show="!editMode && !verMode" @click="copy(form)" wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" >
                                                Crear serie
                                              </button>
                                            </span>

                                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

                                                <button @click="closeModal2()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                                Cancelar
                                          </button>
                                        </span>
                                        </div>
                                    </form>
                                    <!-- Fin form -->
                                </div>
                                <!-- Fin Contenido modal -->

                            </div>
                        </div>
                    </section>
                    <!-- Fin ventana modal 2 -->
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
        rifas : [],
        errors: Object
    },
    computed: {
        uploadDisabled1() {
            return this.form.files1.length === 0;
        },
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
                titulo: null,
                resolucion: null,
                estado: null,
                nombre: null,
                descripcion: null,
                nombre_tecnico: null,
                resumen: null,
                url: null,
                idloteria: 0,
                idpais: 0,
                iddepartamento: 0,
                idciudad: 0,
                cifras: null,
                precio: null,
                fechainicio: null,
                fechafin: null,
                promocional: false,
                publicar: false,
                destacada: false,
                principal: false,
                urlimagen1: null,
                urlimagen2: null,
                idterminos: 0,
                idcreador: 0,
                serieoculta: 1,
                serie: null,
                idserie: 0,
                promocionales: [],
                files1: [],
                files2: [],
            },
            arrayPaises: [],
            arrayDepartamentos: [],
            arrayCiudades: [],
            arrayLoterias: [],
            arrayTerminos: [],
            arraySeries: [],
            editMode: false,
            verMode: false,
            isOpen: false,
            isOpenModal2: false,
            existerifa: 1,
            buscar: '',
            arrayRifas: [],
            sortOrder: 1,
            sortBy: '',
            rango: null,
            cantboletas: 0,
            errorrifa: 0,
            isNumeric: 1,
            isNumericcopia: 1,
            errorMostrarMsjrifa: [],
            idloteriapromo: 0,
            premiopromo: null,
            fechapromo: null,
            tiposseriestxt: [],
            tiposseriestxtdst: [],
            isSerie: false,
            tiposerie: {
                id: 0,
                nombre: null,
                cifras: 0,
                detalle: null
            },
            copiaserie: 0,
            tiposeriedestino: [],
            seriedestino: 0,
            seriedestinooculta: 0,
        }
    },
    methods: {
        selSerieOculta: function (){
            if (this.copiaserie == 1) {
                this.seriedestinooculta = this.form.serieoculta + 1;
            }
        },
        actTipoSerie: function (){
            if (this.tiposerie.cifras > 0) {
                this.isNumeric = true;
            } else {
                this.isNumeric = false;
                this.form.serie = null;
                this.tiposseriestxt = this.tiposerie.detalle.split('|');
            }
        },
        actTipoSeriecopia: function (){
            if (this.tiposeriedestino.cifras > 0) {
                this.isNumericcopia = true;
            } else {
                this.isNumericcopia = false;
                this.seriedestino = null;
                this.tiposseriestxtdst = this.tiposeriedestino.detalle.split('|');
            }
        },
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
            this.getPaises();
            this.getLoterias();
            this.getTerminos();
            this.getSeries();

            switch (accion) {
                case 'registrar':
                {
                    this.tituloModal = 'Crear nueva rifa';
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
                    this.form.serieoculta = 1;
                    this.form.serie = null;
                    this.form.idserie = 1;
                    this.form.promocionales = [];
                    this.form.files1 = [];
                    this.form.files2 = [];
                    this.tiposerie.id = 1;
                    this.isSerie = false;
                    break;
                }
                case 'ver':
                {
                    this.tituloModal = 'Detalle de la Rifa ' +  data['titulo'];
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
                    this.form.serieoculta = data['serieoculta'];
                    this.form.serie = data['serie'];
                    this.form.idserie = data['idserie'];
                    this.form.promocionales = data['promocionales'];
                    this.form.files1 = [];
                    this.form.files2 = [];
                    if (data['idserie'] != 1){
                        this.isSerie = true;
                    } else {
                        this.isSerie = false;
                    }
                    this.getDepartamentos();
                    this.getCiudades();
                    break;
                }
                case 'actualizar': {
                    this.tituloModal = 'Actualizar el rifa' + data['nombre_tecnico'];
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
                    this.form.serieoculta = data['serieoculta'];
                    this.form.serie = data['serie'];
                    this.form.idserie = data['idserie'];
                    this.form.promocionales = data['promocionales'];
                    this.form.files1 = [];
                    this.form.files2 = [];
                    this.tiposerie = data['tiposerie'];
                    if (data['idserie'] != 1){
                        this.isSerie = true;
                    } else {
                        this.isSerie = false;
                    }
                    this.getDepartamentos();
                    this.getCiudades();
                    this.actualizarRangos();
                    break;
                }
            }
        },
        openModal2: function (accion, data = []) {
            this.isOpenModal2 = true;
            this.tituloModal = 'Crear nueva serie' + data['nombre_tecnico'];
            this.form.id = data['id'];
            this.form.titulo = data['titulo'];
            this.form.nombre_tecnico = data['nombre_tecnico'];
            this.form.resolucion = data['resolucion'];
            this.form.serie = data['serie'];
            this.form.idserie = data['idserie'];
            this.tiposerie = data['tiposerie'];
            if (data['idserie'] != 1){
                this.isSerie = true;
            } else {
                this.isSerie = false;
            }
            this.tiposeriedestino = this.tiposerie;
            this.getSeries();
            this.actTipoSeriecopia();
        },

        closeModal: function () {
            this.isOpen = false;
            this.reset();
            this.editMode = false;
            this.verMode  = false;
            this.$page.props.errors = [];
        },
        closeModal2: function () {
            this.isOpenModal2 = false;
            this.reset2();
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
            this.form.serieoculta = 1;
            this.form.serie = null;
            this.form.idserie = 1;
            this.form.promocionales = [];
            this.form.files1 = [];
            this.form.files2 = [];
        },
        reset2: function () {
            this.reset();
            this.seriedestino = null;
            this.seriedestinooculta = null;
            this.copiaserie = 0;
            this.tiposeriedestino = [];
        },
        save: function (data) {
            data.fechainicio = this.dateTimeFull(data.fechainicio);
            data.fechafin = this.dateTimeFull(data.fechafin);
            data.idserie = this.tiposerie.id;
            if (this.tiposerie.id == 1){
                data.serie = null;
            }
            //console.log(data);
            this.$inertia.post('/rifas', data, {
                onSuccess: (page) => {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'La rifa se ha creado',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.reset();
                    this.closeModal();
                    this.getRifas('','rifas.nombre_tecnico');
                    this.editMode = false;
                },
            });

        },
        copy: function (data) {
            //console.log('inicia save');
            data.idserie = this.tiposerie.id;
            if (this.tiposerie.id == 1){
                data.serie = null;
            }

            let isSave = false;

            if (this.copiaserie == 1) {
                //console.log('serie oculta');
                if (this.form.serieoculta == this.seriedestinooculta) {
                    Swal.fire({
                        icon: 'error',
                        title: 'La nueva serie debe ser diferente a la actual',
                        showConfirmButton: true,
                    })
                } else if (!Number.isInteger(this.seriedestinooculta)){
                    Swal.fire({
                        icon: 'error',
                        title: 'La nueva serie debe ser un número entero',
                        showConfirmButton: true,
                    })
                } else {
                    data.isOculta = true;
                    data.serieoculta = this.seriedestinooculta;
                    this.isSave= true;
                }
            } else {
                if (this.tiposeriedestino == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Debe seleecionar el tipo de serie',
                        showConfirmButton: true,
                    })
                } else {
                    if (this.seriedestino == '' || this.seriedestino == 0 || this.seriedestino == null) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Por favor ingrese o selecciones un valor para la nueva serie',
                            showConfirmButton: true,
                        })
                    } else {
                        data.isOculta = false;
                        data.seriedestino = this.seriedestino;
                        data.tiposeriedestino = this.tiposeriedestino.id;
                        this.isSave = true;
                    }

                }
            }

            if (this.isSave) {

                this.$inertia.post('/rifas/copy', data, {
                    onSuccess: (page) => {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'La rifa se ha creado',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.reset2();
                        this.closeModal2();
                        this.getRifas('','rifas.id');
                        this.editMode = false;
                    },
                });
            }
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
        copiar: function (data) {
            this.openModal2('copiar', data);
        },
        update: function (data) {
            data.fechainicio = this.dateTimeFull(data.fechainicio);
            data.fechafin = this.dateTimeFull(data.fechafin);
            data.idserie = this.tiposerie.id;
            if (this.tiposerie.id == 1){
                data.serie = null;
            }
            data._method = 'PUT';
            this.$inertia.post('/rifas/'  + data.id, data, {
                onSuccess: (page) => {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'La rifa se ha actualizado',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.getRifas('','rifas.nombre');
                    this.closeModal();
                    this.reset();
                    this.editMode = false;
                },
            });

        },
        getRifas: async function (buscar, sortBy) {
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
                //console.log(res.data);
                var respuesta = res.data;
                this.arrayRifas = respuesta.rifas;

                if (this.arrayRifas.data.length > 0) {
                    this.existerifa = 1;
                } else {
                    this.existerifa = 0;
                }
            })
        },
        getLoterias: function () {
            axios.get('/loterias',).then((res) => {
                this.arrayLoterias = res.data.loterias;
                //console.log(res.data.loterias)
            })
        },
        getTerminos: function () {
            axios.get('/terminos',).then((res) => {
                this.arrayTerminos = res.data.terminos;
                //console.log(res.data.terminos)
            })
        },
        getPaises: function () {
            axios.get('/paises',).then((res) => {
                this.arrayPaises = res.data.paises;
                //console.log(res.data.paises)
            })
        },
        getDepartamentos: function () {
            axios.get('/paises/departamentos', {
                params: {
                    idpais: this.form.idpais
                }
            }).then((res) => {
                this.arrayDepartamentos = res.data.departamentos;
                //console.log(res.data.departamentos)
            })
        },
        getSeries: function () {
            axios.get('/series', {
            }).then((res) => {
                this.arraySeries = res.data.tiposerie;
                //console.log(res.data.tiposerie)
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
                //console.log(res.data.ciudades)
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
                    this.getRifas('','rifas.nombre');
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

        eliminarPromo(index){
            this.form.promocionales.splice(index, 1);
        },
        agregarPromocional(){
            if(this.premiopromo == '' || this.fechapromo == '' || this.idloteriapromo == 0){
            }
            else{
                    this.form.promocionales.push({
                        premio: this.premiopromo,
                        fecha: this.dateTimeFull(this.fechapromo),
                        idloteria: this.idloteriapromo
                    });
                this.premiopromo = '';
                this.fechapromo = "";
                this.idloteriapromo = 0;
            }
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
            //console.log(this.form.files1);
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
        this.arrayRifas = this.rifas;
        //this.openModal('registrar')
    },
    mounted() {
        console.log('Component mounted.');
    },
}
</script>
