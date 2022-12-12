<template>
    <div class="flex justify-left mx-auto ml-4 p-2 space-x-4">
        <div class="flex p-1 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <Link :href="route('reportes.index')" class="text-xs hover:text-blue-700 text-blue-400 font-bold py-1 px-1 rounded " :active="route().current('reportes.index')">
                Resumen Vendedor
            </Link>
        </div>
        <div class="flex p-1 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <Link :href="route('reportes.ventavendedor')" class="text-xs hover:text-blue-700 text-blue-400 font-bold py-1 px-1 rounded" :active="route().current('reportes.ventavendedor')">
                Ventas por vendedor
            </Link>
        </div>
        <div class="flex p-1 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <Link :href="route('reportes.resumenvendedores')" class="text-xs hover:text-blue-700 text-blue-400 font-bold py-1 px-1 rounded " :active="route().current('reportes.resumenvendedores')">
                Resumen por vendedor
            </Link>
        </div>
        <div class="flex p-1 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <Link :href="route('master.puntosventa')" class="text-xs hover:text-blue-700 text-blue-400 font-bold py-1 px-1 rounded ">
                BI
            </Link>
        </div>

    </div>
</template>

<script>

import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Link
    },
    name: "Subreportes"
}
</script>
