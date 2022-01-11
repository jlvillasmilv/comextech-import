const state = {
  types: [
    {
      name: 'COURIER',
      path:
        'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
    },
    {
      name: 'AEREO',
      path: 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8'
    },
    {
      name: 'CONTAINER',
      path:
        'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
    },
    {
      name: 'CONSOLIDADO',
      path:
        'M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'
    },
    {
      name: 'TERRESTRE',
      path:
        'M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0'
    },
    {
      name: 'SIN TRANSPORTE',
      path:
        'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636'
    }
  ],
  item: {
    mode_calculate: true,
    category_load_id: 1,
    type_container: 1,
    length: '',
    width: '',
    height: '',
    length_unit: 'CM',
    id: 1,
    cbm: '',
    weight: false,
    weight_units: 'KG',
    stackable: false,
    id: 0
  },
  mode_selected: false,
  loadType: 'both',
  loads: [],
  showLoad: true
};

const getters = {};

const mutations = {
  ADD_LOAD(state, payload) {
    state.loads.push({ ...payload });
  },
  REMOVED_LOAD(state, id) {
    if (!state.loads) {
      state.loadType = 'both';
    }
    state.loads.splice(id, 1);
  },
  SET_LOAD(state, data) {
    state.loads = data;
    // state.item.mode_selected = data[0].mode_selected;
  },
  CHANGE_LOAD_TYPE(state, unit) {
    // const firstLoadType = state.loads[0].length_unit;

    const newLoads = state.loads.map((item) => {
      if (unit == 'CM') {
        const newItem = {
          ...item,
          length_unit: unit,
          weight_units: 'KG'
        };
        return newItem;
      } else if (unit == 'IN') {
        const newItem = {
          ...item,
          length_unit: unit,
          weight_units: 'LB'
        };
        return newItem;
      }
    });
    state.loads = [...newLoads];
    // state = {
    //     ...state,
    //     loads: [...newLoads],
    //     loadType: unit
    // };
  },
  SHOW_LOAD_CHARGE(state, value) {
    state.showLoad = value;
  }
};

const actions = {
  addLoad({ commit, rootState }, paylod) {
    commit('ADD_LOAD', paylod);
  },
  removedLoad({ commit }, id) {
    commit('REMOVED_LOAD', id);
  },
  setLoad({ commit }, data) {
    commit('SET_LOAD', data.loads);
  },
  changeLoadType({ commit }, unit) {
    commit('CHANGE_LOAD_TYPE', unit);
  },
  showLoadCharge({ commit }, payload) {
    commit('SHOW_LOAD_CHARGE', payload);
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
