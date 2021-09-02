import Form from 'vform'

const state = {
    form: new Form({
        application_id: 0,
        amount: 0,
        supplier_id: "",
        currency_id: "",
        ecommerce_url: "",
        condition: "",
        description: "",
        statusSuppliers: "with",
        services: [],
        valuePercentage: ""
    }),
    agencyElectronic: [
        {
            name: "Mercado Libre"
        },
        {
            name: "Alibaba"
        },
        {
            name: "Amazon"
        }
    ],
    suppliers: [],
    arrayServices: [],
    currencies: []
}
const getters={}

const mutations={
    SET_SUPPLIERS(state, payload){
        state.suppliers = payload
    },
    SET_SERVICES( state , payload){
        state.arrayServices = payload
    },
    SET_CURRENCIES(state, payload){
        state.currencies = payload
    }
}
const actions = {
    async getSuppliers({ commit, state }){
        
        if(!state.suppliers.length){
            const  { data }  = await axios.get("/supplierlist");
            commit('SET_SUPPLIERS', data)
        }
    },
    async getServices({ commit, state }){
        if(!state.arrayServices.length){
            const { data } = await axios.get("/api/suppl_cond_sales");
            commit('SET_SERVICES', data)
        }
        
    },
    async getCurrencies({ commit, state }){
        if(!state.currencies.length){
            const { data } = await axios.get("/api/currencies");
            commit('SET_CURRENCIES', data)
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