<template>
  <div class="container dashboard">
    <FilterSection />
    <h2 class="dashboard__title">Average score over time</h2>
    <ReviewChart :fromDate="fromDate" :toDate="toDate" />
  </div>
</template>

<script lang="ts">
import FilterSection from "../components/FilterSection.vue";
import ReviewChart from "../components/Chart/ReviewChart.vue";
import { Component, Vue } from "vue-property-decorator";
@Component({
  components: {
    FilterSection,
    ReviewChart,
  },
})
export default class DashboardView extends Vue {}
</script>