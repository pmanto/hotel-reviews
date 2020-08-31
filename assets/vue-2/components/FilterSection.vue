<template>
  <div class="filter">
    <form class="filter__form form">
      <fieldset class="filter__fieldset">
        <legend class="filter__title">Filter</legend>
        <div class="form__inputs">
          <SelectField
            :choices="hotelList"
            label="SELECT HOTEL"
            id="form_hotel_id"
            :onChange="updateHotelId"
          />
          <DatePickerField label="FROM" id="form_from_date" :onChange="updateFromDate" />
          <DatePickerField label="TO" id="form_to_date" :onChange="updateToDate" />
        </div>
      </fieldset>
    </form>
  </div>
</template>
<script>
import SelectField from "./FormType/SelectField";
import DatePickerField from "./FormType/DatePickerField";
import Vue from "vue";

export default Vue.extend({
  name: "FilterSection",
  computed: {
    hotelList() {
      return this.$store.getters.hotelList;
    },
  },
  data: function () {
    return {
      hotelId: 0,
      fromDate: null,
      toDate: null,
    };
  },
  mounted: function () {
    this.$store.dispatch("setHotelList");
  },
  methods: {
    updateHotelId: function (value) {
      this.hotelId = value;
      this.fetchData();
    },
    updateFromDate: function (value) {
      this.fromDate = value.target.value;
      this.fetchData();
    },
    updateToDate(value) {
      this.toDate = value.target.value;
      this.fetchData();
    },
    fetchData() {
      if (
        this.hotelId != 0 &&
        this.fromDate &&
        this.toDate &&
        new Date(this.fromDate) <= new Date(this.toDate)
      ) {
        this.$store.dispatch("setReviewOvertimeList", {
          hotelId: this.hotelId,
          fromDate: this.fromDate,
          toDate: this.toDate,
        });
      }
    },
  },
  components: {
    SelectField,
    DatePickerField,
  },
});
</script>