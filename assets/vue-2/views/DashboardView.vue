<template>
  <div class="container dashboard">
    <FilterSection />
    <h2 class="dashboard__title">Average score over time</h2>
  </div>
</template>

<script>
import FilterSection from "../components/FilterSection";
export default {
  name: "DashboardView",
  components: {
    FilterSection
  },
};
</script>