import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        site: null,
        pinConfigs: [],
    },
    getters: {
        site(state) {
            return state.site
        },
        pinConfigsOfDevice(state) {
            return comId => {
                return state.pinConfigs.filter(conf => conf.com_id === comId)
            }
        }
    },
    mutations: {
        SET_SITE(state, site) {
            state.site = site
        },
        SET_PIN_CONFIGS(state, configs) {
            console.log('pin configs', JSON.stringify(configs))
            state.pinConfigs = configs
        }
    },
    actions: {
        async getSiteInfo({ commit }, site_id) {
            const res = await axios.get(`/rms/site/info`, { params: { site_id } })
            commit('SET_SITE', res.data)
        },
        async fetchPinConfigs({ commit }, query) {
            const res = await axios.get(`/rms/site/pin/fetch`, { params: query })
            commit('SET_PIN_CONFIGS', res.data)
        }
    }
})
