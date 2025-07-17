

function random_str(length) {
  var result           = '';
  var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var charactersLength = characters.length;
  for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}

$(document).ready(function () {

  //   window.addEventListener('swal:success', event => {
  //     Swal.fire({
  //         icon: 'success',
  //         title: 'Success',
  //         text: event.detail.message,
  //         toast: true,
  //         timer: 2000,
  //         position: 'top-end',
  //         showConfirmButton: false
  //     });
  // });

  // window.addEventListener('swal:error', event => {
  //     Swal.fire({
  //         icon: 'error',
  //         title: 'Error',
  //         text: event.detail.message,
  //         toast: true,
  //         timer: 3000,
  //         position: 'top-end',
  //         showConfirmButton: false
  //     });
  // });
});