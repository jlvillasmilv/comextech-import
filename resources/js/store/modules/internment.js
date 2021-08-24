export default {
	namespaced: true,
    state: {
    	       
                custom_agent_id: 0,
                agent_payment: 0,
                treatiesSelected: [],
                file_descrip: [],
                customs_house: false,
                certificate: "Invoice",
                file_certificate: "",
                dataLoad: [],
                files: '',
                iva: false,
                adv: false,        
    },
  
    getters: {
     
    },
  
    mutations: {
        setData(state, payload) {
          
            state.custom_agent_id  = payload.custom_agent_id;
            state.agent_payment    = payload.agent_payment;
            state.treatiesSelected = payload.treatiesSelected;
            state.file_descrip     = payload.file_descrip;
            state.customs_house    = payload.customs_house;
            state.certificate      = payload.certificate;
            state.file_certificate = payload.file_certificate;
            state.dataLoad         = payload.dataLoad;
            state.files            = payload.files;
            state.iva              = payload.iva;
            state.adv              = payload.adv;
        },
       
    },
  
    actions: {
       
    },
  }