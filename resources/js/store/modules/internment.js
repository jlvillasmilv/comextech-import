import Form from 'vform'

export default {
	namespaced: true,
    state: {
        expenses: new Form({
            application_id: '',
            transport: '',
            custom_agent_id: "",
            agent_payment: 0,
            treatiesSelected: [],
            file_descrip: [],
            customs_house: true,
            certificate: "Invoice",
            file_certificate: "",
            dataLoad: [],
            files: new FormData(),
            iva: false,
            adv: false,
        }),     
    },
    getters: {
     
    },
    actions:{
        
    }
  }