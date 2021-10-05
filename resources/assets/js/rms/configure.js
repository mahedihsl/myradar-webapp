require('../bootstrap');

import PinConfig from './component/PinConfig.vue'

import { mapGetters } from 'vuex'
import store from './store';

new Vue({
    el: '#app',
    store,
    components: {
        PinConfig,
    },
    data: {
        site_id: '',
    },
    computed: {
        ...mapGetters(['site', 'pinConfigsOfDevice']),
    },
    mounted() {
        this.site_id = document.getElementById('site_id').value
        this.getSiteInformation(this.site_id)
    },
    methods: {
        async getSiteInformation(site_id) {
            try {
                await this.$store.dispatch('getSiteInfo', site_id)
                await this.$store.dispatch('fetchPinConfigs', { site_id })
            } catch (error) {
                console.log(error)
            }
        }
    },
})
