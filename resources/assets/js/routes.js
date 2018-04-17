import Vue from 'vue';

export default [{
	path: '/',
	name: 'home',
	component: Vue.component('Assistant', require('./components/Assistant.vue'))
},{
	path: '/course',
	name: 'course',
	component: Vue.component('Course', require('./components/Course.vue'))
},{
	path: '/success',
	name: 'success',
	component: Vue.component('Success', require('./components/Success.vue'))
},{
	path: '/fail',
	name: 'fail',
	component: Vue.component('Fail', require('./components/Fail.vue'))
}]