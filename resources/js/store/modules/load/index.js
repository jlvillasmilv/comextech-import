
const state = {
    types: ["COURIER","CARGA AEREA", "CONTAINER", "CONSOLIDADO"],
    item: {
        mode_calculate: true,
        mode_selected:false,
        type_load: 1,
        type_container: 1,
        length: "",
        width: "",
        high: "",
        length_unit: "cm",
        id: 1,
        cbm: "",
        weight: false,
        weight_units: "kg",
        stackable: false,
        id: 0,
    },
    loads: []
};

const getters = {
     
};

const mutations = {
    ADD_LOAD(state, payload){
        state.loads.push({ ...payload });
    },
    REMOVED_LOAD(state, id){
        state.loads.splice(id, 1);
    }, 
    SET_LOAD(state, data){
        console.log(data, 'LOAD')
    }
};

const actions = {
    addLoad({ commit, rootState }, paylod){
        commit("ADD_LOAD", paylod);
    }, 
    removedLoad({commit }, id){
        commit("REMOVED_LOAD", id);
    },
    setLoad({commit }, data){
        commit("SET_LOAD", data);
    },
   
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
