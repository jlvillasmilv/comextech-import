function data() {
  function getThemeFromLocalStorage() {
    // if user already changed the theme, use it
    if (window.localStorage.getItem('dark')) {
      return JSON.parse(window.localStorage.getItem('dark'))
    }

    // else return their preferences
    return (
      !!window.matchMedia &&
      window.matchMedia('(prefers-color-scheme: dark)').matches
    )
  }

  function setThemeToLocalStorage(value) {
    window.localStorage.setItem('dark', value)
  }

  return {
    dark: getThemeFromLocalStorage(),
    toggleTheme() {
      this.dark = !this.dark
      setThemeToLocalStorage(this.dark)
    },
    isSideMenuOpen: false,
    toggleSideMenu() {
      this.isSideMenuOpen = !this.isSideMenuOpen
    },
    closeSideMenu() {
      this.isSideMenuOpen = false
    },
    isNotificationsMenuOpen: false,
    toggleNotificationsMenu() {
      this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
    },
    closeNotificationsMenu() {
      this.isNotificationsMenuOpen = false
    },
    isProfileMenuOpen: false,
    toggleProfileMenu() {
      this.isProfileMenuOpen = !this.isProfileMenuOpen
    },
    closeProfileMenu() {
      this.isProfileMenuOpen = false
    },
    isExecutiveMenuOpen: false,
    toggleExecutiveMenu() {
      this.isExecutiveMenuOpen = !this.isExecutiveMenuOpen
    },
    closeExecutiveMenu() {
      this.isExecutiveMenuOpen = false
    },
    isPagesMenuOpen: false,
    togglePagesMenu() {
      this.isPagesMenuOpen = !this.isPagesMenuOpen
    },
    isFinancingMenuOpen: false,
    toggleFinancingMenu() {
      this.isFinancingMenuOpen = !this.isFinancingMenuOpen
    },
    // Modal
    isModalOpen: false,
    trapCleanup: null,
    openModal() {
      this.isModalOpen = true

    },

    application: {},
    formPaymentApp: {
      application_id: 0,
      availablePrepaid: 0,
      availableCredit: 0,
      available_prepaid: 0,
      available_credit: 0,
    },
    status: false,
    loading: false,
    isError: false,
    async openModalPayment(id) {

      this.formPaymentApp.application_id = id

      let { data } = await axios.get('/get-appayment/' + id);

      console.log(data);

      this.application = data

      this.formPaymentApp.availablePrepaid = Number(this.application.user.company.available_prepaid)
      this.formPaymentApp.availableCredit = Number(this.application.user.company.available_credit)

      this.isModalOpen = true
    },

    async submitModalPayment() {

      axios.post('/application-generate-order', this.formPaymentApp)
        .then(response => {
          console.log(response);

          if (response.data.order) {
            window.open(response.data.order, '_blank');
          }

          if (response.status == 200) {
            Toast.fire({
              icon: 'success',
              title: 'Generado con exito',
            })
          }

          this.closeModal()
          window.setTimeout(function () { window.location.reload() }, 2000)

        }).catch(error => {
          console.log(error);
          Toast.fire({
            icon: 'error',
            title: "No es posible continuar verifique y vuelve a intentarlo más tarde"
          })
        })

    },
    closeModal() {
      this.initData()

      this.isModalOpen = false
      this.trapCleanup = null
    },
    initData() {

      this.formPaymentApp.availablePrepaid = 0
      this.formPaymentApp.availableCredit = 0
      this.formPaymentApp.application_id = 0
      this.formPaymentApp.available_prepaid = 0
      this.formPaymentApp.available_credit = 0

    }
  }
}
