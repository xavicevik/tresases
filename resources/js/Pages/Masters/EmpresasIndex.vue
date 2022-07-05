<template>
    <AppLayout title="Empresas">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de Empresas
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
                                    Empresas
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
                                        Razon social
                                    </th>
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Documento
                                    </th>
                                    <th class="px-4 py-2 w-3/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Ciudad
                                    </th>
                                    <th class="px-4 py-2 w-3/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Teléfono
                                    </th>
                                    <th class="px-4 py-2 w-3/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Tipo empresa
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-1/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Estado
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center hover:bg-blue-100" @click="selectDetalle(dato)" text-sm v-if="existedata > 0" v-for="(dato, id) in arrayData.data" :key="id">
                                    <td class="border px-1 py-2 text-sm text-blue-800 underline truncate" >
                                        <button @click="showDetalle(dato)">{{ dato.razon_social }}</button>
                                    </td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.tipodocumento.nombre_corto + ' ' + dato.documento + '-' + dato.digit"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.ciudad.nombre"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.telefono"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.tipoempresa.nombre"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-if="dato.estado">
                                        <span class="inline-flex px-2 text-sm font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                            Activo
                                        </span>
                                    </td>
                                    <td class="border px-2 py-2 text-sm" v-else>
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                            Inactivo
                                        </span>
                                    </td>
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



                    <!-- Detalles -->
                    <!-- Fin Encabezado y titulo -->
                    <!-- Distribuidores -->
                    <section>
                        <div class="w-1/2 p-4">
                            <h1 v-if="datos.idtipoempresa == 1" class="font-bold text-xl text-black-800 leading-tight">
                                Distribuidor
                            </h1>
                            <h1 v-else class="font-bold text-xl text-black-800 leading-tight">
                                Vendedor
                            </h1>
                        </div>
                        <div class="lg:px-4 md:px-2 sm:px-0 py-2 pb-6 overflow-y-auto h-40">
                            <table class="table-fixed w-full">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Razón social
                                    </th>
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Documento
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Ciudad
                                    </th>
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Teléfono
                                    </th>
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Tipo empresa
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Estado
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center hover:bg-blue-100 text-sm" @click="selectDetalleHijo(dato)" v-if="datos.hijos.length > 0" v-for="(dato, id) in datos.hijos" :key="id">
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.razon_social"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.documento"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.ciudad.nombre"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.telefono"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.tipoempresa.nombre"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-if="dato.estado">
                                        <span class="inline-flex px-2 text-sm font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                            Activo
                                        </span>
                                    </td>
                                    <td class="border px-2 py-2 text-sm" v-else>
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                            Inactivo
                                        </span>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td class="border px-4 py-2 text-xs text-center" colspan="6"> La consulta no obtuvo datos</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </section>
                    <!-- Fin Detalles -->

                    <!-- Vendedores -->
                    <section v-show="datos1.idtipoempresa == 2 && datos.idtipoempresa == 1">
                        <div class="w-1/2 p-4">
                            <h1 class="font-bold text-xl text-black-800 leading-tight">
                                Vendedor
                            </h1>
                        </div>
                        <div class="lg:px-4 md:px-2 sm:px-0 py-2 pb-6 overflow-y-auto h-40">
                            <table class="table-fixed w-full">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Razón social
                                    </th>
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Documento
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Ciudad
                                    </th>
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Teléfono
                                    </th>
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Tipo empresa
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Estado
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center" text-sm v-if="datos1.hijos.length > 0" v-for="(dato, id) in datos1.hijos" :key="id">
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.razon_social"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.documento"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.ciudad.nombre"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.telefono"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.tipoempresa.nombre"></td>
                                    <td class="border px-2 py-2 text-sm truncate" v-if="dato.estado">
                                        <span class="inline-flex px-2 text-sm font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                            Activo
                                        </span>
                                    </td>
                                    <td class="border px-2 py-2 text-sm" v-else>
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                            Inactivo
                                        </span>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td class="border px-4 py-2 text-xs text-center" colspan="6"> La consulta no obtuvo datos</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </section>
                    <!-- Fin Detalles -->


                    <!-- Ventana modal Detalles -->
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
                                    <!-- Menu Tabs -->
                                    <section>
                                        <div class="border-b border-gray-200 dark:border-gray-700">
                                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                                                <li class="mr-2">
                                                    <a href="#" v-on:click="activetab='1'" v-bind:class="[ activetab === '1' ? ' text-blue-600 border-blue-600 active ' : ' text-gray-400 border-transparent hover:text-gray-900 hover:border-gray-900 ' ]" class="inline-flex p-4 rounded-t-lg border-b-2 group">
                                                        <svg v-bind:class="[ activetab === '1' ? 'group-active:text-blue-600 text-blue-600 ' : ' group-active:text-gray-600 text-gray-400 group-hover:text-gray-500 ']" class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                                        </svg>Información
                                                    </a>
                                                </li>
                                                <li class="mr-2">
                                                    <a href="#" v-on:click="activetab='2'" v-bind:class="[ activetab === '2' ? ' text-blue-600 border-blue-600 active ' : ' text-gray-400 border-transparent hover:text-gray-900 hover:border-gray-900 ' ]" class="inline-flex p-4 rounded-t-lg border-b-2 group">
                                                        <svg v-bind:class="[ activetab === '2' ? 'group-active:text-blue-600 text-blue-600 ' : ' group-active:text-gray-600 text-gray-400 group-hover:text-gray-500 ']" class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                                        </svg>Distribuidores
                                                    </a>
                                                </li>
                                                <li class="mr-2">
                                                    <a href="#" v-on:click="activetab='3'" v-bind:class="[ activetab === '3' ? ' text-blue-600 border-blue-600 active ' : ' text-gray-400 border-transparent hover:text-gray-900 hover:border-gray-900 ' ]" class="inline-flex p-4 rounded-t-lg border-b-2 group">
                                                        <svg v-bind:class="[ activetab === '2' ? 'group-active:text-blue-600 text-blue-600 ' : ' group-active:text-gray-600 text-gray-400 group-hover:text-gray-500 ']" class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z"></path>
                                                        </svg>Vendedores
                                                    </a>
                                                </li>
                                                <li class="mr-2">
                                                    <a href="#" v-on:click="activetab='4'" v-bind:class="[ activetab === '4' ? ' text-blue-600 border-blue-600 active ' : ' text-gray-400 border-transparent hover:text-gray-900 hover:border-gray-900 ' ]" class="inline-flex p-4 rounded-t-lg border-b-2 group">
                                                        <svg v-bind:class="[ activetab === '4' ? 'group-active:text-blue-600 text-blue-600 ' : ' group-active:text-gray-600 text-gray-400 group-hover:text-gray-500 ']" class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                                                        </svg>Puntos de Venta
                                                    </a>
                                                </li>
                                                <li class="mr-2">
                                                    <a href="#" v-on:click="activetab='5'" v-bind:class="[ activetab === '5' ? ' text-blue-600 border-blue-600 active ' : ' text-gray-400 border-transparent hover:text-gray-900 hover:border-gray-900 ' ]" class="inline-flex p-4 rounded-t-lg border-b-2 group">
                                                        <svg v-bind:class="[ activetab === '5' ? 'group-active:text-blue-600 text-blue-600 ' : ' group-active:text-gray-600 text-gray-400 group-hover:text-gray-500 ']" class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                                                        </svg>Configuración
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </section>
                                    <!-- Fin Menu Tabs -->
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

                                                <!-- Seccion menu 1 -->
                                                <section v-if="activetab ==='1'" >
                                                    <div class="flex py-0">
                                                        <div class="mb-4 w-1/3 px-2">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Razón social</label>
                                                            {{ datos.razon_social }}
                                                        </div>
                                                        <div class="mb-4 w-1/3 px-2">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Documento</label>
                                                            {{ datos.tipodocumento.nombre_corto + ' ' +datos.documento + '-' + datos.digito?datos.digito:0 }}
                                                        </div>
                                                        <div class="mb-4 w-1/3 px-2">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Ciudad</label>
                                                            {{ datos.ciudad.nombre}}
                                                        </div>
                                                    </div>
                                                    <div class="flex py-1 w-full">
                                                        <div class="mb-4 w-1/3 px-2">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Persona natural</label>
                                                            {{ datos.isnatural?'Si': 'No' }}
                                                        </div>
                                                        <div class="mb-4 w-1/3 px-2">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Rut</label>
                                                            {{ datos.rut }}
                                                        </div>
                                                        <div class="mb-4 w-1/3 px-2">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Camara de comercio</label>
                                                            {{ datos.camaracomercio }}
                                                        </div>
                                                    </div>
                                                    <div class="flex py-1 w-full">
                                                        <div class="mb-4 w-full" >
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">URL</label>
                                                            {{ datos.url }}
                                                        </div>
                                                        <div class="mb-4 w-full" >
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Tipo empresa</label>
                                                            {{ datos.tipoempresa.nombre }}
                                                        </div>
                                                        <div class="mb-4 w-full" >
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Dirección</label>
                                                            {{ datos.direccion }}
                                                        </div>
                                                    </div>

                                                </section>
                                                <!-- Fin seccion menu 1 -->
                                                <!-- Seccion menu 2 -->
                                                <section v-if="activetab ==='2'" >
                                                    <section>
                                                        <div class="w-1/2 pl-4">
                                                            <h1 class="font-bold text-xl text-black-800 leading-tight">
                                                                Distribuidores
                                                            </h1>
                                                        </div>
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
                                                                <tr class="text-center hover:bg-blue-100" text-sm v-if="datos.distribuidores.length > 0" v-for="(dato, id) in datos.distribuidores" :key="id">
                                                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.nombre"></td>
                                                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.correo"></td>
                                                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.idpais"></td>
                                                                </tr>
                                                                <tr v-else>
                                                                    <td class="border px-4 py-2 text-xs text-center" colspan="3"> La consulta no obtuvo datos</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </section>

                                                </section>
                                                <!-- Fin seccion menu 2 -->
                                                <!-- Seccion menu 3 -->
                                                <section v-if="activetab ==='3'" >
                                                    <section>
                                                        <div class="w-1/2 pl-4">
                                                            <h1 class="font-bold text-xl text-black-800 leading-tight">
                                                                Vendedores
                                                            </h1>
                                                        </div>
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
                                                                <tr class="text-center hover:bg-blue-100" text-sm v-if="datos.vendedores.length > 0" v-for="(dato, id) in datos.vendedores" :key="id">
                                                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.nombre"></td>
                                                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.correo"></td>
                                                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.idpais"></td>
                                                                </tr>
                                                                <tr v-else>
                                                                    <td class="border px-4 py-2 text-xs text-center" colspan="3"> La consulta no obtuvo datos</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </section>

                                                </section>
                                                <!-- Fin seccion menu 3 -->

                                                <!-- Seccion menu 4 -->
                                                <section v-if="activetab ==='4'" >
                                                    <section>
                                                        <div class="w-1/2 pl-4">
                                                            <h1 class="font-bold text-xl text-black-800 leading-tight">
                                                                Vendedores
                                                            </h1>
                                                        </div>
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
                                                                <tr class="text-center hover:bg-blue-100" text-sm v-if="datos.vendedores.length > 0" v-for="(dato, id) in datos.vendedores" :key="id">
                                                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.nombre"></td>
                                                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.correo"></td>
                                                                    <td class="border px-2 py-2 text-sm truncate" v-text="dato.idpais"></td>
                                                                </tr>
                                                                <tr v-else>
                                                                    <td class="border px-4 py-2 text-xs text-center" colspan="3"> La consulta no obtuvo datos</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </section>

                                                </section>
                                                <!-- Fin seccion menu 4 -->

                                                <!-- Seccion menu 5 -->
                                                <section v-if="activetab ==='5'" >
                                                    <div class="flex py-0">
                                                        <div class="mb-4 w-1/3 px-2">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Comisión</label>
                                                            {{ datos.razon_social }}
                                                        </div>
                                                        <div class="mb-4 w-1/3 px-2">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Comisión Distribuidor</label>
                                                            {{ datos.tipodocumento.nombre_corto + ' ' +datos.documento + '-' + datos.digito?datos.digito:0 }}
                                                        </div>
                                                        <div class="mb-4 w-1/3 px-2">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Comisión Vendedores</label>
                                                            {{ datos.ciudad.nombre}}
                                                        </div>
                                                    </div>
                                                    <div class="flex py-1 w-full">
                                                        <div class="mb-4 w-1/3 px-2">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Persona natural</label>
                                                            {{ datos.isnatural?'Si': 'No' }}
                                                        </div>
                                                        <div class="mb-4 w-1/3 px-2">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Rut</label>
                                                            {{ datos.rut }}
                                                        </div>
                                                        <div class="mb-4 w-1/3 px-2">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Camara de comercio</label>
                                                            {{ datos.camaracomercio }}
                                                        </div>
                                                    </div>
                                                    <div class="flex py-1 w-full">
                                                        <div class="mb-4 w-full" >
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">URL</label>
                                                            {{ datos.url }}
                                                        </div>
                                                        <div class="mb-4 w-full" >
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Tipo empresa</label>
                                                            {{ datos.tipoempresa.nombre }}
                                                        </div>
                                                        <div class="mb-4 w-full" >
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Dirección</label>
                                                            {{ datos.direccion }}
                                                        </div>
                                                    </div>

                                                </section>
                                                <!-- Fin seccion menu 5 -->
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
                    <!-- Fin Ventana modal Detalles -->


                    <!-- Fin Tabla de contenido -->
                    <!-- Ventana modal 2 -->
                    <section>
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen2" @click="closeModal()">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​


                                <!-- Contenido modal -->
                                <div class="inline-block lg:w-6/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <div class="">
                                        <h2 class="text-xl font-bold text-gray-900 px-4 py-2">Terminos y condiciones</h2>
                                    </div>
                                    <!-- Inicio Form -->
                                        <div class="bg-white px-4 pt-2 pb-2 sm:p-6 sm:pb-4">

                                            <div class="flex-1 py-1">
                                                <label class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
                                                <QuillEditor theme="snow" contentType="html" v-model:content="terminos" class="block w-full p-8  leading-tight text-gray-700 rounded-lg border focus:ring-blue-500 focus:border-blue-500 " placeholder=""/>
                                            </div>

                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <button @click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                                Cancelar
                                          </button>
                                        </div>
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
import { Icon } from '@iconify/vue';
import Pagination from '@/Components/Pagination';

