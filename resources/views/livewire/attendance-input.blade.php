<td class="p-2 text-center" 
    :class="{'readonly-cell':!open,'editonly-cell':open,'bg-honeydew2': synced && !loading}" 
    x-data="{open:false,time: @entangle('time'),synced: @entangle('synced'), loading:false}" 
    x-init="
        $wire.on('attendance.{{$date}}.{{$employee_id}}', function({ success, message }) {
            if( success ) {
              setTimeout(function() { loading=false; }, 1000)
            }
        });
    "
    >
    <input wire:ignore type="time" class="form-control attendance-input timepicker no-focus opacity-0" @change="loading=true; time=$event.target.value; $wire.call('save')">
    <span class="time-display" x-text="time? convertTo12Hour(time): '__:__ __'"></span>
    <i wire:ignore class="fas fa-pen edit-btn open-picker" :class="{'active':!loading}"></i>
</td>

