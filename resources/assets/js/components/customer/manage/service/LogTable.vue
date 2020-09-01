<template>
  <div class="row">
    <div class="col-xs-12" style="margin-top: 20px">
      <button class="btn btn-link pull-right" @click="onBackClick">
        <i class="fa fa-arrow-left"></i> Back
      </button>
    </div>
    <div class="col-xs-12">
      <table class="table table-responsive" v-if="!!summary">
        <thead>
          <tr>
            <th class="col-xs-6">Attribute</th>
            <th class="col-xs-6">Value</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Commercial ID</td>
            <td>{{ summary.com_id }}</td>
          </tr>
          <tr>
            <td>LatLng Ratio</td>
            <td>{{ summary.gps_ratio }} %</td>
          </tr>
          <tr>
            <td>PCR Capability</td>
            <td class="font-medium">
              <span
                :class="{
                  'text-green-500': summary.pcr,
                  'text-red-500': !summary.pcr,
                }"
                >{{ summary.pcr ? 'YES' : 'NO' }}</span
              >
            </td>
          </tr>
          <tr>
            <td>Expected PCR Time</td>
            <td>{{ summary.pcr_time }}</td>
          </tr>
          <tr>
            <td>Frequent Hang</td>
            <td>{{ summary.hang }}</td>
          </tr>
          <tr>
            <td>Reset Count</td>
            <td>{{ summary.reset.total }}</td>
          </tr>
          <tr>
            <td>Internal Reset</td>
            <td>
              {{
                summary.reset.breakdown
                  ? summary.reset.internal
                  : 'Breakdown Not Available'
              }}
            </td>
          </tr>
          <tr>
            <td>External Reset</td>
            <td>
              {{
                summary.reset.breakdown
                  ? summary.reset.external
                  : 'Breakdown Not Available'
              }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import Log from './ServiceLog.vue'
import Dates from './DateRange.vue'

import EventBus from '../../../../util/EventBus'
import ServiceApi from '../../../../api/ServiceApi'

export default {
  props: ['vehicle'],
  components: { Log, Dates },
  data: () => ({
    dates: [],
    services: [
      { id: 0, name: 'Lat/Lng' },
      { id: 1, name: 'Fuel' },
      { id: 2, name: 'Gas' },
      { id: 3, name: 'Engine' },
    ],
    summary: null,
  }),
  async mounted() {
    EventBus.$on('date-range-changed', this.onDateRangeChanged.bind(this))
    this.summary = await ServiceApi.getSummary(this.vehicle)
  },
  methods: {
    onDateRangeChanged(list) {
      if (this.dates.length != list.length) {
        this.dates = list
      } else if (!this.dates.length && !list.length) {
        this.dates = list
      } else if (this.dates[0] != list[0]) {
        this.dates = list
      }
    },

    onBackClick() {
      EventBus.$emit('show-car-list')
    },
  },
}
</script>
<style scoped></style>
