import Form from 'vform';

const state = {
  expenses: new Form({
    app_amount: 0,
    trans_company_id: '',
    application_id: 0,
    origin_address: '',
    origin_postal_code: '',
    origin_locality: '',
    origin_ctry_code: '',
    origin_port_id: '',
    origin_latitude: 0,
    origin_longitude: 0,
    dest_address: '',
    dest_postal_code: '',
    dest_locality: '',
    dest_ctry_code: '',
    dest_province: '',
    dest_port_id: '',
    dest_latitude: 0,
    dest_longitude: 0,
    estimated_date: new Date().toISOString().slice(0, 10),
    description: '',
    dataLoad: [],
    fav_origin_address: false,
    fav_origin_port: false,
    fav_dest_address: false,
    fav_dest_port: false,
    insurance: false,
    code_serv: 'ICS03',
    insurance_amt: 0,
    mode_selected: ''
  }),
  Load: false,
  safe: false,
  addressDestination: [],
  origin_transport: [],
  portsOrigin: [],
  portsOriginTemp: [],
  portsDestination: [],
  portsDesTemp: [],
  minDate: new Date().toISOString().substr(0, 10),
  isFormAddress: true,
  isDateAddress: true,
  isEdit: false,
  fedex: {},
  dhl: {},
  showFedexQuote: false,
  showDhlQuote: false,
  showFedexDhlQuote: false,
  showLclFclQuote: false,
  tableFclLcl: {},
  saveDataTransport: false,
  isDisabled: false
};

const getters = {};

const mutations = {
  ADD_LOAD(state, payload) {
    state.loads.push({ ...payload });
  },
  SET_ADDRESS(state, payload) {
    state.addressDestination = payload;
  },
  SHOW_ADDRESSES(state, value) {
    state.isFormAddress = value;
    state.isDateAddress = value;
  },
  SHOW_BUTTON_EDIT(state, value) {
    state.isEdit = value;
  },
  SET_ORIGIN_TRANSPORT(state, payload) {
    state.origin_transport = payload.supplier_address;
  },
  SET_PORTS(state, payload) {
    state.portsDestination = payload;
    state.portsOrigin = payload;
  },
  SET_TRANSPORT(state, { transport }) {
    state.expenses = new Form(transport);
  },
  SET_MODE_SELECTED(state, payload) {
    state.expenses.mode_selected = payload;
  },
  SET_PORT_DEST(state, payload) {
    if (state.portsDesTemp == '') {
      state.portsDesTemp = state.portsDestination;
    }
    state.portsDestination = payload;
  },
  SET_PORT_ORIGIN(state, payload) {
    if (state.portsOriginTemp == '') {
      state.portsOriginTemp = state.portsDestination;
    }
    state.portsOrigin = payload;
  },
  SHOW_LOCAL_SHIPPING(state, value) {
    if (value) {
      state.showShipping = value;
      state.expenses.dest_address = '';
    } else if (!value) {
      state.showShipping = value;
      state.expenses.dest_address = '';
      state.postalCodeDestination = false;
    }
  },
  SET_FEDEX_DHL(state, response) {
    state.showFedexDhlQuote = true;
    if (response[0]) {
      state.fedex = response[0].data;
      state.showFedexQuote = true;
    }
    if (response[1]) {
      state.dhl = response[1].data;
      state.showDhlQuote = true;
    } else if (!response[0] && !response[1]) {
      state.fedex = {};
      state.dhl = {};
      state.showFedexDhlQuote = false;
      state.showFedexQuote = false;
      state.showDhlQuote = false;
    }
  },
  HIDE_COURIER_QUOTES(state, value) {
    state.fedex = {};
    state.dhl = {};
    state.showFedexDhlQuote = value;
    state.showFedexQuote = value;
    state.showDhlQuote = value;
  },
  SELECT_COURIER(state, type) {
    state.isDisabled = false;
    if (type === 2) {
      state.showDhlQuote = false;
    }
    if (type === 3) {
      state.showFedexQuote = false;
    }
  },
  SET_LCL_FCL(state, QuoteResponse) {
    state.showLclFclQuote = true;
    state.tableFclLcl = QuoteResponse;
  },
  HIDE_TABLE_FCL_LCL(state, value) {
    state.showLclFclQuote = value;
  },
  ACTIVE_SAVE_DATA(state, value) {
    state.saveDataTransport = value;
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
  async getOriginTransport({ commit }, id) {
    const { data } = await axios.get('/api/provider/' + id);
    commit('SET_ORIGIN_TRANSPORT', data);
  },
  async getPorts({ state, commit }, type) {
    if (state.portsDestination == '') {
      let { data } = await axios.get(`/ports/${type}`);
      commit('SET_PORTS', data);
    }
  },
  // Origin Port
  async getFavOriginPort({ commit }, payload) {
    let { data } = await axios.get(`/ports-supplier/${payload.idsupplier}/${payload.type}`);
    commit('SET_PORT_ORIGIN', data);
  },
  setOrigFavOritPorts({ state, commit }) {
    data = state.portsOriginTemp;
    commit('SET_PORT_ORIGIN', data);
  },
  //Dest Port
  async getFavDestPorts({ state, commit }, type) {
    let { data } = await axios.get(`/ports-user/${type}`);
    commit('SET_PORT_DEST', data);
  },
  setOrigFavDestPorts({ state, commit }) {
    data = state.portsDesTemp;
    commit('SET_PORT_DEST', data);
  },
  setTransport({ commit }, data) {
    if (data.transport) {
      commit('SET_TRANSPORT', data);
    }
  },
  setModeSelected({ commit }, data) {
    commit('SET_MODE_SELECTED', data);
  },
  showLocalShipping({ commit }, value) {
    commit('SHOW_LOCAL_SHIPPING', value);
  },
  getFedexDhlQuote({ commit }, payload) {
    const fedexApi = payload
      .post('/api/get-fedex-rate')
      .then((res) => {
        return res;
      })
      .catch((error) => {
        console.error(error);
      });

    const DhlApi = payload
      .post('/api/get-dhl-quote')
      .then((res) => {
        return res;
      })
      .catch((error) => {
        console.error(error);
      });

    const fedexDhlQuote = Promise.all([fedexApi, DhlApi])
      .then((response) => {
        if (response[0] || response[1]) {
          commit('SET_FEDEX_DHL', response);
          return response;
        }
      })
      .catch((error) => {
        console.error(error);
      });
    return fedexDhlQuote;
  },
  async getLclFclTable({ commit }, payload) {
    try {
      const QuoteResponse = await payload.post('/applications/transports');
      if (QuoteResponse.status == 200) {
        commit('SET_LCL_FCL', QuoteResponse.data);
        return QuoteResponse;
      }
    } catch (error) {
      console.error(error);
    }
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
