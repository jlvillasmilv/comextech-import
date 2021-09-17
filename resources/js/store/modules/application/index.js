import Form from 'vform'

const state = {
    data: new Form({
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
    currencies: [],
    currency:'',
    selectedCondition:'',
    tabs:''
}
 

const mutations={
    SET_SUPPLIERS(state, payload){
        state.suppliers = payload
    },
    SET_SERVICES( state , payload){
        state.arrayServices = payload
    },
    SET_CURRENCIES(state, payload){
        state.currencies = payload
    },
    SET_CURRENCY(state, {currency}){
        state.currency = currency
    },
    SET_DATA(state, {fee1, fee2, condition, amount, supplier_id, currency_id, ecommerce_id, ecommerce_url, id:application_id }){
        
        state.data = new Form({
            ...state.data,
            condition:condition,
            amount: amount,
            supplier_id: supplier_id,
            currency_id: currency_id,
            ecommerce_id: ecommerce_id,
            ecommerce_url: ecommerce_url,
            application_id: application_id,
            statusSuppliers: "with",
            valuePercentage:{
                name:`${fee1}/${fee2}`,
                valueInitial:fee1
            }
        }) 
        state.selectedCondition = state.arrayServices.filter(item => item.name === condition )[0]
        state.tabs =  state.selectedCondition.services
    },
    SET_SERVICES_SELECTED(){

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
            commit('SET_SERVICES',  data)
        }
        
    },
    async getCurrencies({ commit, state }){
        if(!state.currencies.length){
            const { data } = await axios.get("/api/currencies");
            commit('SET_CURRENCIES', data)
        }
    },
    async getData({ commit, state }, id){
        const { data } = await axios.get("/get-application/"+id);
        commit('SET_DATA', data)
        commit('SET_CURRENCY', data)
    },
    getServicesSelecteds({ commit, state }){
        commit('UPDATE_TABS', data)     
    }
}


export default {
    namespaced: true,
    state,
    actions,
    mutations
}