import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);

const state = () => ({
    application: [],
    currency: [],
    payment: [],
    expenses: false,
    selectedServices: false,
    tabActive: "",
    statusModal: true,
    positionTabs:0,
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
    },
    setExpenses(state, expenses) {
        state.expenses = expenses;
    },
    setServicesSelected(state, selectedServices) {
        state.selectedServices = selectedServices;
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
    },
    getExpenses({ commit }, paylod) {
        commit("setExpenses", paylod);
    },
    getSelectedServices({ commit }, paylod) {
        commit("setServicesSelected", paylod);
    }
};

const getters = {
    findService: state => code => {
        let service = state.selectedServices.filter(item => item.code == code);
        if (service.length) return true;
        else return false;
    },
    CIF: state => {
        return (
            Number(state.application.amount) +
            Number((state.application.amount * 2) / 100) +
            Number((state.application.amount * 5) / 100)
        );
    },
    codeCurrency: state => {
        return state.currency.code;
    }
};

export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations
});
