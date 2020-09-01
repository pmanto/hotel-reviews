import { shallowMount } from '@vue/test-utils'
import SelectField from '../../FormType/SelectField.vue'

describe('SelectField.vue', () => {
  test('check if the label is render', () => {
    const label = "Label 1";
    const wrapper = shallowMount(SelectField, {
      propsData: { label }
    })
    expect(wrapper.text()).toContain("Label 1")
  })
})