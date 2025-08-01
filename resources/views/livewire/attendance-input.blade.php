<div class="py-3 px-4 text-center" 
    :class="{'readonly-cell':!open,'editonly-cell':open,'bg-honeydew2': synced && !loading}" 
    x-data="{open:false,time: @entangle('time'),synced: @entangle('synced'), loading:false}" 
    x-init="
        $($refs.picker).timepicker({
            timeFormat: 'H:i:s',
            interval: 30,
            dropdown: true,
            scrollbar: true
        });
        $($refs.picker_btn).on('click', function () {
            $($refs.picker).timepicker('show');
        });

        $($refs.picker).on('changeTime', function () {
           $(this).trigger('change');
        });

        $wire.on('attendance.{{$date}}.{{$employee_id}}', function({ success, message }) {
              setTimeout(() =>  {
                    loading = false;
                    if( !success ) {
                        notify({ type: ('error'), message });
                    }
            }, 2000);
        });
    "
    wire:init="load_data"
    >
    <input wire:ignore x-ref="picker" type="time" class="form-control timepicker no-focus opacity-0 zero-dimension" @change="loading=true; time=$event.target.value; $wire.call('save')">
    <span class="time-display"  x-text="time? convertTo12Hour(time): '__:__ __'"></span>
    <i wire:ignore class="fas fa-pen edit-btn" x-ref="picker_btn" :class="{'active':!loading}"></i>
</div>