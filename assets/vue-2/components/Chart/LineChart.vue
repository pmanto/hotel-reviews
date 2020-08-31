<template>
  <div class="chart">
    <TrendChart
      :datasets="datasets"
      :grid="grid"
      :labels="labels"
      :min="0"
      :max="100"
      :interactive="true"
      @mouse-move="onMouseMove"
      class="line-chart"
    />
    <div id="pop" role="tooltip" ref="tooltip" class="tooltip" :class="{'is-active': tooltipData}">
      <div class="tooltip__container" v-if="tooltipData">
        <strong>{{labels.xLabels[tooltipData.index]}}</strong>
        <div class="tooltip__data">
          <div class="tooltip__item">Score: {{tooltipData.data[0]["value"]}}</div>          
          <div class="tooltip__item">Review count: {{tooltipData.data[0]["reviewCount"]}}</div>          
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import TrendChart from "vue-trend-chart";
import Popper from "popper.js";
Popper.Defaults.modifiers.computeStyle.gpuAcceleration = false;
export default {
  name: "LineChart",
  props: {
    values: Array,
    xLabels: Array,
    yLabels: Number,
  },
  data: function () {
    return {
      grid: {
        verticalLines: true,
        horizontalLines: true,
        verticalLinesNumber: 1,
        horizontalLinesNumber: 1
      },
      tooltipData: null,
      popper: null,
      popperIsActive: false,
    };
  },
  computed: {
    datasets() {
      return [
        {
          data: this.values,
          smooth: true,
          showPoints: true
        },
      ];
    },
    labels() {
      return {
        xLabels: this.xLabels,
        yLabels: this.yLabels,
        yLabelsTextFormatter: (val) => Math.round(val),
      };
    },
  },
  methods: {
    initPopper() {
      const chart = document.querySelector(".line-chart");
      const ref = chart.querySelector(".active-line");
      const tooltip = this.$refs.tooltip;
      this.popper = new Popper(ref, tooltip, {
        placement: "right",
        modifiers: {
          offset: { offset: "0,10" },
          preventOverflow: {
            boundariesElement: chart,
          },
        },
      });
    },
    onMouseMove(params) {
      this.popperIsActive = !!params;
      this.popper.scheduleUpdate();
      this.tooltipData = params || null;
    },
  },
  components: {
    TrendChart,
  },
  mounted() {
    this.initPopper();
  },
};
</script>