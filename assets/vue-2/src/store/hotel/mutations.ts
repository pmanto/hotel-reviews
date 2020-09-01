import { MutationTree } from 'vuex';
import { HotelState, HotelDD } from './types';

export const mutations: MutationTree<HotelState> = {
    hotelListLoaded(state, payload: Array<HotelDD>) {
        state.error = false;
        state.hotelList = payload;
    },
    hotelListError(state) {
        state.error = true;
        state.hotelList = [];
    }
};