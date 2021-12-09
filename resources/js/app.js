require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import swal from 'sweetalert';
import * as VueGoogleMaps from "vue2-google-maps";

Vue.use(VueRouter, swal);

Vue.use(VueGoogleMaps, {
    load: {
        key: "AIzaSyCv2upnuUOVx8ZuEIP1Dfd0IG1q6q4ZkdU",
        libraries: "places" // necessary for places input
    }
});

const routes = [

    {
        path: '/',
        name: '/',
        component: require('./components/welcome.vue').default
    },

    {
        path: '/cpanel',
        name: 'cpanel',
        component: require('./components/CPanel.vue').default
    },

    {
        path: '/wallet',
        name: 'wallet',
        component: require('./components/Wallet_Pass.vue').default
    },

    {
        path: '/mis_reservas',
        name: 'mis_reservas',
        component: require('./components/My_Reservas.vue').default
    },




    /////////////////////////////-------------RESTAURANTES-------------//////////////////
    {
        path: '/restaurante/registro',
        name: 'restaurante/registro',
        component: require('./components/Restaurantes/Configuracion/Register_Info.vue').default
    },

    {
        path: '/restaurante/zonas',
        name: 'restaurante/zonas',
        component: require('./components/Restaurantes/Configuracion/Zonas/index.vue').default
    },
    {
        path: '/restaurante/zonas/create',
        name: 'restaurante/zonas/create',
        component: require('./components/Restaurantes/Configuracion/Zonas/create.vue').default
    },

    {
        path: '/restaurante/my-listas',
        name: 'restaurante/my-listas',
        component: require('./components/Restaurantes/Configuracion/Listas/index.vue').default
    },

    {
        path: '/restaurante/my-listas/create',
        name: 'restaurante/my-listas/create',
        component: require('./components/Restaurantes/Configuracion/Listas/create.vue').default
    },

    {
        path: '/restaurante/my-listas/view',
        name: 'restaurante/my-listas/view',
        component: require('./components/Restaurantes/Configuracion/Listas/view.vue').default
    },

    {
        path: '/restaurante/plan',
        name: 'restaurante/plan',
        component: require('./components/Restaurantes/Configuracion/Plan.vue').default
    },

    {
        path: '/restaurante/eventos',
        name: 'restaurante/eventos',
        component: require('./components/Restaurantes/Eventos/index.vue').default
    },

    {
        path: '/restaurante/eventos/create',
        name: 'restaurante/eventos/create',
        component: require('./components/Restaurantes/Eventos/create.vue').default
    },

    {
        path: '/restaurante/reservas',
        name: 'restaurante/reservas',
        component: require('./components/Restaurantes/Reservas.vue').default
    },

    {
        path: '/:nombre_slug',
        //name: ':nombre_slug',
        component: require('./components/Detail_view.vue').default
    },


]

const router = new VueRouter({
    routes: routes,
    mode: "history"
})

const app = new Vue({
    router
}).$mount('#app');