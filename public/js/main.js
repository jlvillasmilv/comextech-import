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

   if (document.body.dataset.notification == ""){

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
            cancelButtonText:'No',
            showLoaderOnConfirm: true,
                preConfirm: () => {
          
                      axios.post(url, {
                        application_id: application_id,
                        service_id: service_id.value,
                        amount: amount.value,
                        currency_id:currency_id.value,
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
                      
          Swal.fire({
            title: '¿Desea eliminar este registro?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText:'No',
            showLoaderOnConfirm: true,
                preConfirm: () => {

                      axios.delete(url).then(response => {

                        Toast.fire({
                          icon: 'success',
                          title: 'Operacion realizada con exito'
                        })
                        $(`#${id}`).remove();  
                      
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

  // facotirng

  $('#table').on('click', '.btn-status[data-remote]', function (e) { 
    e.preventDefault();
    var url = $(this).data('remote');
    
    Swal.fire({
    title: '¿Desea solicitar desembolso?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Si',
    cancelButtonText:'No',
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

                  window.setTimeout(function(){location.reload()},3000)
              
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
    'en la sección <a href="'+profile+'"><b> “Perfil Empresarial”</b></a> ',
    icon: 'info',
    showCancelButton: true,
    showDenyButton: true,
    confirmButtonText: 'Perfil &nbsp;',
    confirmButtonColor: '#3085d6',
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
    title: '¿Desea cargar ultimos 24 meses de '+msg+'?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Si',
    cancelButtonText:'No',
    cancelButtonColor: '#d33',
    showLoaderOnConfirm: true,
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
      html:`Para Importar informacion a sistema debe ser desde un archivo csv puedes <b>descargar</b> formato a llenar 
      <b> <u> <a href="${url}">en este enlace </u></a></b>`
      
    })

  });

})



function initialize() {

  $('form').on('keyup keypress', function(e) {
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

  postalField   = document.querySelector("#postal_code");
  provinceField = document.querySelector("#province");

  for (let i = 0; i < locationInputs.length; i++) {

      const input = locationInputs[i];
      const fieldKey = input.id.replace("-input", "");

      const autocomplete = new google.maps.places.Autocomplete(input,{
        fields: ["address_components", "geometry"],
        types: ["address"],
      });
      autocomplete.key = fieldKey;
      autocompletes.push({input: input, autocomplete: autocomplete});

  }

  for (let i = 0; i < autocompletes.length; i++) {

      const autocomplete = autocompletes[i].autocomplete;
      
      google.maps.event.addListener(autocomplete, 'place_changed', function () {
          const place = autocomplete.getPlace();
         
          let postcode = postalField.value;
          let province = ""
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
                  province = component.long_name;
                  break;
              }

              case "postal_code_suffix": {
                  postcode = `${postcode}-${component.long_name}`;
                  break;
              }
              
            }
          }

          postalField.value = postcode;
          provinceField.value = province;
          placeId = placId;
          
          document.querySelector("#address_latitude").value = place.geometry['location'].lat();
          document.querySelector("#address_longitude").value = place.geometry['location'].lng();

      });
  }

}
