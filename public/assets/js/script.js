

function random_str(length) {
  var result           = '';
  var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var charactersLength = characters.length;
  for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
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