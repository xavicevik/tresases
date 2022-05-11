<template>
    <AppLayout title="Ventas" :cart="cart">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nueva venta
            </h2>
        </template>
        <div class="py-4 w-10/12 mx-auto lg:px-8 md:px-6 sm:px-2">
            <div class="mx-auto 2xl:8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- Fin Mensajes Flash -->

                    <form-wizard next-button-text="Siguiente" subtitle="sub" color="#009db0"
                                 back-button-text="Volver" step-size="sm"
                                 @on-complete="onComplete"
                                 @on-change="onChange"
                                 @on-validate="onValidateRifa"
                                 @on-error="onError"
                    >
                        <tab-content title="Detalle de Rifa" icon="ti-ticket" :before-change="validateRifa" >
                            <form>
                                <div class="bg-white px-4 pt-2 pb-2 sm:p-6 sm:pb-4">
                                    <div class="">
                                        <!-- Mensajes Flash -->

                                        <!-- Fin Mensajes Flash -->
                                        <!-- Formulario -->
                                        <section>
                                            <div class="p-2">
                                                <img v-if="form.idrifa.urlimagen1 != null" :src="'/storage/'+form.idrifa.urlimagen1" alt="image" class="mx-auto w-4/12"/>
                                            </div>
                                            <div class="flex py-1">
                                                <div class="mb-4 w-full pr-2">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Rifa</label>
                                                    <input v-model="form.idrifa.nombre_tecnico" @click="selectRifa()" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Seleccione Rifa">
                                                    <div v-if="$page.props.errors.nombre_tecnico" class="text-red-500">{{ $page.props.errors.rifa }}</div>
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
                                                        <input type="text" v-model="form.numero" @keypress.enter="valBoletaLibre(form.numero, form.idrifa.id, form.idrifa.cifras)" class="h-8 w-96 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" :placeholder="'Buscar (' + form.rangoinicial?form.rangoinicial : '' + ' - ' + form.rangofinal +')'">
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
                                                            <tr class="text-center text-sm"  >
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
                        <tab-content title="Generar boleta" icon="ti-check">
                            Tercer paso
                        </tab-content>
                        <tab-content title="Registrar pago" icon="ti-money">

                            <div class="w-full mx-auto pb-5">
                                <h1 class="sr-only">Resumen de la transacción</h1>

                                <form class="lg:grid lg:gap-x-12 xl:gap-x-16">

                                    <!-- Order summary -->
                                    <div class="mt-5 mb-10 lg:mt-0">
                                        <h2 class="text-lg font-bold font-medium text-gray-900">Resumen de la transacción</h2>

                                        <div class="mt-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                                            <ul role="list" class="divide-y divide-gray-200">
                                                <li class="flex py-6 px-4 sm:px-6" v-for="(dato, id) in cart" :key="id">
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            <img :src="dato.attributes?'/storage/'+dato.attributes.url:''" alt="Front of men&#039;s Basic Tee in black." class="w-20 rounded-md">
                                                        </h4>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            <vue-qrcode value="Hello, World!" :options="{ width: 50 }"></vue-qrcode>
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
                                                <div class="flex items-center justify-between">
                                                    <dt class="text-sm">Subtotal</dt>
                                                    <dd class="text-sm font-medium text-gray-900">$64.000</dd>
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <dt class="text-sm">Impuestos</dt>
                                                    <dd class="text-sm font-medium text-gray-900">$5.520</dd>
                                                </div>
                                                <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                                                    <dt class="text-base font-medium">Total</dt>
                                                    <dd class="text-base font-medium text-gray-900">$75.502</dd>
                                                </div>
                                            </dl>
                                            <div class="w-1/3 mx-auto justify-items-center">
                                                <label class="block text-sm font-medium font-bold text-gray-700">Código de venta</label>
                                                <div class="mt-1">
                                                    <input type="text" autocomplete="family-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                </div>
                                            </div>
                                            <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                                                <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">Confirmar orden</button>
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
                                        <div class="mt-5 mb-10 lg:mt-0">
                                            <h2 class="text-lg font-bold text-gray-900">Información del cliente</h2>

                                            <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                                                    <div class="mt-1">
                                                        <input type="text" v-model="form.cliente.nombre" autocomplete="given-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    </div>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Apellido</label>
                                                    <div class="mt-1">
                                                        <input type="text" v-model="form.cliente.apellido" autocomplete="family-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-2">
                                                    <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                                                    <div class="mt-1">
                                                        <input type="text" v-model="form.cliente.movil" autocomplete="street-address" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    </div>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Tipo documento</label>
                                                    <div class="mt-1">
                                                        <input type="text" v-model="form.cliente.idtipos_documento" autocomplete="address-level1" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    </div>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Documento</label>
                                                    <div class="mt-1">
                                                        <input type="text" v-model="form.cliente.documento" autocomplete="postal-code" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    </div>
                                                </div>

                                                <div>
                                                    <label for="city" class="block text-sm font-medium text-gray-700">Ciudad</label>
                                                    <div class="mt-1">
                                                        <input type="text" name="city" id="city" autocomplete="address-level2" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    </div>
                                                </div>

                                                <div>
                                                    <label for="country" class="block text-sm font-medium text-gray-700">País</label>
                                                    <div class="mt-1">
                                                        <select id="country" name="country" autocomplete="country-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                            <option>United States</option>
                                                            <option>Canada</option>
                                                            <option>Mexico</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-2">
                                                    <label class="block text-sm font-medium text-gray-700">Correo</label>
                                                    <div class="mt-1">
                                                        <input type="email" v-model="form.cliente.correo" autocomplete="email" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payment -->
                                        <div class="mt-10 border-t border-gray-200 pt-10">
                                            <h2 class="text-lg font-bold border-b-2 font-medium text-gray-900">Método de pago</h2>

                                            <fieldset class="mt-4">
                                                <legend class="sr-only">Payment type</legend>
                                                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                                                    <div class="flex items-center">
                                                        <input id="credit-card" name="payment-type" type="radio" checked class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                                        <label for="credit-card" class="ml-3 block text-sm font-medium text-gray-700"> Tarjeta de crédito/débito </label>
                                                    </div>

                                                    <div class="flex items-center">
                                                        <input id="paypal" name="payment-type" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                                        <label for="paypal" class="ml-3 block text-sm font-medium text-gray-700"> Transferencia </label>
                                                    </div>

                                                    <div class="flex items-center">
                                                        <input id="etransfer" name="payment-type" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                                        <label for="etransfer" class="ml-3 block text-sm font-medium text-gray-700"> Efectivo </label>
                                                    </div>
                                                </div>
                                            </fieldset>

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
                                                                <button type="button" class="-m-2.5 bg-white p-2.5 flex items-center justify-center text-gray-400 hover:text-gray-500">
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
                                                <div class="flex items-center justify-between">
                                                    <dt class="text-sm">Subtotal</dt>
                                                    <dd class="text-sm font-medium text-gray-900">$64.000</dd>
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <dt class="text-sm">Impuestos</dt>
                                                    <dd class="text-sm font-medium text-gray-900">$5.520</dd>
                                                </div>
                                                <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                                                    <dt class="text-base font-medium">Total</dt>
                                                    <dd class="text-base font-medium text-gray-900">$75.502</dd>
                                                </div>
                                            </dl>

                                            <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                                                <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">Confirm order</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Fin Checkout -->
                        </tab-content>
                        <tab-content title="Detalle de Cliente" icon="ti-user" :before-change="validateCliente" >
                                <form>
                                    <div class="bg-white px-4 pb-2">
                                        <div class="">
                                            <!-- Mensajes Flash -->

                                            <!-- Fin Mensajes Flash -->
                                            <!-- Formulario -->
                                            <section>
                                               <!-- Contenido modal -->
                                                <div class="mx-auto justify-items-center px-2 w-11/12 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all l" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                                    <div class="">
                                                        <h2 class="text-xl font-bold border-b-2 text-gray-900 px-4 pb-2">Seleccionar Cliente</h2>
                                                    </div>
                                                    <div class="mx-auto w-11/12/12 px-4 py-4">
                                                        <label class="block px-4 text-gray-700 text-sm font-bold mb-2">Cliente</label>
                                                        <input v-model="form.metacliente" @click="selectCliente()" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ingrese cedula">
                                                    </div>
                                                    <!-- Inicio Form -->
                                                    <form>
                                                        <div class="bg-white pt-2 pb-2 sm:p-6 sm:pb-4">
                                                            <div class="">
                                                                <!-- Mensajes Flash -->


                                                                <!-- Fin Mensajes Flash -->
                                                                <!-- Formulario -->
                                                                <section>
                                                                    <div class="flex py-1">
                                                                        <div class="mb-4 w-full pr-3">
                                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>

                                                                            <input v-model="form.cliente.nombre" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Nombre">

                                                                            <div v-if="$page.props.errors.rifa" class="text-red-500">{{ $page.props.errors.rifa }}</div>
                                                                        </div>
                                                                        <div class="mb-4 w-full pl-3">
                                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Apellido</label>

                                                                            <input v-model="form.cliente.apellido" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Apellido">

                                                                            <div v-if="$page.props.errors.rifa" class="text-red-500">{{ $page.props.errors.rifa }}</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex py-1">
                                                                        <div class="mb-4 w-full pr-3">
                                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Tipo de documento</label>
                                                                            <select class="block w-full rounded-lg text-gray-700 text-sm" :disabled="verMode" v-model="form.cliente.idtipos_documento">
                                                                                <option value="0" >Seleccione</option>
                                                                                <option v-for="tipodoc in arrayTiposdocumento" :key="tipodoc.id" :value="tipodoc.id" v-text="tipodoc.nombre_corto"></option>
                                                                            </select>
                                                                            <div v-if="$page.props.errors.idciudad" class="text-red-500">{{ $page.props.errors.idciudad }}</div>
                                                                        </div>
                                                                        <div class="mb-4 w-full pl-3">
                                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Documento</label>

                                                                            <input v-model="form.cliente.documento" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Documento">

                                                                            <div v-if="$page.props.errors.rifa" class="text-red-500">{{ $page.props.errors.rifa }}</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex py-1">
                                                                        <div class="mb-4 w-full pr-3">
                                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Correo</label>

                                                                            <input v-model="form.cliente.correo" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Correo">

                                                                            <div v-if="$page.props.errors.rifa" class="text-red-500">{{ $page.props.errors.rifa }}</div>
                                                                        </div>
                                                                        <div class="mb-4 w-full pl-3">
                                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Celular</label>

                                                                            <input v-model="form.cliente.movil" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Celular">

                                                                            <div v-if="$page.props.errors.rifa" class="text-red-500">{{ $page.props.errors.rifa }}</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex py-1">
                                                                        <div class="mb-4 w-full pr-3">
                                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Teléfono</label>

                                                                            <input v-model="form.cliente.telefono" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Teléfono">

                                                                            <div v-if="$page.props.errors.rifa" class="text-red-500">{{ $page.props.errors.rifa }}</div>
                                                                        </div>
                                                                        <div class="mb-4 w-full pl-3">
                                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Dirección</label>

                                                                            <input v-model="form.cliente.direccion" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Dirección">

                                                                            <div v-if="$page.props.errors.rifa" class="text-red-500">{{ $page.props.errors.rifa }}</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex py-1">
                                                                        <div class="mb-4 w-full pr-3">
                                                                            <select class="block w-full rounded-lg text-gray-700 text-sm" :disabled="verMode" v-model="form.cliente.idpais" @change="getDepartamentos()">
                                                                                <option value="0" >Seleccione País</option>
                                                                                <option v-for="pais in arrayPaises" :key="pais.id" :value="pais.id" v-text="pais.nombre"></option>
                                                                            </select>
                                                                        </div>
                                                                        <div v-if="$page.props.errors.idpais" class="text-red-500">{{ $page.props.errors.idpais }}</div>
                                                                        <div class="mb-4 w-full px-3">
                                                                            <select class="block w-full rounded-lg text-gray-700 text-sm" :disabled="verMode" v-model="form.cliente.iddepartamento" @change="getCiudades()">
                                                                                <option value="0" >Seleccione Departamento</option>
                                                                                <option v-for="departamento in arrayDepartamentos" :key="departamento.id" :value="departamento.id" v-text="departamento.nombre"></option>
                                                                            </select>
                                                                            <div v-if="$page.props.errors.iddepartamento" class="text-red-500">{{ $page.props.errors.iddepartamento }}</div>
                                                                        </div>
                                                                        <div class="mb-4 w-full pl-3">
                                                                            <select class="block w-full rounded-lg text-gray-700 text-sm" :disabled="verMode" v-model="form.cliente.idciudad">
                                                                                <option value="0" >Seleccione Ciudad</option>
                                                                                <option v-for="ciudad in arrayCiudades" :key="ciudad.id" :value="ciudad.id" v-text="ciudad.nombre"></option>
                                                                            </select>
                                                                            <div v-if="$page.props.errors.idciudad" class="text-red-500">{{ $page.props.errors.idciudad }}</div>
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
                                            </section>
                                            <!-- Fin formulario -->
                                        </div>
                                    </div>
                                </form>
                            </tab-content>
                    </form-wizard>


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
                                                <tr class="bg-gray-100">
                                                    <th class="px-4 py-2 w-2/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
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
                                                    <th class="px-4 py-2 w-1/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
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
                                                    <th class="px-4 py-2 w-1/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
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
                                                    <th class="px-4 py-2 w-4/12 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
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
        FormWizard,
        TabContent,
        VueQrcode
    },
    props:{
        data: [],
        errors: Object,
    },
    computed: {
    },
    data() {
        return {
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
                },
                cliente: [],
                numero: null,
                estado: false,
                rangoinicial: null,
                rangofinal: null,
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
                promocionales: []
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
            arrayPaises: [],
            arrayDepartamentos: [],
            arrayCiudades: [],
            arrayTiposdocumento: [],
            cart: [],
            numerotmp: null,
            boleta: []
        }
    },
    methods: {
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
        formatPrice: function(value) {
            let val = (value/1).toFixed(0).replace('.', ',')
            return '$ '+ val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
        dateTime: function(value) {
            return moment(value).format('DD/MM/YYYY');
        },
        dateTimeFull: function(value) {
            return moment(value).format('YYYY-MM-DD HH:MM:SS');
        },
        actualizarRangos: function() {
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

                        if (this.boleta && this.boleta.id && this.boleta.id > 0) {
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
            this.form.metacliente = data.tipodocumento.nombre_corto + ' ' + data.documento + ' - ' + data.nombre + ' ' + data.apellido
                                        + ' Tel: ' + data.movil + ' (' + data.ciudad.nombre + ')';
            this.closeMoodalCliente();
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
        onComplete: function(){
            console.log("onComplete");
        },
        onValidateRifa: function(isValid, tabIndex){
            console.log('registrar cart '+ tabIndex);
            switch (tabIndex) {
                case 0:
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
                    break;
                case 1:
                    console.log('Se valida cliente');
                    break;
            }

        },
        validateRifa:function() {
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

            return true;
        },
        onError:function(error){
            console.log('error ?' + error)
        },
        validateCheckout:function() {
            console.log('Validando checkout');

            return true;
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
        getPaises: function () {
            axios.get('/paises',).then((res) => {
                this.arrayPaises = res.data.paises;
                console.log(res.data.paises)
            })
        },
        getDepartamentos: function () {
            axios.get('/paises/departamentos', {
                params: {
                    idpais: this.form.cliente.idpais
                }
            }).then((res) => {
                this.arrayDepartamentos = res.data.departamentos;
                console.log(res.data.departamentos)
            })
        },
        getCiudades: function () {
            axios.get('/paises/ciudades', {
                params: {
                    idpais: this.form.cliente.idpais,
                    iddepartamento: this.form.cliente.iddepartamento
                }
            }).then((res) => {
                this.arrayCiudades = res.data.ciudades;
                console.log(res.data.ciudades)
            })
        },
        getTiposdocumento: function () {
            axios.get('/master/tiposdocsearch',).then((res) => {
                this.arrayTiposdocumento = res.data.data;
                console.log(res.data.data)
            })
        },
    },
    created: function () {
        this.getCart();
        this.getPaises();
        this.getDepartamentos();
        this.getClientes();
        this.getTiposdocumento();
    },
    mounted() {
        console.log('Component mounted.');
        this.getCart()
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
