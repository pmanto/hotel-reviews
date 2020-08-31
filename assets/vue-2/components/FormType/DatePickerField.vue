<template>
  <div class="form__input-div">
    <div class="form__input-label">{{label}}</div>
    <div class="form__input-input">
      <input type="date" v-model="fieldValue" :id="id" class="form__input from__input--outlined" v-on:change="onChange" />
    </div>
  </div>
</template>
<script>
export default {
  name: "DatePickerField",
  props: {
    label: String,
    id: String,
    onChange: Function
  },
  data: function(){
    return {
      fieldValue: null
    }
  }
};
</script>