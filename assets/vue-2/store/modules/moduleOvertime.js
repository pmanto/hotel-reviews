import axios from "axios"
const moduleOvertime = {
    namespaced: false,
    state: {
        reviewOvertimeList: [],
        reviewOvertimeListStatusPending: null,
        reviewOvertimeListStatusSuccess: null,
        reviewOvertimeListStatusFail: null
    },
    getters: {
        reviewOvertimeList(state) {
            return state.reviewOvertimeList;
        }
    },
    actions: {
        setReviewOvertimeList(context, data) {
            context.commit("SET_REVIEW_OVERTIME_LIST_PENDING", true);
            var hotelId = data["hotelId"];
            var fromDate = data["fromDate"];
            var toDate = data["toDate"];
            axios.get("http://localhost:8000/api/overtime/"+hotelId+"/"+fromDate+"/"+toDate)
                .then(({ data }) => {
                    context.commit("SET_REVIEW_OVERTIME_LIST_STATUS_SUCCESS", true);
                    context.commit("SET_REVIEW_OVERTIME_LIST_STATUS_FAIL", false);
                    if (data.valid) {
                        context.commit("SET_REVIEW_OVERTIME_LIST", data.reviewOverviews);
                    } else {
                        //TODO show error message
                    }
                })
                .catch(() => {
                    context.commit("SET_REVIEW_OVERTIME_LIST_STATUS_SUCCESS", false);
                    context.commit("SET_REVIEW_OVERTIME_LIST_STATUS_FAIL", true);
                    context.commit("SET_REVIEW_OVERTIME_LIST", []);
                })
                .finally(() => {
                    context.commit("SET_REVIEW_OVERTIME_LIST_PENDING", false);
                });
        }
    },
    mutations: {
        SET_REVIEW_OVERTIME_LIST(state, payload) {
            state.reviewOvertimeList = payload;
        },
        SET_REVIEW_OVERTIME_LIST_STATUS_SUCCESS(state, payload) {
            state.reviewOvertimeListStatusSuccess = payload;
        },
        SET_REVIEW_OVERTIME_LIST_STATUS_FAIL(state, payload) {
            state.reviewOvertimeListStatusFail = payload;
        },
        SET_REVIEW_OVERTIME_LIST_PENDING(state, payload) {
            state.reviewOvertimeListStatusPending = payload;
        }
    }
}

export default moduleOvertime;