
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */




window.swal = require('sweetalert');



// console.log(swal);

window.csrf = $('meta[name="csrf-token"]').attr('content');

window.Vue = require('vue');
var VueResource = require('vue-resource');
Vue.use(VueResource);
import Vuex from 'vuex';

Vue.use(Vuex)

export const EventBus = new Vue({});

import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue);

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import moment from 'moment';
window.moment = moment;


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': window.csrf
    }
});

Vue.http.headers.common['X-CSRF-TOKEN'] = window.csrf;

Vue.component('app-nav', require('./components/layout/Header.vue'));
Vue.component('app-admin-crud', require('./components/admin/Crud.vue'));
Vue.component('app-admin-dash', require('./components/admin/Dash.vue'));
Vue.component('app-admin-users', require('./components/admin/Users.vue'));


import inscriptions from './components/admin/Inscriptions.vue';
Vue.component('app-inscriptions', inscriptions);




const app = new Vue({
    el: '#app'
});
