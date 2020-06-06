export default class ServiceApi {
    constructor(bus) {
        this.EventBus = bus;
    }

    getLog(car, service) {
        Vue.http.get(`/service/log/${car}/${service}`).then(response => {
            this.EventBus.$emit('service-log-found', response.body.data.items);
        }, error => {});
    }
}
