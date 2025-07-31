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
       animation: zoomIn 0.1s ease forwards;
    }

</style>
@endsection

<div class="container">
      <div class="row justify-content-center">
           <div class="col-md-8">
                <div class="row justify-content-start" id="searchForm">
                    <div class="col-md-5 mb-2">
                         <input 
                            type="text"
                            class="form-control form-control-sm" 
                            id="searchName"  
                            placeholder ="Search by Name"   
                            wire:model ="search_name" 
                            wire:keydown.enter ="updateSearch"
                        >
                    </div>
            </div>
           </div>
           <div class="col-md-8 mt-2">
               <div class="card shadow-sm">
                   <div 
                         class="card-header bg-black-50 border-bottom-0" 
                         x-init="
                         $wire.on('notify', ({success, message}) => {
                                    notify({
                                        type: ( success? 'success': 'error'), 
                                        message
                                   });
                         });
                         "
                       
                    >
                       <div class="row">
                           <div class="col">
                                <h5>Designatons</h5>
                           </div>
                           <div class="col text-end">
                                  <a class="btn btn-sm btn-primary" href="{{route('designations.create')}}"><i class="fa-solid fa-plus "></i> Add</a>
                           </div>
                       </div>
                   </div>
                   <div class="card-body">
                        <div  class="table-wrapper zoomIn"
                              wire:loading.class.remove="zoomIn"
                              wire:target="previousPage, nextPage, gotoPage, updateSearch, delete"
                        > 
                        <div>
                        <table class="table table-compact">
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
                                        <tr x-data="{deletableId:{{$designation->id}} }" wire:key="dsg-{{$designation->id}}">
                                            <td data-title="Name">{{$designation->name}}</td>
                                            <td class="text-end" data-title="Action">
                                                <a href="javascript:void(0)" @click="confirmDeletion(()=>$wire.call('delete',deletableId),() => notify({message:'Action aborted.'}))"><i class="fa-solid fa-trash text-danger"></i></a>
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