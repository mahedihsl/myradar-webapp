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

    SUBSCRIBE_CAR(state, { geofence, car }) {
      const target = state.geofences.find(m => geofence.id)
      target.cars.push(car)
    },

    UNSUBSCRIBE_CAR(state, { geofence, car }) {
      const index = state.geofences.findIndex(m => geofence.id)
      const target = state.geofences[index]
      const carIndex = target.cars.findIndex(c => c.id === car.id)
      target.cars.splice(carIndex, 1)
      state.geofences.splice(index, 1, target)
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

    async subscribe({ commit }, { geofence, car }) {
      await Vue.http.post('/geofence/subscribe', {
        geofence_id: geofence.id,
        car_id: car.id,
        reg_no: car.reg_no,
      })

      commit('SUBSCRIBE_CAR', { geofence, car })
    },

    async unsubscribe({ commit }, { geofence, car }) {
      await Vue.http.post('/geofence/unsubscribe', {
        geofence_id: geofence.id,
        car_id: car.id,
        reg_no: car.reg_no,
      })

      commit('UNSUBSCRIBE_CAR', { geofence, car })
    },
  },
})
