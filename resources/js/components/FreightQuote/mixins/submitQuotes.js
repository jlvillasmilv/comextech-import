/* Mixin to submit quote in table freightQuotes */
import { mapMutations } from 'vuex';
const mixinFreight = {
  methods: {
    ...mapMutations('freightQuotes', [
      'SHOW_LOCAL_SHIPPING',
      'SHOW_ADDRESS',
      'SHOW_FREIGHT_FORM',
      'SHOW_HIDE_BUTTONS_QUOTE',
      'HIDE_COURIER_QUOTES'
    ]),
    ...mapMutations('load', ['SHOW_LOAD_CHARGE']),

    /**
     * Send api quote (button Cotizar fedex, dhl, ups)
     * @param {Number} appAmount selected service amount if fedex, dhl or ups
     * @param {Number} transCompanyId number of the service that is selected:
     * @param {2} FEDEX
     * @param {3} DHL
     * @param {4} UPS
     */
    async submitQuote(appAmount, transCompanyId) {
      /* Vue-loader config */
      let loader = this.$loading.show({
        canCancel: true,
        transition: 'fade',
        color: '#142c44',
        loader: 'spinner',
        lockScroll: true,
        enforceFocus: true,
        height: 100,
        width: 100
      });

      this.SHOW_ADDRESS(false);
      this.SHOW_LOAD_CHARGE(false);

      try {
        this.expenses.dataLoad = this.$store.state.load.loads;
        this.expenses.app_amount = appAmount;
        this.expenses.trans_company_id = transCompanyId;
        const tableQuote = await this.$store.dispatch(
          'freightQuotes/getTransportTableQuote',
          this.expenses
        );

        if (tableQuote.status == 200) {
          this.HIDE_COURIER_QUOTES();
          this.SHOW_HIDE_BUTTONS_QUOTE(false);
          this.SHOW_FREIGHT_FORM(true);

          Swal.fire({
            title: 'Si desea cotizar con nosotros, llene el siguente formulario',
            // text: '¿Quiere solicitar una tarifa para su operación al Equipo ComexTech?',
            icon: 'warning',
            // showCancelButton: true,
            confirmButtonColor: '#142c44',
            // cancelButtonColor: '#d33',
            // cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar'
          });
        }
      } catch (error) {
        this.hideAddress();
        console.error(error);
      } finally {
        loader.hide();
      }
    },
    /**
     * Show / Hide from address (button "Editar")
     */
    hideAddress() {
      this.HIDE_COURIER_QUOTES();
      this.SHOW_LOAD_CHARGE(true);
      this.SHOW_ADDRESS(true);
      this.SHOW_HIDE_BUTTONS_QUOTE(true);
    }
  }
};

export default mixinFreight;
