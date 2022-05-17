<template>
    <AppLayout title="Numerosreservados">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de números Reservados
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
                                    Números reservados
                                </h1>
                            </div>

                            <div class="w-1/3">
                                <div class="container flex justify-center items-center">
                                    <div class="relative">
                                        <div class="absolute top-4 left-3">
                                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                        <input type="text" v-model="buscar" @keyup="getNumerosreservados(buscar,'numero')" class="h-8 w-96 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar (Rifa, número)">
                                        <button @click="getNumerosreservados(buscar,'numero')">
                                            <div class="absolute top-2 right-2">
                                                <Icon icon="fe:search" class="h-4"  />
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="pr-2 w-1/3 text-center">
                                <button @click="openModal('registrar')" class="bg-blue-500 text-xs  hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ">CREAR RESERVA</button>
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
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getNumerosreservados(buscar, 'cliente.nombre')" class="font-bold">
                                            Cliente
                                            <div v-show="sortBy == 'cliente.nombre'">
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
                                        <button @click="getNumerosreservados(buscar, 'vendedor.nombre')" class="font-bold">
                                            Vendedor
                                            <div v-show="sortBy == 'vendedor.nombre'">
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
                                    <th class="px-4 py-2 text-sm w-3/12 font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getNumerosreservados(buscar, 'idrifa')" class="font-bold">
                                            Rifa
                                            <div v-show="sortBy == 'idrifa'">
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
                                        <button @click="getNumerosreservados(buscar, 'numero')" class="font-bold">
                                            Número
                                            <div v-show="sortBy == 'numero'">
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
                                        <button @click="getNumerosreservados(buscar, 'rango')" class="font-bold">
                                            Rango
                                            <div v-show="sortBy == 'rango'">
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
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold w-1/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getNumerosreservados(buscar, 'fecha')" class="font-bold">
                                            Fecha
                                            <div v-show="sortBy == 'fecha'">
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
                                        <button @click="getNumerosreservados(buscar, 'estado')" class="font-bold">
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
                                    <th class="lg:px-4 md:px-1 mx-auto py-2 text-sm font-bold lg:w-1/12 md:w-1/11 hover:bg-blue-500 hover:text-gray-50 rounded-b">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center" text-sm v-if="existenumerosreservados > 0" v-for="(numeroreservado, id) in arrayNumerosreservados.data" :key="id">
                                    <td class="border px-1 py-2 text-sm truncate" v-text="numeroreservado.cliente.nombre + ' ' + numeroreservado.cliente.apellido"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="numeroreservado.vendedor.nombre + ' ' + numeroreservado.vendedor.apellido"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="numeroreservado.rifa.titulo"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="numeroreservado.numero"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="nvl(numeroreservado.rangoinicial, '') + ' - ' + nvl(numeroreservado.rangofinal, '')"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dateTime(numeroreservado.fecha)"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-if="numeroreservado.estado">
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
                                        <button @click="ver(numeroreservado)" class="hover:bg-green-700 text-green-400 font-bold rounded" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z" />
                                            </svg>
                                        </button>
                                        <button @click="edit(numeroreservado)" class="hover:bg-blue-700 text-white font-bold rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button @click="deleteRow(numeroreservado)" class="hover:bg-red-700 text-white font-bold rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path v-if="numeroreservado.estado" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
                            <pagination class="mt-6" :links="arrayNumerosreservados.links" />
                        </div>
                    </section>
                    <!-- Fin Tabla de contenido -->

                    <!-- Ventana modal Crear Reserva-->
                    <section>
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

                                <!-- Contenido modal -->
                                    <div class="inline-block lg:w-6/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <div class="">
                                        <h2 v-text="tituloModal" class="text-xl font-bold text-gray-900 px-4 py-2"></h2>
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
                                                <div class="flex py-1">
                                                    <div class="mb-4 w-full pr-2">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Rifa</label>

                                                        <input v-model="form.idrifa.nombre_tecnico" @click="selectRifa()" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Seleccione Rifa">

                                                        <div v-if="$page.props.errors.rifa" class="text-red-500">{{ $page.props.errors.rifa }}</div>
                                                    </div>
                                                </div>
                                                <div class="flex py-1">
                                                    <div class="mb-4 w-full pr-2">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Vendedor</label>

                                                        <input v-model="form.idvendedor.nombre" @click="selectVendedor()" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Seleccione Vendedor">

                                                        <div v-if="$page.props.errors.vendedor" class="text-red-500">{{ $page.props.errors.vendedor }}</div>
                                                    </div>
                                                </div>
                                            </section>
                                             <section>
                                                 <div class="flex flex-wrap mx-auto py-4">
                                                     <div class="flex items-center mr-4">
                                                         <input type="radio" value="1" v-model="isIndividual" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500 focus:ring-2 ">
                                                         <label class="ml-2 text-sm font-medium ">Número individual</label>
                                                     </div>
                                                     <div class="flex items-center mr-4">
                                                         <input type="radio" value="0" v-model="isIndividual" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500 dark:ring-offset-gray-800 ">
                                                         <label class="ml-2 text-sm font-medium ">Rango</label>
                                                     </div>
                                                 </div>
                                                <div class="flex py-1 w-full">
                                                    <div class="mb-4 w-full" v-if="isIndividual == 1">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Número</label>
                                                        <input v-model="form.numero" type="text" :disabled="verMode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Numero">
                                                        <div v-if="$page.props.errors.numero" class="text-red-500">{{ $page.props.errors.numero }}</div>
                                                    </div>
                                                    <div class="flex py-1" v-else>
                                                        <div class="mb-4 w-1/2 pl-2">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Rango Inicial</label>
                                                            <input v-model="form.rangoinicial" type="text" :disabled="verMode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ranco inicial">
                                                            <div v-if="$page.props.errors.rangoinicial" class="text-red-500">{{ $page.props.errors.rangoinicial }}</div>
                                                        </div>
                                                        <div class="mb-4 w-1/2 pl-2">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Rango Final</label>
                                                            <input v-model="form.rangofinal" type="text" :disabled="verMode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Rango final">
                                                            <div v-if="$page.props.errors.rangofinal" class="text-red-500">{{ $page.props.errors.rangofinal }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="flex py-1 w-full">
                                                     <div class="mb-4 w-full">
                                                         <label class="block text-gray-700 text-sm font-bold mb-2">Subir archivo por lotes</label>
                                                         <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Seleccione archivo">
                                                         <div v-if="$page.props.errors.file" class="text-red-500">{{ $page.props.errors.file }}</div>
                                                     </div>
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
                    <!-- Fin Ventana modal Reserva -->

                    <!-- Ventana modal Rifas-->
                    <section>
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpenRifa">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity" @click="closeMoodalRifa()">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

                                <!-- Contenido modal -->
                                <div class="inline-block lg:w-7/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <section>
                                        <div class="flex justify-between mx-auto p-4">
                                            <div class="w-1/2">
                                                <h1 class="font-bold text-xl text-black-800 leading-tight">
                                                    Buscar Rifas
                                                </h1>
                                            </div>

                                            <div class="w-1/2 pr-2">
                                                <div class="container flex justify-center items-center">
                                                    <div class="relative">
                                                        <div class="absolute top-4 left-3">
                                                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                                        <input type="text" v-model="buscar" @keyup="getRifas(buscar,'nombre_tecnico', true)" class="h-8 w-26 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar (nombre_tecnico)">
                                                        <button @click="getRifas(buscar,'nombre_tecnico', true)">
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
                                        <div class="lg:px-4 md:px-2 sm:px-0 py-2 pb-6">
                                            <table class="table-fixed w-full">
                                                <thead>
                                                <tr class="bg-gray-100">
                                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                        <button @click="getRifas('', 'idloteria')" class="font-bold">
                                                            Loteria
                                                            <div v-show="sortBy == 'idloteria'">
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
                                                    <th class="px-4 py-2 w-4/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                        <button @click="getRifas('', '.nombre_tecnico')" class="font-bold">
                                                            Nombre
                                                            <div v-show="sortBy == 'nombre_tecnico'">
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

                                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
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
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr @click="onSelectRifa(rifa)" class="hover:bg-blue-50 text-center" text-sm v-if="existerifa > 0" v-for="(rifa, id) in arrayRifas.data" :key="id">
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="rifa.loteria.nombre"></td>
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="rifa.serieoculta"></td>
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="rifa.serie"></td>
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="rifa.nombre_tecnico"></td>
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="dateTime(rifa.fechafin)"></td>
                                                </tr>
                                                <tr v-else>
                                                    <td class="border px-4 py-2 text-xs text-center" colspan="5"> La consulta no obtuvo datos</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <section class="mt-6">
                                                <div v-if="arrayRifas.links.length > 3">
                                                    <div class="flex flex-wrap -mb-1">
                                                        <template v-for="(link, p) in arrayRifas.links" :key="p">
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
                                    <!-- Fin form -->
                                </div>
                                <!-- Fin Contenido modal -->
                            </div>
                        </div>
                    </section>
                    <!-- Fin Ventana modal  Rifas -->

                    <!-- Ventana modal Vendedores-->
                    <section>
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpenVendedor">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity" @click="closeMoodalVendedor()">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

                                <!-- Contenido modal -->
                                <div class="inline-block lg:w-7/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <section>
                                        <div class="flex justify-between mx-auto p-4">
                                            <div class="w-1/2">
                                                <h1 class="font-bold text-xl text-black-800 leading-tight">
                                                    Buscar Vendedores
                                                </h1>
                                            </div>

                                            <div class="w-1/2 pr-2">
                                                <div class="container flex justify-center items-center">
                                                    <div class="relative">
                                                        <div class="absolute top-4 left-3">
                                                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                                        <input type="text" v-model="buscar" @keyup="getRifas(buscar,'nombre_tecnico', true)" class="h-8 w-26 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar (Nombre, apellido)">
                                                        <button @click="getRifas(buscar,'nombre_tecnico', true)">
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
                                        <div class="lg:px-4 md:px-2 sm:px-0 py-2 pb-6">
                                            <table class="table-fixed w-full">
                                                <thead>
                                                <tr class="bg-gray-100">
                                                    <th class="px-4 py-2 w-1/3 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                        Nombre
                                                    </th>
                                                    <th class="px-4 py-2 w-1/3 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                        Documento
                                                    </th>
                                                    <th class="px-4 py-2 w-1/3 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                        Correo
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr @click="onSelectVendedor(vendedor)" class="hover:bg-blue-50 text-center" text-sm v-if="existevendedor > 0" v-for="(vendedor, id) in arrayVendedores.data" :key="id">
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="vendedor.nombre"></td>
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="vendedor.documento"></td>
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="vendedor.correo"></td>
                                                </tr>
                                                <tr v-else>
                                                    <td class="border px-4 py-2 text-xs text-center" colspan="5"> La consulta no obtuvo datos</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <section class="mt-6">
                                                <div v-if="arrayVendedores.links.length > 3">
                                                    <div class="flex flex-wrap -mb-1">
                                                        <template v-for="(link, p) in arrayVendedores.links" :key="p">
                                                            <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                                                                 v-html="link.label" />
                                                            <button  v-else
                                                                     class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                                                                     :class="{ 'bg-blue-700 text-white': link.active }"
                                                                     v-on:click="cambiarPagev(link.url)"
                                                                     v-html="link.label" />
                                                        </template>
                                                    </div>
                                                </div>
                                            </section>

                                        </div>
                                    </section>
                                    <!-- Fin form -->
                                </div>
                                <!-- Fin Contenido modal -->
                            </div>
                        </div>
                    </section>
                    <!-- Fin Ventana modal  Vendedores -->

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
import {InertiaLink} from "@inertiajs/inertia-vue3";


export default {

    components: {
        Button,
        AppLayout,
        Icon,
        Pagination,
        Toggle,
        QuillEditor,
        money3: Money3Component,
    },
    props:{
        numerosreservados : [],
        rifas: [],
        vendedores: [],
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
            form: {
                id: null,
                idrifa: null,
                numero: null,
                estado: false,
                rangoinicial: null,
                rangofinal: null,
                idvendedor: 0,
                idcliente: 0,
                fecha: null,
            },
            arrayRifas: {
                data: [],
                links: []
            },
            arrayVendedores: {
                data: [],
                links: []
            },
            arrayClientes: [],
            editMode: false,
            verMode: false,
            isOpen: false,
            existenumerosreservados: 1,
            buscar: '',
            arrayNumerosreservados: [],
            sortOrder: 1,
            sortBy: '',
            rangoinicial: null,
            rangofinal: null,
            cantboletas: 0,
            errornumerosreservados: 0,
            errorMostrarMsjnumerosreservados: [],
            isOpenRifa: 0,
            isOpenVendedor: 0,
            existerifa: 0,
            existevendedor: 0,
            isIndividual: 0,
        }
    },
    methods: {
        nvl: function (value, fallbackValue) {
            return typeof value !== 'undefined' && value != null
                ? value
                : fallbackValue;
        },
        selTipoSerie: function (data){
            this.isIndividual = data;
        },
        cambiarPage: function (url = '') {
            axios.get(url, {
            }).then((res) => {
                var respuesta = res.data;
                this.arrayRifas = respuesta.rifas;

                if (this.arrayRifas.data.length > 0) {
                    this.existerifa = 1;
                } else {
                    this.existerifa = 0;
                }
            })
        },
        cambiarPagev: function (url = '') {
            axios.get(url, {
            }).then((res) => {
                var respuesta = res.data;
                this.arrayVendedores = respuesta.vendedores;

                if (this.arrayVendedores.data.length > 0) {
                    this.existevendedor = 1;
                } else {
                    this.existevendedor = 0;
                }
            })
        },
        onSelectRifa: function(data){
            this.form.idrifa = data;
            this.closeMoodalRifa();
            this.actualizarRangos();
        },
        onSelectVendedor: function(data){
            this.form.idvendedor = data;
            this.closeMoodalVendedor();
        },
        actualizarRangos() {
            let cantidad = 0;
            let rangoinicial = '';
            let rangofinal = '';

            cantidad = Math.pow(10, this.form.idrifa.cifras);
            rangoinicial = '' + String('0'.toString()).padStart(this.form.idrifa.cifras, '0'.toString());
            rangofinal = (cantidad - 1);
            console.log(rangoinicial);
            if(this.isIndividual == 1) {
                this.form.numero = rangoinicial + ' - ' + rangofinal;
                this.form.rangoinicial = null;
                this.form.rangofinal = null;
            } else {
                this.form.rangoinicial = rangoinicial.toString();
                this.form.rangofinal = rangofinal.toString();
                this.form.numero = null;
            }

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
        openModal: function (accion, data = []) {
            this.isOpen = true;
            this.getNumerosreservados();
            //this.getRifas();

            switch (accion) {
                case 'registrar':
                {
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
                    this.form.files1 = [];
                    this.form.files2 = [];
                    this.getDepartamentos();
                    this.getCiudades();
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
        selectRifa: function () {
            this.isOpenRifa = true;
            //this.getUsers();
            this.getRifas('','nombre_tecnico','true');
        },
        selectVendedor: function () {
            this.isOpenVendedor = true;
            //this.getUsers();
            this.getVendedores('','users.nombre','true');
        },
        closeModal: function () {
            this.isOpen = false;
            this.reset();
            this.editMode = false;
            this.verMode  = false;
            this.$page.props.errors = [];
        },
        closeMoodalRifa: function(){
            this.isOpenRifa = false;
            //this.reset();
            this.editMode = false;
            this.verMode  = false;
            this.$page.props.errors = [];
        },
        closeMoodalVendedor: function(){
            this.isOpenVendedor = false;
            //this.reset();
            this.editMode = false;
            this.verMode  = false;
            this.$page.props.errors = [];
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
        validarNumeros: function (data) {

            if (this.isIndividual == 1){
                let cifrasnum = data.numero.length;
                if (cifrasnum == data.idrifa.cifras && !isNaN(data.numero)) {
                    return true;
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: 'El número no puede ser utilizado, compruebe y vuelva a ingresar',
                        showConfirmButton: false,
                        //timer: 1500
                    })
                    return false;
                }
            } else {
                let cifrasnumini = data.rangoinicial.length;
                let cifrasnumfin = data.rangofinal.length;

                if (cifrasnumini == data.idrifa.cifras &&
                    cifrasnumfin == data.idrifa.cifras &&
                    !isNaN(data.rangoinicial) &&
                    !isNaN(data.rangofinal) ) {
                    return true;
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: 'El rango no puede ser utilizado, compruebe y vuelva a ingresar',
                        showConfirmButton: false,
                        //timer: 1500
                    })
                    return false;
                }
            }
        },
        save: function (data) {
            if(this.isIndividual == 1) {
                data.rangoinicial = '';
                data.rangofinal = '';
            } else {
                data.numero = '';
            }
            data.isIndividual = this.isIndividual;
            this.$page.props.errors = [];

            if(this.validarCreacion()) {
                if (this.validarNumeros(data)) {
                    this.$inertia.post('/numerosreservados', data, {
                        onBefore: (visit) => { console.log('onBefore');},
                        onStart: (visit) => {console.log('onStart');},
                        onProgress: (progress) => {console.log('onProgress');},
                        onSuccess: (page) => {
                            data = page;
                            console.log(data);
                            this.reset();
                            this.closeModal();
                            this.getNumerosreservados('','numerosreservados.nombre');
                            this.editMode = false;
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'La reserva se ha creado satisfactoriamente',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        },
                        onError: (errors) => {console.log('onError');},
                        onCancel: () => {console.log('onCancel');},
                        onFinish: visit => {console.log('onFinish');},
                    });
                }
            }
        },
        validarCreacion: function (){
            if (this.form.idrifa.id > 0 && this.form.idvendedor.id > 0) {
                return true;
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Por favor seleccione el vendedor y/o rifa',
                    showConfirmButton: false,
                    timer: 1500
                })
                return false;
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
        update: function (data) {
            data.fechainicio = this.dateTimeFull(data.fechainicio);
            data.fechafin = this.dateTimeFull(data.fechafin);
            console.log(data);
            data._method = 'PUT';
            this.$inertia.post('/numerosreservados/'  + data.id, data, {
                onBefore: (visit) => { console.log('onBefore');},
                onStart: (visit) => {console.log('onStart');},
                onProgress: (progress) => {console.log('onProgress');},
                onSuccess: (page) => {
                    Swal.fire(
                        'Actualización rifa',
                        'El rifa se ha actualizado!',
                        'success'
                    )
                    this.getNumerosreservados('','numerosreservados.nombre');
                    this.closeModal();
                    this.reset();
                    this.editMode = false;
                },
                onError: (errors) => {console.log('onError');},
                onCancel: () => {console.log('onCancel');},
                onFinish: visit => {console.log('onFinish');},
            });

        },
        getNumerosreservados: async function (buscar, sortBy) {
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

            var url= '/numerosreservados';
            axios.get(url, {
                params: {
                    buscar: this.buscar,
                    sortBy: this.sortBy,
                    sortOrder: sortOrderdesc,
                    ispage: this.ispage
                }
            }).then((res) => {
                var respuesta = res.data;
                this.arrayNumerosreservados = respuesta.numerosreservados;

                if (this.arrayNumerosreservados.data.length > 0) {
                    this.existenumerosreservados = 1;
                } else {
                    this.existenumerosreservados = 0;
                }
            })
        },
        getRifas: async function (buscar = '', filtro = 'nombre_tecnico', paginate = false) {

            var url= '/rifas/getRifasActivas';
            axios.get(url, {
                params: {
                    buscar: buscar,
                    filtro: filtro,
                    paginate: paginate
                }
            }).then((res) => {
                console.log(res.data);
                var respuesta = res.data;
                this.arrayRifas = respuesta.rifas;

                if (this.arrayRifas.data.length > 0) {
                    this.existerifa = 1;
                } else {
                    this.existerifa = 0;
                }
            })
        },
        getVendedores: async function (buscar = '', filtro = 'nombre', paginate = false) {

            var url= '/users/getVendedoresActivos';
            axios.get(url, {
                params: {
                    buscar: buscar,
                    filtro: filtro,
                    paginate: paginate
                }
            }).then((res) => {
                console.log(res.data);
                var respuesta = res.data;
                this.arrayVendedores = respuesta.vendedores;

                if (this.arrayVendedores.data.length > 0) {
                    this.existevendedor = 1;
                } else {
                    this.existevendedor = 0;
                }
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
                axios.post('/numerosreservados/' + data.id, data)
                .then((res) => {
                    this.getNumerosreservados('','Numerosreservados.nombre');
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

    },
    created: function () {
        //this.getPaises();
        this.arrayNumerosreservados = this.numerosreservados;
        //this.openModal('registrar')
    },
    mounted() {
        console.log('Component mounted.');
    },
}
</script>
