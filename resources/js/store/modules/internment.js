import Form from 'vform'

export default {
    namespaced: true,
    state: {
        expenses: new Form({
            application_id: '',
            transport: '',
            custom_agent_id: "",
            agent_payment: 250,
            treatiesSelected: [],
            file_descrip: [],
            customs_house: true,
            certificate: "Invoice",
            file_certificate: "",
            dataLoad: [],
            files: new FormData(),
            iva: false,
            iva_amt: 0,
            adv: false,
            adv_amt: 0,
            cif_amt: 0,
            port_charges: 0,
            insurance: 0,
            code_serv: 'ICS04',
        }),

    },
    getters: {

    },
    mutations: {
        SET_DATA(state, { application_id, custom_agent_id, customs_house, iva, adv, agent_payment, port_charges }) {
            state.expenses.application_id = application_id
            state.expenses.customs_house = customs_house
            state.expenses.iva = iva
            state.expenses.adv = adv
            state.expenses.agent_payment = agent_payment
            state.expenses.port_charges = port_charges
            state.expenses.custom_agent_id = custom_agent_id
        },
    },
    actions: {
        setData({ commit }, { internment_process }) {

            commit("SET_DATA", internment_process);
        }
    }
}