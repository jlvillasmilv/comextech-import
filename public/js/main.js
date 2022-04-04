$(document).ready(function () {
  window._token = $('meta[name="csrf-token"]').attr('content')
 
  $('.select2').select2();

  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    //animation : false,
    timer: 4000,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });

  /*Notificaciones si hay mensaje de confirmacion*/

  if (document.body.dataset.notification == "") {

    var type = document.body.dataset.notificationType;
    var types = ['info', 'warning', 'success', 'error'];

    // Check if `type` is in our `types` array, otherwise default to info.
    Toast.fire({ icon: types.indexOf(type) !== -1 ? type : 'info', title: JSON.parse(document.body.dataset.notificationMessage) });

  }

  // Agrega nuevo registro al detalle de la solicitud 
  $('#add_services').on('click', '.btn-add[data-remote]', function (e) {
    e.preventDefault();

    var button = document.getElementById('add');
    var service_id = document.getElementById('services_id');
    var currency_id = document.getElementById('_currency_id');
    var amount = document.getElementById('_amount');
    var currency2_id = document.getElementById('_currency2_id');
    var amount2 = document.getElementById('_amount2');


    const url = button.dataset.remote;
    const application_id = button.dataset.id;
    $(".invalid-feedback").children("strong").text("");
    $("#add_services input").removeClass("is-invalid");

    Swal.fire({
      title: '¿Agregar registro?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Si',
      confirmButtonColor: '#142c44',
      cancelButtonText: 'No',
      showLoaderOnConfirm: true,
      preConfirm: () => {

        axios.post(url, {
          application_id: application_id,
          service_id: service_id.value,
          amount: amount.value,
          currency_id: currency_id.value,
          amount2: amount2.value,
          currency2_id: currency2_id.value

        }).then(response => {

          Toast.fire({
            icon: 'success',
            title: 'Registro agregado con exito'
          })
          window.location.reload();

        }).catch(error => {


          let errors = error.response.data.errors;

          Toast.fire({
            icon: 'error',
            title: 'Error ingresando datos'
          })

          Object.keys(errors).forEach(function (key) {

            $("#" + key + "Input").addClass("is-invalid");
            $("#" + key + "Error").children("strong").text(errors[key][0]);
          });


          console.error(errors)
        });

      }
    });

  });

  $('#table').on('click', '.btn-delete[data-remote]', function (e) {

    const url = $(this).data('remote');
    var id = $(this).data('id');
    $(this).attr('disabled', true);
  
    Swal.fire({
      title: '¿Desea eliminar este registro?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Si',
      confirmButtonColor: '#142c44',
      cancelButtonText: 'No',
      showLoaderOnConfirm: true,
      preConfirm: () => {

        axios.delete(url).then(response => {

          Toast.fire({
            icon: 'success',
            title: 'Operacion realizada con exito'
          })
        
          $(`#${id}`).fadeOut("normal", function() {
              $(this).remove();
          });

        }).catch(error => {
          Toast.fire({
            icon: 'error',
            title: 'Errore de Conexion'
          })

        });

      }
    });
  });

  // facotirng

  $('#table').on('click', '.btn-status[data-remote]', function (e) {
    e.preventDefault();
    var url = $(this).data('remote');

    Swal.fire({
      title: '¿Desea solicitar desembolso?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Si',
      confirmButtonColor: '#142c44',
      cancelButtonText: 'No',
      cancelButtonColor: '#d33',
      showLoaderOnConfirm: true,
      preConfirm: () => {

        axios.put(url).then(response => {
          // document.getElementById(this).style.visibility = 'hidden';
          Swal.fire({
            icon: 'success',
            title: 'Se ha solicitado el desembolso! ',

            timer: 5000,
            timerProgressBar: true,
          }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
              location.reload()
            }
          })

          window.setTimeout(function () { window.location.reload() }, 2000);

        }).catch(error => {
          Toast.fire({
            icon: 'error',
            title: 'Errore de Conexion'
          })

          console.error(error.response.data)
        });

      }
    });

  });

  $('#table').on('click', '.btn-info[data-remote]', function (e) {

    const url = $(this).data('remote');
    const profile = $(this).data('profile');

    Swal.fire({
      html:
        'Para la solicitud de crédito de sus operaciones, ' +
        'es necesario que complete la información requerida ' +
        'en la sección <a href="' + profile + '"><b> “Perfil Empresarial”</b></a> ',
      icon: 'info',
      showCancelButton: true,
      showDenyButton: true,
      confirmButtonText: 'Perfil &nbsp;',
      confirmButtonColor: '#142c44',
      denyButtonText: `Solicitar`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        window.location.href = profile;
      } else if (result.isDenied) {
        window.location.href = url;
      }
    });
  });


  $('#table').on('click', '.btn-sync[data-remote]', function (e) {
    e.preventDefault();
    var url = $(this).data('remote');
    let msg = $(this).data('type');

    Swal.fire({
      title: '¿Desea cargar ultimos 24 meses de ' + msg + '?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Si',
      confirmButtonColor: '#142c44',
      cancelButtonText: 'No',
      cancelButtonColor: '#d33',
      showLoaderOnConfirm: true,
      backdrop: true,
      preConfirm: () => {
        return fetch(url)
          .then(response => {
           
            if (!response.ok) {

              throw new Error(response.statusText)
            }
            return response.json()
          })
          .catch(error => {

            Swal.showValidationMessage(
              `Falla al cargar: ${error}`
            )
            //window.setTimeout(function(){location.reload()},3000)
          })
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          icon: 'success',
          title: 'Carga generada con exito',

        })
      }
    })

  });

  $('#import_file_info').on('click', function (e) {
    e.preventDefault();
    var url = $(this).data('remote');

    Swal.fire({
      icon: 'info',
      title: 'Importar datos ',
      html: `Para Importar informacion a sistema debe ser desde un archivo csv puedes <b>descargar</b> formato a llenar 
      <b> <u> <a href="${url}">en este enlace </u></a></b>`

    })

  });

})


