/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import store from './store';
import VueRouter from 'vue-router';

window.Vue = require('vue');

Vue.use(VueRouter);

Vue.component('comments', require('./components/comments/CommentsComponent.vue').default);
Vue.component('comment-form', require('./components/comments/CommentFormComponent.vue').default);

const app = new Vue({
    el: '#app',
    store,
    mode: 'history'
});