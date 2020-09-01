export interface HotelDD {
    value: number;
    description: string;
}

export interface HotelState {
    hotelList: Array<HotelDD>;
    error: boolean;
}