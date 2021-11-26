import Form from 'vform';

const state = {
    expenses: new Form({
        app_amount: 0,
        trans_company_id: '',
        application_id: 0,
        origin_address: '',
        origin_latitude: 0,
        origin_longitude: 0,
        origin_postal_code: '',
        origin_locality: '',
        origin_ctry_code: '',
        origin_port_id: '',
        dest_address: '',
        dest_latitude: 0,
        dest_longitude: 0,
        dest_postal_code: '',
        dest_locality: '',
        dest_ctry_code: '',
        dest_port_id: '',
        estimated_date: new Date().toISOString().slice(0, 10),
        description: '',
        dataLoad: [],
        fav_origin_address: false,
        fav_origin_port: false,
        fav_dest_address: false,
        fav_dest_port: false,
        insurance: false,
        code_serv: 'ICS03',
        insurance_amt: 0
    }),
    Load: false,
    safe: false,
    addressDestination: [],
    portsDestination: [],
    addressDate: false,
    formAddress: false
};

const getters = {};

const mutations = {
    ADD_LOAD(state, payload) {
        state.loads.push({ ...payload });
    },
    SET_ADDRESS(state, payload) {
        state.addressDestination = payload;
    },
    SET_PORT_DEST(state, payload) {
        state.portsDestination = payload;
    },
    SET_TRANSPORT(state, { transport }) {
        state.expenses = new Form(transport);
    },
    SHOW_ADDRESS(state, value) {
        state.addressDate = value;
        state.formAddress = value;
    }
};

const actions = {
    addLoad({ commit }, payload) {
        commit('ADD_LOAD', payload);
    },
    async getAddressDestination({ state, commit }) {
        if (state.addressDestination == '') {
            let { data } = await axios.get('/company/address/all');
            commit('SET_ADDRESS', data);
        }
    },
    async getPortsDest({ state, commit }) {
        if (state.portsDestination == '') {
            let { data } = await axios.get('/sea-ports');
            commit('SET_PORT_DEST', data);
        }
    },
    setTransport({ commit }, data) {
        commit('SET_TRANSPORT', data);
    },
    showAddress({ commit }, value) {
        commit('SHOW_ADDRESS', value);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
