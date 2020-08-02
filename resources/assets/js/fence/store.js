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
  actions: {
    async save({ commit }, { name, coordinates }) {
      const res = await Vue.http.post('/geofence/save', {
        name,
        coordinates,
      })
      console.log(`saved geofence: `, res.body)
    }
  },
})
