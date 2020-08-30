<template>
  <div class="filter">
    <form class="filter__form form">
      <fieldset class="filter__fieldset">
        <legend class="filter__title">Filter</legend>
        <div class="form__inputs">
            <SelectField :choices="hotelList" label="Select Hotel" id="form_hotel_id" />
            <DatePickerField label="From" id="form_from_date" />
            <DatePickerField label="To" id="form_to_date" />
        </div>
      </fieldset>
    </form>
  </div>
</template>

<script>
import SelectField from "./FormType/SelectField";
import DatePickerField from "./FormType/DatePickerField";
export default {
  name: "FilterSection",
  computed: {
    hotelList() {
      return this.$store.getters.hotelList;
    },
  },
  mounted: function () {
    this.$store.dispatch("setHotelList");
  }, 
  components: {
    SelectField,
    DatePickerField,
  },
};
</script>