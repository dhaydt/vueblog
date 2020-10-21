import Vue from 'vue';
import Router from 'vue-router';

import FP from './components/pages/first.vue'
import rot from './components/pages/rot.vue'

Vue.use(Router);

const routes = [
	{
		path: '/vue',
		component: FP
	},
	{
		path: '/rot',
		component: rot
	}
]

export default new Router ({
	mode: 'history',
	routes
})