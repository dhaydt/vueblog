import Vue from 'vue';
import Router from 'vue-router';

import FP from './components/pages/first.vue'
import rot from './components/pages/rot.vue'
import hook from './components/pages/basic/hooks.vue'

//adminproject pages
import home from './components/pages/home.vue'
import tags from './admin/pages/tags.vue'
import category from './admin/pages/category.vue'
import usecom from './vuex/usecom.vue'

Vue.use(Router);

const routes = [
    //project route
    {
        path: '/',
        component: home
    },
    {
        path: '/tags',
        component: tags
    },
    {
        path: '/cat',
        component: category
    },
    {
        path: '/use',
        component: usecom
    },















    //test route
    {
        path: '/vue',
        component: FP
    },
    {
        path: '/rot',
        component: rot
    },

    //vue hooks
    {
        path: '/hooks',
        component: hook
    }
]

export default new Router({
    mode: 'history',
    routes
})