function initialize() {

  $('form').on('keyup keypress', function (e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
      e.preventDefault();
      return false;
    }
  });

  const locationInputs = document.getElementsByClassName("map-input");

  const autocompletes = [];
  let postalField;
  let placeId;

  postalField = document.querySelector("#postal_code");
  provinceField = document.querySelector("#province");
  countryCode = document.querySelector("#country_code");
  locality = document.querySelector("#locality");

  for (let i = 0; i < locationInputs.length; i++) {

    const input = locationInputs[i];
    const fieldKey = input.id.replace("-input", "");

    const autocomplete = new google.maps.places.Autocomplete(input, {
      fields: ["address_components", "geometry"],
      types: ["address"],
    });
    autocomplete.key = fieldKey;
    autocompletes.push({ input: input, autocomplete: autocomplete });


  }

  for (let i = 0; i < autocompletes.length; i++) {

    const autocomplete = autocompletes[i].autocomplete;

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
      const place = autocomplete.getPlace();

      let postcode = postalField.value;
      let province = '';
      let country = '';
      let glocality = '';
      let placId = place.place_id;
      // Get each component of the address from the place details,
      // and then fill-in the corresponding field on the form.
      // place.address_components are google.maps.GeocoderAddressComponent objects
      for (const component of place.address_components) {
        const componentType = component.types[0];

        switch (componentType) {

          case "postal_code": {
            postcode = `${component.long_name}`;
            break;
          }

          case "administrative_area_level_2": {
            province = `${component.long_name}`;
            break;
          }

          case "country": {
            country = `${component.short_name}`;
            break;
          }

          case 'locality': {
            glocality = component.long_name;
            break;
          }

        }
      }

      document.querySelector("#latitude").value = place.geometry['location'].lat();
      document.querySelector("#longitude").value = place.geometry['location'].lng();

      postalField.value = postcode;
      provinceField.value = province;
      countryCode.value = country;
      placeId = placId;
      locality.value = glocality;

    });
  }

}


function initial_map() {

  $('form').on('keyup keypress', function (e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
      e.preventDefault();
      return false;
    }
  });

  // const locationInputs = document.getElementsByClassName("map-input");

  const latitude = parseFloat(document.getElementById("latitude").value) || 23.144700;
  const longitude = parseFloat(document.getElementById("longitude").value) || 7.223304;

  map = new google.maps.Map(document.getElementById("address-map"), {
    center: { lat: latitude, lng: longitude },
    zoom: 2,
    minZoom: 2,
    maxZoom: 4,
    disableDefaultUI: true,
  });


  axios.get('/user-applications/dashboard-map').then(response => {

    if (response.data.length > 0) {

      response.data.forEach(async (e, index) => {

        if (e.origin_latitude != 0 && e.origin_longitude != 0) {

          let originLat = Number(e.origin_latitude);
          let originlng = Number(e.origin_longitude);

          let destLat = Number(e.dest_latitude);
          let destlng = Number(e.dest_longitude);

          new google.maps.Marker({
            map: map,
            position: { lat: originLat, lng: originlng },
            title: `Solicitud  ${e.code} Origen ${e.origin_address}`,
          });

          new google.maps.Marker({
            map: map,
            position: { lat: destLat, lng: destlng },
            title: `Solicitud  ${e.code} Destino ${e.dest_address}`,
          });

          const flightPlanCoordinates = [
            { lat: originLat, lng: originlng },
            { lat: destLat, lng: destlng },
          ];


          // Define a symbol using SVG path notation, with an opacity of 1.
          var lineSymbol = {
            path: 'M 0,-1 0,1',
            strokeOpacity: 1,
            scale: 4
          };

          const flightPath = new google.maps.Polyline({
            path: flightPlanCoordinates,
            strokeColor: "#FF0000",
            strokeOpacity: 0,
            icons: [{
              icon: lineSymbol,
              offset: '0',
              repeat: '20px'
            }],
          });

          flightPath.setMap(map);

        }


      });

    }

  }).catch(error => {

    console.error(error);
  });

}

$('#table').on('click', '.btn-sync-app[data-remote]', function (e) {
  e.preventDefault();

  const url = $(this).data('remote');
  const msg = $(this).data('msg');
  const application_id = $(this).data('id');

  $(this).attr('disabled', true);

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

        if (response.status == 200) {

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

});

$('#table').on('click', '.btn-notif-app[data-remote]', function (e) {
  e.preventDefault();

  const url = $(this).data('remote');
  const application_id = $(this).data('id');

  axios.post(url, {
    application_id: application_id,
  }).then(response => {

    Swal.fire({
      title: '<strong>Observaciones</strong>',
      icon: 'warning',
      width: 600,
      html: `<div style="text-align: left; margin-left: 10px"> ${response.data}</ div>`,
      showCloseButton: true,
      confirmButtonColor: '#142c44',
      focusConfirm: false,
    })

  }).catch(error => {
    console.log(error);
    Toast.fire({
      icon: 'error',
      title: "No es posible continuar verifique y vuelve a intentarlo más tarde"
    })

  })



});