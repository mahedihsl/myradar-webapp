import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    geofences: []
  },
  getters: {
    geofences(state) {
      return state.geofences
    }
  },
  mutations: {
    SET_GEOFENCES(state, list) {
      state.geofences = list
    }
  },
  actions: {
    async fetch({ commit }) {
      const res = await Vue.http.get('/geofence/fetch')
      commit('SET_GEOFENCES', res.body.data)
    },

    async save({ commit }, { name, coordinates }) {
      const res = await Vue.http.post('/geofence/save', {
        name,
        coordinates,
      })
    }
  },
})
