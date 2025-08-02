<nav class="navbar navbar-expand-lg navbar-light px-3">
<button class="btn text-white d-lg-none me-3" id="sidebar_toggle_btn">
    <i class="fa fa-bars"></i>
</button>
<div class="ms-auto">
    <a
    class="d-flex align-items-center text-white text-decoration-none"
    href="#"
    id="dropdownUser1"
    data-bs-toggle="dropdown"
    aria-expanded="false"
    >
        <img src="https://i.pravatar.cc/150?img=3" alt="profile" class="profile-img me-2" />
        <span class="text-nowrap me-2">{{auth()->user()->name}}</span>
        <livewire:logout/>
    </a>
    
    <!-- <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser1">
    <li><a class="dropdown-item" href="#">Profile</a></li>
    <li><a class="dropdown-item" href="#">Settings</a></li>
    <li><hr class="dropdown-divider" /></li>
    <li><a class="" href="#"></li>
    </ul> -->
</div>
</nav>