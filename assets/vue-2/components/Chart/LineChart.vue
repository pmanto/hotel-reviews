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
<script lang="ts">
import Popper from "popper.js";
import { Component, Prop, Vue } from "vue-property-decorator";
const TrendChart = require("vue-trend-chart");
Vue.use(TrendChart);
@Component({components:{TrendChart}})
export default class LineChart extends Vue {
  @Prop(Array) readonly values!: Array<object>;
  @Prop(Array) readonly xLabels!: Array<string>;
  @Prop(Number) readonly yLabels!: number;
  private grid: object = {
    verticalLines: true,
    horizontalLines: true,
    verticalLinesNumber: 1,
    horizontalLinesNumber: 1,
  };
  private tooltipData!: object;
  private popper?: Popper = undefined;
  private popperIsActive: boolean = false;
  get datasets(): Array<object> {
    return [
      {
        data: this.values,
        smooth: true,
        showPoints: true,
      },
    ];
  }
  get labels(): object {
    return {
      xLabels: this.xLabels,
      yLabels: this.yLabels,
    };
  }
  public initPopper(): void {
    const chart = document.querySelector(".line-chart");
    if (chart) {
      const ref = chart.querySelector(".active-line");
      const tooltip:any = this.$refs.tooltip;
      if (ref) {
        this.popper = new Popper(ref, tooltip, {
          placement: "right",
          modifiers: {
            offset: { offset: "0,10" },
            preventOverflow: {
              boundariesElement: chart,
            },
          },
        });
      }
    }
  }
  public onMouseMove(params: object): void {
    this.popperIsActive = !!params;
    if (this.popper !== undefined) {
      this.popper.scheduleUpdate();
    }
    this.tooltipData = params || null;
  }
  mounted() {
    this.initPopper();
  }
}
</script>