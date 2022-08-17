<template>
    <AppLayout title="Ventas" :total="total">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nueva venta
            </h2>
        </template>
        <div class="py-2 w-10/12 mx-auto lg:px-8 md:px-6 sm:px-2">
            <div class="mx-auto 2xl:8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- Fin Mensajes Flash -->

                    <form-wizard v-if="!isComplete" next-button-text="Siguiente" subtitle="sub" color="#009db0"
                                 back-button-text="Volver" step-size="sm" finishButtonText="Confirmar orden"
                                 validateOnBack="true"
                                 @on-complete="validatePago"
                                 @on-change="onChange"
                                 @on-validate="onValidateRifa"
                                 @on-error="onError"
                    >
                        <tab-content title="Detalle de Rifa" icon="ti-ticket" :before-change="validateRifa" >
                            <form>
                                <div class="bg-white px-4 pb-2">
                                    <div class="">
                                        <!-- Mensajes Flash -->

                                        <!-- Fin Mensajes Flash -->
                                        <!-- Formulario -->
                                        <section>
                                            <div class="mx-auto text-center w-full border-0">
                                                <vue-countdown ref="countdown" class="p-2 pb-4 border-2 border-gray-800 rounded-md mx-auto text-blue-700" :time="time" v-slot="{ minutes, seconds }" @end="onCountdownEnd">
                                                    Tiempo restante：{{ minutes }} min, {{ seconds }} seg.
                                                </vue-countdown>
                                            </div>
                                            <div class="">
                                                <img v-show="form.idrifa.urlimagen1 != null" :src="'/storage/'+form.idrifa.urlimagen1" alt="image" class="mx-auto w-4/12"/>
                                            </div>

                                            <div class="flex py-1">
                                                <div class="mb-4 w-full pr-2">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Rifa</label>

                                                    <input v-model="form.idrifa.titulo" @click="selectRifa()" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Seleccione Rifa">

                                                    <div v-if="$page.props.errors.rifa" class="text-red-500">{{ $page.props.errors.rifa }}</div>
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
                                                        <div v-if="true" class="flex pl-8 pt-8">
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
                                        <section>
                                            <div class="flex flex-wrap mx-auto py-4">
                                                <div class="flex items-center mr-4">
                                                    <input type="radio" value="0" v-model="isRandom" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500 focus:ring-2 ">
                                                    <label class="ml-2 text-sm font-medium ">Seleccionar número</label>
                                                </div>
                                                <div class="flex items-center mr-4">
                                                    <input type="radio" value="1" v-model="isRandom" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500 dark:ring-offset-gray-800 ">
                                                    <label class="ml-2 text-sm font-medium ">Aleatorio</label>
                                                </div>
                                            </div>
                                            <div class="py-1 w-full">

                                                <div class="container flex justify-center items-center">
                                                    <div class="relative">
                                                        <div class="absolute top-4 left-3">
                                                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                                        <money3 v-bind="configMoney2" v-model="form.numero" @keypress.enter="valBoletaLibre(form.numero, form.idrifa.id, form.idrifa.cifras)" class="h-8 w-96 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" :placeholder="'Buscar (' + form.rangoinicial?form.rangoinicial : '' + ' - ' + form.rangofinal +')'"></money3>
                                                        <a @click="valBoletaLibre(form.numero, form.idrifa.id, form.idrifa.cifras)">
                                                            <div class="absolute top-2 right-2">
                                                                <Icon icon="fe:search" class="h-4"  />
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>

                                                <section>
                                                    <div class="w-full p-2">
                                                        <h1 class="font-bold text-xl text-black-800 leading-tight">
                                                            Premio Mayor
                                                        </h1>
                                                    </div>
                                                    <div class="lg:px-4 md:px-2 sm:px-0 py-2 pb-2 overflow-y-auto h-40">
                                                        <table class="table-fixed w-full">
                                                            <thead>
                                                            <tr class="bg-gray-100">
                                                                <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                                    Premio
                                                                </th>
                                                                <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                                    Serie
                                                                </th>
                                                                <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                                    Fecha sorteo
                                                                </th>
                                                                <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                                    Loteria
                                                                </th>
                                                                <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                                    Número boleta
                                                                </th>
                                                                <th class="px-4 py-2 text-sm font-bold w-1/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                                    +/-
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr class="text-center text-sm" :class="{'hover:bg-blue-100' : form.boleta.numero }">
                                                                <td v-text="form.idrifa.nombre_tecnico" class="border px-1 py-2 text-sm truncate" ></td>
                                                                <td v-text="form.idrifa.serie" class="border px-1 py-2 text-sm truncate" ></td>
                                                                <td v-text="form.idrifa.fechafin" class="border px-2 py-2 text-sm truncate" ></td>
                                                                <td v-text="form.idrifa.loteria.nombre" class="border px-2 py-2 text-sm truncate" ></td>
                                                                <td v-text="form.boleta.numero" class="border px-2 py-2 text-sm truncate" ></td>
                                                                <td @click="selectNumero('boleta')" class="border px-2 py-2 text-sm truncate mx-auto" >
                                                                        <Icon icon="carbon:add" class="h-4 mx-auto"  />
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </section>
                                                <section>
                                                    <div class="w-full p-2">
                                                        <h1 class="font-bold text-xl text-black-800 leading-tight">
                                                            Premios promocionales
                                                        </h1>
                                                    </div>
                                                    <div class="lg:px-4 md:px-2 sm:px-0 py-1 pb-1 overflow-y-auto h-32">
                                                        <table class="table-fixed w-full">
                                                            <thead>
                                                            <tr class="bg-gray-100">
                                                                <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                                    Premio
                                                                </th>
                                                                <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                                    Fecha sorteo
                                                                </th>
                                                                <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                                    Loteria
                                                                </th>
                                                                <th class="px-4 py-2 text-sm font-bold w-2/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                                    Número boleta
                                                                </th>
                                                                <th class="px-4 py-2 text-sm font-bold w-1/12 hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                                                    +/-
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr class="text-center" text-sm v-if="form.idrifa.promocionales.length > 0" v-for="(dato, id) in form.idrifa.promocionales" :key="id">
                                                                <td class="border px-1 py-2 text-sm truncate" v-text="dato.premio"></td>
                                                                <td class="border px-2 py-2 text-sm truncate" v-text="dato.idloteria"></td>
                                                                <td class="border px-2 py-2 text-sm truncate" v-text="dato.fecha"></td>
                                                                <td class="border px-2 py-2 text-sm truncate" ></td>
                                                                <td class="border px-2 py-2 text-sm truncate" ><Icon icon="carbon:add" class="h-4"  /></td>
                                                            </tr>
                                                            <tr v-else>
                                                                <td class="border px-4 py-2 text-xs text-center" colspan="5"> La rifa no tiene promociones</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </section>

                                            </div>
                                        </section>
                                        <!-- Fin formulario -->
                                    </div>
                                </div>
                            </form>
                        </tab-content>
                        <tab-content title="Registrar pago" icon="ti-money" >
                            <div class="w-full mx-auto pb-5">
                                <h1 class="sr-only">Resumen de la transacción</h1>

                                <form class="lg:grid lg:gap-x-12 xl:gap-x-16">

                                    <!-- Order summary -->
                                    <div class="mt-5 mb-10 lg:mt-0">
                                        <h2 class="text-lg font-bold font-medium text-gray-900">Resumen de la transacción</h2>

                                        <div class="mt-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                                            <ul role="list" class="divide-y divide-gray-200">
                                                <li class="flex py-3 px-4 sm:px-6 font-bold">
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            Imagen
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            QR
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            Rifa
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            Boleta
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            Precio
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            Total
                                                        </h4>
                                                    </div>
                                                </li>
                                                <li class="flex py-6 px-4 sm:px-6" v-for="(dato, id) in cart" :key="id">
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            <img :src="dato.attributes?'/storage/'+dato.attributes.url:''" alt="Front of men&#039;s Basic Tee in black." class="w-20 rounded-md">
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            <vue-qrcode v-model="dato.attributes.codigo" :options="{ width: 50 }"></vue-qrcode>
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            <a href="#" class="font-medium text-gray-700 hover:text-gray-800"> {{ dato.name }} </a>
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            <a href="#" class="font-medium text-gray-700 hover:text-gray-800"> {{ dato.attributes.numero }} </a>
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                        <p class="mt-1 text-sm font-medium text-gray-900">${{ dato.price }}</p>
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            <p class="mt-1 text-sm font-medium text-gray-900">${{ dato.price }}</p>
                                                        </h4>
                                                    </div>
                                                </li>
                                                <!-- More products... -->
                                            </ul>
                                            <dl class="border-t border-gray-200 py-6 px-4 space-y-6 sm:px-6">
                                                <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                                                    <dt class="text-base font-medium font-bold">Total</dt>
                                                    <dd class="text-base font-medium text-gray-900 font-bold">{{ formatPrice(calcularSubtotal) }}</dd>
                                                </div>
                                            </dl>
                                            <div class="flex w-10/12 mx-auto justify-items-center pb-4">
                                                <label class="block text-sm font-medium font-bold text-gray-700">Comprobante de pago</label>
                                                <div class="mt-1 px-2">
                                                    <input type="text" v-model="form.comprobante" autocomplete="family-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                </div>
                                                <label class="block text-sm font-medium font-bold text-gray-700">Valor a pagar</label>
                                                <div class="mt-1 px-2">
                                                    <money3 v-bind="configMoney" v-model="form.valorpagar" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></money3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </tab-content>
                        <tab-content title="Checkout" icon="ti-credit-card" :before-change="validateCheckout">

                            <div class="max-w-2xl mx-auto lg:max-w-none pb-5">
                                <h1 class="sr-only">Checkout</h1>

                                <form class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
                                    <div>
                                        <div class=" mt-5 mb-10 lg:mt-0">
                                            <div class="flex">
                                                <h2 class="text-lg font-bold text-gray-900">Información del cliente</h2>
                                                <a href="#" v-if="!isNewCliente" @click="crearCliente()">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                                <a href="#" v-else @click="saveCliente(form.cliente)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                                    </svg>
                                                </a>
                                            </div>
                                            <div v-if="$page.props.flash.message" class="text-red-500">{{ $page.props.flash.message }}</div>
                                            <div class="sm:col-span-2 py-4 border-b-2">
                                                <label class="block text-sm font-medium text-gray-700">Seleccionar cliente</label>
                                                <div class="mt-1">
                                                    <input type="text" @click="selectCliente()" v-model="form.metacliente" autocomplete="street-address" class="block w-full bg-gray-200 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                </div>
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
                                                    <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                                                    <div class="mt-1">
                                                        <input type="text" :disabled="!isNewCliente" :class="{'bg-blue-100' : !isNewCliente}" v-model="form.cliente.movil" autocomplete="street-address" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                        <div v-if="$page.props.errors.telefono" class="text-red-500">{{ $page.props.errors.telefono }}</div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Tipo documento</label>
                                                    <div class="mt-1">
                                                        <select :disabled="!isNewCliente" :class="{'bg-blue-100' : !isNewCliente}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.cliente.idtipos_documento">
                                                            <option value="0" >Seleccione</option>
                                                            <option v-for="tipodoc in arrayTiposdocumento" :key="tipodoc.id" :value="tipodoc.id" v-text="tipodoc.nombre_corto"></option>
                                                        </select>
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
                                                    <label class="block text-sm font-medium text-gray-700">País</label>
                                                    <div class="mt-1">
                                                        <select :disabled="!isNewCliente" :class="{'bg-blue-100' : !isNewCliente}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.cliente.idpais" @change="getDepartamentos()">
                                                            <option value="0" >Seleccione País</option>
                                                            <option v-for="pais in arrayPaises" :key="pais.id" :value="pais.id" v-text="pais.nombre"></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Departamento</label>
                                                    <div class="mt-1">
                                                        <select :disabled="!isNewCliente" :class="{'bg-blue-100' : !isNewCliente}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.cliente.iddepartamento" @change="getCiudades">
                                                            <option value="0" >Seleccione departamento</option>
                                                            <option v-for="departamento in arrayDepartamentos" :key="departamento.id" :value="departamento.id" v-text="departamento.nombre"></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Ciudad</label>
                                                    <div class="mt-1">
                                                        <select :disabled="!isNewCliente" :class="{'bg-blue-100' : !isNewCliente}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.cliente.idciudad">
                                                            <option value="0" >Seleccione Ciudad</option>
                                                            <option v-for="ciudad in arrayCiudades" :key="ciudad.id" :value="ciudad.id" v-text="ciudad.nombre"></option>
                                                        </select>
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

                                    <!-- Order summary -->
                                    <div class="mt-5 mb-10 lg:mt-0">
                                        <h2 class="text-lg font-bold font-medium text-gray-900">Resumen de la orden</h2>

                                        <div class="mt-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                                            <h3 class="sr-only">Boletas en el carro</h3>
                                            <ul role="list" class="divide-y divide-gray-200">
                                                <li class="flex py-6 px-4 sm:px-6" v-for="(dato, id) in cart" :key="id">
                                                    <div class="flex-shrink-0">
                                                        <img :src="dato.attributes?'/storage/'+dato.attributes.url:''" alt="Front of men&#039;s Basic Tee in black." class="w-20 rounded-md">
                                                    </div>

                                                    <div class="ml-6 flex-1 flex flex-col">
                                                        <div class="flex">
                                                            <div class="min-w-0 flex-1">
                                                                <h4 class="text-sm">
                                                                    <a href="#" class="font-medium text-gray-700 hover:text-gray-800"> {{ dato.name }} </a>
                                                                </h4>
                                                                <p class="mt-1 text-sm text-gray-500">{{ dato.attributes.numero }}</p>
                                                            </div>

                                                            <div class="ml-4 flex-shrink-0 flow-root">
                                                                <button type="button" @click="delCartItem(dato)" class="-m-2.5 bg-white p-2.5 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                                                    <span class="sr-only">Eliminar</span>
                                                                    <!-- Heroicon name: solid/trash -->
                                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <div class="flex-1 pt-2 flex items-end justify-between">
                                                            <p class="mt-1 text-sm font-medium text-gray-900">${{ dato.price }}</p>

                                                            <div class="ml-4">
                                                                <label class="sr-only">Cantidad</label>
                                                                <select v-model="dato.quantity" class="rounded-md border border-gray-300 text-base font-medium text-gray-700 text-left shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                    <option value="6">6</option>
                                                                    <option value="7">7</option>
                                                                    <option value="8">8</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                                <!-- More products... -->
                                            </ul>
                                            <dl class="border-t border-gray-200 py-6 px-4 space-y-6 sm:px-6">
                                                <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                                                    <dt class="text-base text-bold font-medium">Total</dt>
                                                    <dd class="text-base font-medium text-gray-900">{{ calcularSubtotal }}</dd>
                                                </div>
                                            </dl>

                                            <!-- Payment -->
                                            <div class="mt-2 border-t border-gray-200 pt-2">
                                                <h2 class="text-lg font-bold border-b-2 font-medium text-gray-900">Método de pago</h2>

                                                <fieldset class="mt-2">
                                                    <legend class="sr-only">Payment type</legend>
                                                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                                                        <div class="flex items-center">
                                                            <input v-model="form.paymentmethod" value="0" type="radio" checked class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                                            <svg class="w-10" style="enable-background:new 0 0 48 48;" version="1.1" viewBox="0 0 48 48" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Icons"><g><path d="M16.3872,34.6633l-6.71-10.09c-0.86-1.42-0.41-3.26,1.01-4.13l14.15-8.6    c1.42-0.86,3.26-0.41,4.13,1l3.68,6.06l1.18,2.11" style="fill:#F43735;"/><path d="M35.7572,36.5934h-16.569c-1.6568,0-3-1.3432-3-3V24.01c0-1.6568,1.3432-3,3-3h16.569    c1.6569,0,3,1.3432,3,3v9.5834C38.7572,35.2502,37.4141,36.5934,35.7572,36.5934z" style="fill:#F9F9F9;"/><rect height="3.1331" style="fill:#383838;" width="22.5712" x="16.1879" y="24.4404"/><g><line style="fill:none;stroke:#303030;stroke-width:0.5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" x1="36.6873" x2="34.0623" y1="31.6485" y2="31.6485"/><line style="fill:none;stroke:#303030;stroke-width:0.5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" x1="36.6873" x2="34.0623" y1="32.7735" y2="32.7735"/><line style="fill:none;stroke:#303030;stroke-width:0.5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" x1="36.6873" x2="34.0623" y1="33.9402" y2="33.9402"/></g><path d="M25.6898,29.138c-1.0925,0-2.0289,0.659-2.44,1.6c-0.4111-0.941-1.3475-1.6-2.44-1.6    c-1.4715,0-2.6642,1.1928-2.6642,2.6641c0,1.4714,1.1927,2.6642,2.6642,2.6642c1.0925,0,2.0289-0.6591,2.44-1.6001    c0.4111,0.941,1.3475,1.6001,2.44,1.6001c1.4714,0,2.6641-1.1928,2.6641-2.6642C28.3539,30.3308,27.1612,29.138,25.6898,29.138z" style="fill:#FFC601;"/><path d="    M35.7572,36.5934h-16.569c-1.6568,0-3-1.3432-3-3V24.01c0-1.6568,1.3432-3,3-3h16.569c1.6569,0,3,1.3432,3,3v9.5834    C38.7572,35.2502,37.4141,36.5934,35.7572,36.5934z" style="fill:none;stroke:#303030;stroke-width:0.5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"/><line style="fill:none;stroke:#303030;stroke-width:0.5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" x1="38.7591" x2="16.1879" y1="24.4404" y2="24.4404"/><line style="fill:none;stroke:#303030;stroke-width:0.5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" x1="38.7591" x2="16.1879" y1="27.5735" y2="27.5735"/><line style="fill:none;stroke:#303030;stroke-width:0.5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" x1="17.1372" x2="17.1272" y1="35.7833" y2="35.7733"/><path d="    M16.3872,34.6633l-6.71-10.09c-0.86-1.42-0.41-3.26,1.01-4.13l14.15-8.6c1.42-0.86,3.26-0.41,4.13,1l3.68,6.06l1.18,2.11" style="fill:none;stroke:#303030;stroke-width:0.5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"/><g><path d="     M11.5128,25.096c0,0-1.9506-2.1279-0.14779-3.5182l5.77659-3.5273" style="fill:none;stroke:#303030;stroke-width:0.5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"/><line style="fill:none;stroke:#303030;stroke-width:0.5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" x1="18.4377" x2="19.0404" y1="17.309" y2="16.8798"/><line style="fill:none;stroke:#303030;stroke-width:0.5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" x1="32.2411" x2="30.6115" y1="21.01" y2="18.3804"/></g><circle cx="20.79519" cy="31.80215" r="2.64959" style="fill:#F43735;"/></g></g></svg>
                                                            <label class="ml-3 block text-sm font-medium text-gray-700"> TC /TD </label>
                                                        </div>

                                                        <div class="flex items-center">
                                                            <input v-model="form.paymentmethod" value="1" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">

                                                            <label class="ml-3 block text-sm font-medium text-gray-700"> Transferencia </label>
                                                        </div>

                                                        <div class="flex items-center">
                                                            <input v-model="form.paymentmethod" value="3" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                                            <svg class="w-10" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="48px" height="48px" viewBox="0 0 48 48"><g >
                                                                <path fill="#307730" d="M40,22H8c-0.55228,0-1-0.44772-1-1V6c0-0.55228,0.44772-1,1-1h32c0.55228,0,1,0.44772,1,1v15
	C41,21.55228,40.55228,22,40,22z"/>
                                                                <path fill="#3F8E3F" d="M43,22H5c-0.55228,0-1-0.44772-1-1V10c0-0.55229,0.44772-1,1-1h38c0.55228,0,1,0.44771,1,1v11
	C44,21.55228,43.55228,22,43,22z"/>
                                                                <path fill="#4DA34D" d="M46,43H2c-0.55225,0-1-0.44775-1-1V14c0-0.55225,0.44775-1,1-1h44c0.55225,0,1,0.44775,1,1v28
	C47,42.55225,46.55225,43,46,43z"/>
                                                                <path fill="#9EDB9E" d="M38,16H10c0,3.31372-2.68628,6-6,6v12c3.31372,0,6,2.68628,6,6h28c0-3.31372,2.68628-6,6-6V22
	C40.68628,22,38,19.31372,38,16z"/>
                                                                <circle fill="#4DA34D" cx="24" cy="28" r="7"/>
                                                            </g></svg>
                                                            <label class="ml-3 block text-sm font-medium text-gray-700"> Efectivo </label>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Fin Checkout -->
                        </tab-content>
                    </form-wizard>
                    <div v-if="isComplete" class="flex items-center justify-center p-5 bg-blue-100 min-w-screen">
                        <div class="max-w-xl p-8 text-center text-gray-800 bg-white shadow-xl lg:max-w-3xl rounded-3xl lg:p-12">
                            <h3 class="text-2xl">Gracias por compra en TresAses!</h3>
                            <div class="flex justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-green-400" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                          d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                                </svg>
                            </div>

                            <p>A continuación recibirá un mensaje de correo electrónico al: {{ form.cliente.correo}}</p>
                            <div class="mt-4">
                                <a :href="'/ventas/reportpdf?id=' + $page.props.flash.message" target="_blank" class="px-2 py-2 text-blue-200 bg-blue-600 rounded">Imprimir</a>
                                <p class="mt-4 text-sm">Si tiene problemas para poder acceder al correo, puede ver el resumen de la compra en:
                                    <a :href="'/ventas/sumary?id=' + $page.props.flash.message" target="_blank" class="text-blue-600 underline">Resumen</a>
                                </p>
                            </div>
                        </div>
                    </div>


                    <!-- Ventana modal Rifas-->
                    <section>
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpenRifa">
                            <div class="flex items-end justify-center pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity" @click="closeMoodalRifa()">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

                                <!-- Contenido modal -->
                                <div class="inline-block lg:w-7/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <button type="button" @click="closeModal()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
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

                    <!-- Ventana modal buscar cliente-->
                    <section>
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpenCliente">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity" @click="closeMoodalCliente()">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

                                <!-- Contenido modal -->
                                <div class="inline-block lg:w-8/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <section>
                                        <div class="flex justify-between mx-auto p-4">
                                            <div class="w-1/2">
                                                <h1 class="font-bold text-xl text-black-800 leading-tight">
                                                    Buscar Clientes
                                                </h1>
                                            </div>

                                            <div class="w-1/2 pr-2">
                                                <div class="container flex justify-center items-center">
                                                    <div class="relative">
                                                        <div class="absolute top-4 left-3">
                                                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                                        <input type="text" v-model="buscar" @keyup="getClientes(buscar,'documento', true)" class="h-8 w-26 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar (documento)">
                                                        <button @click="getClientes(buscar,'documento', true)">
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
                                                            Teléfono
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
                                                    <th class="px-4 py-2 w-4/12 text-sm font-bold rounded-b">
                                                        <button @click="getRifas('', '.nombre_tecnico')" class="font-bold">
                                                            Correo
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

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr @click="onSelectCliente(cliente)" class="hover:bg-blue-50 text-center" text-sm v-if="existecliente > 0" v-for="(cliente, id) in arrayClientes.data" :key="id">
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="cliente.nombre"></td>
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="cliente.documento"></td>
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="cliente.movil"></td>
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="cliente.correo"></td>
                                                </tr>
                                                <tr v-else>
                                                    <td class="border px-4 py-2 text-xs text-center" colspan="4"> La consulta no obtuvo datos</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <section class="mt-6">
                                                <div v-if="arrayClientes.links.length > 3">
                                                    <div class="flex flex-wrap -mb-1">
                                                        <template v-for="(link, p) in arrayClientes.links" :key="p">
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
                    <!-- Fin Ventana modal buscar cliente -->


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


