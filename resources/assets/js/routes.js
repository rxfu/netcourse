import Vue from 'vue';

export default [{
	path: '/',
	name: 'home',
	component: Vue.component('Assistant', require('./components/Assistant.vue'))
}]