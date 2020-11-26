import Vue from 'vue';
import Router from 'vue-router';

import FP from './components/pages/first'
import rot from './components/pages/rot'
import hook from './components/pages/basic/hooks'
import usecom from './vuex/usecom'

//adminproject pages
import home from './components/pages/home'
import tags from './admin/pages/tags'
import category from './admin/pages/category'
import adminusers from './admin/pages/adminusers'
import login from './admin/pages/login'


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
        path: '/adminusers',
        component: adminusers
    },
    {
        path: '/login',
        component: login
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
    },

    //vuex
    {
        path: '/use',
        component: usecom
    },
]

export default new Router({
    mode: 'history',
    routes
})