import Vue from 'vue';

export default [{
	path: '/',
	name: 'home',
	component: Vue.component('Assistant', require('./components/Assistant.vue'))
},{
	path: '/course',
	name: 'course',
	component: Vue.component('Course', require('./components/Course.vue'))
}]