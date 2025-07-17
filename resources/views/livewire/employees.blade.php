<div class="container">
      <div class="row justify-content-center">
           <div class="col-md-10 mt-4">
               <form class="row  justify-content-between mt-2" id="searchForm">
                    <div class="col-md-3">
                         <input 
                            type="text"
                            class="form-control" 
                            id="searchName"  
                            placeholder="Search by Name"   
                            wire:model="search_name" 
                            wire:keydown.enter ="update_search"
                        >
                    </div>
                    <div class="col-md-3">
                          <input 
                              type="text" 
                              class="form-control"
                              id="searchPhone" 
                              placeholder="Search by Phone" 
                              wire:model  ="search_phone" 
                              wire:keydown.enter ="update_search"
                            >
                    </div>
                    <div class="form-group col-md-3">
                        <div class="select2 select2-container" @click.outside = "$wire.set('open_desig',false)">
                            <div class="input-group mb-3">
                                    <input 
                                        type="text" 
                                        class="form-control select2-selection" 
                                        value="{{$search_desig['name']??''}}"
                                        x-on:focus = "$wire.set('open_desig',true)"
                                        readonly
                                    >
                                    <div class="input-group-append">
                                        <span class="input-group-text" style="cursor:pointer;" x-on:click="$dispatch('clear-designation')">&times;</span>
                                    </div>
                            </div>
                            @if($open_desig)
                                <div class="select2-dropdown">
                                        <input 
                                            type="text" 
                                            class="form-control select2-search" 
                                            placeholder="Search..."
                                            wire:model="search_desig_name"
                                            wire:keyup="$dispatch('search-designations')"
                                            x-init="$el.focus()"
                                        >
                            
                                        <ul class="select2-results">
                                            @foreach($designation_options as $option)
                                            <li 
                                                class = "select2-option" 
                                                wire:key   ="user-{{ $option->id }}"
                                                @click = "$dispatch('select-designation',{id:{{$option->id}},name:'{{$option->name}}'})"
                                            >
                                                {{ $option->name }}
                                            </li>
                                            @endforeach
                                        </ul>
                                </div>
                            @endif
                            </div>
                    </div>
                    <!-- <div class="col-md-2">
                           <a href="javascript:void(0)" class="btn btn-primary w-100" wire:click="update_search">Search</a>
                    </div> -->
                </form>
           </div>
           <div class="col-md-10 mt-4">
               <div class="card shadow-sm">
                   <div class="card-header">
                       <div class="row">
                       
                       </div>
                       <div class="row">
                           <div class="col">
                                <h4>Employees</h2>
                           </div>
                           <div class="col text-end">
                              @if(Route::has('employees.create'))
                                  <a wire:navigate class="btn btn-sm btn-primary" href="{{route('employees.create')}}"><i class="fa-solid fa-plus "></i> Add</a>
                              @endif
                           </div>
                       </div>
                   </div>
                   <div class="card-body">
                       <div class="table-wrapper" wire:ignore wire:key="page-{{request()->query('page')}}-ready-{{$ready? '1': '0'}}">    
                            <table class="table"  wire:init="ready_reset">
                                <thead>
                                    <tr>
                                    <th class="text-start">#</th>
                                    <th class="">Name</th>
                                    <th class="">Designation</th>
                                    <th class="">Date of Joining</th>
                                    <th class="">Salary</th>
                                    <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @if($employees->count() !== 0)
                                    @foreach($employees as $employee)
                                        <tr>
                                        <td class="text-start" style="max-width:120px;">
                                            <div class="image-preview-wrapper">
                                            <img class="preview-img" src="{{asset('media/employee_pictures/'.$employee->photo)}}" alt="">
                                            </div>
                                        </td>
                                            <td class="text-start">
                                            
                                                <span> {{$employee->name}}</span><br>
                                                <a href="mailto:{{$employee->email}}"> {{$employee->email}}</a><br>
                                                <a href="tel:{{$employee->phone}}">{{$employee->phone}}</a>
                                            </td>
                                            <td class="">{{$employee->designation->name}}</td>
                                            <td class="">{{$employee->doj}}</td>
                                            <td class="">{{$employee->salary}}</td>
                                            <td class="text-end">
                                                <a href="javascript:void(0)" @click="$dispatch('delete-action', {{$employee->id}})"><i class="fa-solid fa-trash text-danger"></i></a>
                                                @if(Route::has('employees.edit'))
                                                <a wire:navigate href="{{route('employees.edit',$employee->id)}}" class=""><i class="fa-solid fa-pencil text-primary"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                  @else
                                      <tr><td class="py-4"colspan="6">
                                            <h4 class="text-center text-muted" >No Data</h4> 
                                       </td></tr>
                                  @endif
                                </tbody>
                            </table>
                            @if($employees->hasPages())
                                <div class="card-footer">
                                        <nav aria-label="Page navigation example">
                                            {{$employees->links()}}
                                        </nav>
                                </div>
                            @endif
                           
                        </div>
                        @if($loading)
                            <div  class="table-loader-overlay" id="table-loader">
                                <div class="text-center">
                                    <div class="spinner-border" role="status"></div>
                                    <div class="mt-2 fw-bold text-primary">Loading</div>
                                </div>
                            </div>
                        @endif
                   </div>
               </div>
           </div>
      </div>
</div>

@script
<script>
    //  $wire.dispatch('on-load');
     $wire.on('delete-action',function( deleteableId ){
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText:  'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
               $wire.set('loading',true);
               return $wire.dispatch('delete-confirmed', { deleteableId });
            }
            Swal.fire({
                icon:  'info',
                title: 'Operation was cancelled.',
                toast: true,
                timer: 2000,
                position: 'top-end',
                showConfirmButton: false
            });
        });
     });

     $wire.on('on-delete',function( event ){
        
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
            },300);
     });
     $wire.on('on-load',function( event ){
            $wire.set('loading',true);
            setTimeout(() => {
                    $wire.set('loading',false);
                    $wire.set('ready',true);
            },300);
     })

     $wire.on('search-designations',function( event ){
            $wire.call('update_designation_options');
     })

     $wire.on('select-designation',function( option ){
            $wire.call('select_designation', option);
            $wire.set('open_desig',false);
     })

     $wire.on('clear-designation',function( option ){
            $wire.call('clear_designation', option);
            $wire.dispatch('on-load');
     })
</script>
@endscript