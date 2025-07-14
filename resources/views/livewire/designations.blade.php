<div class="container">
      <div class="row justify-content-center">
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
                   <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                   <th class="text-start">Name</th>
                                   <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($designations as $designation)
                                    <tr>
                                        <td>{{$designation->name}}</td>
                                        <td class="text-end">
                                            <a href="{{route('designations.edit',$designation->id)}}" class=""><i class="fa-solid fa-pencil text-primary"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                   </div>
                   @if($designations->hasPages())
                   <div class="card-header">
                        <nav aria-label="Page navigation example">
                             {{$designations->links()}}
                        </nav>
                   </div>
                   @endif
               </div>
           </div>
      </div>
</div>