const state = {
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
    weight: '',
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
