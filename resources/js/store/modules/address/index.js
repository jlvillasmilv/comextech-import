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
  portsOrigin: [],
  portsOriginTemp: [],
  portsDestination: [],
  portsDesTemp: [],
  addressDate: true,
  formAddress: false,
  minDate: new Date().toISOString().substr(0, 10),
  postalCodeOrigin: false,
  postalCodeDestination: false,
  showShipping: false
};

const getters = {};

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
  SHOW_QUOTE_FCL(state, value) {
    state.fclTable = value;
  },
  SHOW_QUOTE_LCL(state, value) {
    state.lclTable = value;
  },
  GET_ADDRESS_ORIGIN(state, { addressData, placeResultData }) {
    state.expenses.origin_address = placeResultData.formatted_address;
    state.expenses.origin_latitude = addressData.latitude;
    state.expenses.origin_longitude = addressData.longitude;

    for (const component of placeResultData.address_components) {
      const componentType = component.types[0];

      switch (componentType) {
        case 'country':
          state.expenses.origin_ctry_code = component.short_name;
          break;

        case 'locality':
          state.expenses.origin_locality = component.long_name;
          break;

        case 'postal_code': {
          state.expenses.origin_postal_code = component.long_name;
          break;
        }
      }
    }
    if (!state.expenses.origin_postal_code) {
      state.postalCodeOrigin = true;
    } else {
      state.postalCodeOrigin = false;
    }
  },
  GET_ADDRESS_DESTINATION(state, { addressData, placeResultData }) {
    state.expenses.dest_latitude = addressData.latitude;
    state.expenses.dest_longitude = addressData.longitude;

    for (const component of placeResultData.address_components) {
      const componentType = component.types[0];

      switch (componentType) {
        case 'country':
          state.expenses.dest_ctry_code = component.short_name;
          break;

        case 'locality':
          state.expenses.dest_locality = component.long_name;
          break;

        case 'administrative_area_level_2': {
          state.expenses.dest_province = component.long_name;
          break;
        }

        case 'postal_code': {
          state.expenses.dest_postal_code = component.long_name;
          break;
        }
      }
    }

    state.expenses.dest_address = placeResultData.formatted_address;

    if (!state.expenses.dest_postal_code) {
      state.postalCodeDestination = true;
    } else {
      state.postalCodeDestination = false;
    }
  },
  GET_FORMAT_PRICE(state, { value, currency }) {
    return Number(value).toLocaleString(navigator.language, {
      minimumFractionDigits: currency == 'CLP' ? 0 : 2,
      maximumFractionDigits: currency == 'CLP' ? 0 : 2
    });
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
  showAddress({ commit }, value) {
    commit('SHOW_ADDRESS', value);
  },
  setModeSelected({ commit }, data) {
    commit('SET_MODE_SELECTED', data);
  },
  showQuoteFCL({ commit }, value) {
    commit('SHOW_QUOTE_FCL', value);
  },
  showQuoteLCL({ commit }, value) {
    commit('SHOW_QUOTE_LCL', value);
  },
  mapa({ state, commit }) {
    console.log('mapa google');
  },
  getAddressOrigin({ commit }, { addressData, placeResultData }) {
    commit('GET_ADDRESS_ORIGIN', { addressData, placeResultData });
  },
  getAddressDestination2({ commit }, { addressData, placeResultData }) {
    commit('GET_ADDRESS_DESTINATION', { addressData, placeResultData });
  },
  getFormatPrice({ commit }, { value, currency }) {
    commit('GET_FORMAT_PRICE', { value, currency });
  },
  showLocalShipping({ commit }, value) {
    commit('SHOW_LOCAL_SHIPPING', value);
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
