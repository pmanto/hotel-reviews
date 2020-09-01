import { GetterTree } from 'vuex';
import { HotelState, HotelDD } from './types';
import { RootState } from '../types';

export const getters: GetterTree<HotelState, RootState> = {
    hotelList(state): Array<HotelDD> {
        return state.hotelList;
    }
};