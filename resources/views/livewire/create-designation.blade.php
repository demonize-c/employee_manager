<div class="container">
      <div class="row justify-content-center">
           <div class="col-md-6 mt-4">
               <div class="card shadow-sm">
                    <div class="card-header">
                           <h4 class="p-3">Create Designation</h4>
                    </div>
                    <div class="card-body">
                         
                         <form action="">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Designation</label>
                                    <input type="text" class="form-control" placeholder="Enter Designation" wire:model="name">
                                    @if( $display_error ) 
                                       @error('name') <small class="text-danger">{{ $message }}  </small> @enderror 
                                    @endif
                                </div>
                         </form>
                    </div>
                    <div class="card-footer text-end">
                         <a  wire:navigate class="btn btn-secondary" href="{{route('designations.index')}}">Close</a>
                            <button role="button" class="btn btn-primary" wire:click="$dispatch('start-save')" @disabled($loading)>{{$loading?'Saving..':'Save'}}</button>
                    </div>
                </div>
           </div>
      </div>
</div>

@script
<script>
     $wire.on('start-save',function( event ){
          $wire.set('display_error', false);
          $wire.set('loading',true);
          $wire.call('save');
     });

     $wire.on('on-save',function( event ){
          setTimeout( function(){ 
                    Swal.fire({
                         icon:  event.success? 'success': 'error',
                         title: event.message,
                         toast: true,
                         timer: 3000,
                         position: 'top-end',
                         showConfirmButton: false,
                         width:'400px',
                         didClose: () => {
                              if( event.success ) {
                                   Livewire.navigate("{{route('designations.index')}}");
                              }
                         }
                    });
                    $wire.set('loading',false);
                    $wire.set('display_error', !event.success );
          },3000);
     });
</script>
@endscript