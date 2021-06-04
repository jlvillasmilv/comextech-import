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

})
