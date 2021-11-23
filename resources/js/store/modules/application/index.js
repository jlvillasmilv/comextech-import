import Form from 'vform';

const state = {
    data: new Form({
        application_id: 0,
        amount: 0,
        supplier_id: null,
        currency_id: null,
        ecommerce_url: null,
        condition: '',
        statusSuppliers: 'with',
        services: [],
        valuePercentage: '',
        type_transport: ''
    }),
    agencyElectronic: [
        {
            id: 1,
            name: 'Mercado Libre'
        },
        {
            id: 2,
            name: 'Alibaba'
        },
        {
            id: 3,
            name: 'Amazon'
        }
    ],
    suppliers: [],
    arrayServices: [],
    currencies: [],
    origin_transport: [],
    currency: '',
    selectedCondition: '',
    tabs: '',
    editing: false
};

const mutations = {
    SET_SUPPLIERS(state, payload) {
        state.suppliers = payload;
    },
    SET_SERVICES(state, payload) {
        state.arrayServices = payload;
    },
    SET_CURRENCIES(state, payload) {
        state.currencies = payload;
    },
    SET_CURRENCY(state, { currency }) {
        state.currency = currency;
    },
    SET_ORIGIN_TRANSPORT(state, payload) {
        console.log(payload.supplier_address);
        state.origin_transport = payload.supplier_address;
    },
    SET_DATA(
        state,
        {
            fee1,
            fee2,
            condition,
            amount,
            supplier_id,
            currency_id,
            ecommerce_id,
            ecommerce_url,
            type_transport,
            id: application_id,
            payment_provider
        },
        rootState
    ) {
        state.editing = true;
        state.data = new Form({
            ...state.data,
            condition,
            amount,
            supplier_id: supplier_id == null ? ecommerce_id : supplier_id,
            currency_id,
            ecommerce_url,
            application_id,
            type_transport,
            valuePercentage: {
                name: `${fee1}/${fee2}`,
                valueInitial: fee1
            }
        });
        state.selectedCondition = state.arrayServices.filter(
            item => item.name === condition
        )[0];
        state.tabs = state.selectedCondition.services;
    },
    SET_SUPPLIER_TYPE(state, { ecommerce_url, supplier_id }) {
        if (ecommerce_url) return (state.data.statusSuppliers = 'E-commerce');
        else if (supplier_id) return (state.data.statusSuppliers = 'with');
        else return (state.data.statusSuppliers = 'without');
    },
    TOOGLE_TABS(state, services) {
        state.tabs = state.tabs.map(item =>
            services.find(e => e == item.code)
                ? { ...item, checked: true }
                : item
        );
    }
};
const actions = {
    async getSuppliers({ commit, state }) {
        if (!state.suppliers.length) {
            const { data } = await axios.get('/supplierlist');
            commit('SET_SUPPLIERS', data);
        }
    },
    async getServices({ commit, state }) {
        if (!state.arrayServices.length) {
            const { data } = await axios.get('/api/suppl_cond_sales');
            commit('SET_SERVICES', data);
        }
    },
    async getCurrencies({ commit, state }) {
        if (!state.currencies.length) {
            const { data } = await axios.get('/api/currencies');
            commit('SET_CURRENCIES', data);
        }
    },
    async getOriginTransport({ commit }, id) {
        const { data } = await axios.get('/api/provider/' + id);
        commit('SET_ORIGIN_TRANSPORT', data);
    },
    async setData({ commit }, data) {
        commit('SET_DATA', data);
        commit('SET_CURRENCY', data);
        commit('SET_SUPPLIER_TYPE', data);
    },
    async getServicesSelecteds({ commit }, id) {
        const { data } = await axios.get('/get-application-category/' + id);
        commit('TOOGLE_TABS', data);
    }
};

export default {
    namespaced: true,
    state,
    actions,
    mutations
};
