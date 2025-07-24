@php $delay = 1000; @endphp
<div class="container">
      <div class="row justify-content-center">
           <div class="col-lg-6">
               <div class="card shadow-sm" x-data="{delay:5}">
                    <div class="card-header">
                           <h4 class="p-3">Create Employee</h4>
                    </div>
                    <div class="card-body">
                         
                         <form action="">
                                <div class="form-group mb-3">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" placeholder="Examples - Jhon Doe, Sundar Pichai" wire:model="name">
                                     
                                         
                                           <small 
                                               class="text-danger"
                                               wr:loading
                                               wr:loading.hide="inline-block {{$delay}}"
                                               wr:target="save"
                                               style="display:none"
                                            >
                                            @error('name') 
                                                {{ $message }} 
                                            @enderror   
                                           </small>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" placeholder="Examples - jhondoe@gmail.com, etc" wire:model="email">
                                    <small 
                                        class="text-danger"
                                        wr:loading
                                        wr:loading.hide="inline-block {{$delay}}"
                                        wr:target="save"
                                        style="display:none"
                                   >
                                   @error('email') 
                                        {{ $message }} 
                                   @enderror   
                                   </small>
                                    
                                </div>
                                <div class="form-group mb-3">
                                    <label>Phone Number</label>
                                    <input type="email" class="form-control" placeholder="Examples - +91 8100012345" wire:model="phone">
                                    <small 
                                        class="text-danger"
                                        wr:loading
                                        wr:loading.hide="inline-block {{$delay}}"
                                        wr:target="save"
                                        style="display:none"
                                   >
                                   @error('phone') 
                                        {{ $message }} 
                                   @enderror   
                                   </small>
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
                                        <small 
                                             class="text-danger"
                                             wr:loading
                                             wr:loading.hide="inline-block {{$delay}}"
                                             wr:target="save"
                                             style="display:none"
                                        >
                                        @error('designation.id') 
                                             {{ $message }} 
                                        @enderror   
                                        </small>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Date Of Joining</label>
                                    <input type="date" class="form-control" placeholder="" wire:model="doj">
                                    <small 
                                        class="text-danger"
                                        wr:loading
                                        wr:loading.hide="inline-block {{$delay}}"
                                        wr:target="save"
                                        style="display:none"
                                   >
                                   @error('doj') 
                                        {{ $message }} 
                                   @enderror   
                                   </small>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Salary</label>
                                    <input type="number" class="form-control" placeholder="Examples - 10000,20000" wire:model="salary">
                                    <small 
                                        class="text-danger"
                                        wr:loading
                                        wr:loading.hide="inline-block {{$delay}}"
                                        wr:target="save"
                                        style="display:none"
                                   >
                                   @error('salary') 
                                        {{ $message }} 
                                   @enderror   
                                   </small>
                                </div>
                                <div class="form-group mb-3">
                                      <label class="mb-2">Photo</label>
                                      <div x-data="{ preview: '' }" class="row g-3 align-items-start">
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
                                   <small 
                                        class="text-danger"
                                        wr:loading
                                        wr:loading.hide="inline-block {{$delay}}"
                                        wr:target="save"
                                        style="display:none"
                                   >
                                   @error('photo') 
                                        {{ $message }} 
                                   @enderror   
                                   </small>
                                </div>
                                
                         </form>
                    </div>
                    <div class="card-footer text-end" wire:ignore>
                         <a wire:navigate class="btn btn-secondary" href="{{route('employees.index')}}">Close</a>
                         <button  class="btn btn-success" wire:click="save"
                            wr:loading
                            wr:loading.attr="disabled {{$delay}}"
                            wr:target="save"
                         >
                         <span 
                            class="spinner-border spinner-border-sm"
                            role="status" aria-hidden="true"
                            wr:loading
                            wr:loading.display="inline-block {{$delay}}"
                            wr:target="save"
                            style="display:none"
                         >
                         </span>
                         <span
                            wr:loading
                            wr:loading.hide="inline {{$delay}}"
                            wr:target="save"
                         >
                              Save
                         </span> 
                               
                         </button>
                    </div>
                </div>
           </div>
      </div>
</div>

@script
<script>
     // $wire.on('start-save',function( event ){
     //      $wire.set('display_error', false);
     //      $wire.set('loading',true);
     //      $wire.call('save');
     // });

     $wire.on('on-save',function( event ){
          setTimeout( function(){ 
                    Swal.fire({
                         icon:  event.success? 'success': 'error',
                         title: event.message,
                         toast: true,
                         timer: 2000,
                         position: 'top-end',
                         showConfirmButton: false,
                         width:'400px',
                         didClose: () => {
                              if( event.success ) {
                                   Livewire.navigate("{{route('employees.index')}}");
                              }
                         }
                    });
                    // $wire.set('display_error', true);
                    // $wire.set('loading',false);
          },3000);
     });
</script>
@endscript