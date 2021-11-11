import Vue from 'vue';
import Vuex from 'vuex';
import payment from './modules/payment';
import exchange from './modules/exchange';
import load from './modules/load';
import address from './modules/address';
import internment from './modules/internment';
import application from './modules/application';
import internalStorage from './modules/internalStorage';

Vue.use(Vuex);

const state = () => ({
    selectedServices: false,
    tabActive: '',
    statusModal: true,
    positionTabs: 0
});

const mutations = {
    incomingOrNextMenu(state, isAction) {
        state.positionTabs = isAction
            ? state.positionTabs + 1
            : state.positionTabs - 1;
        state.tabActive = state.selectedServices[state.positionTabs].code;
    },
    activeTabs(state, { code }) {
        state.tabActive = code;
        state.positionTabs = state.selectedServices.findIndex(
            service => service.code === code
        );
        this.state.address.addressDate = true;
        this.state.address.formAddress = true;
    }
};

const actions = {
    callIncomingOrNextMenu({ commit }, action) {
        commit('incomingOrNextMenu', action);
    },
    callActiveTabs({ commit }, service) {
        commit('activeTabs', service);
    }
};

const getters = {
    findService: state => code => {
        let service = state.selectedServices.filter(item => item.code == code);
        if (service.length) return true;
        else return false;
    }
};

export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations,
    modules: {
        payment,
        exchange,
        load,
        address,
        internment,
        application,
        internment,
        internalStorage
    }
});
