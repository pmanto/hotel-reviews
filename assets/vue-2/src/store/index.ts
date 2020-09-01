import Vue from 'vue';
import Vuex, { StoreOptions } from 'vuex';
import { RootState } from './types';
import { hotel } from './hotel/index';
import { review } from './review/index';

Vue.use(Vuex);

const store: StoreOptions<RootState> = {
    modules: {
        hotel, review
    }
};

export default new Vuex.Store<RootState>(store);