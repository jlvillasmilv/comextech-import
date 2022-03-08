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
    loading: false,
    isError: false,
    icon: '',
    async openModalPayment(id) {
      this.formPaymentApp.application_id = id;
      //x-show="application.type_transport=='COURIER'"
      let { data } = await axios.get('/get-appayment/' + id);

      switch (this.application.type_transport) {
        case 'AEREO':
          this.icon = 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8';
          break;

        case 'CONSOLIDADO':
          this.icon =
            'M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z';
          break;

        default:
          this.icon =
            'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10';
          break;
      }

      console.log(data);

      this.application = data;

      this.formPaymentApp.availablePrepaid = Number(
        this.application.user.company.available_prepaid
      );
      this.formPaymentApp.availableCredit = Number(this.application.user.company.available_credit);

      this.isModalOpen = true;
    },

    async submitModalPayment() {
      this.loading = true
      axios
        .post('/application-generate-order', this.formPaymentApp)
        .then((response) => {
          console.log(response);

          if (response.data.order) {
            window.open(response.data.order, '_blank');
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
          this.loading = false
          //console.log(error.response.data.errors);
          Toast.fire({
            icon: 'error',
            title: error.response.data.error ? error.response.data.error : 'No es posible continuar, revise los datos'
          });
        });
    },
    closeModal() {
      this.initData();

      this.isModalOpen = false;
      this.trapCleanup = null;
    },
    async sendAuthorizationCode(id) {

      let response = await axios.get('/generate-code/' + id);

      if (response.status == 200) {
        Toast.fire({
          icon: 'success',
          title: 'Codigo Generado con exito verifque'
        });
      }
      
    },
    initData() {
      this.formPaymentApp.availablePrepaid = 0;
      this.formPaymentApp.availableCredit = 0;
      this.formPaymentApp.application_id = 0;
      this.formPaymentApp.available_prepaid = 0;
      this.formPaymentApp.available_credit = 0;
      this.formPaymentApp.authorization_code = '';
      this.loading = false; 
    }
  };
}