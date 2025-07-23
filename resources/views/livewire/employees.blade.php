
@section('css')
<style>
    .opacity-zero{
        opacity:0;
    }

   .fade-in {
       animation: fadeIn 2s ease forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

</style>
@endsection

<div class="container">
      <div class="row justify-content-center">
           <div class="col-md-10">
               <form class="row  justify-content-between" id="searchForm">
                    <div class="col-md-3 mb-2 mb-md-0">
                         <input 
                            type="text"
                            class="form-control" 
                            id="searchName"  
                            placeholder="Search by Name"   
                            wire:model="search_name" 
                            wire:keydown.enter ="update_search"
                        >
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                          <input 
                              type="text" 
                              class="form-control"
                              id="searchPhone" 
                              placeholder="Search by Phone" 
                              wire:model  ="search_phone" 
                              wire:keydown.enter ="update_search"
                            >
                    </div>
                    <div class="form-group col-md-3 mb-2 mb-md-0">
                        <livewire:designation-select-input :dsg_name="$search_dsg_name" :dsg_id="$search_dsg_id"/>
                    </div>
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
                           <div class="btn-group btn-group-sm me-2" role="group">
                                <button 
                                    type="button" 
                                    class="btn btn-outline-info {{$filter_applied?'text-danger':''}} no-focus"
                                    wire:click="clear_search"
                                    title="Clear Filters"
                                >
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                                
                                <button 
                                    type="button" 
                                    class="btn btn-outline-info no-focus"
                                    wire:click="update_search"
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
                   <div class="card-body" >
                         <div 
                            class="table-wrapper opacity-zero fade-in"
                            wire:loading.class.remove="fade-in"
                            wire:target="gotoPage, nextPage, update_search, select_designation, clear_designation"
                         >    
                            <table class="table">
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
                                            <div class="image-preview-wrapper">
                                                <img class="preview-img" src="{{asset('media/employee_pictures/'.$employee->photo)}}" alt="">
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
                                      <tr><td class="py-4"colspan="6">
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
            },300);
     });;

    
</script>
@endscript