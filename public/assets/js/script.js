

function random_str(length) {
  var result           = '';
  var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var charactersLength = characters.length;
  for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}
function notify ({type, message, cb}) {
    Swal.fire({
        icon:  type ?? 'info',
        title: message,
        toast: true,
        timer: 3000,
        position: 'top-end',
        showConfirmButton: false,
        width:'400px',
        didClose: () => {
            if( cb ) {
                cb();
            } 
        }
    });
}

function confirmDeletion ( onConfirm, onExit){
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText:  'Cancel'
    }).then((result) => {
            if (result.isConfirmed) {
                 if( onConfirm ) {
                    return onConfirm();
                 }
            }
            if( onExit ) { 
              return onExit();
            }
            return;
    });
}

$(document).ready( function() {
    $(document).on('click','#sidebar_toggle_btn', function(e){
           e.stopPropagation();
           $('#sidebar').toggleClass('active');
    })
    $(document).on('click','div.content', function(e){
           e.stopPropagation();
           $('#sidebar.active').removeClass('active');
     })
})