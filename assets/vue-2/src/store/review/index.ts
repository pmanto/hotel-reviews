import { Module } from 'vuex';
import { getters } from './getters';
import { actions } from './actions';
import { mutations } from './mutations';
import { ReviewState } from './types';
import { RootState } from '../types';
export const state: ReviewState = {
    reviewCollection: {
        valid: false,
        errorMessage: '',
        reviewOverviews: []
    },
    error: false
}
const namespaced: boolean = true;
export const review: Module<ReviewState, RootState> = {
    namespaced,
    state,
    getters,
    actions,
    mutations
};