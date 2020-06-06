<template>
    <div class="row">
        <div class="col-xs-12" style="margin-top: 20px">
            <button class="btn btn-link pull-right" @click="onBackClick">
                <i class="fa fa-arrow-left"></i> Back
            </button>
        </div>
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <log v-for="(s, i) in services" :service="s" :carid="vehicle.id" :key="i"></log>
                        <dates :dates="dates"></dates>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import Log from './ServiceLog.vue';
import Dates from './DateRange.vue';

import EventBus from '../../../../util/EventBus';
import ServiceApi from '../../../../api/ServiceApi';

export default {
    props: ['vehicle'],
    components: {Log, Dates},
    data: () => ({
        dates: [],
        services: [
            {id: 0, name: 'Lat/Lng'},
            {id: 1, name: 'Fuel'},
            {id: 2, name: 'Gas'},
            {id: 3, name: 'Engine'},
        ],
    }),
    mounted() {
        EventBus.$on('date-range-changed', this.onDateRangeChanged.bind(this));
    },
    methods: {
        onDateRangeChanged(list) {
            if (this.dates.length != list.length) {
                this.dates = list;
            } else if (!this.dates.length && !list.length) {
                this.dates = list;
            } else if (this.dates[0] != list[0]) {
                this.dates = list;
            }
        },

        onBackClick() {
            EventBus.$emit('show-car-list');
        },
    }
}
</script>
<style scoped>
</style>
