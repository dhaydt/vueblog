require('./bootstrap');

import router from './router.js';
import VueRouter from 'vue-router';
import ViewUI from 'view-design';
import common from './common.js';
import store from './store';

import 'view-design/dist/styles/iview.css';

window.Vue = require('vue');
Vue.use(VueRouter)
Vue.use(ViewUI);
Vue.mixin(common);


Vue.component('mainapp', require('./components/mainapp.vue').default)

const app = new Vue({
    el: '#app',
    router,
    store
})