import { shallowMount } from '@vue/test-utils'
import ReviewChart from '../../Chart/ReviewChart.vue'

describe('ReviewChart.vue', () => {
  test('renders line chart when loaded', () => {
    const load = true;
    const wrapper = shallowMount(ReviewChart, {
      data: { load }
    })
    expect(wrapper.find('.chart').exists()).toBeTruthy()
  })
})