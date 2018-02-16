
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance for certain pages.
 */

if (document.getElementById('task_manager')) {
	Vue.component('task-list', require('./components/tasks/TaskList.vue'));

	const app = new Vue({
    	el: '#app' 
	}); 
}
