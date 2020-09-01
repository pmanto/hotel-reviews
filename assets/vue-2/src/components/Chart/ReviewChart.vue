<template>
  <LineChart v-if="load" :values="scores" :xLabels="xLabels" :yLabels="yLabels" />
</template>
<script lang="ts">
import LineChart from "./LineChart";
import { Component, Prop, Vue, Watch } from "vue-property-decorator";
import { ReviewOvertime, ReviewCollection } from "../../store/review/types";
import { State, Action, Getter } from "vuex-class";

@Component({
  components: {
    LineChart,
  },
})
export default class ReviewChart extends Vue {
  @Getter("reviewCollection", { namespace: "review" })
  reviewCollection!: ReviewCollection;
  private scores: Array<object> = [];
  private xLabels: Array<string> = [];
  private yLabels: number = 5;
  private load: boolean = false;

  get reviewsOvertime(): Array<ReviewOvertime> {
    return this.reviewCollection.reviewOverviews;
  }
  @Watch("reviewsOvertime", {
    immediate: true,
  })
  reviewsOvertimeChanged() {
    this.updateValues();
  }
  public updateValues(): void {
    if (this.reviewsOvertime.length > 0) {
      this.scores = [];
      this.xLabels = [];
      var period: string = "";
      this.reviewsOvertime.forEach((element) => {
        var score = {
          value: element.averageScore,
          reviewCount: element.reviewCount,
        };

        this.scores.push(score);
        if (period == "" || period !== element.period) {
          period = element.period;
          this.xLabels.push(element.period);
        } else {
          this.xLabels.push("");
        }
      });
      this.load = true;
    }
  }
}
</script>