import {FormWizard, TabContent} from 'vue3-form-wizard';
import 'vue3-form-wizard/dist/style.css';
import ThemifyIcon from "vue-themify-icons";

import VueQrcode from '@chenfengyuan/vue-qrcode';
import VueCountdown from '@chenfengyuan/vue-countdown';

export default {
    name: 'App',

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
        FormWizard,
        TabContent,
        VueQrcode,
        ThemifyIcon,
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
        calcularSubtotal(){
            var total = 0.0;
            for (var i = 0; i < Object.keys(this.cart).length; i++) {
                total += Object.values(this.cart)[i]['price'];
            }
            this.total = this.formatPrice(total)
            this.totalnoparseado = total;
            this.form.valorpagar = total;
            return (total);
        },

    },
    data() {
        return {
            time: 2 * 60 * 1000,
            session: [],
            loadingWizard: false,
            inputValue: null,
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
            form: {
                id: null,
                idrifa: {
                   ciudad: [],
                   departamento: [],
                   loteria: [],
                   promocionales: [],
                   tiposerie: [],
                   cifras: 0
                },
                cliente: {
                    nombre: null,
                    apellido: null,
                    correo: null,
                    movil: null,
                    telefono: null,
                    idtipos_documento: 0,
                    username: null,
                    idrol: 0,
                    idpais: 0,
                    idciudad: 0,
                    iddepartamento: 0,
                },
                numero: null,
                estado: false,
                rangoinicial: 0,
                rangofinal: 0,
                idvendedor: 0,
                idcliente: 0,
                fecha: null,
                boleta: {
                    id: null,
                    numero: null,
                    idrifa: null,
                    promocionales: [],
                    valor: null,
                    cantidad: null,
                    url: null,
                    attributes: []
                },
                promocionales: [],
                comprobante: null,
                paymentmethod: 0,
                valorpagar: 0,
                reservas:[],
                reserva: {
                    numero: null,
                    promocional: null,
                    valortotal:null,
                    valorpagar:null,
                    valorsaldo: null,
                    idcliente:null,
                    cliente:null
                },
            },
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
                max: 0,
                allowBlank: false,
                minimumNumberOfCharacters: 0,
            },

            editMode: false,
            verMode: false,
            isOpen: false,
            buscar: '',
            sortOrder: 1,
            sortBy: '',
            errornumerosreservados: 0,
            existedata: 0,
            existecliente: 0,
            arrayRifas: {
                data: [],
                links: []
            },
            arrayClientes: {
                data: [],
                links: []
            },
            isOpenRifa: false,
            isOpenCliente: false,
            valboleta: [],
            promoboleta: [],
            isRandom: 0,
            isCliente: false,
            arrayPaises: [],
            arrayDepartamentos: [],
            arrayCiudades: [],
            arrayTiposdocumento: [],
            cart: [],
            numerotmp: null,
            boleta: [],
            total: 0.0,
            totalnoparseado: 0.0,
            subtotal: 0.0,
            isComplete: false,
            isBussyCart: 0,
            isNewCliente: false
        }
    },
    methods: {
        selectNumero: async function(tipo) {
            this.numerotmp = this.form.numero;
            const { value: ipAddress } = await Swal.fire({
                title: 'Ingrese el número deseado',
                input: 'text',
                inputLabel: 'Número boleta',
                inputValue: this.numerotmp,
                showCancelButton: true,
                /*
                inputValidator: (value) => {
                    if (!value) {
                        return 'Por favor ingrese un número!'
                    }
                */
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.boleta.numero = this.form.numero;
                    this.form.boleta.idrifa = this.form.idrifa.id;
                }
            })
        },
        valBoletaLibre: function (buscar, rifa, cifras, tiporifa = 'boletas'){

            if(!this.form.idrifa.id) {
                Swal.fire({
                    //position: 'top-end',
                    icon: 'warning',
                    title: 'Primero debe seleccionar una rifa',
                    showConfirmButton: true,
                    //timer: 1500
                })
            } else if(this.form.numero == '' && this.isRandom == 0) {
                Swal.fire({
                    //position: 'top-end',
                    icon: 'warning',
                    title: 'Ingrese un número válido',
                    showConfirmButton: true,
                    //timer: 1500
                })
            } else {
                if (this.isRandom == 1){
                    var tiporifa = 'Boleta';
                    Swal.fire({
                        //position: 'top-end',
                        icon: 'warning',
                        title: 'Se buscará un número libre de manera aleatoria',
                        showConfirmButton: true,
                        timer: 1500
                    })
                    var url = '/ventas/getRandBoletaLibre';
                    axios.get(url, {
                        params: {
                            buscar: buscar,
                            rifa: rifa,
                            cifras: cifras,
                            tiporifa: tiporifa
                        }
                    }).then((res) => {
                        console.log(res.data);
                        var respuesta = res.data;
                        this.boleta = respuesta.boleta;
                        this.promoboleta = respuesta.promoboleta;

                        Swal.fire({
                            //position: 'top-end',
                            icon: 'success',
                            title: 'Se obtuvo el número ' + this.boleta.numero,
                            showConfirmButton: true,
                            //timer: 1500
                        })
                        this.form.numero =  this.boleta.numero;

/*
                        this.promoboleta.forEach(function(rifa, indice) {
                            Swal.fire({
                                //position: 'top-end',
                                icon: 'warning',
                                title: 'El número se encuentra ocupado para un premio promocional',
                                showConfirmButton: true,
                                //timer: 1500
                            })
                        })
*/
                    })
                } else {
                    var url = '/ventas/valBoletaLibre';
                    axios.get(url, {
                        params: {
                            buscar: buscar,
                            rifa: rifa,
                            cifras: cifras
                        }
                    }).then((res) => {
                        console.log(res.data);
                        var respuesta = res.data;
                        this.boleta = respuesta.boleta;
                        this.promoboleta = respuesta.promoboleta;
                        var isocupado = respuesta.isocupado;

                        if (isocupado) {
                            Swal.fire({
                                //position: 'top-end',
                                icon: 'warning',
                                title: 'El número se encuentra ocupado para el premio mayor de la rifa ' + this.boleta.idrifa,
                                showConfirmButton: true,
                                //timer: 1500
                            })
                        } else {
                            Swal.fire({
                                //position: 'top-end',
                                icon: 'success',
                                title: 'El número se encuentra disponible para el premio mayor',
                                showConfirmButton: true,
                                //timer: 1500
                            })
                        }

                        this.promoboleta.forEach(function(rifa, indice) {
                            Swal.fire({
                                //position: 'top-end',
                                icon: 'warning',
                                title: 'El número se encuentra ocupado para un premio promocional',
                                showConfirmButton: true,
                                //timer: 1500
                            })
                        })
                    })
                }
            }
        },
        selectRifa: function () {
            this.isOpenRifa = true;
            this.getRifas('','nombre_tecnico','true');
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
        closeMoodalRifa: function(){
            this.isOpenRifa = false;
            //this.reset();
            this.editMode = false;
            this.verMode  = false;
            this.$page.props.errors = [];
        },
        onSelectRifa: function(data){
            this.form.idrifa = data;
            this.closeMoodalRifa();
            this.actualizarRangos();
        },
        selectCliente: function () {
            this.isOpenCliente = true;
            this.getClientes('','documento','true');
        },
        getClientes: async function (buscar = '', filtro = 'documento', paginate = false) {

            var url= '/users/getClientesActivos';
            axios.get(url, {
                params: {
                    buscar: buscar,
                    filtro: filtro,
                    paginate: paginate
                }
            }).then((res) => {
                console.log(res.data);
                var respuesta = res.data;
                this.arrayClientes = respuesta.clientes;

                if (this.arrayClientes.data.length > 0) {
                    this.existecliente = 1;
                } else {
                    this.existecliente = 0;
                }
            })
        },
        closeMoodalCliente: function(){
            this.isOpenCliente = false;
            //this.reset();
            this.editMode = false;
            this.verMode  = false;
            this.$page.props.errors = [];
        },
        onSelectCliente: function(data){
            this.form.cliente = data;
            this.getDepartamentos();
            this.getCiudades();
            this.form.metacliente = data.tipodocumento.nombre_corto + ' ' + data.documento + ' - ' + data.nombre + ' ' + data.apellido
                                        + ' Tel: ' + data.movil + ' (' + data.ciudad.nombre + ')';
            this.isNewCliente = false;
            this.closeMoodalCliente();
        },
        crearCliente: function (){
            this.isCliente = true;
            this.isNewCliente = true;
            this.form.cliente = []
            this.form.cliente.idpais = 0;
            this.form.cliente.iddepartamento = 0;
            this.form.cliente.idciudad = 0;
            this.form.cliente.idtipos_documento = 0;
            this.form.metacliente = null;
        },
        saveCliente: function(data) {
            var formData = new FormData();
            formData.append('nombre', this.form.cliente.nombre);
            formData.append('apellido', this.form.cliente.apellido);
            formData.append('correo', this.form.cliente.correo);
            formData.append('password', this.form.cliente.documento);
            formData.append('username', this.form.cliente.documento);
            formData.append('idrol', 2);
            formData.append('estado', 1);
            formData.append('idtipos_documento', this.form.cliente.idtipos_documento);
            formData.append('documento', this.form.cliente.documento);
            formData.append('direccion', this.form.cliente.direccion);
            formData.append('idpais', this.form.cliente.idpais);
            formData.append('iddepartamento', this.form.cliente.iddepartamento);
            formData.append('idciudad', this.form.cliente.idciudad);
            formData.append('telefono', this.form.cliente.telefono);
            formData.append('movil', this.form.cliente.movil);
            formData.append('isnatural', 1);
            formData.append('idempresa', 3);

            console.log(formData);
            this.$inertia.post('/users', formData, {
                onBefore: (visit) => { console.log('onBefore');},
                onStart: (visit) => {console.log('onStart');},
                onProgress: (progress) => {console.log('onProgress');},
                onSuccess: (page) => {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'El cliente se ha creado satisfactoriamene',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.onSelectCliente(data);
                },
                onError: (errors) => {console.log('onError');},
                onCancel: () => {console.log('onCancel');},
                onFinish: visit => {console.log('onFinish');},
            });
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

            var url= '/ventas';
            axios.get(url, {
                params: {
                    buscar: buscar,
                    filtro: filtro,
                    paginate: paginate,
                    ispage: true,
                }
            }).then((res) => {
                console.log(res.data);
                var respuesta = res.data;
                this.arrayData = respuesta.data;

                if (this.arrayData.data.length > 0) {
                    this.existedata = 1;
                } else {
                    this.existedata = 0;
                }
            })
        },
        getCart: async function() {
            var url = '/cart/1' + '';
            axios.get(url, {
            }).then((res) => {
                console.log(res.data);
                var respuesta = res.data;
                this.cart = respuesta.cart;
            })
        },
        delCartItem: async function(data) {
            data._method = 'DELETE';
            var url = '/cart';
            axios.delete(url, { data: { id: data.id }}
            ).then((res) => {
                console.log(res.data);
                var respuesta = res.data;
                this.cart = respuesta.cart;
            })

            data._method = 'DELETE';
            this.$inertia.post('/cart/'  + data.id, data, {
                onBefore: (visit) => { console.log('onBefore');},
                onStart: (visit) => {console.log('onStart');},
                onProgress: (progress) => {console.log('onProgress');},
                onSuccess: (page) => {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Se ha eliminado el artículo del carrito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.getCart();
                },
                onError: (errors) => {console.log('onError');},
                onCancel: () => {console.log('onCancel');},
                onFinish: visit => {console.log('onFinish');},
            });
        },
        onValidateRifa: function(isValid, tabIndex){
            console.log('Termino validar rifa, se registrar cart '+ tabIndex);
            switch (tabIndex) {
                case 0:
                    this.isBussyCart = 0;
                    axios.get('/cart/validarId', {
                        params: {
                            iditem: this.boleta.id
                        }
                    }).then((res) => {
                        console.log('bol id' + this.boleta.id);
                        console.log('cart ' + res.data.cart);
                        console.log('object ' + Object.keys(res.data).length);
                        this.isBussyCart = res.data.cart;

                        console.log('isbussy' + this.isBussyCart);
                        if (this.form.boleta.idrifa && this.form.boleta.numero && this.isBussyCart == 0)
                        {
                            this.form.boleta.idrifa = this.form.idrifa.id;
                            this.form.boleta.id     = this.boleta.id;
                            this.form.boleta.valor  = this.form.idrifa.precio;
                            this.form.boleta.rifa   = this.form.idrifa.nombre_tecnico;
                            this.form.boleta.cantidad = 1;
                            this.form.boleta.url    = this.form.idrifa.urlimagen1;
                            const data              = {};
                            data.id = this.form.boleta.id;
                            data.name = this.form.boleta.rifa;
                            data.price = this.form.boleta.valor;
                            data.quantity = this.form.boleta.cantidad;
                            data.url = this.form.boleta.url;
                            data.serie = this.form.idrifa.serie;
                            data.descripcion = this.form.idrifa.titulo;
                            data.idrifa = this.form.idrifa.id;
                            data.numero = this.form.boleta.numero;
                            data.codigo = this.boleta.codigo;
                            console.log(data);

                            this.$inertia.post('/cart', data, {
                                onBefore: (visit) => { console.log('onBefore');},
                                onStart: (visit) => {console.log('onStart');},
                                onProgress: (progress) => {console.log('onProgress');},
                                onSuccess: (page) => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'La boleta se ha agregado al carrito de compras',
                                        showConfirmButton: true,
                                        timer: 1500
                                    })
                                    this.getCart();
                                },
                                onError: (errors) => {console.log('onError');},
                                onCancel: () => {console.log('onCancel');},
                                onFinish: visit => {console.log('onFinish');},
                            });
                        } else {
                            console.log('error de validacion');
                        }
                    })
                    break;
                case 1:
                    console.log('Se valida cliente');
                    break;
                case 2:
                    console.log('Se valida pago');
                    break;
            }

        },
        validateRifa:function() {
            console.log('Validando Rifa');

            if (Object.keys(this.cart).length > 0) {
                return true;
            }
            if (!this.form.boleta.idrifa) {
                Swal.fire({
                    icon: 'error',
                    title: 'Primero debe seleccionar una rifa',
                    showConfirmButton: true,
                    //timer: 1500
                })
                return false;
            }
            if (!this.form.boleta.numero) {
                Swal.fire({
                    //position: 'top-end',
                    icon: 'error',
                    title: 'Seleccione un número de boleta',
                    showConfirmButton: true,
                    //timer: 1500
                })
                return false;
            }

            return true;
        },
        onError:function(error){
            console.log('error ?' + error)
        },
        validateCheckout:function() {
            console.log('Validando checkout');
            if (!this.form.cliente.id) {
                Swal.fire({
                    icon: 'error',
                    title: 'Selecciones un cliente',
                    showConfirmButton: true,
                })
                return false;
            }
            if (Object.keys(this.cart).length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Selecciones al menos una boleta',
                    showConfirmButton: true,
                })
                return false;
            }

            return true;
        },
        validatePago:function() {
            console.log("onComplete");
            if (this.form.valorpagar > this.totalnoparseado) {
                Swal.fire({
                    icon: 'warning',
                    title: 'El valor a pagar es superior al total',
                    showConfirmButton: false,
                    timer: 1500,
                })
            } else {
                if (this.form.valorpagar < this.totalnoparseado) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Se realizará un pago parcial del total',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                }
                Swal.fire({
                    title: 'Confirmar pago',
                    text: "Completar la venta!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, comprar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var data = {
                            cart: [],
                            valortotal: 0.0,
                            idcliente: 0,
                            cantidad: 0,
                            idpuntoventa: 0,
                            fechaventa: null,
                            comprobante: null,
                            nombre: null,
                            correo: null,
                            telefono: null,
                            documento: null,
                            paymentmethod: null,
                            valorpagar: 0.0
                        };
                        data.valortotal = this.totalnoparseado;
                        data.cantidad = Object.keys(this.cart).length;
                        data.idcliente = this.form.cliente.id;
                        data.idpuntoventa = this.$page.props.auth.puntoventa[0].id;
                        data.fechaventa = this.dateTimeFull(Date.now());
                        data.comprobante = this.form.comprobante;
                        data.nombre = this.form.cliente.nombre + ' ' + this.form.cliente.apellido;
                        data.correo = this.form.cliente.correo;
                        data.telefono = this.form.cliente.telefono;
                        data.movil = this.form.cliente.telefono;
                        data.documento = this.form.cliente.documento;
                        data.paymentmethod = this.form.paymentmethod;
                        data.valorpagar = this.form.valorpagar;

                        this.$inertia.post('/ventas', data, {
                            onBefore: (visit) => { console.log('onBefore');},
                            onStart: (visit) => {console.log('onStart');},
                            onProgress: (progress) => {console.log('onProgress');},
                            onSuccess: (page, data) => {
                                Swal.fire({
                                    //position: 'top-end',
                                    icon: 'success',
                                    title: 'La venta se ha realizado exitosamente',
                                    showConfirmButton: true,
                                    timer: 1500,
                                })
                                window.open('/ventas/reportpdf?id=' + page.props.flash.message, '_blank');
                                this.isComplete = true;
                                //this.form = [];
                                this.cart = [];
                                //this.reset();
                            },
                            onError: (errors) => {console.log('onError');},
                            onCancel: () => {console.log('onCancel');},
                            onFinish: visit => {console.log('onFinish');},
                        });
                    }
                })
            }
        },
        onValidateCliente: function(isValid, tabIndex){
            console.log('registrar cart');
            //if (!this.cart) {
                if (isValid) {
                    this.form.boleta.idrifa = this.form.idrifa.id;
                    this.form.boleta.id = this.boleta.id;
                    this.form.boleta.valor = this.form.idrifa.precio;
                    this.form.boleta.rifa = this.form.idrifa.nombre_tecnico;
                    this.form.boleta.cantidad = 1;
                    this.form.boleta.url = this.form.idrifa.urlimagen1;
                    const data = {};
                    data.id = this.form.boleta.id;
                    data.name = this.form.boleta.rifa;
                    data.price = this.form.boleta.valor;
                    data.quantity = this.form.boleta.cantidad;
                    data.url = this.form.boleta.url;
                    data.serie = this.form.idrifa.serie;
                    data.descripcion = this.form.idrifa.titulo;
                    data.idrifa = this.form.idrifa.id;
                    data.numero = this.form.boleta.numero;
                    console.log(data);

                    this.$inertia.post('/cart', data, {
                        onBefore: (visit) => { console.log('onBefore');},
                        onStart: (visit) => {console.log('onStart');},
                        onProgress: (progress) => {console.log('onProgress');},
                        onSuccess: (page) => {
                            Swal.fire({
                                //position: 'top-end',
                                icon: 'success',
                                title: 'La boleta se ha agregado al carrito de compras',
                                showConfirmButton: true,
                                timer: 1500
                            })
                            this.getCart();
                        },
                        onError: (errors) => {console.log('onError');},
                        onCancel: () => {console.log('onCancel');},
                        onFinish: visit => {console.log('onFinish');},
                    });
                } else {
                    console.log('error de validacion');
                }
            //}
        },
        validateCliente:function() {
            console.log('Validando info');

            if (this.cart) {
                 return true;
            }

            if (!this.form.boleta.idrifa) {
                Swal.fire({
                    //position: 'top-end',
                    icon: 'error',
                    title: 'Primero debe seleccionar una rifa',
                    showConfirmButton: true,
                    //timer: 1500
                })
                return false;
            }
            if (!this.form.boleta.numero) {
                Swal.fire({
                    //position: 'top-end',
                    icon: 'error',
                    title: 'Seleccione un número de boleta',
                    showConfirmButton: true,
                    //timer: 1500
                })
                return false;
            }

            console.log('validate ok');
            return true;
        },

    },
    created: function () {
        this.getCart();
        //this.getPaises();
        //this.getClientes();
        //this.getTiposdocumento();
    },
    mounted() {
        this.getCart();
        this.registrarSessionVenta(this.caja.puntoventa.id)
    },
}
</script>
<style>
* {
    margin: 0;
    padding: 0;
}
fieldset label span {
    min-width: 125px;
}
fieldset .select::after {
    content: '';
    position: absolute;
    width: 9px;
    height: 5px;
    right: 20px;
    top: 50%;
    margin-top: -2px;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='9' height='5' viewBox='0 0 9 5'><title>Arrow</title><path d='M.552 0H8.45c.58 0 .723.359.324.795L5.228 4.672a.97.97 0 0 1-1.454 0L.228.795C-.174.355-.031 0 .552 0z' fill='%23CFD7DF' fill-rule='evenodd'/></svg>");
    pointer-events: none;
}
</style>
