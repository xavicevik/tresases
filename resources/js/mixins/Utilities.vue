<script>

import moment from "moment";
import Swal from "sweetalert2";
import {usePage} from "@inertiajs/inertia-vue3";

export default {
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
            ispage: true,
            arrayPaises: [],
            arrayDepartamentos: [],
            arrayCiudades: [],
            arrayRoles: [],
            arrayTiposdocumento: [],
            arrayEmpresas: [],
            editMode: false,
            verMode: false,
            newMode: false,
            isOpen: false,
            isOpencambiopass: false,
            buscar: '',
            arrayData: {
                data: [],
                links: []
            },
            arrayDetalles: {
                data: [],
                links: []
            },
            arrayRifas: {
                data: [],
                links: []
            },
            arrayVendedores: {
                data: [],
                links: []
            },
            arrayClientes: {
                data: [],
                links: []
            },
            sortOrder: 1,
            sortBy: '',
            selectedRow: null,
        }
    },
    methods: {
        cambiarPage: function (url = '', entidad = '', filtros = [], id = null) {
            axios.get(url, {
                params: {
                    filtros: filtros,
                    ispage: 1,
                    id: id,
                }
            }).then((res) => {
                var respuesta = res.data;
                if (entidad == 'cliente') {
                    this.arrayData = respuesta.clientes;
                } else if (entidad == 'clientes') {
                    this.arrayClientes = respuesta.clientes;
                } else if (entidad == 'rifas') {
                    this.arrayRifas = respuesta.data;
                } else if (entidad == 'vendedores') {
                    this.arrayVendedores = respuesta.vendedores;
                } else if (entidad == 'vendedor') {
                    this.arrayData = respuesta.vendedores;
                } else if (entidad == 'detalles') {
                    this.arrayDetalles = respuesta.data;
                } else if (entidad == 'cajas') {
                    this.arrayCajas = respuesta.cajas;
                } else if (entidad == 'ventas') {
                    this.arrayVentas = respuesta.data;
                } else if (entidad == 'detalles') {
                    this.arrayDetalles = respuesta.data;
                } else if (entidad == 'users') {
                    this.arrayDetalles = respuesta.users;
                } else {
                    this.arrayData = respuesta.datos;
                }
            })
        },
        actualizarRangos() {
            let rango = null;
            let cantidad = 0;

            cantidad = Math.pow(10, this.form.cifras);
            rango = String(0).padStart(this.form.cifras, '0') + ' - ' + (cantidad-1);
            this.cantboletas = cantidad;
            this.rango = rango;
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
        getLoterias: function () {
            axios.get('/loterias',).then((res) => {
                this.arrayLoterias = res.data.loterias;
            })
        },
        getTerminos: function () {
            axios.get('/terminos',).then((res) => {
                this.arrayTerminos = res.data.terminos;
            })
        },
        getPaises: function () {
            axios.get('/paises',).then((res) => {
                this.arrayPaises = res.data.paises;
            })
        },
        getDepartamentos: function () {
            axios.get('/paises/departamentos', {
                params: {
                    idpais: this.form.idpais
                }
            }).then((res) => {
                this.arrayDepartamentos = res.data.departamentos;
            })
        },
        getEmpresas: function () {
            axios.get('/master/getEmpresas', {
                params: {
                    idrol: this.form.idrol
                }
            }).then((res) => {
                this.arrayEmpresas = res.data.data;
            })
        },
        getCiudades: function () {
            axios.get('/paises/ciudades', {
                params: {
                    idpais: this.form.idpais,
                    iddepartamento: this.form.iddepartamento
                }
            }).then((res) => {
                this.arrayCiudades = res.data.ciudades;
            })
        },
        getTiposdocumento: function () {
            axios.get('/master/tiposdocsearch',).then((res) => {
                this.arrayTiposdocumento = res.data.data;
            })
        },
        getRoles: async function () {
            var url= '/master/getRoles';
            axios.get(url).then((res) => {
                var respuesta = res.data;
                this.arrayRoles = respuesta.data;
            })
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
                var respuesta = res.data;
                this.arrayClientes = respuesta.clientes;
            })
        },
        getBoletasreservas: function (filtros = [], sortBy = 'boletas.id') {
            if (sortBy == this.sortBy){
                this.sortOrder = !this.sortOrder;
            }
            let sortOrderdesc;
            if (this.sortOrder){
                sortOrderdesc = 'asc';
            } else {
                sortOrderdesc = 'desc';
            }
            this.sortBy = sortBy;
            this.ispage = true;

            var url= '/numerosreservados';
            axios.get(url, {
                params: {
                    filtros: filtros,
                    sortBy: this.sortBy,
                    sortOrder: sortOrderdesc,
                    ispage: this.ispage
                }
            }).then((res) => {
                var respuesta = res.data;
                this.arrayData = respuesta.datos;
            })
        },
        getBoletas: function (filtros = [], sortBy = 'boletas.id') {
            if (sortBy == this.sortBy){
                this.sortOrder = !this.sortOrder;
            }
            let sortOrderdesc;
            if (this.sortOrder){
                sortOrderdesc = 'asc';
            } else {
                sortOrderdesc = 'desc';
            }
            this.sortBy = sortBy;
            this.ispage = true;

            var url= '/rifas/indexboletas';
            axios.get(url, {
                params: {
                    filtros: filtros,
                    sortBy: this.sortBy,
                    sortOrder: sortOrderdesc,
                    ispage: this.ispage
                }
            }).then((res) => {
                var respuesta = res.data;
                this.arrayData = respuesta.datos;
            })
        },
        getRifas: async function (buscar = '', filtro = 'titulo', paginate = false) {
            var url= '/rifas/getRifasActivas';
            axios.get(url, {
                params: {
                    buscar: buscar,
                    filtro: filtro,
                    paginate: paginate
                }
            }).then((res) => {
                var respuesta = res.data;
                this.arrayRifas = respuesta.rifas;
            })
        },
        getVendedoresSelect: async function (buscar = '', filtro = 'nombre', paginate = false) {
            var url= '/users/getVendedoresActivos';
            axios.get(url, {
                params: {
                    buscar: buscar,
                    filtro: filtro,
                    paginate: paginate
                }
            }).then((res) => {
                var respuesta = res.data;
                this.arrayVendedoresMenu = respuesta.vendedores;
            })
        },
        getVendedores: async function (buscar = '', filtro = 'nombre', paginate = false) {
            var url= '/users/getVendedoresActivos';
            axios.get(url, {
                params: {
                    buscar: buscar,
                    filtro: filtro,
                    paginate: paginate
                }
            }).then((res) => {
                var respuesta = res.data;
                this.arrayVendedores = respuesta.vendedores;
            })
        },
        getDetallesVentas: function (id) {
            var url= '/ventas/getDetallesHistorial';
            axios.get(url, {
                params: {
                    id: id,
                }
            }).then((res) => {
                var respuesta = res.data;
                this.arrayVentas = respuesta.data;
                this.arrayDetalles.data = [];
                this.arrayDetalles.links = [];
                this.idHistorial = id;
            })
        },
        getDetalles: function (id) {
            var url= '/ventas/getDetalles';
            axios.get(url, {
                params: {
                    id: id,
                }
            }).then((res) => {
                var respuesta = res.data;
                this.arrayDetalles = respuesta.data;
                this.idVenta = id;
            })
        },
        getHistorialBoleta: function (id) {
            var url= '/rifas/getHistorialBoleta';
            axios.get(url, {
                params: {
                    id: id,
                }
            }).then((res) => {
                var respuesta = res.data;
                this.arrayDetalles = respuesta.data;
                this.idVenta = id;
            })
        },
        deleteRow: function (data) {
            let mensaje = '';
            let title = '';
            let html = '';
            if (data.estado) {
                mensaje = 'Desea desactivar el usuario?';
                title = 'Desactivado!';
                html = 'El usuario ha sido desactivado con éxito';
            } else {
                mensaje = 'Desea activar el usuario?';
                title = 'Activado!';
                html = 'El usuario ha sido activado con éxito.';
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
                axios.post('/users/' + data.id, data)
                    .then((res) => {
                        this.getUsers('','nombre');
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
        cleanMessage: function () {
            this.$page.props.flash.message = '';
        },
        sendSMS: function (id) {
            axios.get('/ventas/sendSmsSales?id='+id,).then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Mensaje enviado',
                    showConfirmButton: false,
                    timer: 1000
                })
            })
        },
        rowSelect(idx) {
            this.selectedRow = idx;
        },
        rowSelect2(idx) {
            this.selectedRow2 = idx;
        },
        nvl: function (value, fallbackValue) {
            return typeof value !== 'undefined' && value != null
                ? value
                : fallbackValue;
        },
        selTipoSerie: function (data){
            this.isIndividual = data;
        },
        updateSession: function (idsesion, idrifa = null, idvendedor = null) {
            var url= '/ventas/updateSession';
            axios.get(url, {
                params: {
                    idsesion: idsesion,
                    idrifa: idrifa,
                    idvendedor: idvendedor,
                }
            }).then((res) => {
            })
        },
        pushSessionDetail: function (id, boleta, type) {
            var url= '/ventas/updDetailSession';
            axios.get(url, {
                params: {
                    idsesion: id,
                    boleta: boleta,
                    type: type
                }
            }).then((res) => {
                console.log(res.data);
            })
        },
        registrarSessionVenta: function (idpuntoventa = null, idrifa = null, idvendedor = null) {
            var url= '/ventas/initSession';
            axios.get(url, {
                params: {
                    idpuntoventa: idpuntoventa,
                    idrifa: idrifa,
                    idvendedor: idvendedor
                }
            }).then((res) => {
                var respuesta = res.data;
                this.session = respuesta.session;
                this.detallesession = respuesta.detallesession;
                if(this.session.rifa) this.form.idrifa = this.session.rifa;
                if(this.session.vendedor) this.form.idvendedor = this.session.vendedor;
                this.time = respuesta.time * 1000;
                for (const property in this.detallesession) {
                    this.form.reservas.push({
                        numero: this.detallesession[property]['numero'],
                        promocional: this.detallesession[property]['promocional'],
                        valortotal: this.detallesession[property]['valortotal'],
                        valorpagar: this.detallesession[property]['valor'],
                        valorsaldo: this.detallesession[property]['saldo'],
                        valoranular: this.detallesession[property]['pago'],
                        valorpagado: this.detallesession[property]['pago'],
                        idcliente: this.detallesession[property]['idcliente'],
                        cliente: this.detallesession[property]['idcliente']?this.detallesession[property]['full_name']:'',
                    });
                }
            })
        },
        finishSession: function () {
            var url= '/ventas/finishSession';
            axios.get(url, {
                params: {
                    idsesion: this.session.id,
                }
            }).then((res) => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Se ha superado el tiempo máximo para realizar la venta',
                    showConfirmButton: true,
                    timer: 1000
                })
                //this.registrarSessionVenta(this.caja.puntoventa.id)
                this.form.reservas = [];
                this.form.idrifa = [];
                this.form.idvendedor = [];
                this.getMovimientos();
                this.closeModal();
                //this.$refs.countdown.start();
            })
        },
        anularVenta: function (id) {
            axios.get('/ventas/anularVenta?id='+id+'&idcaja='+this.caja.id+'&idpuntoventa='+this.caja.puntoventa.id,)
                .then((res) => {
                    if (res.data.status == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Se ha realizado la anulación de la venta',
                            showConfirmButton: true,
                        })
                        window.open(res.data.url, '_blank');
                        this.getMovimientos();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: res.data.status,
                            showConfirmButton: true,
                        })
                    }
                })
        },
        onCountdownEnd: function () {
            this.finishSession()
        }
    },
};
</script>
