<template>
  <div class="container dashboard">
    <FilterSection />
    <h2 class="dashboard__title">Average score over time</h2>
    <ReviewChart :fromDate="fromDate" :toDate="toDate" />
  </div>
</template>

<script>
import FilterSection from "../components/FilterSection";
import ReviewChart from "../components/Chart/ReviewChart";
export default {
  name: "DashboardView",
  components: {
    FilterSection,
    ReviewChart,
  }
};
</script>