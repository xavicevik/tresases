<script setup>
import { ref, computed  } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue';
import JetBanner from '@/Jetstream/Banner.vue';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import JetNavLink from '@/Jetstream/NavLink.vue';
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue';
import { usePage } from '@inertiajs/inertia-vue3'

defineProps({
    title: String,
    isOpenCart: false,
    total: null,
});

import { onMounted } from 'vue'
import Button from "../Jetstream/Button";

onMounted(() => {
    console.log('ready');
})

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    Inertia.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    Inertia.post(route('logout'));
};

</script>
<script>

export default {
    data() {
        return {
            cartx: [],
            isMenutransac: false,
            isMenuConfig: false,
            isMenuUsers: false,
            isMenuPuntoventa: false,
            isMenuCajas: false,
            isMenuRifas: false,
            isMenuVentas: false,
            isMenuComision: false,
        }
    },
    computed: {
        showCart() {
            return usePage().props.value.cart.cart;
        }
    }
}

</script>


<template>

    <div >
        <Head :title="title" />

        <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white text-black ">

            <!-- Page Heading -->
            <!-- Header -->
            <div class="fixed w-full flex items-center justify-between h-14 text-white z-10">
                <div class="flex items-center justify-start md:justify-center pl-3 w-14 md:w-64 h-14 bg-blue-800 dark:bg-gray-800 border-none">
                    <img class="w-7 h-7 md:w-10 md:h-10 mr-2 rounded-md overflow-hidden" src="https://therminic2018.eu/wp-content/uploads/2018/07/dummy-avatar.jpg" />
                    <span class="hidden md:block">
                        {{ $page.props.auth.user.roles[0].name }}<br>
                        {{ $page.props.user.username }}
                    </span>

                </div>
                <div class="flex justify-between items-center h-14 bg-blue-800 dark:bg-gray-800 header-right">
                    <div class="flex items-center w-full max-w-xl mr-4 p-2 shadow-sm ">
                    </div>
                    <ul class="flex items-center">
                        <li>
                            <div class="relative ">
                                <div class="flex flex-row cursor-pointer truncate p-2 px-4  rounded" @click="isOpenCart=!isOpenCart">
                                    <div></div>
                                    <div class="flex flex-row-reverse ml-2 w-full">
                                        <div slot="icon" class="relative">
                                            <div class="absolute text-xs rounded-full -mt-1 -mr-2 px-1 font-bold top-0 right-0 bg-red-700 text-white">
                                                {{ showCart?Object.keys(showCart).length:0 }}
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart w-6 h-6 mt-2">
                                                <circle cx="9" cy="21" r="1"></circle>
                                                <circle cx="20" cy="21" r="1"></circle>
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute w-full  rounded-b border-t-0 z-10" v-show="isOpenCart">
                                    <div class="shadow-xl w-64 overflow-y-auto h-80">
                                        <div v-if="showCart" v-for="(dato, id) in showCart" :key="id" class="p-2 flex bg-white hover:bg-gray-400 cursor-pointer border-b border-gray-100" style="">
                                            <div class="p-2 w-12">
                                                <img :src="dato.attributes?'/storage/'+dato.attributes.url:''"  height="50" width="50" alt="img product"></div>
                                            <div class="flex-auto text-sm w-32">
                                                <div class="font-bold"> {{ dato.name }}</div>
                                                <div class="truncate">{{ dato.attributes?dato.attributes.numero:'' }}</div>
                                                <div class="text-gray-400">Cant: {{ dato.quantity }}</div>
                                            </div>
                                            <div class="flex flex-col w-18 text-sm font-medium items-end">
                                                <div class="w-4 h-4 mb-6 hover:bg-red-200 rounded-full cursor-pointer text-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 ">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg>
                                                </div>
                                                ${{ dato.price }}</div>
                                        </div>
                                        <div class="p-4 justify-center flex">
                                            <button class="text-base  undefined  hover:scale-110 focus:outline-none flex justify-center px-4 py-2 rounded font-bold cursor-pointer
                                                            hover:bg-teal-700 hover:text-teal-100
                                                            bg-teal-100
                                                            text-teal-700
                                                            border duration-200 ease-in-out
                                                            border-teal-600 transition">
                                                Total: {{ total }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="block w-px h-6 mx-3 bg-gray-400 dark:bg-gray-700"></div>
                        </li>
                        <li v-if="$page.props.auth.puntoventa">
                            Punto de Venta: {{ $page.props.auth.puntoventa[0].nombre }}
                        </li>

                        <li>
                            <div class="block w-px h-6 mx-3 bg-gray-400 dark:bg-gray-700"></div>
                        </li>
                        <li>
                            <!-- Authentication -->

                            <form method="POST" @submit.prevent="logout">
                                <button class="flex items-center mr-4 hover:text-blue-100">
                                    <span class="inline-flex mr-1">
                                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    </span>
                                    Logout
                                </button>
                            </form>

                        </li>
                    </ul>
                </div>
            </div>
            <!-- ./Header -->

            <!-- Sidebar -->
            <div class="fixed flex flex-col top-14 left-0 w-14 hover:w-64 md:w-64 bg-blue-900 dark:bg-gray-900 h-full text-white transition-all duration-300 border-none z-10 sidebar">
                <div class="overflow-y-auto overflow-x-hidden flex flex-col justify-between flex-grow">

                    <ul class="flex flex-col py-2 space-y-1">
                        <span>
                            <img src="/storage/img/logo.jpg" class="mx-auto" alt="" />
                        </span>
                        <li class="px-5 md:block">
                            <div class="flex flex-row items-center h-8">
                                <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Main</div>
                            </div>
                        </li>
                        <li>
                            <Link :href="route('dashboard')"  class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                            <span class="inline-flex justify-center items-center ml-4 text-red-500">
                              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Dashboard</span>
                            </Link>
                        </li>
                        <li>
                            <a v-if="$can('ventas-list')" href="#" @click="isMenuVentas = !isMenuVentas" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4 text-blue-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Ventas</span>
                            </a>
                        </li>
                        <div v-show="isMenuVentas && $can('ventas-list')" class="pl-8 bg-gray-700 text-white-600 hover:text-white-600">
                            <li>
                                <Link v-if="$can('ventas-list')" :href="route('ventas.index')" :active="route().current('ventas.index')" class="relative flex flex-row items-center h-8 focus:outline-none  border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                  </svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Buscar</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('ventas-create')" :href="route('ventas.create')" href="#" class="relative flex flex-row items-center h-8 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Nueva</span>
                                </Link>
                            </li>
                        </div>
                        <li>
                            <a v-show="$can('rifas-list')" href="#" @click="isMenuRifas = !isMenuRifas" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4 text-yellow-500">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Rifas</span>
                            </a>
                        </li>
                        <div v-show="isMenuRifas && $can('rifas-list')" class="pl-8 bg-gray-700 text-white-600 hover:text-white-600">
                            <li>
                                <Link v-if="$can('rifas-list')" :href="route('rifas.index')" class="relative flex flex-row items-center h-8 focus:outline-none  border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                  </svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Buscar</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('rifas-create')" :href="route('rifas.create')" href="#" class="relative flex flex-row items-center h-8 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                                  </svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Nueva</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('rifas-create')" :href="route('rifas.create')" href="#" class="relative flex flex-row items-center h-8 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Reserva</span>
                                </Link>
                            </li>
                        </div>
                        <li>
                            <a v-show="$can('cajas-list')" href="#" @click="isMenuCajas = !isMenuCajas" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4 text-green-500">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Cajas</span>
                            </a>
                        </li>
                        <div v-show="isMenuCajas && $can('cajas-list')" class="pl-8 bg-gray-500 text-white-800">
                            <li>
                                <Link v-if="$can('cajas-list')" :href="route('cajas.historial')" class="relative flex flex-row items-center h-8 focus:outline-none  border-transparent hover:border-blue-500  pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                </span>
                                    <span class="ml-2 text-xs tracking-wide truncate">Historial</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('cajas-list')" :href="route('cajas.index')" class="relative flex flex-row items-center h-8 focus:outline-none  border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                </span>
                                    <span class="ml-2 text-xs tracking-wide truncate">Resumen</span>
                                </Link>
                            </li>
                        </div>
                        <li>
                            <Link v-if="$can('ventas-list')" :href="route('master.puntosventa')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                  </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Puntos de venta</span>
                            </link>
                        </li>
                        <li>
                            <Link v-if="$can('ventas-list')" :href="route('transacciones.index')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4 text-teal-600">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                  </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Transacciones</span>
                            </Link>
                        </li>
                        <li>
                            <Link v-if="$can('ventas-list')" :href="route('pagos.index')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4 text-blue-600">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                  </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Pagos</span>
                            </Link>
                        </li>
                        <li class="px-5 hidden md:block">
                            <div class="flex flex-row items-center mt-5 h-8">
                                <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Settings</div>
                            </div>
                        </li>
                        <li>
                            <Link v-if="$can('users-list')" :href="route('users.index')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4 text-pink-500">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Usuarios</span>
                            </Link>
                        </li>
                        <li>
                            <a href="#" @click="isMenuConfig = !isMenuConfig" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                  </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Configuración</span>
                            </a>
                        </li>
                        <div v-show="isMenuConfig" class="pl-8 bg-gray-700 text-white-600 hover:text-white-600">
                            <li>
                                <Link v-if="$can('ventas-list')" :href="route('master.paises')" class="relative flex flex-row items-center h-11 focus:outline-none  border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Localización</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('ventas-list')" :href="route('master.index')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Roles</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('ventas-list')" :href="route('master.empresas')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Empresas</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('ventas-list')" :href="route('master.series')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Series</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('ventas-list')" :href="route('master.terminos')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">T&C</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('ventas-list')" :href="route('master.tiposdoc')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Tipos de Doc</span>
                                </Link>
                            </li>
                        </div>
                        <li>
                            <Link v-if="$can('ventas-list')" :href="route('confcomisiones.index')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Comisiones</span>
                            </Link>
                        </li>
                    </ul>
                    <p class="mb-14 px-5 py-3 hidden md:block text-center text-xs">TresAses.com Copyright @2022</p>
                </div>
            </div>
            <!-- ./Sidebar -->

            <div class="h-full ml-14 mt-14 mb-10 md:ml-64">

                <!-- Page Content -->
                <main>
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
<style>
/* Compiled dark classes from Tailwind */
.dark .dark\:divide-gray-700 > :not([hidden]) ~ :not([hidden]) {
    border-color: rgba(55, 65, 81);
}
.dark .dark\:bg-gray-50 {
    background-color: rgba(249, 250, 251);
}
.dark .dark\:bg-gray-100 {
    background-color: rgba(243, 244, 246);
}
.dark .dark\:bg-gray-600 {
    background-color: rgba(75, 85, 99);
}
.dark .dark\:bg-gray-700 {
    background-color: rgba(55, 65, 81);
}
.dark .dark\:bg-gray-800 {
    background-color: rgba(31, 41, 55);
}
.dark .dark\:bg-gray-900 {
    background-color: rgba(17, 24, 39);
}
.dark .dark\:bg-red-700 {
    background-color: rgba(185, 28, 28);
}
.dark .dark\:bg-green-700 {
    background-color: rgba(4, 120, 87);
}
.dark .dark\:hover\:bg-gray-200:hover {
    background-color: rgba(229, 231, 235);
}
.dark .dark\:hover\:bg-gray-600:hover {
    background-color: rgba(75, 85, 99);
}
.dark .dark\:hover\:bg-gray-700:hover {
    background-color: rgba(55, 65, 81);
}
.dark .dark\:hover\:bg-gray-900:hover {
    background-color: rgba(17, 24, 39);
}
.dark .dark\:border-gray-100 {
    border-color: rgba(243, 244, 246);
}
.dark .dark\:border-gray-400 {
    border-color: rgba(156, 163, 175);
}
.dark .dark\:border-gray-500 {
    border-color: rgba(107, 114, 128);
}
.dark .dark\:border-gray-600 {
    border-color: rgba(75, 85, 99);
}
.dark .dark\:border-gray-700 {
    border-color: rgba(55, 65, 81);
}
.dark .dark\:border-gray-900 {
    border-color: rgba(17, 24, 39);
}
.dark .dark\:hover\:border-gray-800:hover {
    border-color: rgba(31, 41, 55);
}
.dark .dark\:text-white {
    color: rgba(255, 255, 255);
}
.dark .dark\:text-gray-50 {
    color: rgba(249, 250, 251);
}
.dark .dark\:text-gray-100 {
    color: rgba(243, 244, 246);
}
.dark .dark\:text-gray-200 {
    color: rgba(229, 231, 235);
}
.dark .dark\:text-gray-400 {
    color: rgba(156, 163, 175);
}
.dark .dark\:text-gray-500 {
    color: rgba(107, 114, 128);
}
.dark .dark\:text-gray-700 {
    color: rgba(55, 65, 81);
}
.dark .dark\:text-gray-800 {
    color: rgba(31, 41, 55);
}
.dark .dark\:text-red-100 {
    color: rgba(254, 226, 226);
}
.dark .dark\:text-green-100 {
    color: rgba(209, 250, 229);
}
.dark .dark\:text-blue-400 {
    color: rgba(96, 165, 250);
}
.dark .group:hover .dark\:group-hover\:text-gray-500 {
    color: rgba(107, 114, 128);
}
.dark .group:focus .dark\:group-focus\:text-gray-700 {
    color: rgba(55, 65, 81);
}
.dark .dark\:hover\:text-gray-100:hover {
    color: rgba(243, 244, 246);
}
.dark .dark\:hover\:text-blue-500:hover {
    color: rgba(59, 130, 246);
}

/* Custom style */
.header-right {
    width: calc(100% - 3.5rem);
}
.sidebar:hover {
    width: 16rem;
}
@media only screen and (min-width: 768px) {
    .header-right {
        width: calc(100% - 16rem);
    }
}
</style>
