 <!-- Sidebar -->
 <div class="sidebar p-3" id="sidebar">
    <div>
        <h5 class="text-white">Admin Panel</h5>
        <ul class="nav flex-column">
           @if(Route::has('dashboard'))
           <li class="nav-item">
             <a wire:navigate  class="nav-link {{Route::is('dashboard')?'active':''}}" href="{{route('dashboard')}}" >
               <i class="fa fa-tachometer-alt me-2"></i> Dashboard
             </a>
           </li>
           @endif
            <li class="nav-item">
            <a class="nav-link {{Route::is('designations.*') || Route::is('employees.*')?'active':''}}" data-bs-toggle="collapse" href="#menu1" role="button">
                <i class="fa-solid fa-user-tie me-2"></i>Employees
            </a>
            <div 
               class="collapse" 
               id="menu1"
            >
                
                 <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a wire:navigate class="nav-link" href="{{route('designations.index')}}">
                           <i class="fa-solid fa-user-group me-2  {{Route::is('designations.*')?'text-primary':''}}"></i>
                            Designations
                        </a>
                    </li>
                </ul>

                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a  wire:navigate class="nav-link" href="{{route('employees.index')}}">
                            <i class="fa-solid fa-users me-2 {{Route::is('employees.*')?'text-primary':''}}"></i>
                            Employees
                        </a>
                    </li>
                </ul>
            </div>
            </li>
        </ul>
        </div>
        <div>
        <a class="nav-link" href="#">
            <i class="fa fa-cog me-2"></i> Settings
    </a>
    </div>
</div>