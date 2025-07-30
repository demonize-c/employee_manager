

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

function convertTo12Hour(time24) {
    if (!time24) return '';
  
    const [hourStr, minuteStr] = time24.split(':');
    let hour = parseInt(hourStr, 10);
    const minute = minuteStr.padStart(2, '0');
  
    const ampm = hour >= 12 ? 'PM' : 'AM';
    hour = hour % 12 || 12; // convert 0 to 12
  
    return `${hour}:${minute} ${ampm}`;
}
 
function initializeTimePicker() {

     // Initialize all timepickers
     $('.timepicker').timepicker({
        timeFormat: 'H:i:s',
        interval: 30,
        dropdown: true,
        scrollbar: true
    });

    $('.timepicker').on('changeTime', function () {
        $(this).trigger('change');
    });

    $('.open-picker').on('click', function () {
        $(this)
            .closest('td')            // go to parent <td>
            .find('.timepicker')      // find the input inside that td
            .timepicker('show');
    });
}
$(document).ready(function() {
    initializeTimePicker();
})
function ComponentUpdationListener() {

    this.store = { };

    this.add = function ( $wire, cb ) {
        this.store[ $wire.$id ] = cb;
    }

    this.init = function( ) {
        Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => { 
            succeed(({ snapshot, effects }) => {
                queueMicrotask(() => {
                    if(component.id in this.store){
                          setTimeout(this.store[ component.id ],1000);
                    }
                })
            })
        });
    }
}
const __cul = new ComponentUpdationListener();

document.addEventListener('livewire:init', function( event ) {
    
    __cul.init();

})


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