const state = {
    types: [
        'COURIER',
        'AEREO',
        'CONTAINER',
        'CONSOLIDADO',
        'TERRESTRE',
        'SIN TRANSPORTE'
    ],
    item: {
        mode_calculate: true,
        type_transport: 'COURIER',
        type_load: 1,
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
    loadType: 'both',
    loads: []
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
        state.item.type_transport = data[0].type_transport;
    },
    CHANGE_LOAD_TYPE(state, unit) {
        // const firstLoadType = state.loads[0].length_unit;

        const newLoads = state.loads.map(item => {
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
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
