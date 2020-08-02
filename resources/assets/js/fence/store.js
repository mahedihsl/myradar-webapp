import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    areas: []
  },
  getters: {
    areas(state) {
      return state.areas
    }
  },
  mutations: {},
  actions: {},
})
