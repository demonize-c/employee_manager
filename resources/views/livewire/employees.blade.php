<div class="container">
      <div class="row justify-content-center">
           <div class="col-md-10 mt-4">
               <div class="card shadow-sm">
                   <div class="card-header">
                       <div class="row">
                           <div class="col">
                                <h4>Employees</h2>
                           </div>
                           <div class="col text-end">
                              @if(Route::has('employees.create'))
                                  <a class="btn btn-sm btn-primary" href="{{route('employees.create')}}"><i class="fa-solid fa-plus "></i> Add</a>
                              @endif
                           </div>
                       </div>
                   </div>
                   <div class="card-body">
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
                                            <a href="javascript:void(0)" ><i class="fa-solid fa-trash text-danger"></i></a>
                                            @if(Route::has('employees.edit'))
                                              <a href="{{route('employees.edit',$employee->id)}}" class=""><i class="fa-solid fa-pencil text-primary"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                   </div>
                   @if($employees->hasPages())
                   <div class="card-header">
                        <nav aria-label="Page navigation example">
                             {{$employees->links()}}
                        </nav>
                   </div>
                   @endif
               </div>
           </div>
      </div>
</div>