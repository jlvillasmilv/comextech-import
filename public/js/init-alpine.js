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

      this.formPaymentApp.availablePrepaid = Number(this.application.company.available_prepaid);

      this.formPaymentApp.availableCredit = Number(this.application.company.available_credit);

      this.isModalOpen = true;
   
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
    formatterCredit(item) {

      let valueCurrency = document.getElementById(item);

      if (valueCurrency.value === '' || typeof Number(valueCurrency.value) !== 'number') {
        valueCurrency.value = 0;
      }

      let removePoints = Number(valueCurrency.value.replaceAll('.', ''));

      if (item === 'input-credit') {
        this.formPaymentApp.available_credit = isNaN(valueCurrency.value) ? 0 : removePoints;
      }

      if (item === 'input-available') {
        this.formPaymentApp.available_prepaid = isNaN(valueCurrency.value) ? 0 : removePoints;
      }

      valueCurrency.value = isNaN(valueCurrency.value)
        ? 0
        : new Intl.NumberFormat('es-CL').format(valueCurrency.value);
    },

    async submitModalPayment() {
      this.isLoadingPay = true;
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
          window.setTimeout(function () {
            window.location.reload();
          }, 3000);
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
      window.setTimeout(function () { window.location.reload() }, 1000);
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
    },
    applicationStatus(el) {

      const url = el.getAttribute('data-remote');
      const msg = el.getAttribute('data-msg');
      const application_id = el.getAttribute('data-id'); 
      
      el.setAttribute('disabled', true);
     
      Swal.fire({
        title: msg,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        confirmButtonColor: '#142c44',
        cancelButtonText: 'No',
        cancelButtonColor: '#d33',
        showLoaderOnConfirm: true,
        preConfirm: async () => {
          await axios.post(url, {
            application_id: application_id,
          }).then(response => {

              if (response.data.notifications) {

                Swal.fire({
                  title: '<strong>No fue posible Generar</strong>',
                  icon: 'warning',
                  html: `<div style="text-align: left; margin-left: 10px"> ${response.data.notifications}</ div>`,
                  showDenyButton: false,
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                  confirmButtonColor: '#142c44',
                  focusConfirm: true,
                  backdrop: false,
                  allowOutsideClick: false
                }).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {
                    window.location.reload();
                  } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                  }
                })

                $(this).attr('disabled', false);

              }
              else {
               
                if(response.data.application.status.name =='Activada')
                {
                  Toast.fire({
                    icon: 'success',
                    title: 'Activado con exito!, proceder a realizar el pago de la solicitud: '+response.data.application.code,
                  })

                  this.openModalPayment(response.data.application.id);
                }
                else {
                  Toast.fire({
                    icon: 'success',
                    title: 'Generado con exito',
                  })
  
                  window.setTimeout(function () { window.location.reload() }, 2000);

                }
               
              }
              
          }).catch(error => {
            console.log(error);
            Toast.fire({
              icon: 'error',
              title: "No es posible continuar verifique y vuelve a intentarlo más tarde"
            })

          })
            .then(function () {
              // always executed
            });

        },
        allowOutsideClick: () => !Swal.isLoading()
      })

    }
  };
}
