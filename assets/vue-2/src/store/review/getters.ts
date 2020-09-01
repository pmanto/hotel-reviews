import { GetterTree } from 'vuex';
import { ReviewState, ReviewCollection } from './types';
import { RootState } from '../types';

export const getters: GetterTree<ReviewState, RootState> = {
    reviewCollection(state): ReviewCollection {
        return state.reviewCollection;
    }
};