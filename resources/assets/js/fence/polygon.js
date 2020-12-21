require('../bootstrap')

import VModal from 'vue-js-modal'

Vue.use(VModal)

import store from './store'
import { mapGetters } from 'vuex'

import GeofenceMap from '../position/GeofenceMap'

import AreaBuilder from './comp/AreaBuilder.vue'
import NoAreaFound from './comp/NoAreaFound.vue'
import AreaList from './comp/AreaList.vue'
import TemplateList from './comp/TemplateList.vue'
import GeofenceInfo from './comp/GeofenceInfo.vue'
import TemplateInfo from './comp/TemplateInfo.vue'

new Vue({
  el: '#app',
  store,
  components: {
    NoAreaFound,
    AreaBuilder,
    AreaList,
    TemplateList,
    GeofenceInfo,
    TemplateInfo,
  },
  data: {
    map: null,
    userId: 0,
    currentGeofence: null,
    currentTemplate: null,
  },
  computed: {
    ...mapGetters(['geofences', 'templates']),
  },
  mounted() {
    this.userId = document.getElementsByName('customer_id')[0].value

    this.$store.dispatch('fetchCars', this.userId)
    this.$store.dispatch('fetch', this.userId)
    this.$store.dispatch('templates')
    this.map = new GeofenceMap('common-map')
    this.map.init()
  },
  methods: {
    onGeofenceClick(geofence) {
      this.currentGeofence = geofence
      this.currentTemplate = null
      this.map.showPolygon(geofence.coordinates)
    },

    onTemplateClick(geofence) {
      this.currentTemplate = geofence
      this.currentGeofence = null
      this.map.showPolygon(geofence.coordinates)
    },

    async onTemplateAdd(template) {
      await this.$store.dispatch('attachTemplate', {
        templateId: template.id,
        userId: this.userId,
      })
    },

    showAreaBuilder() {
      this.$modal.show('area-builder')
    },

    closeAreaBuilder() {
      this.$modal.hide('area-builder')
    },
  },
})
