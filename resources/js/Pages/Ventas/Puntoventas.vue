<template>
    <AppLayout title="Puntos de Venta">
        <Statscards></Statscards>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de Puntos de Venta
            </h2>
        </template>
        <div class="py-4 px-10">
            <div class="mx-auto 2xl:8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <section>
                        <div @click="cleanMessage()" mx-auto class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-show="$page.props.flash.message">
                            <div class="flex">
                                <div>
                                    <p class="text-sm">{{ $page.props.flash.message }}</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="flex justify-between mx-auto p-4">
                            <div class="w-1/3">
                                <h1 class="font-bold text-xl text-black-800 leading-tight">
                                    Puntos de Venta
                                </h1>
                            </div>

                            <div class="w-1/3">
                                <div class="container flex justify-center items-center">
                                    <div class="relative">
                                        <div class="absolute top-4 left-3">
                                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                        <input type="text" v-model="buscar" @keyup="getPuntos(buscar,'puntos_ventas.nombre')" class="h-8 w-96 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar (Nombre, Codigo)">
                                        <button @click="getPuntos(buscar,'puntos_ventas.nombre')">
                                            <div class="absolute top-2 right-2">
                                                <Icon icon="fe:search" class="h-4"  />
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="pr-2 w-1/3 text-center">
                                <button @click="openModal('registrar')" class="bg-blue-500 text-xs  hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ">CREAR PUNTO DE VENTA</button>
                            </div>

                        </div>
                    </section>
                    <section>
                        <div class="px-4 py-2 pb-6">
                            <table class="table-fixed w-full">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getPuntos(buscar, 'puntos_ventas.codigo')" class="font-bold">
                                            Empresa
                                            <div v-show="sortBy == 'puntos_ventas.empresa.nombre'">
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
                                    <th class="px-4 py-2 text-sm font-bold  hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getPuntos(buscar, 'puntos_ventas.nombre')" class="font-bold">
                                            Nombre
                                            <div v-show="sortBy == 'puntos_ventas.nombre'">
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
                                        <button @click="getPuntos(buscar, 'puntos_ventas.descripcion')" class="font-bold">
                                            Descripción
                                            <div v-show="sortBy == 'puntos_ventas.descripcion'">
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
                                        <button @click="getPuntos(buscar, 'ciudad.nombre')" class="font-bold">
                                            Ciudad
                                            <div v-show="sortBy == 'ciudad.nombre'">
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
                                        <button @click="getPuntos(buscar, 'puntos_ventas.estado')" class="font-bold">
                                            Estado
                                            <div v-show="sortBy == 'puntos_ventas.estado'">
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
                                    <th class="px-4 py-2 text-sm font-bold w-1/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">ACCIONES</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center" v-if="existePunto > 0" v-for="(punto, id) in arrayPuntos.data" :key="id">
                                    <td class="border px-4 py-2 text-sm" v-text="punto.empresa.razon_social"></td>
                                    <td class="border px-4 py-2 text-sm" v-text="punto.nombre"></td>
                                    <td class="border px-4 py-2 text-sm" v-text="punto.descripcion"></td>
                                    <td class="border px-4 py-2 text-sm" v-text="punto.ciudad.nombre"></td>
                                    <td class="border px-4 py-2 text-sm" v-if="punto.estado">
                                        <span
                                            class="inline-flex px-2 text-sm font-semibold leading-5 text-green-800 bg-green-100 rounded-full">Activo
                                        </span>
                                    </td>
                                    <td class="border px-4 py-2 text-sm" v-else>
                                        <span
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">Inactivo
                                        </span>
                                    </td>
                                    <td class="border px-4 py-2 mx-auto text-center flex items-center">
                                        <button @click="edit(punto)" class="hover:bg-blue-700 text-white font-bold rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button @click="deleteRow(punto)" class="hover:bg-red-700 text-white font-bold rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path v-if="punto.estado" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                <path v-else fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>

                                        </button>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td class="border px-4 py-2 text-xs text-center" colspan="6"> La consulta no obtuvo datos</td>
                                </tr>
                                </tbody>
                            </table>
                            <pagination class="mt-6" :links="arrayPuntos.links" />
                        </div>
                    </section>
                    <section> <!-- Ventana modal -->
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                                <div class="inline-block lg:w-10/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <button type="button" @click="closeModal()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                    <div class="">
                                        <h2 v-text="tituloModal" class="text-sm font-bold text-gray-900 px-4 py-4"></h2>
                                    </div>
                                    <form>
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="">
                                                <section v-show="!editMode">
                                                    <div class="mb-4">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Imágenes local:</label>
                                                    </div>

                                                    <section>
                                                        <div class="max-w-screen-xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                                                            <div class="max-w-3xl mx-auto lg:max-w-none">
                                                                <div class="mt-2 sm:mt-0 sm:col-span-2">
                                                                    <div
                                                                        v-cloak
                                                                        v-on:dragover.prevent="onUploadDragoverEvent($event)"
                                                                        v-on:drop.prevent="onUploadDropEvent($event)"
                                                                        class="w-full flex justify-center items-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md h-128"
                                                                    >
                                                                        <div
                                                                            class="absolute rounded-full bg-gray-100 h-10 w-10 z-10 transition-opacity duration-500 ease-in-out"
                                                                            v-bind:class="{
                                                                                            'opacity-100': uploadDragoverTracking,
                                                                                            'opacity-0': !uploadDragoverTracking
                                                                                          }"
                                                                                            v-bind:style="{
                                                                                            left: `calc(${pageX}px - 2.5rem)`,
                                                                                            top: `calc(${pageY}px - 2.5rem)`
                                                                                          }"
                                                                        >

                                                                        </div>
                                                                        <div class="relative z-20 text-center">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                            </svg>
                                                                            <p class="mt-5 text-sm text-gray-600">
                                                                                <button type="button" class="font-medium text-pink-600 hover:text-pink-500 focus:outline-none focus:underline transition duration-150 ease-in-out"
                                                                                    v-bind:disabled="uploadDisabled"
                                                                                    v-on:click="uploadFiles"
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
                                                                        v-for="(file, index) in form.files"
                                                                        v-bind:key="index"
                                                                    >
                                                                        <a href="#" class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                                                                            <div class="px-4 py-4 sm:px-6">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div class="text-sm leading-5 font-medium text-pink-600 truncate">
                                                                                        {{ file.name }} ({{ file.size | prettyBytes }})
                                                                                    </div>
                                                                                    <div class="ml-2 flex-shrink-0 flex">
                                                                                      <span @click="removeFile(file)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
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
                                                </section>
                                                <section>
                                                    <section>
                                                        <div v-show="errorPunto" mx-auto class="bg-red-300 border-t-4 border-red-500 rounded-b text-gray-900 px-4 py-3 shadow-md my-3" role="alert" >
                                                            <div class="text-sm mx-auto text-gray-50 text-center">
                                                                <div v-for="error in errorMostrarMsjPunto" :key="error" v-text="error">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </section>

                                            <section>
                                                <div class="flex py-4">
                                                    <div class="mb-4 w-2/3 pr-4">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                                                        <input v-model="form.nombre" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Nombre">
                                                        <div v-if="$page.props.errors.nombre" class="text-red-500">{{ $page.props.errors.nombre }}</div>
                                                    </div>
                                                    <div class="mb-4 w-1/3 ">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Dirección:</label>
                                                        <input v-model="form.direccion" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" iplaceholder="Direccion" >
                                                    </div>
                                                </div>
                                                <div class="flex py-4">
                                                    <div class="mb-4 w-1/3 pr-4">
                                                        <select class="block w-full rounded-lg text-gray-700 text-sm" v-model="form.idpais" @change="getDepartamentos()">
                                                            <option value="0" >Seleccione País</option>
                                                            <option v-for="pais in arrayPaises" :key="pais.id" :value="pais.id" v-text="pais.nombre"></option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-4 w-1/3 px-4">
                                                        <select class="block w-full rounded-lg text-gray-700 text-sm" v-model="form.iddepartamento" @change="getCiudades()">
                                                            <option value="0" >Seleccione Departamento</option>
                                                            <option v-for="departamento in arrayDepartamentos" :key="departamento.id" :value="departamento.id" v-text="departamento.nombre"></option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-4 w-1/3">
                                                        <select class="block w-full rounded-lg text-gray-700 text-sm" v-model="form.idciudad">
                                                            <option value="0" >Seleccione Ciudad</option>
                                                            <option v-for="ciudad in arrayCiudades" :key="ciudad.id" :value="ciudad.id" v-text="ciudad.nombre"></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="flex py-4">
                                                    <div class="mb-4 w-1/2 pr-2">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Latitud:</label>
                                                        <input v-model="form.latitud" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Latitud">
                                                    </div>
                                                    <div class="mb-4 w-1/2 pl-2">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Altitud:</label>
                                                        <input v-model="form.altitud" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Altitud">
                                                    </div>
                                                </div>
                                                <div class="flex py-4">
                                                    <div class="mb-4 w-1/2 pr-2">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Codigo:</label>
                                                        <input v-model="form.codigo" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Codigo">
                                                    </div>
                                                    <div class="mb-4 w-1/2 text-center mx-auto">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Activo (NO):</label>
                                                        <Toggle v-model="form.estado" />
                                                    </div>
                                                </div>
                                                <div class="flex py-4">
                                                    <div class="mb-4 w-full">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                                                        <textarea v-model="form.descripcion" id="message" rows="4" class="block leading-tight w-full text-gray-700 rounded-lg border focus:ring-blue-500 focus:border-blue-500 " placeholder="Descripción"></textarea>
                                                    </div>

                                                </div>
                                            </section>
                                            </div>
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

