import Vue from 'vue';
import Vuex from 'vuex';

import { comments } from './modules/comments';

Vue.use(Vuex);

export default new Vuex.Store({
  strict: true,
  state: {
    errors: null
  },
  modules: {
    comments
  },
  getters: {},
  mutations: {},
  actions: {}
});