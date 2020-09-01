import { Module } from 'vuex';
import { getters } from './getters';
import { actions } from './actions';
import { mutations } from './mutations';
import { HotelState } from './types';
import { RootState } from '../types';
export const state: HotelState = {
    hotelList: [],
    error: false
}
const namespaced: boolean = true;
export const hotel: Module<HotelState, RootState> = {
    namespaced,
    state,
    getters,
    actions,
    mutations
};