export default {

    components: {
        Button,
        AppLayout,
        Icon,
        Pagination,
        Toggle
    },
    props:{
        puntoventas : {
            data: [],
            links: []
        },
        errors: Object
    },
    computed: {
        uploadDisabled() {
            return this.form.files.length === 0;
        },
    },
    data() {
        return {
            ispage: true,
            pageX: 0,
            pageY: 0,
            uploadDragoverTracking: false,
            uploadDragoverEvent: false,
            tituloModal: '',
            form: {
                id: null,
                nombre: null,
                direccion: null,
                idpais: 0,
                iddepartamento: 0,
                idciudad: 0,
                latitud: null,
                altitud: null,
                codigo: null,
                descripcion: null,
                url: null,
                estado: false,
                files: []
            },
            arrayPaises: [],
            arrayDepartamentos: [],
            arrayCiudades: [],
            editMode: false,
            isOpen: false,
            existePunto: 1,
            buscar: '',
            arrayPuntos: {
                data: [],
                links: []
            },
            sortOrder: 1,
            sortBy: '',
            errorPunto: 0,
            errorMostrarMsjPunto: []
        }
    },
    methods: {
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

            switch (accion) {
                case 'registrar':
                {
                    this.form.id = null;
                    this.tituloModal = 'Crear nuevo punto de venta';
                    this.form.nombre = null;
                    this.form.direccion = null;
                    this.form.idpais = 0;
                    this.form.iddepartamento = 0;
                    this.form.idciudad = 0;
                    this.form.latitud = null;
                    this.form.altitud = null;
                    this.form.codigo = null;
                    this.form.descripcion = null;
                    this.form.url = null;
                    this.form.estado = false;
                    this.form.files = [];
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
            this.editMode=false;
        },
        validarPunto(){
            this.errorPunto=0;
            this.errorMostrarMsjPunto =[];

            if (this.form.idpais == 0) this.errorMostrarMsjPunto.push("Seleccione un pais.");
            if (this.form.iddepartamento == 0) this.errorMostrarMsjPunto.push("Seleccione un departamento.");
            if (this.form.idciudad == 0) this.errorMostrarMsjPunto.push("Seleccione una ciudad.");
            if (!this.form.nombre) this.errorMostrarMsjPunto.push("El nombre del punto de venta no puede estar vacío.");
            if (!this.form.direccion) this.errorMostrarMsjPunto.push("Se requiere una dirección para el punto de venta");
            if (!this.form.codigo) this.errorMostrarMsjPunto.push("El codigo del punto de venta no puede estar vacio");
            if (!this.form.descripcion) this.errorMostrarMsjPunto.push("Por favor ingrese una descripción");

            if (this.errorMostrarMsjPunto.length) this.errorPunto = 1;

            return this.errorPunto;
        },
        reset: function () {
            this.form.id =  null;
            this.tituloModal = 'Crear nuevo punto de venta';
            this.form.nombre = null;
            this.form.direccion = null;
            this.form.idpais = 0;
            this.form.iddepartamento = 0;
            this.form.idciudad = 0;
            this.form.latitud = null;
            this.form.altitud = null;
            this.form.codigo = null;
            this.form.descripcion = null;
            this.form.url = null;
            this.form.estado = false;
            this.form.files = [];
        },
        save: function (data) {
            if (this.validarPunto()) {
                return;
            }
            this.$inertia.post('/puntoventas', data);
            this.reset();
            this.closeModal();
            this.editMode = false;
        },
        edit: function (data) {
            //this.form = Object.assign({}, data);
            this.editMode = true;
            //console.log(this.form);
            this.openModal('actualizar', data);
        },
        update: function (data) {
            if (this.validarPunto()) {
                return;
            }
            data._method = 'PUT';
            axios.post('/puntoventas/' + data.id, data
            ).then((res) => {
                Swal.fire(
                    'Actualización Puntos de venta',
                    'El punto de venta se ha actualizado!',
                    'success'
                )
                this.getPuntos('','puntos_ventas.nombre');
                this.closeModal();
                this.reset();
                this.editMode = false;
            }).catch(function (error) {
                //console.log(error);
            });

        },
        getPuntos: async function (buscar, sortBy) {
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

            var url= '/puntoventas';
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
                this.arrayPuntos = respuesta.puntoventas;

                if (this.arrayPuntos.data.length > 0) {
                    this.existePunto = 1;
                } else {
                    this.existePunto = 0;
                }
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
                mensaje = 'Desea desactivar el punto de venta?';
                title = 'Desactivado!';
                html = 'El punto de venta ha sido desactivado con éxito.';
            } else {
                mensaje = 'Desea activar el punto de venta?';
                title = 'Activado!';
                html = 'El punto de venta ha sido activado con éxito.';
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
                axios.post('/puntoventas/' + data.id, data)
                .then((res) => {
                    this.getPuntos('','puntos_ventas.nombre');
                    Swal.fire(
                        title,
                        html,
                        'success'
                    )
                }).catch(function (error) {
                    //console.log(error);
                });
                //this.$inertia.post('/puntoventas/' + data.id, data);

            })

        },

        onUploadDragoverEvent(e) {
            this.uploadDragoverEvent = true;
            this.uploadDragoverTracking = true;
            this.pageX = e.pageX;
            this.pageY = e.pageY;
        },
        onUploadDropEvent(e) {
            this.uploadDragoverEvent = false;
            this.uploadDragoverTracking = false;
            this.pageX = 0;
            this.pageY = 0;
            this.droppedFiles(e)
        },
        droppedFiles(e) {
            let droppedFiles = e.dataTransfer.files;

            if (!droppedFiles) return;

            ([...droppedFiles]).forEach(f => {
                this.form.files.push(f);
            });
        },
        droppedFileValidator(file) {
            return false;
        },
        removeFile(file) {
            this.form.files = this.form.files.filter(f => {
                return f != file;
            });
        },
        uploadFiles() {
            //console.log(this.form.files);
            // This is where the magic could happen!
        },
    },
    created: function () {
        //console.log(this.puntoventas);
        this.arrayPuntos = this.puntoventas;
    },
    mounted() {
        //console.log('Component mounted.');
    },
}
</script>
