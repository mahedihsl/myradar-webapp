require('../bootstrap')

import store from './store'
import {mapGetters} from 'vuex'
import NoAreaFound from './comp/NoAreaFound.vue'

new Vue({
  el: '#app',
  store,
  components: {
    NoAreaFound,
  },
  data: {
    
  },
  computed: {
    ...mapGetters(['areas']),
  },
  methods: {

  }
})
