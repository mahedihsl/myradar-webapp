require('../bootstrap')

import VModal from 'vue-js-modal'

Vue.use(VModal)

import store from './store'
import {mapGetters} from 'vuex'

import GeofenceMap from '../position/GeofenceMap'

import AreaBuilder from './comp/AreaBuilder.vue'
import NoAreaFound from './comp/NoAreaFound.vue'
import AreaList from './comp/AreaList.vue'
import GeofenceInfo from './comp/GeofenceInfo.vue'

new Vue({
  el: '#app',
  store,
  components: {
    NoAreaFound,
    AreaBuilder,
    AreaList,
    GeofenceInfo,
  },
  data: {
    map: null,
    userId: 0,
    currentGeofence: null,
  },
  computed: {
    ...mapGetters(['geofences']),
  },
  mounted() {
    this.userId = document.getElementsByName('auth_id')[0].value

    this.$store.dispatch('fetchCars', this.userId)
    this.$store.dispatch('fetch')
    this.map = new GeofenceMap('common-map')
    this.map.init()
  },
  methods: {
    onGeofenceClick(geofence) {
      this.currentGeofence = geofence
      this.map.showPolygon(geofence.coordinates)
    },

    showAreaBuilder() {
      this.$modal.show('area-builder')
    },

    closeAreaBuilder() {
      this.$modal.hide('area-builder')
    }
  }
})
