function data() {
  function getThemeFromLocalStorage() {
    // if user already changed the theme, use it
    if (window.localStorage.getItem('dark')) {
      return JSON.parse(window.localStorage.getItem('dark'));
    }

    // else return their preferences
    return !!window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
  }

  function setThemeToLocalStorage(value) {
    window.localStorage.setItem('dark', value);
  }

  return {
    dark: getThemeFromLocalStorage(),
    toggleTheme() {
      this.dark = !this.dark;
      setThemeToLocalStorage(this.dark);
    },
    isSideMenuOpen: false,
    toggleSideMenu() {
      this.isSideMenuOpen = !this.isSideMenuOpen;
    },
    closeSideMenu() {
      this.isSideMenuOpen = false;
    },
    isNotificationsMenuOpen: false,
    toggleNotificationsMenu() {
      this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen;
    },
    closeNotificationsMenu() {
      this.isNotificationsMenuOpen = false;
    },
    isProfileMenuOpen: false,
    toggleProfileMenu() {
      this.isProfileMenuOpen = !this.isProfileMenuOpen;
    },
    closeProfileMenu() {
      this.isProfileMenuOpen = false;
    },
    isExecutiveMenuOpen: false,
    toggleExecutiveMenu() {
      this.isExecutiveMenuOpen = !this.isExecutiveMenuOpen;
    },
    closeExecutiveMenu() {
      this.isExecutiveMenuOpen = false;
    },
    isPagesMenuOpen: false,
    togglePagesMenu() {
      this.isPagesMenuOpen = !this.isPagesMenuOpen;
    },
    isFinancingMenuOpen: false,
    toggleFinancingMenu() {
      this.isFinancingMenuOpen = !this.isFinancingMenuOpen;
    },
    // Modal
    isModalOpen: false,
    trapCleanup: null,
    openModal() {
      this.isModalOpen = true;
    },

    application: {},
    formPaymentApp: {
      application_id: 0,
      availablePrepaid: 0,
      availableCredit: 0,
      available_prepaid: 0,
      available_credit: 0,
      authorization_code: ''
    },
    status: false,
    isLoadingPay: false,
    isLoadingValidation: false,
    isError: false,
    icon: '',
    isDisabled: false,
    formatterPrepaid: 0,
    formatterCredit: 0,
    // showValidations: false,
    async openModalPayment(id) {
      this.formPaymentApp.application_id = id;
      let { data } = await axios.get('/get-appayment/' + id);
      this.application = data;

      switch (this.application.type_transport) {
        case 'AEREO':
          this.icon = 'bxs:plane-take-off';
          break;

        case 'CONSOLIDADO':
          this.icon = 'bx:bar-chart-square';
          break;

        case 'CONTAINER':
            this.icon = 'clarity:container-line';
            break;

        default:
          this.icon = 'akar-icons:shipping-box-01';
          break;
      }

      this.formPaymentApp.availablePrepaid = Number(
        this.application.user.company.available_prepaid
      );

      // this.formPaymentApp.available_prepaid = Number(
      //   this.application.user.company.available_prepaid
      // );

      this.formPaymentApp.availableCredit = Number(this.application.user.company.available_credit);

      // this.formPaymentApp.available_credit = Number(this.application.user.company.available_credit);

      this.isModalOpen = true;
      // }
    },

    prepaidValidate(value) {
      let valueCurrency = document.getElementById('input-available');

      value = valueCurrency.value;

      let formatterCurrency = Number(value.replaceAll('.', ''));

      if (Math.sign(formatterCurrency) === -1) {
        return true;
      } else if (Math.sign(formatterCurrency) === 0) {
        return false;
      } else if (
        formatterCurrency > 0 &&
        formatterCurrency < this.formPaymentApp.availablePrepaid
      ) {
        return true;
      } else if (formatterCurrency > this.formPaymentApp.availablePrepaid) {
        return true;
      } else if (isNaN(formatterCurrency)) {
        return true;
      }
    },

    creditValidate(value) {
      let valueCurrency = document.getElementById('input-credit');

      value = valueCurrency.value;

      let formatterCurrency = Number(value.replaceAll('.', ''));

      if (Math.sign(formatterCurrency) === -1) {
        return true;
      } else if (formatterCurrency > this.formPaymentApp.availableCredit) {
        return true;
      }
    },

    formatterPrepaid() {
      let valueCurrency = document.getElementById('input-available');

      if (valueCurrency.value === '' || typeof Number(valueCurrency.value) !== 'number') {
        valueCurrency.value = 0;
      }

      let removePoints = Number(valueCurrency.value.replaceAll('.', ''));

      this.formPaymentApp.available_prepaid = isNaN(valueCurrency.value) ? 0 : removePoints;
      valueCurrency.value = isNaN(valueCurrency.value)
        ? 0
        : new Intl.NumberFormat('es-es').format(valueCurrency.value);
    },

    formatterCredit() {
      let valueCurrency = document.getElementById('input-credit');

      if (valueCurrency.value === '' || typeof Number(valueCurrency.value) !== 'number') {
        valueCurrency.value = 0;
      }

      let removePoints = Number(valueCurrency.value.replaceAll('.', ''));

      this.formPaymentApp.available_credit = isNaN(valueCurrency.value) ? 0 : removePoints;

      valueCurrency.value = isNaN(valueCurrency.value)
        ? 0
        : new Intl.NumberFormat('es-es').format(valueCurrency.value);
    },

    async submitModalPayment() {
      this.isLoadingPay = true;
      axios
        .post('/application-generate-order', this.formPaymentApp)
        .then((response) => {
          console.log(response);

          if (response.data.order) {
            window.open(response.data.order + '?n=' + new Date().getTime(), '_blank');
          }

          if (response.status == 200) {
            Toast.fire({
              icon: 'success',
              title: 'Generado con exito'
            });
          }

          this.closeModal();
          window.setTimeout(function() {
            window.location.reload();
          }, 2000);
        })
        .catch((error) => {
          this.isLoadingPay = false;
          //console.log(error.response.data.errors);
          Toast.fire({
            icon: 'error',
            title: error.response.data.error
              ? error.response.data.error
              : 'No es posible continuar, revise los datos'
          });
        });
    },
    closeModal() {
      this.initData();

      this.isModalOpen = false;
      this.trapCleanup = null;
    },
    async sendAuthorizationCode(id) {
      this.isDisabled = true;
      this.isLoadingValidation = true;
      let response = await axios.get('/generate-code/' + id);

      if (response.status == 200) {
        setTimeout(() => {
          Toast.fire({
            icon: 'success',
            title: 'Codigo Generado con exito verifque'
          });
          this.isDisabled = false;
          this.isLoadingValidation = false;
        }, 1000);
      }
    },
    initData() {
      this.formPaymentApp.availablePrepaid = 0;
      this.formPaymentApp.availableCredit = 0;
      this.formPaymentApp.application_id = 0;
      this.formPaymentApp.available_prepaid = 0;
      this.formPaymentApp.available_credit = 0;
      this.formPaymentApp.authorization_code = '';
      this.isLoadingPay = false;
      this.isLoadingValidation = false;
      this.isDisabled = false;
    }
  };
}
// let selector = document.getElementById('input-available');
// $(document).ready(function() {
//   $(selector).inputmask('99-9999999');
// });
// $("input[name='masknumber']").on('keyup change', function() {
//   $("input[name='number']").val(destroyMask(this.value));
//   // this.formPaymentApp.available_prepaid = this.value;
//   console.log(this.formPaymentApp.available_prepaid);
//   this.value = createMask($("input[name='number']").val());
// });

// function createMask(string) {
//   return string.replace(/(\d{1})(\d{3})(\d{3})/, '$1.$2.$3');
// }

// function destroyMask(string) {
//   return string.replace(/\D/g, '').substring(0, 7);
// }
