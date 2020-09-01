export interface ReviewOvertime {
    reviewCount: number;
    averageScore: number;
    dateGroup: string;
    period: string;
}

export interface ReviewCollection {
    valid: boolean;
    errorMessage: string;
    reviewOverviews: Array<ReviewOvertime>
}

export interface ReviewState {
    reviewCollection: ReviewCollection;
    error: boolean;
}