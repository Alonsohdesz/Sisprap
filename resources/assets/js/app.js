require('./bootstrap');
window.Vue = require('vue');
window.$ = window.jQuery = require('jquery');

//Vue-Select para el manejo de datos en varias formas
import vSelect from 'vue-select';
Vue.component('v-select', vSelect);

import ImgInputer from 'vue-img-inputer';
import 'vue-img-inputer/dist/index.css';

Vue.component('ImgInputer', ImgInputer);

import VueFormWizard from 'vue-form-wizard';
import 'vue-form-wizard/dist/vue-form-wizard.min.css';
Vue.use(VueFormWizard);

import Datetime from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'

Vue.use(Datetime)

var VueTruncate = require('vue-truncate-filter')
Vue.use(VueTruncate)

//Import Tab content
import Tabs from 'vue-tabs-component';
Vue.use(Tabs);

// import datables from 'datatables';
// Vue.use(datables);

import Checkbox from 'vue-material-checkbox'
Vue.use(Checkbox)

//Import Vue Toaster
import VueToastr from '@deveodk/vue-toastr'
import '@deveodk/vue-toastr/dist/@deveodk/vue-toastr.css'
Vue.use(VueToastr)

import es from 'vee-validate/dist/locale/es';
import VeeValidate, { Validator } from 'vee-validate';
Vue.use(VeeValidate);
Validator.localize('es', es);

// Vue Mask
import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)


//Aplicando configuraciones generales para vuejs para cambiar a modo de produccion
Vue.config.productionTip = false;
Vue.config.debug = false;
Vue.config.silent = true;

Vue.component('pulse-loader', require('vue-spinner/src/PulseLoader.vue'));
Vue.component('institucion', require('./components/instituciones/Institucion.vue'));
Vue.component('publiproject', require('./components/proyectos/Publicacion.vue'));
Vue.component('lineaproject', require('./components/proyectos/Linea.vue'));
Vue.component('usuarios', require('./components/proyectos/Usuarios.vue'));
Vue.component('notification', require('./components/Notification.vue'));
Vue.component('preregister', require('./components/proyectos/Preinscripciones.vue'));
Vue.component('pagoarancel', require('./components/recepcion/PagoArancel.vue'));
Vue.component('pagoaranceladmin', require('./components/arancel/PagoArancelAdmin.vue'));
Vue.component('hojasupervgeneral', require('./components/reportes/HojaSupervGeneral.vue'));
Vue.component('general', require('./components/reportes/InstitucionGeneral.vue'));
Vue.component('supervision', require('./components/reportes/SupervisionesInst.vue'));
Vue.component('configuracion', require('./components/mantenimientos/configuracion.vue'));
Vue.component('inicioproceso', require('./components/reportes/SSPP/InicioProceso.vue'));
Vue.component('pendientesinicio', require('./components/reportes/SSPP/PendienteInicio.vue'));
Vue.component('pendientefin', require('./components/reportes/SSPP/PendienteFin.vue'));
Vue.component('culminados', require('./components/reportes/SSPP/ProcesoCulminado.vue'));
Vue.component('configuracion', require('./components/mantenimientos/configuracion.vue'));
Vue.component('gestproy', require('./components/proyectos/GestionProyectos.vue'));
Vue.component('constancias', require('./components/proyectos/Constancias.vue'));
Vue.component('sectores', require('./components/instituciones/Sectores.vue'));
Vue.component('solicitudes_aprobadas', require('./components/proyectos/SolicitudesAprobadas.vue'));
Vue.component('proyectos_externos', require('./components/proyectos/ProyectosExternos.vue'));
Vue.component('modal_year', require('./components/mantenimientos/modal_year.vue'));
Vue.component('chat', require('./components/chat/ChatAdmin.vue'));

const app = new Vue({
    el: '#app',
    data: {
        menu: 0,
        notifications: [],
        messages_unread: 0
    },
    methods: {
        getMessagesUnread() {
            let me = this;
            var url = route('getCountOfUnreadMessages');
            axios.get(url).then(function(response) {
                var respuesta = response.data;
                me.messages_unread = respuesta
            }).catch(function(error) {
                console.log(error);
            });
        },
        showNotification(userName) {
            this.$toastr('add', {
                title: 'Nuevo Mensaje',
                msg: 'Tienes nuevos mensajes de ' + userName,
                timeout: 6000,
                position: 'toast-bottom-right',
                type: 'info',
                clickClose: true,
                closeOnHover: false
            });
        },
        getNotifications() {
            let me = this;
            axios.get(route('getNotificationsAdmin')).then(function(response) {
                me.notifications = response.data;
            }).catch(function(error) {
                console.log(error);
            });
        }
    },
    created() {
        let me = this;
        Echo.private('App.User.' + 0).notification((notification) => {
            this.$toastr('add', {
                title: 'Nueva Notificación',
                msg: notification.cantidad + " " + notification.msj,
                timeout: 6000,
                position: 'toast-bottom-right',
                type: 'success',
                clickClose: true,
                closeOnHover: false
            });
            me.getNotifications();
        });

        me.getMessagesUnread();
        me.getNotifications();

        Echo.private('chat').listen('MessageSentEvent', (e) => {
            me.getMessagesUnread();
            !$("#btnFAB").hasClass('hiddeBtnFab') ? me.showNotification(e.user.nombre) : '';
        });
    },
});