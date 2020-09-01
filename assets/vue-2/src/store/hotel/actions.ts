import { ActionTree } from 'vuex';
import axios from 'axios';
import { HotelState, HotelDD } from './types';
import { RootState } from '../types';


export const actions: ActionTree<HotelState, RootState> = {
    fetchHotelData({ commit }): any {
        axios({ url: "http://localhost:8000/api/hotels" })
            .then((response) => {
                const payload: Array<HotelDD> = response && response.data
                commit("hotelListLoaded", payload);
            }, (error) => {
                commit('hotelListError');
            });
    }
};