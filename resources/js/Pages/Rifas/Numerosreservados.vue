<template>
    <AppLayout title="Numerosreservados">
        <Statscards></Statscards>
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


                            <div class="flex w-1/2">
                                <div class="w-1/6 text-center">
                                    <button @click="openModal('registrar')" class="bg-blue-500 text-xs  hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ">Asignar</button>
                                </div>
                                <div class="w-1/6 text-center">
                                    <button @click="openModal('eliminar')" class="bg-red-500 text-xs  hover:bg-red-700 text-white font-bold py-2 px-4 rounded ">Desasignar</button>
                                </div>
                                <div class="w-1/6 text-center">
                                    <button @click="openModal('importar')" class="bg-orange-500 text-xs  hover:bg-orange-700 text-white font-bold py-2 px-4 rounded ">Importar</button>
                                </div>
                            </div>


                        </div>
                    </section>
                    <!-- Fin Encabezado y titulo -->


                    <section>
                        <div class="px-4">
                            <form @submit.prevent="getBoletasreservas(form)" @keyup.enter="getBoletasreservas(form)">
                                <div class="grid xl:grid-cols-2 xl:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <select class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" v-model="form.rifa">
                                            <option value="0" >Seleccione Rifa</option>
                                            <option v-for="rifa in arrayRifas.data" :key="rifa.id" :value="rifa.id" v-text="rifa.titulo"></option>
                                        </select>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" v-model="form.numero" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                        <label class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                            Número
                                        </label>
                                    </div>
                                </div>
                                <div class="grid xl:grid-cols-2 xl:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" v-model="form.promocional" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                        <label class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                            Promocional
                                        </label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <select class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" v-model="form.vendedor">
                                            <option value="0" >Seleccione Vendedor</option>
                                            <option v-for="vendedor in arrayVendedoresMenu" :key="vendedor.id" :value="vendedor.id" v-text="vendedor.full_name"></option>
                                        </select>
                                    </div>
                                </div>

                                <button type="button" @click="getBoletasreservas(form)" class="mx-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Buscar</button>
                            </form>
                        </div>
                    </section>
                    <!-- Fin Encabezado y titulo -->
                    <!-- Tabla de contenido -->
                    <section>
                        <div class="lg:px-4 w-full md:px-2 sm:px-0 py-2 pb-6 overflow-x-scroll">
                            <table class="table-fixed w-full">
                                <thead>
                                <tr class="text-left bg-gray-100">
                                    <th class="px-4 py-2 w-1/5 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Rifa
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
                                    <th class="px-4 py-2 w-1/5 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Número
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
                                    <th class="px-4 py-2 w-1/5 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Promocional
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
                                    <th class="px-4 w-2/5 py-2 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
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
                                    <th class="px-4 py-2 w-1/5 text-sm font-bold hover:bg-blue-500 hover:text-gray-50 rounded-b">
                                        <button @click="getCajas(buscar, 'id')" class="font-bold">
                                            Fecha
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
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-left" text-sm v-if="arrayData.data" v-for="(dato, id) in arrayData.data" :key="id">
                                    <td class="border px-4 py-2 text-sm truncate" v-text="dato.rifa.titulo"></td>
                                    <td class="border px-4 py-2 text-sm truncate" v-text="dato.numero"></td>
                                    <td class="border px-4 py-2 text-sm truncate" v-text="dato.promocional"></td>
                                    <td class="border px-4 py-2 text-sm truncate"><a :href="dato.vendedor?verVendedor(dato.vendedor.id):''"> {{ dato.vendedor?(dato.vendedor.documento + ' - '+dato.vendedor.full_name):''}} </a></td>
                                    <td class="border px-4 py-2 text-sm truncate" v-text="dateTimeFull(dato.updated_at)"></td>
                                </tr>
                                <tr v-else>
                                    <td class="border px-4 py-2 text-xs text-center" colspan="12"> La consulta no obtuvo datos</td>
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
                                                     v-on:click="this.cambiarPage(link.url, 'reservas', form)"
                                                     v-html="link.label" />
                                        </template>
                                    </div>
                                </div>
                            </section>
                            <!-- Paginacion -->
                        </div>
                    </section>
                    <!-- Fin Tabla de contenido -->



                    <!-- Ventana modal Crear Reserva-->
                    <section>
                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                            <div class="flex items-end justify-center h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                <div class="fixed inset-0 transition-opacity">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

                                <!-- Contenido modal -->
                                    <div class="inline-block lg:w-6/12 align-bottom bg-white rounded-lg text-left h-fit shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                        <button type="button" @click="closeModal()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </button>
                                    <div class="">
                                        <h2 v-text="tituloModal" class="text-xl font-bold text-gray-900 px-4 py-2"></h2>
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

                                                    <input v-model="form.idrifa.nombre_tecnico" @click="selectRifa()" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Seleccione Rifa">

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
                                            <div v-if="isImport" class="flex py-1 w-full max-h-fit overflow-y-scroll">
                                                 <div class="mb-4 w-full">
                                                     <label class="block text-gray-700 text-sm font-bold mb-2">Importar</label>

                                                         <form name="import" id="import" :action="route('numerosreservados.import')" method="POST" enctype="multipart/form-data">
                                                             <div class="form-group mb-4">
                                                                 <div class="custom-file text-left">
                                                                     <input type="hidden" name="vendedor" :value="form.idvendedor.id">
                                                                     <input type="hidden" name="rifa" :value="form.idrifa.id">
                                                                     <input type="hidden" name="_token" :value="form._token">
                                                                     <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="file" name="file" id="customFile">
                                                                 </div>
                                                             </div>
                                                         </form>
                                                     <button onclick="document.getElementById('import').submit()" class="bg-orange-500 text-xs  hover:bg-orange-700 text-white font-bold py-2 px-4 rounded ">Importar</button>

                                                 </div>
                                            </div>
                                            <div v-else class="flex py-1 w-full max-h-fit overflow-y-scroll">
                                                <div class="mb-4 w-full">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Número</label>

                                                    <div class="container flex justify-center items-center">
                                                        <div class="relative pt-4">
                                                            <div class="absolute top-4 left-3">
                                                                <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                                            <money3 v-bind="configMoney2" v-model="form.reserva.numero" @keypress.enter="valBoletaDisponible(form.reserva.numero, form.idrifa.id, form.idvendedor.id)" class="h-8 w-96 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none"></money3>
                                                            <a @click="valBoletaDisponible(form.reserva.numero, form.idrifa.id, form.idvendedor.id)">
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
                                                            <label>Asignar e Imprimir</label>

                                                        </div>
                                                        <div v-if="eliminarMode" class="flex pl-8 pt-8">
                                                            <button @click="generarReciboEliminar()" class="hover:bg-red-700 text-red-400 font-bold rounded" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                            </button>
                                                            <label>Desasignar e Imprimir</label>

                                                        </div>
                                                    </div>

                                                        <div class="flex py-1 px-2 font-bold">
                                                            <div class="w-1/3">
                                                                Número
                                                            </div>
                                                            <div class="w-1/3 px-2">
                                                                Promocional
                                                            </div>
                                                            <div class="w-1/3 px-2">
                                                                Eliminar
                                                            </div>
                                                        </div>
                                                        <div v-for="(reserva, index) in form.reservas" :key="reserva.numero" class="bg-blue-200 rounded-md flex py-1 px-2">
                                                            <div class="w-1/3">
                                                                {{ reserva.numero }}
                                                            </div>
                                                            <div class="w-1/3 px-2">
                                                                {{ reserva.promocional }}
                                                            </div>
                                                            <div class="w-1/3 px-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" @click="eliminarReserva(reserva.numero, index)" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="bg-blue-400 rounded-md flex py-1 px-2 font-bold">
                                                            <div class="w-1/3">
                                                                Cantidad:
                                                            </div>
                                                            <div class="w-1/3 px-2">
                                                            </div>
                                                            <div class="w-1/3 px-2">
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
                                                                  v-on:click="this.cambiarPage(link.url, 'rifas', form)"
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
                                    <button type="button" @click="closeMoodalVendedor()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
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
                                                            <input type="text" v-model="buscar" @keyup.enter="getVendedores(buscar,'nombre', true)" class="h-8 w-26 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Buscar (Nombre, apellido)">
                                                            <button @click="getVendedores(buscar,'nombre', true)">
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
                                                <tr @click="onSelectVendedor(vendedor, )" class="hover:bg-blue-50 text-center" text-sm v-if="arrayVendedores.data" v-for="(vendedor, id) in arrayVendedores.data" :key="id">
                                                    <td class="border px-1 py-2 text-sm truncate" v-text="vendedor.full_name"></td>
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
                                                                     v-on:click="this.cambiarPage(link.url, 'vendedores', form)"
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
import {InertiaLink, usePage} from "@inertiajs/inertia-vue3";
import Input from "../../Jetstream/Input";


