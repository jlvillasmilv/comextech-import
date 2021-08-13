import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);

const state = () => ({
    application: [],
    currency: [],
    payment:[]
});

const mutations = {
    setApplications(state, application) {
        state.application = application;
    },
    setCurrency(state, currency) {
        state.currency = currency;
    },
    setPayment(state, payment) {
        state.payment = payment;
    }
};

const actions = {
    getApplications({ commit }, paylod) {
        commit("setApplications", paylod);
    },
    getCurrency({ commit }, paylod) {
        commit("setCurrency", paylod);
    },
    getPayment({ commit }, paylod) {
        commit("setPayment", paylod);
    }
};

const getters = {};

export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations
});
