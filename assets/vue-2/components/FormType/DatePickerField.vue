<template>
  <div class="form__input-div">
    <div class="form__input-label">{{label}}</div>
    <div class="form__input-input">
      <input type="date" :id="id" class="form__input from__input--outlined" />
    </div>
  </div>
</template>
<script>
export default {
  name: "DatePickerField",
  props: {
    label: String,
    id: String,
  },
};
</script>