export default {

    components: {
        Input,
        Button,
        AppLayout,
        Icon,
        Pagination,
        Toggle,
        QuillEditor,
        money3: Money3Component,
    },
    props:{
        datos : [],
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
            ispage: true,

            tituloModal: '',
            form: {
                _token: usePage().props.value._token,
                rifa: 0,
                numero: null,
                promocional: null,
                vendedor: 0,
                cliente: null,
                estado: '',
                reserva: {
                    numero: null,
                    promocional: null
                },
                rangoinicial: null,
                rangofinal: null,
                idvendedor: 0,
                reservas:[]
            },
            arrayRifas: {
                data: [],
                links: []
            },
            arrayVendedores: {
                data: [],
                links: []
            },
            arrayVendedoresMenu: [],
            arrayClientes: [],
            editMode: false,
            asignarMode: false,
            eliminarMode: false,
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
            isImport: false,
        }
    },
    methods: {
        selTipoSerie: function (data){
            this.isIndividual = data;
        },

        onSelectRifa: function(data){
            this.form.idrifa = data;
            this.closeMoodalRifa();
            this.actualizarRangos();
        },
        onSelectVendedor: function(data, target = ''){
            this.form.idvendedor = data;
            this.closeMoodalVendedor();
        },
        actualizarRangos: function() {
            let cantidad = 0;
            let rangoinicial = '';
            let rangofinal = '';

            cantidad = Math.pow(10, this.form.idrifa.cifras);
            rangoinicial = '' + String('0'.toString()).padStart(this.form.idrifa.cifras, '0'.toString());
            rangofinal = (cantidad - 1);
            //console.log(rangoinicial);
            this.form.numero = rangoinicial + ' - ' + rangofinal;

            this.configMoney2.min = rangoinicial.toString();
            this.configMoney2.max = rangofinal.toString();
            this.configMoney2.minimumNumberOfCharacters = this.form.idrifa.cifras;

        },
        generarReciboEliminar: function () {
            if (this.form.reservas.length > 0){
                var url = '/numerosreservados/reportpdfDesasignacion';
                axios.get(url, {
                    params: {
                        rifa: this.form.idrifa.nombre_tecnico,
                        vendedor: this.form.idvendedor.nombre + ' '+ this.form.idvendedor.apellido,
                        reservas: this.form.reservas,
                        iduserdestino: this.form.idvendedor.id,
                        idrifa: this.form.idrifa.id
                    }
                }).then((res) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Se ha generado el recibo correspondiente',
                        showConfirmButton: true,
                    })
                    this.getBoletasreservas();
                    window.open(res.data.url, '_blank');
                    this.form.reservas = [];
                })
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Por favor seleccione por lo menos un número',
                    showConfirmButton: true,
                })
            }

        },
        generarReciboAsignar: function () {
            if (this.form.reservas.length > 0){
                var url = '/numerosreservados/reportpdfAsignacion';
                axios.get(url, {
                    params: {
                        rifa: this.form.idrifa.nombre_tecnico,
                        vendedor: this.form.idvendedor.nombre + ' '+ this.form.idvendedor.apellido,
                        reservas: this.form.reservas,
                        iduserdestino: this.form.idvendedor.id,
                        idrifa: this.form.idrifa.id
                    }
                }).then((res) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Se ha generado el recibo correspondiente',
                        showConfirmButton: true,
                    })
                    window.open(res.data.url, '_blank');
                    this.getBoletasreservas();
                    this.form.reservas = [];
                })
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Por favor seleccione por lo menos un número',
                    showConfirmButton: true,
                })
            }

        },
        eliminarReserva: function(numero, index){
            this.form.reservas.splice(index, 1);
            /*
            var url = '/numerosreservados/eliminarReserva';
            axios.get(url, {
                params: {
                    numero: numero,
                    rifa: this.form.idrifa.id,
                    idvendedor: this.form.idvendedor.id,
                }
            }).then((res) => {
                console.log(res.data);
                var respuesta = res.data;
                let isocupado = respuesta.isocupado;
                if (isocupado) {
                    this.form.reservas.splice(index, 1);
                } else {
                    Swal.fire({
                        //position: 'top-end',
                        icon: 'warning',
                        title: 'La reserva no se pudo liberar',
                        showConfirmButton: true,
                        //timer: 1500
                    })
                }
            })

             */
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
                    this.tituloModal = 'Asignar Boletería';
                    this.form.id = null;
                    this.form.idrifa = 0;
                    this.form.numero = null;
                    this.form.estado = false;
                    this.form.rangoinicial = null;
                    this.form.rangofinal = null;
                    this.form.idvendedor = 0;
                    this.form.idcliente = 0;
                    this.form.fecha = null;
                    this.asignarMode = true;
                    this.eliminarMode = false;
                    break;
                }
                case 'eliminar':
                {
                    this.tituloModal = 'Desasignar Boletería';
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
                case 'importar':
                {
                    this.tituloModal = 'Importar reserva de Boletería';
                    this.form.id = null;
                    this.form.idrifa = 0;
                    this.form.numero = null;
                    this.form.estado = false;
                    this.form.rangoinicial = null;
                    this.form.rangofinal = null;
                    this.form.idvendedor = 0;
                    this.form.idcliente = 0;
                    this.form.fecha = null;
                    this.asignarMode = true;
                    this.eliminarMode = false;
                    this.isImport = true;
                    break;
                }
            }
        },
        selectRifa: function () {
            this.isOpenRifa = true;
            this.getRifas('','titulo','true');
        },
        selectVendedor: function (target = '') {
            this.isOpenVendedor = true;
            this.getVendedores('','users.nombre','true', target);
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
            this.form.reservas = [];
        },
        valBoletaDisponible: function (numero, rifa, idvendedor){
            if(!this.form.idrifa.id) {
                Swal.fire({
                    //position: 'top-end',
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
                    var url = '/numerosreservados/valBoletaDisponible';
                } else if (this.eliminarMode) {
                    var url = '/numerosreservados/valBoletaOcupada';
                }
                axios.get(url, {
                    params: {
                        numero: numero,
                        rifa: rifa,
                        idvendedor: idvendedor,
                    }
                }).then((res) => {
                    //console.log(res.data);
                    var respuesta = res.data;
                    let isocupado = respuesta.isocupado;
                    if (isocupado) {
                        this.form.reserva.numero = respuesta.boleta.numero;
                        this.form.reserva.promocional = respuesta.boleta.promocional;
                        this.form.reservas.push({
                            numero: this.form.reserva.numero,
                            promocional: this.form.reserva.promocional
                        });
                        this.form.reserva.numero = null;
                        this.form.reserva.promocional = null;
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
                            //console.log(data);
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
                });
            })

        },

    },
    created: function () {
        this.arrayData = this.datos;
        this.getVendedoresSelect('');
        this.getVendedores('','nombre', true);
        this.getRifas('');
    },
    mounted() {
    },
}
</script>
