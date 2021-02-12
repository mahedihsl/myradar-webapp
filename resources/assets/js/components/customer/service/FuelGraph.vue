<template>
  <div style="width: 100%;">
    <spinner v-show="loading" :extra-height="false"></spinner>
    <canvas v-show="!loading && !empty" id="fuel-graph"></canvas>
    <no-data v-show="!loading && empty"></no-data>
  </div>
</template>

<script>
import NoData from '../../util/NoItemFound.vue'
import Spinner from '../../util/Spinner'

export default {
  props: {
    items: {
      type: Array,
      required: true,
    },
    loading: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  components: {
    NoData,
    Spinner,
  },
  computed: {
    empty() {
      return !this.items.length
    },
  },
  watch: {
    items(list, old) {
      this.updateChartData(list)
    },
  },
  mounted() {
    this.drawChart()
    this.updateChartData(this.items)
  },
  methods: {
    updateChartData(list) {
      this.chart.data.labels = list.map(el => el.when)
      this.chart.data.datasets[0].data = list.map(el => el.value)
      this.chart.update()
    },
    drawChart() {
      this.chart = new Chart(
        document.getElementById('fuel-graph').getContext('2d'),
        {
          type: 'line',
          data: {
            labels: [],
            datasets: [
              {
                label: '%',
                backgroundColor: '#EF5350',
                borderColor: '#EF5350',
                data: [],
                fill: false,
              },
            ],
          },
          options: {
            responsive: true,
            tooltips: {
              enabled: true,
            },
            legend: {
              display: false,
            },
            scales: {
              xAxes: [
                {
                  stacked: true,
                  barThickness: 20,
                },
              ],
              yAxes: [
                {
                  stacked: true,
                  gridLines: {
                    display: true,
                  },
                  ticks: {
                    beginAtZero: true,
                    min: 0,
                    max: 100,
                    stepSize: 20,
                    callback: (label, index, labels) => label + '%',
                  },
                },
              ],
            },
          },
        }
      )
    },
  },
}
</script>

<style lang="scss" scoped></style>
