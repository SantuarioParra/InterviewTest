/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
/**
 * Vuetify import
 */
import Vuetify from 'vuetify';

Vue.use(Vuetify);

//Vuetify config
/**
 * Only if you need spanish
 */
//import es from 'vuetify/es5/locale/es';
const options = {
    theme: {
        dark: false
    },
    icons: {
        iconfont: 'mdi'
    },
    //Only if you need spanish
    /*lang:{
        locales:{es},
        current:'es'
    }*/
}

/**
 * Vuex import
 */
import store from './store'

/**
 * Vue-route import
 */

import router from './routes/index'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify:new Vuetify(options),
    store,
    router
});
