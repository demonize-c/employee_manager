
@section('css')
<style>
    @keyframes zoomIn {
        0% {
            opacity: 0;
            transform: scale(0.95);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    .zoomIn {
       animation: zoomIn 0.15s ease forwards;
     }

</style>
@endsection

<div class="container">
      <div class="row justify-content-center">
           <div class="col-lg-10">
               <form class="row  justify-content-between" id="searchForm">
                    <div class="col-md-4 mb-2 mb-md-0">
                       <div class="input-group">
                                 
                            <span class="input-group-text">
                                 <i class="fa fa-search"></i>
                            </span>
                            <input 
                                type="text"
                                class="form-control text-sm" 
                                id="searchName"  
                                placeholder="Search by Name"   
                                wire:model="search_name" 
                                wire:keydown.enter ="updateSearch"
                            >
                      </div>
                    </div>
                    <div class="col-md-4 mb-2 mb-md-0">
                          <div class="input-group">
                            <span class="input-group-text">
                              <i class="fa-solid fa-phone"></i>
                            </span>
                            <input 
                                type="text" 
                                class="form-control text-sm"
                                id="searchPhone" 
                                placeholder="Search by Phone" 
                                wire:model  ="search_phone" 
                                wire:keydown.enter ="updateSearch"
                                >
                          </div>
                    </div>
                    <div class="form-group col-md-4 mb-2 mb-md-0">
                        <div class="select2 select2-container" x-data="{open:false}" >
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-user-tie"></i>
                                    </span>
                                    <input 
                                        type = "text" 
                                        class = "form-control select2-selection text-sm no-focus" 
                                        @if( $search_dsg_name )
                                          value = "{{$search_dsg_name}}"
                                        @endif
                                        @focus = "$refs.dropdown.classList.remove('d-none'); open=true;"
                                        placeholder="Search by Designation"
                                        readonly
                                    >
                                    <span class="input-group-text" 
                                            x-on:click="
                                                $wire.set('search_dsg_name', null);
                                                $wire.set('search_dsg_id',null);
                                                open=false;
                                            "
                                            style="cursor:pointer;" 
                                    ><i class="fa-solid fa-trash-can"></i></span>
                                 
                                </div>
                                <div
                                    class  ="select2-dropdown d-none"
                                    x-ref="dropdown"
                                    x-show="open"
                                    x-transition:enter.duration.500ms
                                    x-transition:leave.duration.400ms 
                                >  <div>
                                    <div class="select2-search">
                                        <div class="input-group input-group-sm w-100">
                                                    <input type="text" 
                                                        class="form-control no-focus border-right-0" placeholder="Search..." 
                                                        wire:model.live.debounce.250ms="search_dsg_text" 
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
                                                $wire.set('search_dsg_name', '{{$option->name}}');
                                                $wire.set('search_dsg_id', '{{$option->id}}');
                                                open = false;
                                            "
                                        >
                                            {{ $option->name }}
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                       </div>
                </form>
           </div>
           <div class="col mt-2">
               <div class="card shadow-none-sm shadow-sm">
                   <div class="card-header border-bottom-0 bg-none-sm">
                       <div class="row">
                           <div class="col">
                                <h5>Employees</h5>
                           </div>
                           <div class="col text-end">
                           <div class="btn-group btn-group-sm me-2" role="group">
                                <button 
                                    type="button" 
                                    class="btn btn-outline-info {{$filter_applied?'text-danger':''}} no-focus"
                                    wire:click="clearSearch"
                                    title="Clear Filters"
                                >
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                                
                                <button 
                                    type="button" 
                                    class="btn btn-outline-info no-focus"
                                    wire:click="updateSearch"
                                    title="Apply Filters"
                                >
                                    <i class="fa-solid fa-filter"></i>
                                </button>
                            </div>

                             
                              @if(Route::has('employees.create'))
                                  <a wire:navigate class="btn btn-sm btn-primary" href="{{route('employees.create')}}"><i class="fa-solid fa-plus "></i> Add</a>
                              @endif
                           </div>
                       </div>
                   </div>
                   <div class="card-body px-0 px-md-4" >
                         <div 
                            class="table-wrapper zoomIn"
                            wire:loading.class.remove="zoomIn"
                            wire:target="gotoPage, nextPage, previousPage, updateSearch, clearSearch, selectDesignation, clearDesignation, deleteConfirmed"
                         >    
                            <table class="table table-compact mobile-stacked-table">
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
                                  @if( $employees->count() !== 0)
                                    @foreach($employees as $employee)
                                        <tr>
                                        <td class="text-start" style="" data-title="Photo">
                                             <div class="image-aligner">
                                                <div class="image-preview-wrapper">
                                                    <img class="preview-img" src="{{ $employee->photoUrl()}}" alt="">
                                                </div>
                                             </div>

                                        </td>
                                            <td class="text-start" data-title="Name">
                                            
                                                <span> {{$employee->name}}</span><br>
                                                <a href="mailto:{{$employee->email}}"> {{$employee->email}}</a><br>
                                                <a href="tel:{{$employee->phone}}">{{$employee->phone}}</a>
                                            </td>
                                            <td class="" data-title="Designation">{{$employee->designation->name}}</td>
                                            <td class="" data-title="Date of Joining">{{$employee->doj}}</td>
                                            <td class="" data-title="Salary">{{$employee->salary}}</td>
                                            <td class="text-end" data-title="Action">
                                                <a href="javascript:void(0)" @click="$dispatch('delete-action', {{$employee->id}})"><i class="fa-solid fa-trash text-danger"></i></a>
                                                @if(Route::has('employees.edit'))
                                                <a wire:navigate href="{{route('employees.edit',$employee->id)}}" class=""><i class="fa-solid fa-pencil text-primary"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                  @else
                                       <tr class="no-data"><td class="py-4" colspan="6">
                                            <h4 class="text-center text-muted" >No Data</h4> 
                                       </td></tr>
                                  @endif
                                </tbody>
                            </table>
                            @if($employees->hasPages())
                                <div class="">
                                        <nav aria-label="Page navigation example bg-none">
                                            {{$employees->links()}}
                                        </nav>
                                </div>
                            @endif
                        </div>  
                   </div>
                   <!-- card body -->
               </div>
           </div>
      </div>
</div>

@script
<script>
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
               return $wire.call('deleteConfirmed', deleteableId );
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
            },300);
     });;

    
</script>
@endscript