@section('css')

<style>

.card-summary {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.card-summary i {
    font-size: 1.5rem;
    color: #10b981;
}
</style>
@endsection

<div class="container">
    <!-- <h2 class="mb-4">Dashboard Overview</h2> -->
    <div class="row g-4">
    <div class="col-md-4">
        <div class="card-summary">
        <div class="d-flex align-items-center">
            <i class="fa fa-users me-3"></i>
            <div>
            <h5 class="mb-0">{{$total_employees}} Employees</h5>
              <small class="text-muted">Total active staff in organization</small>
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-summary">
        <div class="d-flex align-items-center">
            <i class="fa fa-briefcase me-3"></i>
            <div>
            <h5 class="mb-0">{{$total_designations}} Designations</h5>
            <small class="text-muted">Roles across departments</small>
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-summary">
        <div class="d-flex align-items-center">
            <i class="fa fa-calendar-check me-3"></i>
            <div>
            <h5 class="mb-0">{{round(($total_attendances/ $total_employees) * 100, 2)}}% Attendance</h5>
            <small class="text-muted">Today’s attendance rate</small>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>

