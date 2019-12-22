/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueSweetalert2 from 'vue-sweetalert2';
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import Auth from './auth.js'
import router from './router.js'
import iChecks from 'icheck-bootstrap'

Vue.use(VueSweetalert2)
Vue.router = router
Vue.use(VueRouter)
Vue.use(VueAxios, axios)
Vue.use(VueAuth, Auth)
Vue.use(iChecks)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import appview from './components/app.vue'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue(Vue.util.extend({
    router
}, appview)).$mount('#app');