import Vue from "vue"
import Vuex from "vuex"
import payment from './modules/payment'
import exchange from "./modules/exchange"
import load from "./modules/load"
import address from "./modules/address"
import internment from "./modules/internment"



Vue.use(Vuex)

const state = () => ({
    application: [],
    currency: [],
    expenses: false,
    selectedServices: false,
    tabActive: "",
    statusModal: true,
    positionTabs: 0
})

const mutations = {
    setApplications(state, application) {
        state.application = application
    },
    setCurrency(state, currency) {
        state.currency = currency
    },
    
    setExpenses(state, expenses) {
        state.expenses = expenses
    },
    setServicesSelected(state, selectedServices) {
        state.selectedServices = selectedServices
    },
    incomingOrNextMenu(state, isAction) {
        state.positionTabs = isAction
            ? state.positionTabs + 1
            : state.positionTabs - 1
        state.tabActive = state.selectedServices[state.positionTabs].code
    },
    activeTabs(state, { code }) {
        state.tabActive = code
        state.positionTabs = state.selectedServices.findIndex(service => service.code === code)
    }
}

const actions = {
    getApplications({ commit }, paylod) {
        commit("setApplications", paylod)
    },
    getCurrency({ commit }, paylod) {
        commit("setCurrency", paylod)
    },
    getExpenses({ commit }, paylod) {
        commit("setExpenses", paylod)
    },
    callIncomingOrNextMenu({ commit }, action) {
        commit("incomingOrNextMenu", action)
    },
    callActiveTabs({ commit }, service){
        commit("activeTabs", service)
    }
}

const getters = {
    findService: state => code => {
        let service = state.selectedServices.filter(item => item.code == code)
        if (service.length) return true
        else return false
    },
    CIF: state => {
        return (
            Number(state.application.amount) +
            Number((state.application.amount * 2) / 100) +
            Number((state.application.amount * 5) / 100)
        )
    },
    codeCurrency: state => {
        return state.currency.code
    }
}


export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations,
    modules:{
        payment,
        exchange,
        load,
        address
        internment

    }
})
