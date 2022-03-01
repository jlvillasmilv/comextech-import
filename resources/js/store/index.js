import Vue from 'vue';
import Vuex from 'vuex';
import payment from './modules/payment';
import exchange from './modules/exchange';
import load from './modules/load';
import address from './modules/address';
import internment from './modules/internment';
import application from './modules/application';
import internalStorage from './modules/internalStorage';
import freightQuotes from './modules/freightQuotes';

Vue.use(Vuex);

const state = () => ({
  selectedServices: [],
  tabActive: '',
  statusModal: true,
  positionTabs: 0
});

const mutations = {
  incomingOrNextMenu(state, isAction) {
    state.positionTabs = isAction ? state.positionTabs + 1 : state.positionTabs - 1;
    state.tabActive = state.selectedServices[state.positionTabs].code;
  },
  activeTabs(state, { code }) {
    state.tabActive = code;
    state.positionTabs = state.selectedServices.findIndex((service) => service.code === code);
    if (code === 'ICS03') {
      if (this.state.address.showFedexDhlQuote || this.state.address.showLclFclQuote) {
        this.state.load.showLoad = false;
        this.state.address.isFormAddress = false;
        this.state.address.isDateAddress = false;
        this.state.address.isEdit = true;
        this.state.address.saveDataTransport = true;
        if (this.state.address.trans_company_id === 2) {
          this.state.address.showDhlQuote = false;
        }
        if (this.state.address.trans_company_id === 3) {
          this.state.address.showFedexQuote = false;
        }
      }
    } else {
      this.state.load.showLoad = true;
    }
    console.log(code);
  },
  SELECT_SERVICE(state, payload) {
    state.selectedServices.push({ ...payload });
    state.selectedServices = state.selectedServices.map((service) => {
      const newService = {
        ...service,
        checked: true
      };
      return newService;
    });
  },
  CLEAR_SERVICE(state) {
    const checkedServices = state.selectedServices.filter((item) => {
      return item.checked && item.selected;
    });
    const newConditionServices = this.state.application.selectedCondition.services.map((item) => {
      const serviceFound = checkedServices.find(
        (selected) => selected.code === item.code && item.selected
      );
      if (serviceFound) {
        item.checked = true;
      }
      return item;
    });
    this.state.application.selectedCondition.services = newConditionServices;
    state.selectedServices = newConditionServices.filter((item) => item.checked);

    // state.selectedServices = [];
    // const newCondition = this.state.application.selectedCondition.services.map((item) => {
    //   const clearService = {
    //     ...item,
    //     checked: false
    //   };
    //   return clearService;
    // });
    // this.state.application.selectedCondition.services = newCondition;
  }
};

const actions = {
  callIncomingOrNextMenu({ commit }, action) {
    commit('incomingOrNextMenu', action);
  },
  callActiveTabs({ commit }, service) {
    commit('activeTabs', service);
  },
  selectService({ commit }, service) {
    commit('SELECT_SERVICE', service);
  },
  clearService({ commit }) {
    commit('CLEAR_SERVICE');
  }
};

const getters = {
  findService: (state) => (code) => {
    let service = state.selectedServices.filter((item) => item.code == code);
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
    internalStorage,
    freightQuotes
  }
});
