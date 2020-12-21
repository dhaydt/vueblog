require('./bootstrap');
window.Vue = require('vue');
import router from './router.js';
import VueRouter from 'vue-router';
import ViewUI from 'view-design';
import common from './common.js';
import store from './store';
import jsonToHtml from './jsonToHtml';
import 'view-design/dist/styles/iview.css';
import Editor from 'vue-editor-js'
Vue.use(Editor)

Vue.use(VueRouter)
Vue.use(ViewUI);
Vue.mixin(common);
Vue.mixin(jsonToHtml);

Vue.component('mainapp', require('./components/mainapp.vue').default)

const app = new Vue({
    el: '#app',
    router,
    store
})
