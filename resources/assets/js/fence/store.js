import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    geofences: [],
    cars: [],
  },
  getters: {
    geofences(state) {
      return state.geofences
    },
    cars(state) {
      return geofenceId => {
        const geofence = state.geofences.find(m => m.id === geofenceId)
        return state.cars.map(car => {
          const isSubscribed =
            geofence.cars.findIndex(c => c.id === car.id) != -1
          return { ...car, subscribed: isSubscribed }
        })
      }
    },
  },
  mutations: {
    SET_GEOFENCES(state, list) {
      state.geofences = list
    },

    SET_CARS(state, list) {
      state.cars = list
    },
  },
  actions: {
    async fetchCars({ commit }, userId) {
      const res = await Vue.http.get(`/user/car/list/${userId}`)
      commit('SET_CARS', res.body.data.items)
    },

    async fetch({ commit }) {
      const res = await Vue.http.get('/geofence/fetch')
      commit('SET_GEOFENCES', res.body.data)
    },

    async save({ commit }, { name, coordinates }) {
      const res = await Vue.http.post('/geofence/save', {
        name,
        coordinates,
      })
    },
  },
})
