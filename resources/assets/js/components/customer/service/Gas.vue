<template lang="html">
  <div class="col-xs-12 col-md-6">
    <div class="info-boxx">
      <h4 class="text-center box-title">GAS METER</h4>
      <div class="content" v-show="subscribed">
          <canvas class="" id="gas-meter" style="margin-top: 30px;"></canvas>
      </div>
      <div class="content" v-show="!subscribed">
        <not-subscribed body="Not subscribed"></not-subscribed>
      </div>
    </div>
  </div>
</template>

<script>
import EventBus from '../../../util/EventBus';
import GasApi from '../../../api/GasApi';

import NotSubscribed from '../../util/NotSubscribed.vue';

export default {
  props: ['deviceId', 'subscribed'],
  components: {
    NotSubscribed,
  },
  data: () => ({
      chart: null,
  }),
  watch: {
    deviceId: function(newVal, oldVal) {
      this.getLatestGas(newVal);
    }
  },
  mounted() {
    if (this.subscribed) {
      EventBus.$on('latest-gas-found', this.onLatestGasData.bind(this));
      this.drawChart();
      this.getLatestGas(this.deviceId);
    }
  },
  methods: {
    getLatestGas(id) {
      let api = new GasApi(EventBus);
      api.latest(id);
    },
    onLatestGasData(item) {
      this.chart.data.datasets = this.getChartData(item.value);
      this.chart.update();
    },
    drawChart() {
      this.chart = new Chart(document.getElementById("gas-meter").getContext("2d"), {
        type: 'bar',
        data: {
          labels: ["Today"],
          datasets: [],
        },
        options: {
          tooltips: {
            enabled: false
          },
          legend: {
            display: false,
          },
          scales: {
            xAxes: [{
              stacked: true,
              barThickness: 20,
            }],
            yAxes: [{
              stacked: true,
              gridLines : {
                display : false
              },
              ticks: {
                callback: (label, index, labels) => ''
              },
            }]
          }
        }
      });
    },
    getChartData(value) {
      let ret = [{
          backgroundColor: '#FDD835',
          data: [1]
      }];
      for (var i = 1; i < 5; i++) {
        ret.push({
          backgroundColor: 'white',
          data: [.5]
        });
        ret.push({
          backgroundColor: i <= value ? '#66BB6A' : 'white',
          data: [1]
        });
      }
      return ret;
    },
  }
}
</script>

<style lang="css">
</style>
