
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
// import $ from 'jquery';
// window.$ = window.jQuery = $;

// require('timepicker');
// // window.timepicker = timepicker;

// import 'jquery-ui/ui/widgets/datepicker.js';
// $(window).on('load',()=>{

// });





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
import Datepicker from 'vuejs-datepicker';
Vue.component('date-picker',Datepicker);
import VueTimepicker from 'vue2-timepicker';
Vue.use(VueTimepicker);
Vue.component('time-picker',VueTimepicker);

import inscriptions from './components/admin/Inscriptions.vue';
Vue.component('app-inscriptions', inscriptions);

Vue.component('fb-login', require('./components/users/fblogin.vue') );

// filstros
Vue.filter('price', (value)=>{
    if (value % 1 != 0) {
        return value.toFixed(2)
    }return value;
});
Vue.filter('date',(value)=>{return moment(value).format('DD/MM/YYYY')});


var PulseLoader = require('vue-spinner/src/PulseLoader.vue');
Vue.component('pulse-loader', require('vue-spinner/src/PulseLoader.vue'));


const app = new Vue({
    el: '#app'
});
