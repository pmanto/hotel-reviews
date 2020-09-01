<template>
  <div class="form__input-div">
    <select
      :id="id"
      class="form__select select form__select--outlined"
      v-model="fieldValue"
      v-on:change="onChange(fieldValue)"
    >
      <option class="select__placeholder" value="0" disabled selected>{{label}}</option>
      <option
        class="select__option"
        v-for="choice in choices"
        :key="choice.value"
        :value="choice.value"
      >{{choice.description}}</option>
    </select>
  </div>
</template>
<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
@Component
export default class SelectField extends Vue {
  @Prop(Object) readonly choices!: object;
  @Prop(String) readonly label!: string;
  @Prop(String) readonly id!: string;
  @Prop(Function) readonly onChange!: Function;
  private fieldValue: string = "0";
}
</script>