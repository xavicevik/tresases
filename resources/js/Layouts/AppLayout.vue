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
import Button from "../Jetstream/Button";
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
            sidebarOpen: true,
            selectedRow: null,
        }
    },
    computed: {
        showCart() {
            return usePage().props.value.cart.cart;
        },
    },
}
</script>


<template>

    <div x-data="{ sidebarOpen: true }" class="flex overflow-x-hidden h-screen">
        <aside class="h-screen bg-white text-red-900 overflow-auto sticky top-0 flex-shrink-0 w-64 flex flex-col border-r transition-all duration-300" :class="{ '-ml-64': !sidebarOpen }">

            <div class="h-screen">
                <div class="flex-grow">
                    <ul class="flex flex-col py-2 space-y-1">
                        <span>
                            <img src="/storage/img/logo_fondo.jpg" class="mx-auto" alt="" />
                        </span>
                        <li class="px-5 md:block">
                            <div class="flex flex-row items-center h-8">
                                <div class="text-sm font-bold tracking-wide text-gray-900 uppercase">Principal</div>
                            </div>
                        </li>
                        <li>
                            <Link :href="route('dashboard')" @click="rowSelect('dashboard')" :class=" (selectedRow === 'dashboard' || route().current('dashboard')) ? 'border-blue-500 bg-blue-200' : 'hover:border-gray-500'" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4 text-red-500">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Dashboard</span>
                            </Link>
                        </li>
                        <li>
                            <a v-if="$can('ventas-list')" href="#" @click="isMenuVentas = !isMenuVentas; rowSelect('isMenuVentas')" :class=" (selectedRow === 'isMenuVentas' || route().current('ventas.index')) ? 'border-blue-500 bg-blue-200' : 'hover:border-gray-500'" class="relative flex flex-row items-center h-8 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4 text-blue-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Ventas</span>
                            </a>
                        </li>
                        <div v-show="isMenuVentas && $can('ventas-list')" class="pl-8 bg-blue-100 text-white-600 hover:text-white-600">
                            <li>
                                <Link v-if="$can('ventas-list')" :href="route('ventas.index')" class="relative flex flex-row items-center h-8 focus:outline-none border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                  </svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Buscar</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('ventas-create')" :href="route('ventas.create')" href="#" class="relative flex flex-row items-center h-8 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Nueva</span>
                                </Link>
                            </li>
                        </div>
                        <li>
                            <a v-show="$can('rifas-list')" href="#" @click="isMenuRifas = !isMenuRifas" :class=" (selectedRow === 'rifas' || route().current('rifas.index') || route().current('rifas.indexboletas') || route().current('numerosreservados.index')) ? 'border-blue-500 bg-blue-200' : 'hover:border-gray-500'" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4 text-yellow-500">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Rifas</span>
                            </a>
                        </li>
                        <div v-show="isMenuRifas && $can('rifas-list')" class="pl-8 bg-blue-100 text-white-600 hover:text-white-600">
                            <li>
                                <Link v-if="$can('rifas-list')" :href="route('rifas.index')" class="relative flex flex-row items-center h-8 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                  </svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Buscar</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('rifas-create')" :href="route('rifas.indexboletas')" href="#" class="relative flex flex-row items-center h-8 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                                  </svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Boletas</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('rifas-create')" :href="route('numerosreservados.index')" href="#" class="relative flex flex-row items-center h-8 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Reserva</span>
                                </Link>
                            </li>
                        </div>
                        <li>
                            <a v-show="$can('cajas-list')" href="#" @click="isMenuCajas = !isMenuCajas" :class=" (selectedRow === 'isMenuCajas' || route().current('cajas.index') || route().current('cajas.movimientos') || route().current('cajas.historial')) ? 'border-blue-500 bg-blue-200' : 'hover:border-gray-500'" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4 text-green-500">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Cajas</span>
                            </a>
                        </li>
                        <div v-show="isMenuCajas && $can('cajas-list')" class="pl-8 bg-blue-100 text-white-600 hover:text-white-600">

                            <li>
                                <Link v-if="$can('cajas-list')" :href="route('cajas.historial')" class="relative flex flex-row items-center h-8 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                                    </svg>
                                </span>
                                    <span class="ml-2 text-xs tracking-wide truncate">Historial</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('cajas-list')" :href="route('cajas.movimientos')" class="relative flex flex-row items-center h-8 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                      <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z" />
                                    </svg>
                                </span>
                                    <span class="ml-2 text-xs tracking-wide truncate">Movimientos</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('cajas-list')" :href="route('cajas.index')" class="relative flex flex-row items-center h-8 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                    </svg>
                                </span>
                                    <span class="ml-2 text-xs tracking-wide truncate">Resumen</span>
                                </Link>
                            </li>
                        </div>
                        <li>
                            <Link v-if="$can('ventas-list')" :href="route('master.puntosventa')" :class=" (selectedRow === 'master.puntosventa' || route().current('master.puntosventa')) ? 'border-blue-500 bg-blue-200' : 'hover:border-gray-500'" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                  </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Puntos de venta</span>
                            </link>
                        </li>
                        <li>
                            <Link v-if="$can('transacciones-list')" :href="route('transacciones.index')" :class=" (selectedRow === 'transacciones.index' || route().current('transacciones.index')) ? 'border-blue-500 bg-blue-200' : 'hover:border-gray-500'" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4 text-teal-600">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                  </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Transacciones</span>
                            </Link>
                        </li>
                        <li>
                            <Link v-if="$can('transacciones-list')" :href="route('pagos.index')" :class=" (selectedRow === 'pagos.index' || route().current('pagos.index')) ? 'border-blue-500 bg-blue-200' : 'hover:border-gray-500'" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
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
                                <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Configuración</div>
                            </div>
                        </li>
                        <li>
                            <Link v-if="$can('users-list')" :href="route('users.index')" :class=" (selectedRow === 'users.index' || route().current('users.index')) ? 'border-blue-500 bg-blue-200' : 'hover:border-gray-500'" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4 text-pink-500">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Usuarios</span>
                            </Link>
                        </li>
                        <li>
                            <Link v-if="$can('users-list')" :href="route('users.indexclientes')" :class=" (selectedRow === 'users.indexclientes' || route().current('users.indexclientes')) ? 'border-blue-500 bg-blue-200' : 'hover:border-gray-500'" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4 text-green-500">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Clientes</span>
                            </Link>
                        </li>
                        <li>
                            <Link v-if="$can('users-list')" :href="route('users.indexvendedores')" :class=" (selectedRow === 'users.indexvendedores' || route().current('users.indexvendedores')) ? 'border-blue-500 bg-blue-200' : 'hover:border-gray-500'" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4 text-green-500">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Vendedores</span>
                            </Link>
                        </li>
                        <li>
                            <a href="#" v-if="$can('configuracion-list')" @click="isMenuConfig = !isMenuConfig" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                  </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Configuración</span>
                            </a>
                        </li>
                        <div v-show="isMenuConfig" class="pl-8 bg-blue-100 text-white-600 hover:text-white-600">
                            <li>
                                <Link v-if="$can('configuracion-list')" :href="route('master.paises')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Localización</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('configuracion-list')" :href="route('master.index')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Roles</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('configuracion-list')" :href="route('master.empresas')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Empresas</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('configuracion-list')" :href="route('master.series')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                    </svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Series</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('configuracion-list')" :href="route('master.terminos')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">T&C</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('configuracion-list')" :href="route('master.tiposdoc')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Tipos de Doc</span>
                                </Link>
                            </li>
                        </div>
                        <li>
                            <a v-if="$can('comisiones-list')" href="#" @click="isMenuComision = !isMenuComision" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Comisiones</span>
                            </a>
                        </li>
                        <div v-show="isMenuComision && $can('comisiones-list')" class="pl-8 bg-blue-100 text-white-600 hover:text-white-600">
                            <li>
                                <Link v-if="$can('comisiones-list')" :href="route('comisiones.index')" :active="route().current('ventas.index')" class="relative flex flex-row items-center h-8 focus:outline-none  border-l-4 border-transparent pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Buscar</span>
                                </Link>
                            </li>
                            <li>
                                <Link v-if="$can('comisiones-list')" :href="route('confcomisiones.index')" href="#" class="relative flex flex-row items-center h-8 focus:outline-none hover:bg-blue-200 text-white-600 hover:text-white-800 border-l-4 border-transparent pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Configuración</span>
                                </Link>
                            </li>
                        </div>




                    </ul>
                </div>
                <footer class="text-center text-white">
                    <div class="container pt-4">
                        <div class="flex justify-center mb-4">
                            <a href="#!" class="mr-4 text-gray-800">
                                <svg
                                    aria-hidden="true"
                                    focusable="false"
                                    data-prefix="fab"
                                    data-icon="facebook-f"
                                    class="svg-inline--fa fa-facebook-f w-2.5"
                                    role="img"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"
                                    ></path>
                                </svg>
                            </a>


                            <a href="#!" class="mr-9 text-gray-800">
                                <svg
                                    aria-hidden="true"
                                    focusable="false"
                                    data-prefix="fab"
                                    data-icon="instagram"
                                    class="svg-inline--fa fa-instagram w-3.5"
                                    role="img"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 448 512"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"
                                    ></path>
                                </svg>
                            </a>
                            <a href="#!" class="mr-9 text-gray-800">
                                <svg
                                    aria-hidden="true"
                                    focusable="false"
                                    data-prefix="fab"
                                    data-icon="linkedin-in"
                                    class="svg-inline--fa fa-linkedin-in w-3.5"
                                    role="img"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 448 512"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"
                                    ></path>
                                </svg>
                            </a>

                        </div>
                    </div>

                    <div class="text-center text-gray-800 p-2 text-sm bg-gray-200">
                        © 2022 Copyright:
                        <a class="text-gray-800 text-sm" href="https://www.shoppingred.com.co/">shoppingRed</a>
                    </div>
                </footer>
            </div>
        </aside>
        <div class="flex-1">
            <header class="sticky top-0 w-full flex items-center p-4 text-semibold text-red-900 bg-white">
                <button class="p-1 mr-4" @click="sidebarOpen = !sidebarOpen;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>


                <!-- Header -->
                <div class="flex items-center justify-start md:justify-center pl-3 h-10 border-none">
                    <img class="w-5 h-5 md:w-10 md:h-7 mr-2 rounded-md overflow-hidden" src="https://therminic2018.eu/wp-content/uploads/2018/07/dummy-avatar.jpg" />
                    <span class="hidden md:block">
                        {{ $page.props.auth.user.roles[0].name }}<br>
                        {{ $page.props.user.full_name }}
                    </span>

                </div>
                <div class="flex justify-between items-center h-10 header-right">
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
                                <div class="absolute w-full rounded-b border-t-0 z-10" v-show="isOpenCart && Object.keys(showCart).length > 0">
                                    <div class="shadow-xl w-64 overflow-y-auto h-80 bg-blue-100 rounded-md border-b border-gray-100">
                                        <div v-if="showCart" v-for="(dato, id) in showCart" :key="id" class="p-2 flex bg-white hover:bg-gray-400 cursor-pointer border-b border-blue-400" style="">
                                            <div class="p-2 w-12">
                                                <img :src="dato.attributes?'/storage/'+dato.attributes.url:''"  height="50" width="50" alt="img product"></div>
                                            <div class="flex-auto text-sm w-32">
                                                <div class="font-bold text-gray-500"> {{ dato.name }}</div>
                                                <div class="truncate text-gray-500">{{ dato.attributes?dato.attributes.numero:'' }}</div>
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
                                                </div><span class=" text-gray-500">
                                                ${{ dato.price }}</span></div>
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
                            <div class="block w-px h-6 mx-3 bg-gray-400 dark:bg-blue-100"></div>
                        </li>
                        <li v-if="$page.props.auth.puntoventa">
                            Punto de Venta: {{ $page.props.auth.puntoventa[0].nombre }}
                        </li>

                        <li>
                            <div class="block w-px h-6 mx-3 bg-gray-400 dark:bg-blue-100"></div>
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
                <!-- ./Header -->

            </header>
            <main class="p-4">
                <!-- Page Content -->
                <main>
                    <slot />
                </main>
            </main>
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
.dark .dark\:bg-blue-100 {
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
.dark .dark\:hover\:bg-blue-100:hover {
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
