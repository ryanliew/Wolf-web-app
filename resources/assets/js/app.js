import vuescroll from 'vue-scroll';
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.events = new Vue();

Vue.use(vuescroll);

window.flash = function(message, level = 'success'){
 	window.events.$emit('flash', {message, level});
};
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('game-create', require('./components/Game-Create.vue'));
Vue.component('game-details', require('./components/Game-Details.vue'));
Vue.component('user-profile', require('./components/User-Profile.vue'));
Vue.component('player-roles', require('./components/Player-Roles.vue'));

/**
 * Powers actions
 */
Vue.component('wolf', require("./roles/wolf.vue"));
Vue.component('witch', require("./roles/witch.vue"));
Vue.component('fortune-teller', require("./roles/fortune-teller.vue"));
Vue.component('demon', require("./roles/demon.vue"));
Vue.component('guard', require("./roles/guard.vue"));
Vue.component('assassin', require("./roles/assassin.vue"));
Vue.component('hunter', require("./roles/hunter.vue"));
Vue.component('white-wolf', require("./roles/white-wolf.vue"));


Vue.component('v-select', 'vue-select');

const app = new Vue({
    el: '#app',
    data: {
    	scrollY: null
    },

    mounted() {
    	window.addEventListener('scroll', (event) => {
    		this.scrollY = Math.round(window.scrollY);
    	});
    }
});
