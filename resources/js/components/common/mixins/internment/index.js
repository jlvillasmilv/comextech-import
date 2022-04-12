const mixinInternment = {
  methods: {
    activeAd() {
      this.expenses.adv = !this.expenses.adv;
      console.log(this.expenses.adv);
      this.advalorem();
    },

    async advalorem() {
      // change iva value if Advalorem is checked
      if (this.expenses.adv) {
        let CIF = parseFloat(
          Number(this.expenses.cif_amt) + Number(this.expenses.cif_amt * 0.06)
        ).toFixed(2);

        let cif_clp = await axios.get(`/custom-convert-currency/${CIF}/USD`);

        if (cif_clp.data <= 0) {
          cif_clp = await axios.get(`/api/convert-currency/${CIF}/USD/CLP`);
        }

        this.expenses.iva_amt = cif_clp.data * (19 / 100);
      } else {
        this.taxCheck(true);
      }
    },

    async taxCheck(value) {
      if (value) {
        this.expenses.cif_amt = parseFloat(
          Number(this.amountsDollar.AppAmount) +
            Number(this.amountsDollar.transpAmount) +
            Number(this.amountsDollar.insureAmount)
        ).toFixed(2);

        this.expenses.insurance = Number(this.amountsDollar.insureAmount);
        this.expenses.transport_amt = Number(this.amountsDollar.transpAmount);

        let cif_clp = await axios.get(`/custom-convert-currency/${this.expenses.cif_amt}/USD`);

        if (cif_clp.data <= 0) {
          cif_clp = await axios.get(`/api/convert-currency/${this.expenses.cif_amt}/USD/CLP`);
        }

        this.expenses.iva_amt = cif_clp.data * (19 / 100);
        this.expenses.adv_amt = cif_clp.data * (6 / 100);
      }
      if (!value) {
        this.expenses.cif_amt = 0;
        this.expenses.iva_amt = 0;
        this.expenses.adv_amt = 0;
      }
    }
  }
};

export default mixinInternment;
