import Vue from 'vue'
import Vuex from 'vuex'
import moduleHotel from './modules/moduleHotel'
Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        moduleHotel
    }
})

export default store;