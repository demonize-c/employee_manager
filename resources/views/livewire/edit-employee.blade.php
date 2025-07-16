<div class="container">
      <div class="row justify-content-center">
           <div class="col-md-6 mt-4">
               <div class="card shadow-sm {{$loading? 'opacity-50':''}}" >
                    <div class="card-header">
                           <h4 class="p-3">Edit Employee</h4>
                    </div>
                    <div class="card-body">
                         
                         <form action="" wire:ignore wire:key="is-ready-{{$ready}}" wire:init="ready_reset">
                                <div class="form-group mb-3">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" placeholder="Examples - Jhon Doe, Sundar Pichai" wire:model="name">
                                     @error('name') <small class="text-danger">{{ $message }}  </small> @enderror 
                                </div>
                                <div class="form-group mb-3">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" placeholder="Examples - jhondoe@gmail.com, etc" wire:model="email">
                                     @error('email') <small class="text-danger">{{ $message }}  </small> @enderror 
                                </div>
                                <div class="form-group mb-3">
                                    <label>Phone Number</label>
                                    <input type="email" class="form-control" placeholder="Examples - +91 8100012345" wire:model="phone">
                                     @error('phone') <small class="text-danger">{{ $message }}  </small> @enderror 
                                </div>
                                <div class="form-group mb-3">
                                    <label>Designation</label>
                                    <div class="select2 select2-container" @click.outside = "$wire.set('open_desig',false)">
                                        <div class="input-group mb-3">
                                             <input 
                                                  type="text" 
                                                  class="form-control select2-selection" 
                                                  value="{{$designation['name']??''}}"
                                                  x-on:focus = "$wire.set('open_desig',true)"
                                                  readonly
                                             >
                                             <div class="input-group-append">
                                                  <span class="input-group-text" x-on:click="$wire.call('clear_designation')">&times;</span>
                                             </div>
                                        </div>
                                        @if($open_desig)
                                        <div class="select2-dropdown">
                                             <input type="text" class="select2-search" placeholder="Search..." wire:model.live="desig_name">
                                   
                                             <ul class="select2-results">
                                                  @foreach($designation_options as $option)
                                                  <li 
                                                       class = "select2-option" 
                                                       wire:key ="user-{{ $option->id }}"
                                                       x-on:click = "$wire.call('select_designation', {{$option->id}}, '{{$option->name}}')"
                                                  >
                                                       {{ $option->name }}
                                                  </li>
                                                  @endforeach
                                             </ul>
                                        </div>
                                        @endif
                                        </div>

                                     @error('designation.id') <small class="text-danger">{{ $message }}  </small> @enderror 
                                </div>
                                <div class="form-group mb-3">
                                    <label>Date Of Joining</label>
                                    <input type="date" class="form-control" placeholder="" wire:model="doj">
                                     @error('doj') <small class="text-danger">{{ $message }}  </small> @enderror 
                                </div>
                                <div class="form-group mb-3">
                                    <label>Salary</label>
                                    <input type="number" class="form-control" placeholder="Examples - 10000,20000" wire:model="salary">
                                     @error('salary') <small class="text-danger">{{ $message }}  </small> @enderror 
                                </div>
                                <div class="form-group mb-3">
                                      <label class="mb-2">Photo</label>
                                      <div x-data="{ preview: '{{asset('media/employee_pictures/'.$employee->photo)}}' }" class="row g-3 align-items-start">
                                        <div class="col-md-4 text-center">
                                             <div class="image-preview-wrapper border rounded">
                                                  <template  x-if="preview">
                                                       <img  id="preview-image" :src="preview"  class="img-fluid preview-img" alt="Image Preview">
                                                  </template>
                                             </div>
                                        </div>
                                        <div class="col-md-8">
                                             <input 
                                                  class="form-control" 
                                                  type="file" 
                                                  id="image" 
                                                  accept="image/*"
                                                  @change="preview = URL.createObjectURL($event.target.files[0])"
                                                  wire:model="photo"
                                             >
                                             <div class="form-text">Max size 2MB. Accepted: JPG, PNG, WebP</div>
                                        </div>
                                   </div>
                                   @error('photo') <small class="text-danger">{{ $message }}  </small> @enderror 
                                </div>
                                
                         </form>
                    </div>
                    <div class="card-footer text-end">
                         <a class="btn btn-secondary" href="{{route('employees.index')}}">Close</a>
                         <button role="button" class="btn btn-primary" wire:click="update" @disabled($loading) >Update</button>
                    </div>
                </div>
           </div>
      </div>
</div>

@script
<script>
     $wire.on('on-update',function( event ){
          setTimeout( function(){ 
                    Swal.fire({
                         icon:  event.success? 'success': 'error',
                         title: event.message,
                         toast: true,
                         timer: 2000,
                         position: 'top-end',
                         showConfirmButton: false,
                         width:'400px'
                    });
                    $wire.set('loading',false);
                    $wire.set('ready',true);
          },1500);
     });
</script>
@endscript