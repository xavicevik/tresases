<template>
    <body class="overflow-y-hidden dark:bg-gray-900">
    <div class="py-14 px-14 md:px-6 2xl:px-20 2xl:container 2xl:mx-auto">
        <div class="flex justify-start item-start space-y-2 flex-col">
            <div class="">
                <img class="h-100" src="/storage/img/logo.jpg" alt="dress" />
                <h1 class="text-3xl dark:text-white lg:text-4xl font-semibold leading-7 lg:leading-9 text-gray-800">Venta #{{ data.id }}</h1>
            </div>
            <p class="text-base dark:text-gray-300 font-medium leading-6 text-gray-600">{{ data.fechaventa }}</p>
        </div>
        <div class="mt-10 flex flex-col xl:flex-row jusitfy-center items-stretch w-full xl:space-x-8 space-y-4 md:space-y-6 xl:space-y-0">
            <div class="flex flex-col justify-start items-start w-full space-y-4 md:space-y-6 xl:space-y-8">
                <div class="flex flex-col justify-start items-start dark:bg-gray-800 bg-gray-50 px-4 py-4 md:py-6 md:p-6 xl:p-8 w-full">
                    <p class="text-lg md:text-xl dark:text-white font-semibold leading-6 xl:leading-5 text-gray-800">Detalle compra</p>

                    <div v-for="(dato, id) in data.detalles" :key="id" class="mt-4 md:mt-6 flex flex-col md:flex-row justify-start items-start md:items-center md:space-x-6 xl:space-x-8 w-full">
                        <div class="pb-4 md:pb-8 w-full md:w-40">
                            <img class="w-full hidden md:block" :src="'/storage/'+dato.rifa.urlimagen1" alt="dress" />
                            <img class="w-full md:hidden" src="https://i.ibb.co/L039qbN/Rectangle-10.png" alt="dress" />
                        </div>
                        <div class="border-b border-gray-200 md:flex-row flex-col flex justify-between items-start w-full pb-8 space-y-4 md:space-y-0">
                            <div class="w-full flex flex-col justify-start items-start space-y-8">
                                <h3 class="text-xl dark:text-white xl:text-2xl font-semibold leading-6 text-gray-800">{{ dato.rifa.nombre_tecnico }}</h3>
                                <div class="flex justify-start items-start flex-col space-y-2">
                                    <p class="text-sm dark:text-white leading-none text-gray-800"><span class="dark:text-gray-400 text-gray-300">Serie: </span> {{ dato.rifa.serie }}</p>
                                    <p class="text-sm dark:text-white leading-none text-gray-800"><span class="dark:text-gray-400 text-gray-300">Código: </span> {{ dato.boleta.codigo }}</p>
                                    <p class="text-sm dark:text-white leading-none text-gray-800"><span class="dark:text-gray-400 text-gray-300">Boleta: </span> {{ dato.boleta.numero }}</p>
                                </div>
                            </div>
                            <div class="flex justify-between space-x-8 items-start w-full">
                                <p class="text-base dark:text-white xl:text-lg leading-6">{{ formatPrice(dato.valor) }}</p>
                                <p class="text-base dark:text-white xl:text-lg leading-6 text-gray-800">01</p>
                                <p class="text-base dark:text-white xl:text-lg font-semibold leading-6 text-gray-800">{{ formatPrice(dato.valor) }}</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="flex justify-center flex-col md:flex-row flex-col items-stretch w-full space-y-4 md:space-y-0 md:space-x-6 xl:space-x-8">
                    <div class="flex flex-col px-4 py-6 md:p-6 xl:p-8 w-full bg-gray-50 dark:bg-gray-800 space-y-6">
                        <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">Resumen</h3>
                        <div class="flex justify-center items-center w-full space-y-4 flex-col border-gray-200 border-b pb-4">
                            <div class="flex justify-between w-full">
                                <p class="text-base dark:text-white leading-4 text-gray-800">Subtotal</p>
                                <p class="text-base dark:text-gray-300 leading-4 text-gray-600">{{ formatPrice(data.valortotal) }}</p>
                            </div>
                        </div>
                        <div class="flex justify-between items-center w-full">
                            <p class="text-base dark:text-white font-semibold leading-4 text-gray-800">Total</p>
                            <p class="text-base dark:text-gray-300 font-semibold leading-4 text-gray-600">{{ formatPrice(data.valortotal) }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center px-4 py-6 md:p-6 xl:p-8 w-full bg-gray-50 dark:bg-gray-800 space-y-6">
                        <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">Método de venta</h3>
                        <div class="flex justify-between items-start w-full">
                            <div class="flex justify-center items-center space-x-4">
                                <div class="w-8 h-8">
                                    <img class="w-full h-full" alt="logo" src="https://i.ibb.co/L8KSdNQ/image-3.png" />
                                </div>
                                <div class="flex flex-col justify-start items-center">
                                    <p class="text-lg leading-6 dark:text-white font-semibold text-gray-800">DPD Delivery<br /><span class="font-normal">Delivery with 24 Hours</span></p>
                                </div>
                            </div>
                            <p class="text-lg font-semibold leading-6 dark:text-white text-gray-800">$8.00</p>
                        </div>
                        <div class="w-full flex justify-center items-center">
                            <button class="hover:bg-black dark:bg-white dark:text-gray-800 dark:hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 py-5 w-96 md:w-full bg-gray-800 text-base font-medium leading-4 text-white">View Carrier Details</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 w-full xl:w-96 flex justify-between items-center md:items-start px-4 py-6 md:p-6 xl:p-8 flex-col">
                <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">Cliente</h3>
                <div class="flex flex-col md:flex-row xl:flex-col justify-start items-stretch h-full w-full md:space-x-6 lg:space-x-8 xl:space-x-0">
                    <div class="flex flex-col justify-start items-start flex-shrink-0">
                        <div class="flex justify-center w-full md:justify-start items-center space-x-4 py-8 border-b border-gray-200">
                            <div class="flex justify-start items-start flex-col space-y-2">
                                <p class="text-base dark:text-white font-semibold leading-4 text-left text-gray-800">{{ data.cliente.nombre+' '+data.cliente.apellido }}</p>
                                <p class="text-sm dark:text-gray-300 leading-5 text-gray-600">{{ data.cliente.documento }}</p>
                            </div>
                        </div>

                        <div class="flex justify-center text-gray-800 dark:text-white md:justify-start items-center space-x-4 py-4 border-b border-gray-200 w-full">
                            <img class="dark:hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/order-summary-3-svg1.svg" alt="email">
                            <img class="hidden dark:block" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/order-summary-3-svg1dark.svg" alt="email">
                            <p class="cursor-pointer text-sm leading-5 ">{{ data.cliente.correo }}</p>
                        </div>
                    </div>
                    <div class="flex justify-between xl:h-full items-stretch w-full flex-col mt-6 md:mt-0">
                        <div class="flex justify-center md:justify-start xl:flex-col flex-col md:space-x-6 lg:space-x-8 xl:space-x-0 space-y-4 xl:space-y-12 md:space-y-0 md:flex-row items-center md:items-start">
                            <div class="flex justify-center md:justify-start items-center md:items-start flex-col space-y-4 xl:mt-8">
                                <p class="text-base dark:text-white font-semibold leading-4 text-center md:text-left text-gray-800">Información personal</p>
                                <p class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">{{ data.cliente.movil }}</p>
                                <p class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">{{ data.cliente.direccion }}</p>
                            </div>

                        </div>
                        <div class="flex w-full justify-center items-center md:justify-start md:items-start">
                            <button class="mt-6 md:mt-0 dark:border-white dark:hover:bg-gray-900 dark:bg-transparent dark:text-white py-5 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 border border-gray-800 font-medium w-96 2xl:w-full text-base font-medium leading-4 text-gray-800">Edit Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Ventana modal -->
    <section>
        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400 backdrop-blur-sm" v-if="isOpen">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

                <!-- Contenido modal -->
                <div class="inline-block lg:w-7/12 py-10 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <section>
                        <div class="flex justify-between mx-auto p-4">
                            <div class="w-1/2">
                                <h1 class="font-bold text-xl text-black-800 leading-tight">
                                    Detalle de la venta
                                </h1>
                            </div>

                            <div class="w-1/2 pr-2">
                                <div class="container flex justify-center items-center">
                                    <div class="relative">
                                        <div class="absolute top-4 left-3">
                                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                                            <input type="password" v-model="buscar" @keydown.enter="getSumary(buscar)" class="h-8 w-40 pl-4 pr-4 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Digite documento">
                                            <button @click="getSumary(buscar)">
                                            <div class="absolute top-2 right-2">
                                                <Icon icon="fe:search" class="h-4"  />
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>

                </div>
                <!-- Fin Contenido modal -->
            </div>
        </div>
    </section>
    <!-- Fin Ventana modal -->

    </body>
</template>

<script>
import moment from "moment";
import Swal from "sweetalert2";

export default {

    props:{
        data: [],
        buscar: null
    },
    data() {
        return {
            isOpen: true,
        }
    },
    methods: {
        formatPrice: function (value) {
            let val = (value / 1).toFixed(0).replace('.', ',')
            return '$ ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
        closeMoodal: function(){
            this.isOpen = false;
        },
        getSumary: function(documento){
            if(this.data.cliente.documento == documento) {
                this.isOpen = false;
            } else {
                Swal.fire({
                    //position: 'top-end',
                    icon: 'error',
                    title: 'Ingrese el documento de identidad',
                    showConfirmButton: false,
                    timer: 2500
                })
            }
        },
    },

}
</script>

<style>

</style>
