export default {
	namespaced: true,
    state: {
        exchangeItem: []
    },
  
    getters: {
     
    },
  
    mutations: {
        SET_SUMMARY( state , payload){
            state.exchangeItem = payload
        },
    },
  
    actions: {
        async getSummary({ commit }, payload){
            let { data } = await axios.get("/application-summary/"+payload);
            commit('SET_SUMMARY', data)
        },

    },
  }