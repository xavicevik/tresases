<template>
    <AppLayout title="Movimientos de Caja">
        <Statscards></Statscards>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Movimientos de caja
            </h2>
        </template>
        <div class="py-4 lg:px-8 md:px-6 sm:px-2">
            <div class="mx-auto 2xl:8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <!-- Encabezado y titulo -->
                    <section>
                        <div class="flex justify-between mx-auto p-4">
                            <div class="w-1/3">
                                <h1 class="font-bold text-xl text-black-800 leading-tight">
                                    Movimientos de Caja
                                </h1>
                            </div>

                            <div class="w-1/3">

                            </div>
                            <div class="flex w-1/4">
                                <div class="w-1/2 text-center">
                                    <button @click="openModal('registrar')" class="bg-blue-500 text-xs  hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ">Registrar</button>
                                </div>
                                <div class="w-1/2 text-center">
                                    <button @click="openModal('eliminar')" class="bg-red-500 text-xs  hover:bg-red-700 text-white font-bold py-2 px-4 rounded ">Anular</button>
                                </div>
                                <div class="w-1/2 text-center">
                                    <button @click="cerrar()" class="bg-green-500 text-xs  hover:bg-green-700 text-white font-bold py-2 px-4 rounded ">Cerrar</button>
                                </div>
                            </div>

                        </div>
                    </section>
                    <!-- Fin Encabezado y titulo -->


                    <section>
                        <div class="flex relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 ">
                                <tr class="flex bg-white border-b ">
                                    <th scope="col" class="w-1/2 px-6 py-2 font-medium text-black font-bold">
                                        Fecha:
                                    </th>
                                    <th scope="col" class="w-1/2 px-6 py-2 font-medium">
                                        {{ caja.fechaapertura }}
                                    </th>
                                </tr>
                                <tr class="flex bg-white border-b ">
                                    <th scope="col" class="w-1/2 px-6 py-2 font-medium text-black font-bold">
                                        Perfil:
                                    </th>
                                    <th scope="col" class="w-1/2 px-6 py-2 font-medium">
                                        {{ $page.props.auth.user.roles[0].name }}
                                    </th>
                                </tr>
                                <tr class="flex bg-white border-b ">
                                    <th scope="col" class="w-1/2 px-6 py-2 font-medium text-black font-bold">
                                        Responsable:
                                    </th>
                                    <th scope="col" class="w-1/2 px-6 py-2 font-medium">
                                        {{ $page.props.user.username + ' - ' + $page.props.user.full_name  }}
                                    </th>
                                </tr>
                            </table>
                            <table class="w-full text-sm text-left text-gray-500 ">
                                <tr class="flex bg-white border-b ">
                                    <th scope="col" class="w-1/2 px-6 py-2 font-medium text-black font-bold">
                                        Saldo Inicial:
                                    </th>
                                    <th scope="col" class="w-1/2 px-6 py-2 font-medium">
                                        {{ caja.montoapertura }}
                                    </th>
                                </tr>
                                <tr class="flex bg-white border-b ">
                                    <th scope="col" class="w-1/2 px-6 py-2 font-medium text-black font-bold">
                                        Saldo Final:
                                    </th>
                                    <th scope="col" class="w-1/2 px-6 py-2 font-medium">
                                        {{ formatPrice(totaltransaccion - totalcomisiones) }}
                                    </th>
                                </tr>
                                <tr class="flex bg-white border-b ">
                                    <th scope="col" class="w-1/2 px-6 py-2 font-medium text-black font-bold">
                                        Punto de Venta:
                                    </th>
                                    <th scope="col" class="w-1/2 px-6 py-2 font-medium">
                                        {{ caja.puntoventa.nombre }}
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </section>
                    <!-- Fin Encabezado y titulo -->

                    <section>
                        <br>
                        <div class="w-1/3">
                            <h3 class="font-bold text-xl text-black-800 leading-tight">
                                Transacciones
                            </h3>
                        </div>
                    </section>

                    <!-- Tabla de contenido -->
                    <section>
                        <div class="lg:px-4 w-full md:px-2 sm:px-0 py-2 pb-6 overflow-x-scroll">
                            <table class="table-fixed w-full">
                                <thead>
                                <tr class="text-left bg-gray-100">
                                    <th class="w-20 px-4 py-2 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
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
                                    <th class="px-4 py-2 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
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
                                    <th class="px-4 py-2 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Valor Total
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
                                    <th class="px-4 py-2 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Comisión
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
                                    <th class="px-4 py-2 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Cantidad
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
                                    <th class="px-4 py-2 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Recibo
                                        </button>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr :class="dato.id === selectedRow ? 'bg-blue-200' : ''"  class="text-left hover:bg-blue-400" @click="rowSelect(dato.id); getDetalles(dato.id)" text-sm v-if="arrayData.data" v-for="(dato, id) in arrayData.data" :key="id">
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.id"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.vendedor.full_name"></td>
                                    <td class="border px-1 py-2 text-sm truncate" :class="{ 'text-red-400':dato.valorventa < 0 }" v-text="formatPrice(dato.valorventa)"></td>
                                    <td class="border px-1 py-2 text-sm truncate" :class="{ 'text-red-400':-dato.comision < 0 }" v-text="formatPrice(-dato.comision)"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.cantidad"></td>
                                    <td class="border px-1 py-2 text-sm truncate">
                                        <a :href="dato.urlrecibo" target="_blank" class="hover:bg-red-700 text-red-400 font-bold rounded" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td class="border px-4 py-2 text-xs text-center" colspan="5"> La consulta no obtuvo datos</td>
                                </tr>
                                <tr class="text-left hover:bg-blue-400">
                                    <td class="border font-bold px-1 py-2 text-sm truncate">Total:</td>
                                    <td class="border font-bold px-1 py-2 text-sm truncate"></td>
                                    <td class="border font-bold px-1 py-2 text-sm truncate">{{ formatPrice(totaltransaccion) }}</td>
                                    <td class="border font-bold px-1 py-2 text-sm truncate">{{ formatPrice(totalcomisiones) }}</td>
                                    <td class="border font-bold px-1 py-2 text-sm truncate">{{ totalboletas }}</td>
                                    <td class="border font-bold px-1 py-2 text-sm truncate"></td>
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
                                                     v-on:click="this.cambiarPage(link.url, 'movimientos', form, idVenta)"
                                                     v-html="link.label" />
                                        </template>
                                    </div>
                                </div>
                            </section>
                            <!-- Paginacion -->
                        </div>
                    </section>
                    <!-- Fin Tabla de contenido -->


                    <!-- Tabla de Detalle -->
                    <section>
                        <div class="lg:px-4 md:px-2 sm:px-0 py-2 pb-6 overflow-y-auto h-50">
                            <h4 class="font-semibold text-xl text-gray-800 leading-tight">
                                Detalle de la venta
                            </h4>
                            <table class="table-fixed w-full">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Id
                                    </th>
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Rifa
                                    </th>
                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Boleta
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Cliente
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Valor Boleta
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Valor pagado
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Comisión vendedor
                                    </th>
                                    <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        Recibo/SMS/Anular
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center" text-sm v-if="arrayDetalles.data" v-for="(dato, id) in arrayDetalles.data" :key="id">
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.id"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.rifa.nombre_tecnico"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.numero"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="dato.cliente.nombre+' '+dato.cliente.apellido"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="formatPrice(dato.valortotal)"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="formatPrice(dato.valor)"></td>
                                    <td class="border px-1 py-2 text-sm truncate" v-text="formatPrice(dato.comision)"></td>
                                    <td class="flex border px-1 py-2 text-sm truncate">
                                        <a :href="route('numerosreservados.reportpdfCliente', {'iddetalleventa' : dato.id})" target="_blank" class="hover:bg-red-700 text-red-400 font-bold rounded" fill="none"
                                           viewBox="0 0 24 24" stroke="currentColor">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </a>
                                        <a href="#" @click="sendSMS(dato.id)" class="hover:bg-blue-700 text-blue-400 font-bold rounded" fill="none"
                                           viewBox="0 0 24 24" stroke="currentColor">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                                            </svg>
                                        </a>
                                        <a href="#" v-show="dato.estado != 6" @click="anularVenta(dato.id)" class="hover:bg-blue-700 text-blue-400 font-bold rounded" fill="none"
                                           viewBox="0 0 24 24" stroke="currentColor">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td class="border px-4 py-2 text-xs text-center" colspan="6"> La consulta no obtuvo datos</td>
                                </tr>
                                </tbody>
                            </table>
                            <!-- Paginacion -->
                            <section class="mt-6">
                                <div v-if="arrayDetalles.links.length > 3">
                                    <div class="flex flex-wrap -mb-1">
                                        <template v-for="(link, p) in arrayDetalles.links" :key="p">
                                            <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                                                 v-html="link.label" />
                                            <button  v-else
                                                     class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                                                     :class="{ 'bg-blue-700 text-white': link.active }"
                                                     v-on:click="this.cambiarPage(link.url, 'detalles', form, idVenta)"
                                                     v-html="link.label" />
                                        </template>
                                    </div>
                                </div>
                            </section>
                            <!-- Paginacion -->
                        </div>
                    </section>
                    <!-- Fin Tabla de Detalle -->


                    <!-- Ventana modal Crear movimiento-->
                    <section>
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                            <div class="flex items-end justify-center h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

                                <!-- Contenido modal -->
                                    <div class="inline-block lg:w-8/12 align-bottom bg-white rounded-lg text-left h-fit shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                        <button type="button" @click="closeModal()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </button>
                                    <div class="">
                                        <h2 v-text="tituloModal" class="text-xl font-bold text-gray-900 px-4 py-2"></h2>
                                    </div>
                                    <div class="mx-auto text-center w-full border-1">
                                        <vue-countdown ref="countdown" class="p-2 border-2 border-gray-800 rounded-md mx-auto text-blue-700" :time="time" v-slot="{ minutes, seconds }" @end="onCountdownEnd">
                                            Tiempo restante：{{ minutes }} min, {{ seconds }} seg.
                                        </vue-countdown>
                                    </div>
                                    <!-- Inicio Form -->
                                    <div class="bg-white px-4 pt-2 pb-2 sm:p-6 sm:pb-4">
                                        <div class="">

                                            <!-- Fin Mensajes Flash -->
                                        <!-- Formulario -->
                                        <section>
                                            <div class="flex py-1">
                                                <div class="mb-4 w-full pr-2">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Rifa</label>

                                                    <input v-model="form.idrifa.titulo" @click="selectRifa()" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Seleccione Rifa">

                                                    <div v-if="$page.props.errors.rifa" class="text-red-500">{{ $page.props.errors.rifa }}</div>
                                                </div>
                                            </div>
                                            <div class="flex py-1">
                                                <div class="mb-4 w-full pr-2">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Vendedor</label>

                                                    <input v-model="form.idvendedor.full_name" @click="selectVendedor()" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Seleccione Vendedor">

                                                    <div v-if="$page.props.errors.vendedor" class="text-red-500">{{ $page.props.errors.vendedor }}</div>
                                                </div>
                                            </div>
                                        </section>
                                         <section>

                                            <div class="flex py-1 w-full max-h-fit overflow-y-scroll">
                                                <div class="mb-4 w-full">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Número</label>

                                                    <div class="container flex justify-center items-center">
                                                        <div class="relative pt-4">
                                                            <div class="absolute top-4 left-3">
                                                                <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                                                <money3 v-bind="configMoney2" v-model="form.reserva.numero" @keypress.enter="valBoletaDisponible(form.reserva.numero, form.idrifa.id, form.idvendedor.id, form.idcliente.id)" class="h-8 w-96 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none"></money3>
                                                                <a @click="valBoletaDisponible(form.reserva.numero, form.idrifa.id, form.idvendedor.id, form.idcliente.id)">
                                                                    <div class="absolute top-6 right-4">
                                                                        <Icon icon="fe:search" class="h-4"  />
                                                                    </div>
                                                                </a>
                                                        </div>
                                                        <div v-if="asignarMode" class="flex pl-8 pt-8">
                                                            <button @click="generarReciboAsignar()" class="hover:bg-green-700 text-green-400 font-bold rounded" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                            </button>
                                                            <label>Registrar e Imprimir</label>

                                                        </div>
                                                        <div v-if="eliminarMode" class="flex pl-8 pt-8">
                                                            <button @click="generarReciboEliminar()" class="hover:bg-red-700 text-red-400 font-bold rounded" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                            </button>
                                                            <label>Anular e Imprimir</label>

                                                        </div>
                                                    </div>

                                                        <div class="flex py-1 px-2 font-bold">
                                                            <div class="w-1/5">
                                                                Número
                                                            </div>
                                                            <div class="w-1/5 px-2">
                                                                Promocional
                                                            </div>
                                                            <div class="w-1/5 px-2">
                                                                Valor Total
                                                            </div>
                                                            <div class="w-2/5 px-2">
                                                                {{ asignarMode?'Valor a pagar':'Valor a anular' }}
                                                            </div>
                                                            <div class="w-2/5 px-2">
                                                                Cliente
                                                            </div>
                                                            <div class="w-1/5 px-2">
                                                                Eliminar
                                                            </div>
                                                        </div>
                                                        <div v-for="(reserva, index) in form.reservas" :key="reserva.numero" class="bg-blue-200 rounded-md flex py-1 px-2">
                                                            <div class="w-1/5">
                                                                {{ reserva.numero }}
                                                            </div>
                                                            <div class="w-1/5 px-2">
                                                                {{ reserva.promocional }}
                                                            </div>
                                                            <div class="w-1/5 px-2">
                                                                {{ formatPrice(reserva.valortotal) }}
                                                            </div>
                                                            <div class="w-2/5 px-2">
                                                                <money3 v-if="asignarMode" v-bind="configMoney" @focusout="pushSessionDetail(session.id, reserva, 'upd')" :max="reserva.valorsaldo" v-model="reserva.valorpagar" class="h-8 w-full pl-4 pr-4 rounded-md z-0 focus:shadow focus:outline-none"></money3>
                                                                <money3 v-else v-bind="configMoney" :max="reserva.valoranular" v-model="reserva.valorpagado" class="h-8 w-full pl-4 pr-4 rounded-md z-0 focus:shadow focus:outline-none"></money3>
                                                            </div>
                                                            <div class="w-3/5 px-2">
                                                                <input type="hidden" v-model="reserva.idcliente">
                                                                <input v-model="reserva.cliente" :disabled="eliminarMode" @keyup.enter="selectCliente(index, reserva)" type="text" class="h-8 w-full pl-4 pr-4 rounded-md z-0 focus:shadow focus:outline-none" placeholder="Cliente">
                                                            </div>
                                                            <div class="w-1/10 px-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" @click="eliminarReserva(reserva, index)" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="bg-blue-400 rounded-md flex py-1 px-2 font-bold">
                                                            <div class="w-1/5">
                                                                Total:
                                                            </div>
                                                            <div class="w-1/5 px-2">

                                                            </div>
                                                            <div class="w-1/5 px-2">
                                                                {{ formatPrice(totalmovimiento) }}
                                                            </div>
                                                            <div class="w-2/5 px-2">
                                                                {{ formatPrice(totalapagar) }}
                                                            </div>
                                                            <div class="w-3/5 px-2">
                                                                Cantidad:
                                                            </div>
                                                            <div class="w-1/5 px-2">
                                                                {{ form.reservas.length }}
                                                            </div>
                                                        </div>

                                                </div>
                                            </div>
                                         </section>
                                        <!-- Fin formulario -->
                                        </div>
                                    </div>
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
                                <button type="button" @click="closeMoodalRifa()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                </button>
                                <div class="fixed inset-0 transition-opacity" @click="closeMoodalRifa()">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

                                <!-- Contenido modal -->
                                <div class="inline-block lg:w-7/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <button type="button" @click="closeMoodalRifa()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
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
                                                            <input type="text" v-model="buscar" @keyup.enter="getRifas(buscar,'nombre_tecnico', true)" class="h-8 w-26 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar (nombre_tecnico)">
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
                                                <tr @click="onSelectRifa(rifa)" class="hover:bg-blue-50 text-center" text-sm v-if="arrayRifas.data" v-for="(rifa, id) in arrayRifas.data" :key="id">
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
                                                                          v-on:click="cambiarPage(link.url, 'rifas')"
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
                                <button type="button" @click="closeMoodalVendedor()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                </button>
                                <div class="fixed inset-0 transition-opacity" @click="closeMoodalVendedor()">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

                                <!-- Contenido modal -->
                                <div class="inline-block lg:w-7/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <section>
                                        <div class="flex justify-between mx-auto p-4">
                                            <button type="button" @click="closeMoodalVendedor()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </button>
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
                                                        <input type="text" v-model="buscar" @keyup.enter="getVendedores(buscar,'documento', true)" class="h-8 w-26 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar (Nombre, apellido)">
                                                        <button @click="getVendedores(buscar,'documento', true)">
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
                                                <tr @click="onSelectVendedor(vendedor)" class="hover:bg-blue-50 text-center" text-sm v-if="arrayVendedores.data" v-for="(vendedor, id) in arrayVendedores.data" :key="id">
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="vendedor.full_name"></td>
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="vendedor.documento"></td>
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="vendedor.correo"></td>
                                                </tr>
                                                <tr v-else>
                                                    <td class="border px-4 py-2 text-xs text-center" colspan="5"> La consulta no obtuvo datos</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!-- Paginacion -->
                                            <section class="mt-6">
                                                <div v-if="arrayVendedores.links.length > 3">
                                                    <div class="flex flex-wrap -mb-1">
                                                        <template v-for="(link, p) in arrayVendedores.links" :key="p">
                                                            <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                                                                 v-html="link.label" />
                                                            <button  v-else
                                                                     class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                                                                     :class="{ 'bg-blue-700 text-white': link.active }"
                                                                     v-on:click="this.cambiarPage(link.url, 'vendedores', form)"
                                                                     v-html="link.label" />
                                                        </template>
                                                    </div>
                                                </div>
                                            </section>
                                            <!-- Paginacion -->

                                        </div>
                                    </section>
                                    <!-- Fin form -->
                                </div>
                                <!-- Fin Contenido modal -->
                            </div>
                        </div>
                    </section>
                    <!-- Fin Ventana modal  Vendedores -->

                    <!-- Ventana modal buscar cliente-->
                    <section>
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpenCliente">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" @click="closeModalCliente()">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>

                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

                                <!-- Contenido modal -->
                                <div class="inline-block lg:w-6/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <button type="button" @click="closeModalCliente()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                    <section>
                                        <div class="flex justify-between mx-auto p-4">
                                            <div class="w-1/2">
                                                <h1 class="font-bold text-xl text-black-800 leading-tight">
                                                    Buscar Clientes
                                                </h1>
                                                <a href="#" @click="crearCliente()">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            </div>

                                            <div class="w-1/2 pr-2">
                                                <div class="container flex justify-center items-center">
                                                    <div class="relative">
                                                        <div class="absolute top-4 left-3">
                                                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                                        <input type="text" v-model="buscarcliente" @keyup.enter="getClientes(buscarcliente,'documento, nombre', true)" class="h-8 w-26 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar (documento, nombre)">
                                                        <button @click="getClientes(buscarcliente,'documento, nombre', true)">
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
                                                <tr class="bg-gray-100 hover:bg-blue-500 hover:text-gray-50">
                                                    <th class="px-4 py-2 w-2/12 text-sm font-bold rounded-b">
                                                        <button @click="getRifas('', 'idloteria')" class="font-bold">
                                                            Nombre
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
                                                    <th class="px-4 py-2 w-1/12 text-sm font-bold rounded-b">
                                                        <button @click="getRifas(buscar, 'loteria.nombre')" class="font-bold">
                                                            Documento
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
                                                    <th class="px-4 py-2 w-1/12 text-sm font-bold rounded-b">
                                                        <button @click="getRifas(buscar, 'serie')" class="font-bold">
                                                            Movil
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
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr @click="onSelectCliente(cliente)" class="hover:bg-blue-100 text-center" text-sm v-if="arrayClientes.data" v-for="(cliente, id) in arrayClientes.data" :key="id">
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="cliente.nombre + ' ' + cliente.apellido"></td>
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="cliente.documento"></td>
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="cliente.movil"></td>
                                                </tr>
                                                <tr v-else>
                                                    <td class="border px-4 py-2 text-xs text-center" colspan="4"> La consulta no obtuvo datos</td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <!-- Paginacion -->
                                            <section class="mt-6">
                                                <div v-if="arrayClientes.links.length > 3">
                                                    <div class="flex flex-wrap -mb-1">
                                                        <template v-for="(link, p) in arrayClientes.links" :key="p">
                                                            <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                                                                 v-html="link.label" />
                                                            <button  v-else
                                                                     class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                                                                     :class="{ 'bg-blue-700 text-white': link.active }"
                                                                     v-on:click="this.cambiarPage(link.url, 'clientes', form, idVenta)"
                                                                     v-html="link.label" />
                                                        </template>
                                                    </div>
                                                </div>
                                            </section>
                                            <!-- Paginacion -->


                                        </div>
                                    </section>
                                    <!-- Fin form -->
                                </div>
                                <!-- Fin Contenido modal -->
                            </div>
                        </div>
                    </section>
                    <!-- Fin Ventana modal buscar cliente -->

                    <!-- Ventana modal Crear Clientes-->
                    <section>
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpenClienteNew">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity" @click="closeModalClienteNew()">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

                                <!-- Contenido modal -->
                                <div class="inline-block lg:w-7/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <button type="button" @click="closeModalClienteNew()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                    <section>
                                        <div class="flex justify-between mx-auto p-4">
                                            <div class="w-1/2">
                                                <h1 class="font-bold text-xl text-black-800 leading-tight">
                                                    Crear Clientes
                                                </h1>
                                            </div>

                                        </div>
                                    </section>
                                    <!-- Fin Encabezado y titulo -->
                                    <!-- Tabla de contenido -->
                                    <section>

                                        <div>
                                            <div class=" p-4 mt-5 mb-10 lg:mt-0">
                                                <div class="flex">
                                                    <h2 class="text-lg font-bold text-gray-900">Guardar</h2>
                                                    <a href="#"  @click="saveClienteLite(form.cliente)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                                        </svg>
                                                    </a>
                                                </div>
                                                <div class="mt-2 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                                                        <div class="mt-1">
                                                            <input type="text" :disabled="!isNewCliente" :class="{'bg-blue-100' : !isNewCliente}" v-model="form.cliente.nombre" autocomplete="given-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                            <div v-if="$page.props.errors.nombre" class="text-red-500">{{ $page.props.errors.nombre }}</div>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Apellido</label>
                                                        <div class="mt-1">
                                                            <input type="text" :disabled="!isNewCliente" :class="{'bg-blue-100' : !isNewCliente}" v-model="form.cliente.apellido" autocomplete="family-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                            <div v-if="$page.props.errors.apellido" class="text-red-500">{{ $page.props.errors.apellido }}</div>
                                                        </div>
                                                    </div>

                                                    <div class="sm:col-span-2">
                                                        <label class="block text-sm font-medium text-gray-700">Móvil</label>
                                                        <div class="mt-1">
                                                            <input type="text" :disabled="!isNewCliente" :class="{'bg-blue-100' : !isNewCliente}" v-model="form.cliente.movil" autocomplete="street-address" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                            <div v-if="$page.props.errors.movil" class="text-red-500">{{ $page.props.errors.movil }}</div>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Documento</label>
                                                        <div class="mt-1">
                                                            <input type="text" :disabled="!isNewCliente" :class="{'bg-blue-100' : !isNewCliente}" v-model="form.cliente.documento" autocomplete="postal-code" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                            <div v-if="$page.props.errors.documento" class="text-red-500">{{ $page.props.errors.docuemnto }}</div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Correo</label>
                                                        <div class="mt-1">
                                                            <input type="email" :disabled="!isNewCliente" :class="{'bg-blue-100' : !isNewCliente}" v-model="form.cliente.correo" autocomplete="email" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                            <div v-if="$page.props.errors.correo" class="text-red-500">{{ $page.props.errors.correo }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                    </section>
                                    <!-- Fin form -->
                                </div>
                                <!-- Fin Contenido modal -->
                            </div>
                        </div>
                    </section>
                    <!-- Fin Ventana modal Crear Clientes -->


                    <!-- Ventana modal Cerrar Caja -->
                    <!-- Main modal -->
                    <section> <!-- Ventana modal -->
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpenCerrar">
                            <div class="items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" @click="closeModalCierre()">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <div class="fixed inset-0 transition-opacity">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>

                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                                <div class="inline-block lg:w-6/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <button type="button" @click="closeModalCierre()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
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
                                                                <input type="text" disabled :class="{'bg-blue-100' : editMode}" v-model="caja.puntoventa.nombre" autocomplete="given-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">Cantidad final ($)</label>
                                                            <div class="mt-1">
                                                                <money3 v-model="caja.montocierre" v-bind="configMoney" :disabled="verMode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></money3>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                              <button wire:click.prevent="cierre()" @click="cierre(caja)" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" >
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
                                    <button type="button" @click="route('cajas.index')" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
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
                                                                {{ recaudocaja.vendedor.full_name }}
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
                                                                Fondo de caja
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
                                                                Comisiones pagadas
                                                            </th>
                                                            <td class="px-6 py-2">
                                                                {{ formatPrice(recaudocaja.comisionventa) }}
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
                                           <a :href="route('cajas.index')" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">Cerrar</a>
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

import Toggle from '@vueform/toggle';
import '@vueform/toggle/themes/default.css';
import Button from "../../Jetstream/Button";

import moment from 'moment'
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { ref, onMounted } from 'vue';
import { Money3Component } from 'v-money3'
import {InertiaLink} from "@inertiajs/inertia-vue3";
import Input from "../../Jetstream/Input";

import VueCountdown from '@chenfengyuan/vue-countdown';


export default {
    name: 'App',

    components: {
        Input,
        Button,
        AppLayout,
        Icon,
        Toggle,
        QuillEditor,
        money3: Money3Component,
        VueCountdown
    },
    props:{
        datos : [],
        caja:[],
        numerosreservados : [],
        rifas: [],
        vendedores: [],
        errors: Object,
        totaltransaccionprop: 0,
        totalcomisionesprop: 0,
        totalboletas: 0
    },
    computed: {
        totalmovimiento: function () {
            const sumWithInitial = this.form.reservas.reduce(
                (accumulator, currentValue) => parseFloat(accumulator) + parseFloat(currentValue.valortotal),
                0
            );
            return sumWithInitial;
        },
        totalapagar: function () {
            if (this.asignarMode) {
                const sumWithInitial = this.form.reservas.reduce(
                    (accumulator, currentValue) => parseFloat(accumulator) + parseFloat(currentValue.valorpagar),
                    0
                );
                return sumWithInitial;
            } else if (this.eliminarMode) {
                const sumWithInitial = this.form.reservas.reduce(
                    (accumulator, currentValue) => parseFloat(accumulator) + parseFloat(currentValue.valorpagado),
                    0
                );
                return sumWithInitial;
            }
        },
    },
    data() {
        return {
            time: 1 * 60 * 1000,
            session: [],
            configMoney2: {
                masked: true,
                prefix: '',
                suffix: '',
                thousands: '',
                decimal: '',
                precision: 0,
                disableNegative: true,
                disabled: false,
                min: 0,
                max: 9999,
                allowBlank: false,
                minimumNumberOfCharacters: 4,
            },
            idHistorial: null,
            idVenta: null,
            isOpenCliente: false,
            isOpenClienteNew: false,
            isOpenCerrar: false,
            tituloModal: '',
            form: {
                idrifa: null,
                numero: null,
                promocional: null,
                vendedor: null,
                idcliente: null,
                estado: '',
                reserva: {
                    numero: null,
                    promocional: null,
                    valortotal:null,
                    valorpagar:null,
                    valorsaldo: null,
                    idcliente:null,
                    cliente:null
                },
                rangoinicial: null,
                rangofinal: null,
                idvendedor: null,
                reservas:[]
            },
            existenumerosreservados: 1,
            buscarcliente: '',
            arrayNumerosreservados: [],
            rangoinicial: null,
            rangofinal: null,
            cantboletas: 0,
            errornumerosreservados: 0,
            errorMostrarMsjnumerosreservados: [],
            isOpenRifa: false,
            isOpenVendedor: false,
            isOpenDetalle: false,
            indexcliente: null,
            existerifa: 0,
            existevendedor: 0,
            isIndividual: 0,
            totaltransaccion: 0,
            totalcomisiones: 0,
            boletatmp: []
        }
    },
    methods: {
        onSelectRifa: function(data){
            this.form.idrifa = data;
            this.closeMoodalRifa();
            this.actualizarRangos();
            this.updateSession(this.session.id, this.form.idrifa.id, this.form.idvendedor.id);
        },
        onSelectVendedor: function(data){
            var url= '/users/getConfVendedor';
            axios.get(url, {
                params: {
                    idvendedor: data.id,
                }
            }).then((res) => {
                let configuracion = res.data;
                if (configuracion.comision && configuracion.comision !== null && configuracion.comision.comisionvendedor >= 0) {
                    this.form.idvendedor = data;
                    this.closeMoodalVendedor();
                    this.updateSession(this.session.id, this.form.idrifa.id, this.form.idvendedor.id);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'El vendedor no cuenta con al configuración de las comisiones',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            })
        },
        onSelectCliente: function(data){
            this.form.reservas[this.indexcliente].cliente = data.full_name;
            this.form.reservas[this.indexcliente].idcliente = data.id;
            this.isNewCliente = false;
            this.closeModalCliente();
            this.closeModalClienteNew();
            this.pushSessionDetail(this.session.id, this.boletatmp, 'upd');
        },
        generarReciboEliminar: function () {
            let isOk = true;
            if (this.form.reservas.length > 0){
                this.form.reservas.forEach(element => {
                    if (element['idcliente'] == '' || element['idcliente'] === null) {
                        isOk = false;
                    }
                });

                if (isOk) {
                    var url = '/ventas/reportpdfAnulaMov';
                    axios.get(url, {
                        params: {
                            rifa: this.form.idrifa.nombre_tecnico,
                            idvendedor: this.form.idvendedor.id,
                            idcliente: this.form.idcliente.id,
                            vendedor: this.form.idvendedor.full_name,
                            cliente: this.form.idcliente.full_name,
                            reservas: this.form.reservas,
                            idrifa: this.form.idrifa.id,
                            idcaja: this.caja.id,
                            idpuntoventa: this.caja.idpuntoventa
                        }
                    }).then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Se ha generado el recibo correspondiente',
                            showConfirmButton: true,
                        })
                        window.open(res.data.url, '_blank');
                        this.form.reservas = [];
                        this.getMovimientos();
                    })
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Por favor seleccione los clientes para cada número',
                        showConfirmButton: true,
                    })
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Por favor seleccione por lo menos un número',
                    showConfirmButton: true,
                })
            }

        },
        generarReciboAsignar: function () {
            let isOk = true;
            if (this.form.reservas.length > 0){
                this.form.reservas.forEach(element => {
                    if (element['idcliente'] == '' || element['idcliente'] === null) {
                        isOk = false;
                    }
                });

                if (isOk) {
                    var url = '/ventas/reportpdfRegistroMov';
                    axios.get(url, {
                        params: {
                            idsesion: this.session.id,
                            idcaja: this.caja.id,
                            idpuntoventa: this.caja.idpuntoventa
                        }
                    }).then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Se ha generado el recibo correspondiente',
                            showConfirmButton: true,
                        })
                        this.$refs.countdown.end();
                        window.open(res.data.url, '_blank');
                        this.form.reservas = [];
                        this.getMovimientos();
                    })
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Por favor seleccione los clientes para cada número',
                        showConfirmButton: true,
                    })
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Por favor seleccione por lo menos un número',
                    showConfirmButton: true,
                })
            }

        },
        eliminarReserva: function(boleta, index){
            this.form.reservas.splice(index, 1);
            this.pushSessionDetail(this.session.id, boleta, 'del');
        },
        verVendedor: function (id) {
            //this.isOpen = true;
            //this.editMode = true;

            //this.tituloModal = 'Administrar reservas';
            //this.form.idrifa =  data['idrifa'];
            //this.form.idvendedor = data['idvendedor'];
        },
        openModal: function (accion, data = []) {
            this.isOpen = true;

            switch (accion) {
                case 'registrar':
                {
                    this.tituloModal = 'Registrar movimiento';
                    this.form.id = null;
                    this.form.idrifa = '';
                    this.form.numero = null;
                    this.form.estado = false;
                    this.form.rangoinicial = null;
                    this.form.rangofinal = null;
                    this.form.idvendedor = '';
                    this.form.idcliente = '';
                    this.form.fecha = null;
                    this.asignarMode = true;
                    this.eliminarMode = false;
                    this.registrarSessionVenta(this.caja.puntoventa.id)
                    break;
                }
                case 'eliminar':
                {
                    this.tituloModal = 'Anular movimiento';
                    this.form.id = null;
                    this.form.idrifa = 0;
                    this.form.numero = null;
                    this.form.estado = false;
                    this.form.rangoinicial = null;
                    this.form.rangofinal = null;
                    this.form.idvendedor = 0;
                    this.form.idcliente = 0;
                    this.form.fecha = null;
                    this.asignarMode = false;
                    this.eliminarMode = true;
                    break;
                }
            }
        },
        selectRifa: function () {
            this.isOpenRifa = true;
            this.getRifas('','titulo','true');
        },
        crearCliente: function (){
            this.isOpenClienteNew = true;
            this.isNewCliente = true;
            this.form.cliente = []
            this.form.cliente.idpais = 0;
            this.form.cliente.iddepartamento = 0;
            this.form.cliente.idciudad = 0;
            this.form.cliente.idtipos_documento = 0;
            this.getPaises();
            this.getTiposdocumento();
        },
        saveClienteLite: function(data) {
            var formData = new FormData();
            formData.append('nombre', this.form.cliente.nombre);
            formData.append('apellido', this.form.cliente.apellido);
            formData.append('correo', this.form.cliente.correo);
            formData.append('password', this.form.cliente.documento);
            formData.append('username', this.form.cliente.documento);
            formData.append('idrol', 2);
            formData.append('estado', 1);
            formData.append('idtipos_documento', 1);
            formData.append('documento', this.form.cliente.documento);
            formData.append('direccion', '');
            formData.append('idpais', 1);
            formData.append('iddepartamento', 17);
            formData.append('idciudad', 1017001);
            formData.append('telefono', this.form.cliente.movil);
            formData.append('movil', this.form.cliente.movil);
            formData.append('observaciones', 'Creado por movimiento de caja');

            //console.log(formData);
            var url= '/users';
            axios.post(url, formData
            ).then((res) => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'El cliente se ha creado satisfactoriamene',
                    showConfirmButton: false,
                    timer: 1500
                })
                var respuesta = res.data;
                this.onSelectCliente(respuesta.user);
            })

        },
        selectCliente: function (index, reserva) {
            this.isOpenCliente = true;
            this.indexcliente = index;
            this.getClientes(this.form.reservas[index].cliente,'documento','true');
            this.boletatmp = reserva;
        },
        selectVendedor: function () {
            this.isOpenVendedor = true;
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
        closeModalCliente: function(){
            this.isOpenCliente = false;
            this.editMode = false;
            this.verMode  = false;
            this.$page.props.errors = [];
        },
        closeModalClienteNew: function(){
            this.isOpenClienteNew = false;
            this.verMode  = false;
            this.$page.props.errors = [];
        },
        closeModalCierre: function(){
            this.isOpenCerrar = false;
            this.verMode  = false;
            this.$page.props.errors = [];
        },
        cerrar: function (data) {
            this.isOpenCerrar = true;
            this.form = data;
            this.tituloModal = 'Cierre de caja';
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
        cierre: function (data) {
            var url= '/cajas/cierre';
            axios.get(url, {
                params: {
                    idcaja: data.id,
                    montocierre: data.montocierre
                }
            }).then((res) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Se ha realizado el cierre de caja',
                        showConfirmButton: true,
                    })
                    this.recaudocaja = res.data.histocaja; console.log(res.data.histocaja);
                    this.isOpenCerrar = false;
                    this.tituloModal = 'Detalle del cierre de caja'
                    this.isOpenDetalle = true;
                }).catch(function (error) {
            });

            /*
            this.$inertia.post('/cajas/cierre', data, {
                onBefore: (visit) => { console.log('onBefore');},
                onStart: (visit) => {console.log('onStart');},
                onProgress: (progress) => {console.log('onProgress');},
                onSuccess: (page) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Se ha realizado el cierre de caja',
                        showConfirmButton: true,
                    })
                    this.isOpenCerrar = false;
                    this.getCajas();
                    this.tituloModal = 'Detalle del cierre de caja'
                    this.isOpenDetalle = true;
                },
                onError: (errors) => {console.log('onError');},
                onCancel: () => {console.log('onCancel');},
                onFinish: visit => {console.log('onFinish');},
            });
            */

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
            this.form.reservas = [];
        },
        valBoletaDisponible: function (numero, rifa, idvendedor, idcliente){
            if(!this.form.idrifa.id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Primero debe seleccionar una rifa',
                    showConfirmButton: true,
                    //timer: 1500
                })
            } else if(this.form.reserva.numero == '') {
                Swal.fire({
                    //position: 'top-end',
                    icon: 'warning',
                    title: 'Ingrese un número válido',
                    showConfirmButton: true,
                    //timer: 1500
                })
            } else {
                if (this.asignarMode) {
                    var url = '/numerosreservados/getBoletaOcupadaVenta';
                } else if (this.eliminarMode) {
                    var url = '/numerosreservados/getBoletaVendida';
                }
                axios.get(url, {
                    params: {
                        numero: numero,
                        rifa: rifa,
                        idvendedor: idvendedor,
                        idcliente: idcliente
                    }
                }).then((res) => {
                    //console.log(res.data);
                    var respuesta = res.data;
                    let isocupado = respuesta.isocupado;
                    if (isocupado) {
                        this.form.reservas.push({
                            numero: respuesta.boleta.numero,
                            promocional: respuesta.boleta.promocional,
                            valortotal: respuesta.boleta.valor,
                            valorpagar: respuesta.boleta.saldo,
                            valorsaldo: respuesta.boleta.saldo,
                            valoranular: respuesta.boleta.pago,
                            valorpagado: respuesta.boleta.pago,
                            idcliente: respuesta.boleta.idcliente,
                            cliente: respuesta.boleta.cliente?respuesta.boleta.cliente.full_name:'',
                        });
                        this.form.reserva.numero = null;
                        this.form.reserva.promocional = null;
                        this.pushSessionDetail(this.session.id, respuesta.boleta, 'add');
                    } else {
                        Swal.fire({
                            //position: 'top-end',
                            icon: 'warning',
                            title: 'El número no se puede utilizar',
                            showConfirmButton: true,
                            //timer: 1500
                        })
                    }
                })
            }
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
            this.editMode = true;
            this.openModal('actualizar', data);
        },
        ver: function (data) {
            this.verMode = true;
            this.openModal('ver', data);
        },
        update: function (data) {
            data.fechainicio = this.dateTimeFull(data.fechainicio);
            data.fechafin = this.dateTimeFull(data.fechafin);
            //console.log(data);
            data._method = 'PUT';
            this.$inertia.post('/numerosreservados/'  + data.id, data, {
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
            });

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
                    //console.log(error);
                });
            })

        },
        getMovimientos: function () {
            var url= '/cajas/movimientos';
            axios.get(url, {
                params: {
                    ispage: this.ispage
                }
            }).then((res) => {
                var respuesta = res.data;
                this.arrayData = respuesta.datos;
                this.totaltransaccion = respuesta.totaltransaccionprop;
                this.totalcomisiones = respuesta.totalcomisionesprop;
            })
        },

    },
    created: function () {
        this.arrayData = this.datos;
        this.totaltransaccion = this.totaltransaccionprop;
        this.totalcomisiones = this.totalcomisionesprop;
        this.getRifas('','titulo', true);
        this.getVendedores('','documento', true);
    },
    mounted() {

    },
}
</script>
