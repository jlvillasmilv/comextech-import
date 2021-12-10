import Form from 'vform';

const state = {
  data: new Form({
    application_id: 0,
    amount: 0,
    supplier_id: null,
    currency_id: null,
    ecommerce_url: null,
    condition: 'EXW',
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
    state.selectedCondition = payload[0];
  },
  SET_CURRENCIES(state, payload) {
    state.currencies = payload;
  },
  SET_CURRENCY(state, { currency }) {
    state.currency = currency;
  },
  SET_ORIGIN_TRANSPORT(state, payload) {
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
      id
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
      application_id: id,
      type_transport,
      valuePercentage: {
        name: `${fee1}/${fee2}`,
        valueInitial: fee1
      }
    });
    state.selectedCondition = state.arrayServices.filter((item) => item.name === condition)[0];
    state.tabs = state.selectedCondition.services;
  },
  SET_SUPPLIER_TYPE(state, { ecommerce_url, supplier_id }) {
    if (ecommerce_url) return (state.data.statusSuppliers = 'E-commerce');
    else if (supplier_id) return (state.data.statusSuppliers = 'with');
    else return (state.data.statusSuppliers = 'without');
  },
  TOOGLE_TABS(state, services) {
    state.tabs = state.tabs.map((item) =>
      services.find((e) => e == item.code) ? { ...item, checked: true } : item
    );
    state.selectedCondition.services = state.tabs;
  },
  UPDATE_SERVICE(state, payload) {
    state.selectedCondition.services = state.selectedCondition.services.map((service) =>
      payload.name === service.name ? { ...service, checked: true } : service
    );
    state.data.services.push(payload.code);
  },
  DELETE_SERVICE(state, payload) {
    console.log(payload);
    this.state.selectedServices = this.state.selectedServices.filter(
      (item) => item.sort !== payload
    );
    state.selectedCondition.services = state.selectedCondition.services.map((tab) =>
      tab.sort == payload ? { ...tab, checked: false } : tab
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
      const { data } = await axios.get('/suppl_cond_sales');
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
  },
  updateService({ commit }, service) {
    commit('UPDATE_SERVICE', service);
  },
  deleteService({ commit }, id) {
    commit('DELETE_SERVICE', id);
  }
};

export default {
  namespaced: true,
  state,
  actions,
  mutations
};
