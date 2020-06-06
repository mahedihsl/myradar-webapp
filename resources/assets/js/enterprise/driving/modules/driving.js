import EventBus from '../../../util/EventBus';
import CarApi from '../../../api/enterprise/CarApi';
import DrivingApi from '../../../api/enterprise/DrivingHourApi';

export const driving = {
    namespaced: true,
    state: {
        cars: [],
        timeSort: 0,
        loading: true,

        time: null,
    },
    getters: {
        cars(state) {
            return (search, compare, value) => {
                if (state.loading) {
                    return [];
                }

                let list = state.cars;

                if (search) {
                    list = list.filter(val => {
                            return val.name.toLowerCase().indexOf(search) != -1 || (
                                !!val.driver &&
                                (val.driver.name.toLowerCase().indexOf(search) != -1 ||
                                val.driver.phone.toLowerCase().indexOf(search) != -1) );
                        });
                }

                if (compare != 0 && value) {
                    list = list.filter(val => {
                        if (!val.info) return false;
                        return compare == 1 ? (val.info.time > value) : (val.info.time < value);
                    });
                }

                return list;
            };
        },
        loading(state) {
            return state.loading
        },
        nothing(state) {
            return !(state.cars.length || state.loading)
        },
        timeSort(state) {
            return state.timeSort;
        },
        time(state){
          return state.time;
        }
    },
    mutations: {
        setTime(state, time) {
            state.time = time;
        },
        setCars(state, list) {
            state.cars = list.map(item => {
                item.info = null;
                return item;
            })
        },
        setDrivingInfo(state, {info, id}) {
            let i = state.cars.findIndex(c => c.id == id);
            if (i != -1) {
                let temp = state.cars[i];
                temp.info = info;
                state.cars[i] = temp;
            }
        },
        setLoading(state, flag) {
            state.loading = flag
        },
        setTimeSort(state) {
            state.timeSort = (state.timeSort == 0 || state.timeSort == -1) ? 1 : -1;
            state.cars.sort((a, b) => {
                if (a.info.time < b.info.time) {
                  return state.timeSort == 1 ? -1 : 1;
                }

                if (b.info.time < a.info.time) {
                  return state.timeSort == 1 ? 1 : -1;
                }

                return 0;
            });
        }
    },
    actions: {
        getCars({commit, rootGetters}) {
            commit('setLoading', true);
            CarApi.all(rootGetters.userId)
                .then(list => commit('setCars', list))
                .catch(() => {})
                .then(() => commit('setLoading', false))
        },
        getDrivingHourSum({commit, state}, carId) {
            DrivingApi.month(carId, state.time.m + 1, state.time.y)
                .then(info => commit('setDrivingInfo', {info, id: carId}))
                .catch(() => {})
                .then(() => {})
        },
        getDrivingHourReport({commit, state}, carId) {
            DrivingApi.daily(carId, state.time.m + 1, state.time.y)
                .then(list => EventBus.$emit('chart-report-found', carId, list))
                .catch(() => {})
                .then(() => {})
        },
    }
}
