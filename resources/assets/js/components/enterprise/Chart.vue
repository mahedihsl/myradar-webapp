<template>
  <div class="col-xs-12">
    <canvas id="canvas"></canvas>
  </div>
</template>
<script>
import EventBus from '../../util/EventBus';

export default {
  props: ['type', 'car'],
  data: () => ({
    label: '',
    items: [],
    labels: [],
  }),
  mounted() {
    EventBus.$on('chart-report-found', this.onReportFound.bind(this));

    let names = ['Driving Hour per Day', 'Duty Hour per Day', 'Mileage per Day'];
    this.label = names[parseInt(this.type) - 1];
  },
  updated() {
    console.log('chart update called');
  },
  methods: {
    onReportFound(id, list) {
      console.log('report found, ', list.length);
      if (this.car.id == id) {
        this.labels = [];
        this.items = [];
        for (let i = 1; i <= 31; i++) {
          let k = list.findIndex(o => o.day == i);
          this.labels.push(`${i}`);
          this.items.push(k != -1 ? list[k].val : 0);
        }
        this.drawChart();
      }
    },
    drawChart() {
      let ctx = document.getElementById('canvas').getContext('2d');
      let instance = this;
      new Chart(ctx, {
				type: 'bar',
				data: {
    			labels: this.labels,
    			datasets: [{
    				label: this.label,
    				backgroundColor: this.getBarColor(),
    				borderColor: this.getBorderColor(),
    				borderWidth: 1,
    				data: this.items,
    			}]
    		},
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: this.getTitle(),
					},
          tooltips: {
            enabled: true,
            callbacks: {
              title: function(tooltipItems, data) {
                return `${tooltipItems[0].xLabel} ${instance.car.info.month}`;
              },
              label: function(tooltipItem, data) {
                let val = tooltipItem.yLabel;
                let unit = instance.type == 3 ? 'Km' : 'Hour'
                let suffix = val > 1 && instance.type != 3 ? 's' : '';
                return `${val} ${unit}${suffix}`;
              }
            }
          }
				}
			});
    },

    getTitle() {
      let names = ['Driving Hour', 'Duty Hour', 'Mileage Report'];
      let driver = this.car.driver ? this.car.driver.name : '--'
      return `${names[parseInt(this.type) - 1]} of ${driver}, Car: ${this.car.name} (${this.car.info.month})`;
    },

    getBarColor() {
      let colors = ['#42A5F5', '#66BB6A', '#26A69A'];
      return colors[parseInt(this.type) - 1];
    },

    getBorderColor() {
      let colors = ['#1E88E5', '#43A047', '#00897B'];
      return colors[parseInt(this.type) - 1];
    }
  }
}
</script>
<style lang="scss" scoped>
canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
</style>
