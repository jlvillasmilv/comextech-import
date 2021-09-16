import Form from 'vform'

const state = {
    expenses: new Form({
        application_id: 0,
        addressOrigin: "",
        origin_latitude: 0,
        origin_longitude: 0,
        origin_postal_code: 0,
        addressDestination: "",
        dest_latitude: 0,
        dest_longitude: 0,
        dest_postal_code: 0,
        estimated_date: "",
        description: "",
        dataLoad: [],
        favoriteAddressOrigin: false,
        favoriteAddressDestin: false,
        insurance: false,
        code_serv:'ICS03',
        insurance_amt:0,
    }),
    Load: false,
    safe: false,
    addressDestination: []
}

const getters = {}

const mutations = {
    ADD_LOAD(state, payload) {
        state.loads.push({ ...payload })
    },
    SET_ADDRESS(state, payload) {
        state.addressDestination = payload
    }
}

const actions = {
    addLoad({ commit  }, payload) {
        commit("ADD_LOAD", payload)
    },
    async getAddressDestination({state, commit }){
         if(state.addressDestination == ''){
            let { data } = await axios.get("/company/address/all");
            commit("SET_ADDRESS", data)
         }
        
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
