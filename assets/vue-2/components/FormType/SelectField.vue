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
<script>
export default {
  name: "SelectField",
  props: {
    choices: Object,
    label: String,
    id: String,
    onChange: Function,
  },
  data: function () {
    return {
      fieldValue: "0",
    };
  },
};
</script>