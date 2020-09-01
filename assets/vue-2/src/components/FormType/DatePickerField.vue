<template>
  <div class="form__input-div">
    <div class="form__input-label">{{label}}</div>
    <div class="form__input-input">
      <input
        type="date"
        v-model="fieldValue"
        :id="id"
        class="form__input from__input--outlined"
        v-on:change="onChange"
      />
    </div>
  </div>
</template>
<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
@Component
export default class DatePickerField extends Vue {
  @Prop(String) readonly label!: string;
  @Prop(String) readonly id!: string;
  @Prop(Function) readonly onChange!: Function;
  private fieldValue: string = "";
}
</script>