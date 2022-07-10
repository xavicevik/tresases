<template>
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 p-4 gap-4">
        <div class="bg-blue-500  shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600  text-white font-medium group">
            <div class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-blue-800  transform transition-transform duration-500 ease-in-out"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div class="text-right">
                <p class="text-2xl">{{ cajasopen }}</p>
                <p>Cajas abiertas</p>
            </div>
        </div>
        <div class="bg-red-500 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-red-600  text-white font-medium group">
            <div class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-blue-800  transform transition-transform duration-500 ease-in-out"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <div class="text-right">
                <p class="text-2xl">{{ cajasclose }}</p>
                <p>Cajas cerradas</p>
            </div>
        </div>
        <div class="bg-green-500 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-green-600 text-white font-medium group">
            <div class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-blue-800 transform transition-transform duration-500 ease-in-out"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
            <div class="text-right">
                <p class="text-2xl">{{ cantidadventasdia }}</p>
                <p>Boletas vendidas x día</p>
            </div>
        </div>
        <div class="bg-pink-500 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-pink-600  text-white font-medium group">
            <div class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-blue-800 transform transition-transform duration-500 ease-in-out"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="text-right">
                <p class="text-2xl">{{ formatPrice(valorventasdia) }}</p>
                <p>Ventas x día</p>
            </div>
        </div>
    </div>
    <!-- ./Statistics Cards -->
</template>

<script>

export default {
    name: "Statscards",
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
            cajasopen: 0,
            cajasclose: 0,
            valorventasdia: 0,
            cantidadventasdia: 0,
            recaudocaja: []
        }
    },
    computed: {
        showCart() {
            return usePage().props.value.cart.cart;
        }
    },

    methods: {
        formatPrice(value) {
            let val = (value/1).toFixed(0).replace('.', ',')
            return '$ '+ val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
        cajasAbiertas: async function () {
            var url= '/cajas/open';
            axios.get(url, {
            }).then((res) => {
                var respuesta = res.data;
                this.resumencajas = respuesta.cajas;
                this.cajasopen = 0;
                this.cajasclose = 0;
                this.valorventasdia = respuesta.stats[0].valor;
                this.cantidadventasdia = respuesta.stats[0].cantidad;

                for (var i = 0; i < this.resumencajas.length; i++) {
                    if (this.resumencajas[i].estado == 1) {
                        this.cajasopen = this.resumencajas[i].cantidad;
                    } else if (this.resumencajas[i].estado == 0) {
                        this.cajasclose = this.resumencajas[i].cantidad;
                    }
                }

            });
            /*
            setInterval(() => {
                var url= '/cajas/open';
                axios.get(url, {
                }).then((res) => {
                    var respuesta = res.data;
                    this.resumencajas = respuesta.cajas;
                    this.cajasopen = 0;
                    this.cajasclose = 0;
                    this.valorventasdia = respuesta.stats[0].valor;
                    this.cantidadventasdia = respuesta.stats[0].cantidad;

                    for (var i = 0; i < this.resumencajas.length; i++) {
                        if (this.resumencajas[i].estado == 1) {
                            this.cajasopen = this.resumencajas[i].cantidad;
                        } else if (this.resumencajas[i].estado == 0) {
                            this.cajasclose = this.resumencajas[i].cantidad;
                        }
                    }

                });
            }, (60000));

             */
        }
    },
    mounted() {
        this.cajasAbiertas();
    }
    /*
    created: function () {
        this.cajasAbiertas();
    },

     */
}
</script>

