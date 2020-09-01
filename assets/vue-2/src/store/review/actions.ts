import { ActionTree } from 'vuex';
import axios from 'axios';
import { ReviewState, ReviewCollection } from './types';
import { RootState } from '../types';

export const actions: ActionTree<ReviewState, RootState> = {
    fetchReviewData({ commit }, params): any {
        var hotelId = params["hotelId"];
        var fromDate = params["fromDate"];
        var toDate = params["toDate"];
        axios({ url: "http://localhost:8000/api/overtime/" + hotelId + "/" + fromDate + "/" + toDate })
            .then((response) => {
                const payload: ReviewCollection = response && response.data
                commit("reviewListLoaded", payload);
            }, (error) => {
                commit('reviewListError');
            });
    }
};