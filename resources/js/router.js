import Vue from 'vue';
import Router from 'vue-router';

import FP from './components/pages/first.vue'
import rot from './components/pages/rot.vue'
import hook from './components/pages/basic/hooks.vue'

Vue.use(Router);

const routes = [
//project route
	{
		path: '/',
		component: FP
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

export default new Router ({
	mode: 'history',
	routes
})