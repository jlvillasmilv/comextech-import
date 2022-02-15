import Form from 'vform';

const state = {
  expenses: new Form({
    type_transport: 'COURIER',
    app_amount: 0,
    cargo_value: '',
    trans_company_id: '',
    application_id: 1,
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
    local_transp_amt: 0,
    transport_amount: 0,
    oth_exp: 0,
    cif: 0,
    mode_selected: 'COURIER',
    client: {
      name: '',
      email: '',
      phone_number: '',
      ip: 0,
      region: '',
      country: 'CL'
    }
  }),
  Load: false,
  safe: false,
  addressDestination: [],
  portsOrigin: [],
  portsOriginTemp: [],
  portsDestination: [],
  portsDesTemp: [],
  addressDate: true,
  formAddress: false,
  minDate: new Date().toISOString().substr(0, 10),
  postalCodeOrigin: false,
  postalCodeDestination: false,
  showShipping: false,
  showForm: false,
  table: [],
  showTable: false,
  buttons: true,
  fedex: {},
  dhl: {},
  showFedexQuote: false,
  showDhlQuote: false,
  showFedexDhlQuote: false
};

const getters = {
  showLoader(status) {
    let loader = this.$loading.show({
      canCancel: true,
      transition: 'fade',
      color: '#142c44',
      loader: 'spinner',
      lockScroll: true,
      enforceFocus: true,
      height: 100,
      width: 100
    });
    if (!status) {
      loader.hide();
    }
  }
};

const mutations = {
  ADD_LOAD(state, payload) {
    state.loads.push({ ...payload });
  },
  SET_ADDRESS(state, payload) {
    state.addressDestination = payload;
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
  SHOW_ADDRESS(state, value) {
    state.addressDate = value;
    state.formAddress = value;
  },
  HIDE_COURIER_QUOTES(state) {
    state.showFedexQuote = false;
    state.showDhlQuote = false;
    state.showFedexDhlQuote = false;
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
  SHOW_FREIGHT_FORM(state, value) {
    state.showForm = value;
  },
  SHOW_HIDE_BUTTONS_QUOTE(state, value) {
    state.buttons = value;
  },
  SET_TABLE(state, payload) {
    if (payload) {
      state.showTable = true;
      state.table = payload;
      state.expenses.transport_amount = state.table.transport.transport_amount;
      state.expenses.local_transp_amt = state.table.transport.local_transp;
      state.expenses.oth_exp = state.table.transport.oth_exp;
      state.expenses.insurance_amt = state.table.transport.insurance;
      state.expenses.cif = state.table.transport.cif;
    } else {
      state.showTable = false;
    }
  },
  SET_FEDEX_DHL(state, response) {
    if (response[0]) {
      state.fedex = response[0].data;
      state.showFedexDhlQuote = true;
      state.showFedexQuote = true;
    }
    if (response[1]) {
      state.dhl = response[1].data;
      state.showFedexDhlQuote = true;
      state.showDhlQuote = true;
    }
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
  async getPorts({ state, commit }, type) {
    if (state.portsDestination == '') {
      let { data } = await axios.post(`/api/ports/${type}`);
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
  // Dest Port
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
  getAddressOrigin({ commit }, { addressData, placeResultData }) {
    commit('GET_ADDRESS_ORIGIN', { addressData, placeResultData });
  },
  getAddressDestination2({ commit }, { addressData, placeResultData }) {
    commit('GET_ADDRESS_DESTINATION', { addressData, placeResultData });
  },
  async getTransportTableQuote({ commit }, payload) {
    try {
      const transportQuote = await payload.post('/freight-quotes/calculate');
      if (transportQuote.status == 200) {
        commit('SET_TABLE', transportQuote.data);
        return transportQuote;
      }
    } catch (error) {
      console.error(error);
    }
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
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
