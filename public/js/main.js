$(document).ready(function () {
  window._token = $('meta[name="csrf-token"]').attr('content')

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

  postalField = document.querySelector("#postal_code");

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
         
          let postcode = "";
          let placId = place.place_id;
          // Get each component of the address from the place details,
          // and then fill-in the corresponding field on the form.
          // place.address_components are google.maps.GeocoderAddressComponent objects
          for (const component of place.address_components) {
              const componentType = component.types[0];
              
              switch (componentType) {
              
              case "postal_code": {
                  postcode = `${component.long_name}${postcode}`;
                  break;
              }

              case "postal_code_suffix": {
                  postcode = `${postcode}-${component.long_name}`;
                  break;
              }
              
              }
          }

          postalField.value = postcode;
          placeId = placId;
          
          document.querySelector("#address_latitude").value = place.geometry['location'].lat();
          document.querySelector("#address_longitude").value = place.geometry['location'].lng();

      });
  }


}
