import Vue from "vue";

const state = {
    payment: [],
    discount: "",
    percentageInitial: 100,
};

const getters = {};

const mutations = {
    SET_PAYMENT(state, payment) {
        state.payment = payment;
    },
    ADD_PAYMENT(state, payment) {
        state.percentageInitial = state.percentageInitial - state.discount;

        state.payment.push(payment);
        state.discount = state.percentageInitial;
    },
    REMOVED_PAYMENT(state, id) {
         state.payment = state.payment.filter(item => item.id !== id)
    },
    RESET_PAYMENT(state, id) {
        state.payment = [],
        state.percentageInitial = 100

   }
};

const actions = {
    setPayment({ commit }, paylod) {
        commit("SET_PAYMENT", paylod);
    },
    addPayment({ commit }, paylod) {
        commit("ADD_PAYMENT", paylod);
    }, 
    deletePayment({ commit }, paylod){
      commit("REMOVED_PAYMENT", paylod);
    },
    resetPayment({ commit }){
        commit("RESET_PAYMENT");
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
