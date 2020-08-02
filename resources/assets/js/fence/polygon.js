require('../bootstrap')

import VModal from 'vue-js-modal'

Vue.use(VModal)

import store from './store'
import {mapGetters} from 'vuex'

import AreaBuilder from './comp/AreaBuilder.vue'
import NoAreaFound from './comp/NoAreaFound.vue'

new Vue({
  el: '#app',
  store,
  components: {
    NoAreaFound,
    AreaBuilder,
  },
  data: {
    
  },
  computed: {
    ...mapGetters(['areas']),
  },
  methods: {
    showAreaBuilder() {
      this.$modal.show('area-builder')
    },

    closeAreaBuilder() {
      this.$modal.hide('area-builder')
    }
  }
})
