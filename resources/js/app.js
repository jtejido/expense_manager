/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'


import Vue from 'vue';
import SimpleVueValidation from 'simple-vue-validator';
Vue.use(SimpleVueValidation);

Vue.use(VueRouter)

let routes = [
  
  { path: '/', component: require('./components/pages/Dashboard.vue').default },    
  { path: '/login', component: require('./components/Login.vue').default },
  { path: '/roles', component: require('./components/pages/Roles.vue').default },
  { path: '/users', component: require('./components/pages/Users.vue').default },
  { path: '/expense-category', component: require('./components/pages/ExpenseCategory.vue').default },
  { path: '/expenses', component: require('./components/pages/Expenses.vue').default },
  { path: '/change-password', component: require('./components/pages/ChangePassword.vue').default },     
]

const router = new VueRouter({
	mode: 'history',
  	routes 
})
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component('index', require('./components/Index.vue').default);
Vue.component('side-menu', require('./components/SideMenu.vue').default);
Vue.component('header-menu', require('./components/Header.vue').default);
Vue.component('login', require('./components/Login.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
	router,
    el: '#app',

});


