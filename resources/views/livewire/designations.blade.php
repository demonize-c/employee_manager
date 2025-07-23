<div class="container">
      <div class="row justify-content-center">
           <div class="col-md-8 mt-4">
                <div class="row  justify-content-start mt-2" id="searchForm">
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
            </div>
           </div>
           <div class="col-md-8 mt-4">
               <div class="card shadow-sm">
                   <div class="card-header">
                       <div class="row">
                           <div class="col">
                                <h4>Designatons</h2>
                           </div>
                           <div class="col text-end">
                                  <a class="btn btn-sm btn-primary" href="{{route('designations.create')}}"><i class="fa-solid fa-plus "></i> Add</a>
                           </div>
                       </div>
                   </div>
                   <div class="card-body"  wire:init="loading_off">
                        <div class="table-wrapper" wire:show="!loading" wire:transition.scale.duration.300ms> 
                        <div
                          wire:key="{{$designations->count() !==0? $designations->pluck('id')->join('-'):'xx'}}"  
                          wire:transition.scale.duration.300ms
                        >
                        <table class="table">
                            <thead>
                                <tr>
                                   <th class="text-start">Name</th>
                                   <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody
                               
                            >
                               @if($designations->count() !== 0)
                                    @foreach($designations as $designation)
                                        <tr>
                                            <td data-title="Name">{{$designation->name}}</td>
                                            <td class="text-end" data-title="Action">
                                                <a href="javascript:void(0)" wire:click="$dispatch('delete-action', {{$designation->id}})"><i class="fa-solid fa-trash text-danger"></i></a>
                                                @if( Route::has('designations.edit'))
                                                    <a wire:navigate href="{{route('designations.edit',$designation->id)}}" class=""><i class="fa-solid fa-pencil text-primary"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                      <tr ><td class="py-4"colspan="2">
                                            <h4 class="text-center text-muted" >No Data</h4> 
                                       </td></tr>
                                @endif
                            </tbody>
                        </table>
                        @if($designations->hasPages())
                            <div class="">
                                    <nav 
                                       aria-label="Page navigation example bg-none" 
                                      
                               
                                    >
                                        {{$designations->links()}}
                                    </nav>
                            </div>
                        @endif
                        </div>
                        </div>
                   </div>
                   
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
               return $wire.call('delete_confirmed', deleteableId);
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
     });
</script>
@endscript