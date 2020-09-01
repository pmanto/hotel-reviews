import { MutationTree } from 'vuex';
import { ReviewState, ReviewCollection } from './types';

export const mutations: MutationTree<ReviewState> = {
    reviewListLoaded(state, payload: ReviewCollection) {
        state.error = false;
        state.reviewCollection = payload;
    },
    reviewListError(state) {
        state.error = true;
        var reviewColl :ReviewCollection ={
            valid: false,
            errorMessage: '',
            reviewOverviews: []
        }

        state.reviewCollection = reviewColl;
    }
};