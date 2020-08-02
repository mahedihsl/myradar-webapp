require('../bootstrap')

import VModal from 'vue-js-modal'

Vue.use(VModal)

import store from './store'
import {mapGetters} from 'vuex'

import GeofenceMap from '../position/GeofenceMap'

import AreaBuilder from './comp/AreaBuilder.vue'
import NoAreaFound from './comp/NoAreaFound.vue'
import AreaList from './comp/AreaList.vue'

new Vue({
  el: '#app',
  store,
  components: {
    NoAreaFound,
    AreaBuilder,
    AreaList,
  },
  data: {
    map: null,
  },
  computed: {
    ...mapGetters(['geofences']),
  },
  mounted() {
    this.$store.dispatch('fetch')
    this.map = new GeofenceMap('common-map')
    this.map.init()
  },
  methods: {
    onGeofenceClick(index) {
      this.map.drawPolygon(this.geofences[index].coordinates)
    },

    showAreaBuilder() {
      this.$modal.show('area-builder')
    },

    closeAreaBuilder() {
      this.$modal.hide('area-builder')
    }
  }
})
