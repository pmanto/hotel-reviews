<template>
  <LineChart v-if="load" :values="scores" :xLabels="xLabels" :yLabels="yLabels" />
</template>
<script>
import LineChart from "./LineChart";
export default {
  name: "ReviewChart",
  components: {
    LineChart,
  },
  data: function () {
    return {
      scores: [],
      xLabels: [],
      yLabels: 5,
      load: false,
    };
  },
  computed: {
    reviewsOvertime() {
      return this.$store.getters.reviewOvertimeList;
    },
  },
  watch: {
    reviewsOvertime: function () {
      this.updateValues();
    },
  },
  methods: {
    updateValues: function () {
      if (this.reviewsOvertime.length > 0) {
        this.scores = [];
        this.xLabels = [];
        var period = null;
        this.reviewsOvertime.forEach((element) => {
          var score = {
            value: element.averageScore,
            reviewCount: element.reviewCount,
          };

          this.scores.push(score);
          if (!period || period !== element.period) {
            period = element.period;
            this.xLabels.push(element.period);
          } else {
            this.xLabels.push("");
          }
        });
        this.load = true;
      }
    },
  },
};
</script>