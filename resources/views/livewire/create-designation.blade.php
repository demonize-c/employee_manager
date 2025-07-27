<div class="container">
      <div class="row justify-content-center">
           <div class="col-md-6 mt-4">
               <div class="card shadow-sm" x-data="{loading:false}" x-init="
                       $wire.on('notify', ({success, message}) => {
                              setTimeout(() =>  {
                                    loading = false;
                                    notify({
                                        type: ( success? 'success': 'error'), 
                                        message,
                                        cb: ( success? 
                                              () => Livewire.navigate('{{route('designations.index')}}') :
                                              null )
                                   });
                              }, 2000);
                         });
                    ">
                    <div class="card-header">
                           <h4 class="p-3">Create Designation</h4>
                    </div>
                    <div class="card-body">
                         
                         <form action="">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Designation</label>
                                    <input type="text" class="form-control" placeholder="Enter Designation" :disabled="loading" wire:model="name">
                                    @error('name') <small class="text-danger" x-show="!loading">{{ $message }}  </small> @enderror 
                                    
                                </div>
                         </form>
                    </div>
                    <div class="card-footer text-end">
                         <a  wire:navigate class="btn btn-secondary" href="{{route('designations.index')}}">Close</a>
                         <button role="button" class="btn btn-primary"
                          @click="
                              loading=true;
                              $wire.call('save');
                           " 
                           x-text="!loading? 'Save': 'Saving..'"
                           :disabled="loading"
                          ></button>
                    </div>
                </div>
           </div>
      </div>
</div>