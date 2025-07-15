<div class="container">
      <div class="row justify-content-center">
           <div class="col-md-6 mt-4">
               <div class="card shadow-sm">
                    <div class="card-header">
                           <h4 class="p-3">Update Designation</h4>
                    </div>
                    <div class="card-body">
                         
                         <form action="">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Designation</label>
                                    <input type="text" class="form-control" placeholder="Enter Designation" wire:model="name">
                                     @error('name') <small class="text-danger">{{ $message }}  </small> @enderror 
                                </div>
                         </form>
                    </div>
                    <div class="card-footer text-end">
                         <a class="btn btn-secondary" href="{{route('designations.index')}}">Close</a>
                         <button role="button" class="btn btn-primary" wire:click="update">
                              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading wire:target="update"></span>
                              <span wire:loading.remove wire:target="update">Update<span>
                         </button>
                    </div>
                </div>
           </div>
      </div>
</div>