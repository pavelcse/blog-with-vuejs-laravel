/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import { filter } from './filter'

/** VueX */
import Vuex from 'vuex'
Vue.use(Vuex)

import StoreData from './store/index'
const store = new Vuex.Store(
    StoreData
)

/** Markdown Editor */
import 'v-markdown-editor/dist/index.css';
import Editor from 'v-markdown-editor'

// global register
Vue.use(Editor);


import VueRouter from 'vue-router'
Vue.use(VueRouter)

/** Sweet Alert 2 */
import Swal from 'sweetalert2'
window.swal = Swal
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.toast = Toast

/** V-Form */
import { Form, HasError, AlertError } from 'vform'

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
import {routes} from './routes'
Vue.component('admin-master', require('./components/admin/AdminMaster').default);
Vue.component('public-master', require('./components/frontend/FrontMasterComponent'));

const router = new VueRouter({
    mode: 'hash',
    routes
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store
});
