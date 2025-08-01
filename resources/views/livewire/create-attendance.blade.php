@section('css')
<style>
.zoomIn {
    animation: zoomIn 0.15s ease forwards;
}

.table-responsive{
    max-width:calc(100vw - 280px);
    overflow-x:scroll;
    padding:0 !important;
}


@media only screen and (max-width: 980px) {
   
   .table-responsive{
         max-width:calc(100vw - 20px) !important;
   }
}
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


</style>
@endsection

<div class="container-fluid content-area mt-4">
  <!-- Filter Inputs -->
  <div class="row mb-3">
    <div class="col-md-3 mb-2 mb-md-0">
      <!-- <label for="yearInput" class="form-label">Year</label> -->
      <input type="text" id="yearInput" class="form-control form-control-sm" placeholder="e.g. 2025" min="2000" max="2100" wire:model.live="year" wire:keydown.enter="updateAttendanceChart">
    </div>
    <div class="col-md-3 mb-2 mb-md-0">
      <!-- <label for="monthInput" class="form-label">Month</label> -->
      <select id="monthInput" class="form-select form-select-sm" wire:model="month" wire:change="updateAttendanceChart">
        <option value="">Select Month</option>
        <option value="1">January</option>
        <option value="2">February</option>
        <option value="3">March</option>
        <option value="4">April</option>
        <option value="5">May</option>
        <option value="6">June</option>
        <option value="7">July</option>
        <option value="8">August</option>
        <option value="9">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
      </select>
    </div>
    <div class="col-md-3  mb-2 mb-md-0">
      <!-- <label for="weekInput" class="form-label">Week</label> -->
      <select id="weekInput" class="form-select form-select-sm" wire:model="week" wire:change="updateAttendanceChart">
        <option value="">Select Week</option>
        @for($i=1; $i <= $total_weeks; $i++)
           <option value="{{$i}}">Week {{$i}}</option>
        @endfor
      </select>
    </div>
    <!-- <div class="col-md-3 col-6 d-flex align-items-end">
      <a href="javascript:void(0)" class="btn btn-primary btn-sm w-100" wire:click="updateSearch"><i class="fas fa-search"></i> Search</a>
    </div> -->
  </div>
  <div class="row justify-content-center">
    <div class="table-responsive zoomIn" wire:loading.class.remove="zoomIn" wire:target="gotoPage, nextPage, previousPage, updateAttendanceChart">
          <table id="attendance_table" class="table table-bordered text-nowrap mobile-stacked-table">
              <thead>
                  <tr>
                      <th class="employee-col">Employee</th>
                      @foreach($periods as $date)
                          <th class="text-center" colspan="2">{{ $date }}</th>
                      @endforeach
                  </tr>
                  <tr>
                      <th class="employee-col"></th>
                      @foreach($periods as $date)
                          <th>In <i class="fas fa-sign-in-alt"></i></th>
                          <th>Out <i class="fas fa-sign-out-alt"></i></th>
                      @endforeach
                  </tr>
              </thead>
              <tbody>
                @if($employees->count() !== 0)
                  @foreach($employees as $employee)
                      <tr>
                          <td class="employee-col">{{ $employee->name }}</td>
                          @foreach($periods as $date)
                            <td data-title="In at {{date('d, M', strtotime($date))}}"><livewire:attendance-input  wire:key="attendance-{{ $date }}-{{ $employee->id }}-check-in" :date="$date" :employee_id="$employee->id" :type="'check_out'"></td>
                            
                            <td data-title="Out at {{date('d, M', strtotime($date))}}"><livewire:attendance-input  wire:key="attendance-{{ $date }}-{{ $employee->id }}-check-out"  :date="$date" :employee_id="$employee->id" :type="'check_in'"></td>
                          @endforeach
                      </tr>
                  @endforeach
                @else
                    <tr class="no-data"><td class="py-4" colspan="14">
                        <h4 class="text-center text-muted" >No Data</h4> 
                    </td></tr>
                @endif
                
              </tbody>
          </table>
      </div>
    </div>
    <div class="row justify-content-end mt-4">
          <nav>
              {{$employees->links()}}
          </nav>
    </div>
</div>

@script

<script>

  __cul.add($wire, ()=> { initializeTimePicker(); });

</script>

@endscript