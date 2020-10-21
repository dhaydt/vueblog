require('./bootstrap');
import router from './router.js';

window.Vue = require('vue');

Vue.component('mainapp', require('./components/mainapp.vue').default)

const app = new Vue({
    el: '#app',
    router
})