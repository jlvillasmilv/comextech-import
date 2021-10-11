import Form from 'vform'

const state = {
    
    expenses: new Form({
        application_id: 0,
        address_origin: "",
        origin_latitude: 0,
        origin_longitude: 0,
        origin_postal_code: "",
        origin_locality: "",
        origin_ctry_code: "",
        address_destination: "",
        dest_latitude: 0,
        dest_longitude: 0,
        dest_postal_code: "",
        dest_locality: "",
        dest_ctry_code: "",
        estimated_date: new Date().toISOString().slice(0, 10),
        description: "",
        dataLoad: [],
        fav_address_origin: false,
        fav_dest_address: false,
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
    },
    SET_TRANSPORT(state, { transport }) {
       state.expenses = new Form(transport) 
    }

}

const actions = {
    addLoad({ commit  }, payload) {
        commit("ADD_LOAD", payload)
    },
    async getAddressDestination({state, commit }){
         if(state.addressDestination == ''){
            let { data } = await axios.get("/company/address/all")
            commit("SET_ADDRESS", data)
         }
    },
    setTransport({commit }, data){
        commit("SET_TRANSPORT", data)
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
