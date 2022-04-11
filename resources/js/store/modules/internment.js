import Form from 'vform';

export default {
  namespaced: true,
  state: {
    expenses: new Form({
      application_id: '',
      transport: false,
      custom_agent_id: '',
      trans_company_id: '',
      courier_svc: false,
      agent_payment: 150,
      treatiesSelected: [],
      file_descrip: [],
      customs_house: true,
      certificate: 'Invoice',
      file_certificate: '',
      dataLoad: [],
      files: [],
      iva: false,
      iva_amt: 0,
      adv: false,
      adv_amt: 0,
      cif_amt: 0,
      port_charges: 0,
      insurance: 0,
      transport_amt: 0,
      code_serv: 'ICS04',
      tax_comex: false
    }),
    files: [],
    filesUpload: {
      certFile: '',
      file1Name: '',
      file2Name: ''
    },
    isTaxDutys: false
  },
  getters: {},
  mutations: {
    SET_DATA(state, payload) {
      state.expenses.application_id = payload.application_id;
      state.expenses.customs_house = payload.customs_house;
      state.expenses.iva = payload.iva;
      state.expenses.adv = payload.adv;
      state.expenses.agent_payment = payload.agent_payment;
      state.expenses.port_charges = payload.port_charges;
      state.expenses.custom_agent_id = payload.custom_agent_id;
      state.expenses.insurance = payload.insurance;
      state.expenses.adv_amt = payload.adv_amt;
      state.expenses.iva_amt = payload.iva_amt;
      state.expenses.cif_amt = payload.cif_amt;
      state.expenses.transport_amt = payload.transport_amt;
      state.expenses.tax_comex = payload.tax_comex;
      state.files = payload.file_store_internment
        ? (state.files = payload.file_store_internment)
        : state.files;

      if (state.files) {
        const invoice = state.files.find((file) => file.intl_treaty === 'Invoice');
        const otherfile = state.files.find((file) => file.intl_treaty === 'Otro Documento');
        const otherfile2 = state.files.find((file) => file.intl_treaty === 'Otro Documento 2');

        state.filesUpload.certFile = invoice;
        state.filesUpload.file1Name = otherfile;
        state.filesUpload.file2Name = otherfile2;
      }
    },
    changeTax(state, value) {
      if (value) {
        state.expenses.tax_comex = true;
        state.expenses.iva = true;
        state.expenses.adv = true;
        state.isTaxDutys = true;
      }
      if (!value) {
        state.expenses.tax_comex = false;
        state.expenses.iva = false;
        state.expenses.adv = false;
        state.isTaxDutys = false;
      }
    }
  },
  actions: {
    setData({ commit }, { internment_process }) {
      if (internment_process) {
        commit('SET_DATA', internment_process);
      }
    }
  }
};
