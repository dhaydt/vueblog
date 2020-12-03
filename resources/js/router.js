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
import createblog from './admin/pages/createblog'
import adminusers from './admin/pages/adminusers'
import login from './admin/pages/login'
import role from './admin/pages/role'
import assignrole from './admin/pages/assignrole'


Vue.use(Router);

const routes = [
    //project route
    {
        path: '/',
        component: home,
        name: '/'
    },
    {
        path: '/tags',
        component: tags,
        name: 'tags'
    },
    {
        path: '/category',
        component: category,
        name: 'category'
    },
    {
        path: '/createblog',
        component: createblog,
        name: 'createblog'
    },

    {
        path: '/adminusers',
        component: adminusers,
        name: 'adminusers'
    },
    {
        path: '/login',
        component: login,
        name: 'login'
    },
    {
        path: '/role',
        component: role,
        name: 'role'
    },
    {
        path: '/assignrole',
        component: assignrole,
        name: 'assignrole'
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
