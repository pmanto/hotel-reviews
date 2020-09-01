<template>
  <div class="filter">
    <form class="filter__form form">
      <fieldset class="filter__fieldset">
        <legend class="filter__title">Filter</legend>
        <div class="form__inputs">
          <SelectField
            :choices="hotelListComp"
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
<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import SelectField from "./FormType/SelectField";
import DatePickerField from "./FormType/DatePickerField";
import { State, Action, Getter } from "vuex-class";
import { HotelState, HotelDD } from "../store/hotel/types";
import { ReviewState } from "../store/review/types";

@Component({
  components: {
    SelectField,
    DatePickerField,
  },
})
export default class FilterSection extends Vue {
  @State("hotel") hotel!: HotelState;
  @State("review") review!: ReviewState;
  @Action("fetchHotelData", { namespace: "hotel" }) fetchHotelData: any;
  @Action("fetchReviewData", { namespace: "review" }) fetchReviewData: any;
  @Getter("hotelList", { namespace: "hotel" }) hotelList!: Array<HotelDD>;
  private hotelId: string = "0";
  private fromDate?: string;
  private toDate?: string;
  get hotelListComp(): Array<HotelDD> {
    return this.hotelList;
  }
  public updateHotelId(value: string): void {
    this.hotelId = value;
    this.fetchData();
  }
  public updateFromDate(event: any): void {
    this.fromDate = event.target._value;
    this.fetchData();
  }
  public updateToDate(event: any): void {
    this.toDate = event.target._value;
    this.fetchData();
  }
  public fetchData(): void {
    if (
      this.hotelId != "0" &&
      this.fromDate &&
      this.toDate &&
      new Date(this.fromDate) <= new Date(this.toDate)
    ) {
      this.fetchReviewData({
        hotelId: this.hotelId,
        fromDate: this.fromDate,
        toDate: this.toDate,
      });
    }
  }
  mounted() {
    this.fetchHotelData();
  }
}
</script>