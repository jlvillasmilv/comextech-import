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
    }
};

const actions = {
    getPayment({ commit }, paylod) {
        commit("SET_PAYMENT", paylod);
    },
    addPayment({ commit }, paylod) {
        commit("ADD_PAYMENT", paylod);
    }, 
    deletePayment({ commit }, paylod){
      commit("REMOVED_PAYMENT", paylod);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
