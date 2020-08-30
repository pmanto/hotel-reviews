import axios from "axios"
const moduleHotel = {
    namespaced: false,
    state: {
        hotelList: {},
        hotelListStatusPending: null,
        hotelListStatusSuccess: null,
        hotelListStatusFail: null
    },
    getters: {
        hotelList(state) {
            return state.hotelList;
        }
    },
    actions: {
        setHotelList(context) {
            context.commit("SET_HOTEL_LIST_PENDING", true);
            axios.get("http://localhost:8000/api/hotels")
                .then(({ data }) => {
                    context.commit("SET_HOTEL_LIST_STATUS_SUCCESS", true);
                    context.commit("SET_HOTEL_LIST_STATUS_FAIL", false);
                    context.commit("SET_HOTEL_LIST", data);
                })
                .catch(() => {
                    context.commit("SET_HOTEL_LIST_STATUS_SUCCESS", false);
                    context.commit("SET_HOTEL_LIST_STATUS_FAIL", true);
                    context.commit("SET_HOTEL_LIST", {});
                })
                .finally(() => {
                    context.commit("SET_HOTEL_LIST_PENDING", false);
                });
        }
    },
    mutations: {
        SET_HOTEL_LIST(state, payload) {
            state.hotelList = payload;
        },
        SET_HOTEL_LIST_STATUS_SUCCESS(state, payload) {
            state.hotelListStatusSuccess = payload;
        },
        SET_HOTEL_LIST_STATUS_FAIL(state, payload) {
            state.hotelListStatusFail = payload;
        },
        SET_HOTEL_LIST_PENDING(state, payload) {
            state.hotelListStatusPending = payload;
        }
    }
}

export default moduleHotel;