import Toggle from '@vueform/toggle';
import '@vueform/toggle/themes/default.css';
import Button from "../../Jetstream/Button";

import moment from 'moment'
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { Money3Component } from 'v-money3'

import { Head, Link } from '@inertiajs/inertia-vue3';
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
            activetab: '1',
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
            datos: {
                hijos: [],
                tipoempresa: [],
                tipodocumento: [],
                mayoristas: [],
                vendedores: [],
                distribuidores: [],
            },
            datos1: {
                hijos: [],
                tipoempresa: [],
                tipodocumento: [],
                mayoristas: [],
                vendedores: [],
                distribuidores: [],
            },
            editMode: false,
            verMode: false,
            isOpen: false,
            buscar: '',
            sortOrder: 1,
            sortBy: '',
            errornumerosreservados: 0,
            existedata: 0,
            terminos: null
        }
    },
    methods: {
        showDetalle: function (data) {
            this.selectDetalle(data);
            this.isOpen = true;
        },
        selectDetalle: function (data) {
            this.datos = data;
        },
        selectDetalleHijo: function (data) {
            this.datos1 = data;
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
        openModal: function (data) {
            this.isOpen = true;
            this.terminos = data;
        },
        closeModal: function () {
            this.isOpen = false;
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

            var url= '/master/empresas';
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
    },
    created: function () {
        this.arrayData = this.data;
        if (this.arrayData.data.length > 0) {
            this.existedata = 1;
        } else {
            this.existedata = 0;
        }
    },
    mounted() {
        //console.log('Component mounted.');
    },
}
</script>
