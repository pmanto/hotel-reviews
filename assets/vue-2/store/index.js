import Vue from 'vue'
import Vuex from 'vuex'
import moduleHotel from './modules/moduleHotel'
import moduleOvertime from './modules/moduleOvertime'
Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        moduleHotel,
        moduleOvertime
    }
})

export default store;