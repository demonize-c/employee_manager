@php $delay = 1000; @endphp
<div class="container">
      <div class="row justify-content-center">
           <div class="col-lg-6">
               <div 
                    class  = "card shadow-sm" 
                    x-data = "{loading:false}"
                    x-init = "
                       $wire.on('notify', ({success, message}) => {
                              setTimeout(() =>  {
                                    loading = false;
                                    notify({
                                        type: ( success? 'success': 'error'), 
                                        message,
                                        cb: ( success? 
                                              () => Livewire.navigate('{{route('employees.index')}}') :
                                              null )
                                   });
                              }, 2000);
                         });
                    "
               >
                    <div class="card-header">
                           <h4 class="p-3">Create Employee</h4>
                    </div>
                    <div class="card-body">
                         
                         <form action="">
                                <div class="form-group mb-3">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" placeholder="Examples - Jhon Doe, Sundar Pichai" wire:model="name">
                                    @error('name')<small class="text-danger" x-show="!loading">{{ $message }}</small>@enderror   
                                </div>
                                <div class="form-group mb-3">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" placeholder="Examples - jhondoe@gmail.com, etc" wire:model="email">
                                    @error('email')<small class="text-danger" x-show="!loading">{{ $message }}</small>@enderror   
                                    
                                </div>
                                <div class="form-group mb-3">
                                    <label>Phone Number</label>
                                    <input type="email" class="form-control" placeholder="Examples - +91 8100012345" wire:model="phone">
                                    @error('phone')<small class="text-danger" x-show="!loading">{{ $message }}</small>@enderror   
                                </div>
                                <div class="form-group mb-3">
                                    <label>Designation</label>
                                    <div class="select2 select2-container" x-data="{open:false}">
                                             <div class="input-group mb-3">
                                                  <input 
                                                       type = "text" 
                                                       class = "form-control select2-selection no-focus" 
                                                       value =" {{$designation_name??''}}"
                                                       x-on:focus = "open=true"
                                                       readonly
                                                  >
                                                  <div class="input-group-append" style="cursor:pointer;">
                                                       <span class="input-group-text" 
                                                             x-on:click="
                                                                $wire.set('designation_name', null);
                                                                $wire.set('designation_id',null);
                                                                open=false;
                                                             "
                                                       >&times;</span>
                                                  </div>
                                             </div>
                                             <div
                                                  class="select2-dropdown" 
                                                  x-show="open"
                                                  x-transition:enter.duration.500ms
                                                  x-transition:leave.duration.400ms 
                                             >  <div>
                                                  <div class="select2-search">
                                                       <div class="input-group w-100 ">
                                                                 <input type="text" 
                                                                        class="form-control no-focus border-right-0" placeholder="Search..." 
                                                                        wire:model.live.debounce.250ms="designation_text" 
                                                                 >
                                                                 <div class="input-group-append" 
                                                                      @click="open=false" 
                                                                      style="cursor:pointer;">
                                                                      <span class="input-group-text bg-transparent border-left-0">&times;</span>
                                                                 </div>
                                                       </div>
                                                  </div>
                                                  <ul class="select2-results">
                                                       @foreach($designation_options as $option)
                                                       <li 
                                                            class = "select2-option" 
                                                            wire:key ="dsg-{{ $option->id }}"
                                                            @click = "
                                                                $wire.set('designation_name', '{{$option->name}}');
                                                                $wire.set('designation_id', '{{$option->id}}');
                                                                open = false;
                                                            "
                                                       >
                                                            {{ $option->name }}
                                                       </li>
                                                       @endforeach
                                                  </ul>
                                             </div>
                                       </div>
                                        @error('designation_id')<small class="text-danger" x-show="!loading">{{ $message }}</small>@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label>Date Of Joining</label>
                                    <input type="date" class="form-control" placeholder="" wire:model="doj">
                                    @error('doj')<small class="text-danger" x-show="!loading">{{ $message }}</small>@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label>Salary</label>
                                    <input type="number" class="form-control" placeholder="Examples - 10000,20000" wire:model="salary">
                                    @error('salary')<small class="text-danger" x-show="!loading">{{ $message }}</small>@enderror
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
                                   @error('photo')<small class="text-danger" x-show="!loading">{{ $message }}</small>@enderror
                                </div>
                                
                         </form>
                    </div>
                    <div class="card-footer text-end">
                         <a wire:navigate class="btn btn-secondary" href="{{route('employees.index')}}">Close</a>
                         <button  
                           class="btn btn-success" 
                           @click="
                              loading = true;
                              $wire.call('save');
                           " 
                           x-text="!loading? 'Save':'Saving..'"
                           :disabled="loading"
                           ></button>
                    </div>
                </div>
           </div>
      </div>
</div>