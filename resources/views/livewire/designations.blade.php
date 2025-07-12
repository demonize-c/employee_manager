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
                                  <a class="btn btn-primary" href="{{route('designations.create')}}">Add</a>
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
                                            <button class="btn btn-primary">Edit</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                   </div>
                   <div class="card-header">
                        <nav aria-label="Page navigation example">
                             {{$designations->links()}}
                        </nav>
                   </div>
               </div>
           </div>
      </div>
</div>