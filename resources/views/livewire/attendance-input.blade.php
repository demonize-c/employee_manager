<div class="py-3 px-4 text-center" 
    :class="{'readonly-cell':!open,'editonly-cell':open,'bg-honeydew2': synced && !loading}" 
    x-data="{open:false,time: @entangle('time'),synced: @entangle('synced'), display: null, loading:false}" 
    x-init="
         loading=true;
         setTimeout(() =>  {
                     display = time;
                     loading = false;
        }, 500);
        $($refs.picker).timepicker({
            timeFormat: 'H:i:s',
            interval: 30,
            dropdown: true,
            scrollbar: true,
            className:'form-select mobile-resize'
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
                    display = time;
                    if( !success ) {
                        notify({ type: ('error'), message });
                    }
            }, 500);
        });
    "
    wire:init="load_data"
    >
    <input
     wire:ignore 
     x-ref="picker" 
     type="time" 
     class="form-control timepicker no-focus opacity-0 zero-dimension" 
     @change="loading=true; time=$event.target.value; $wire.call('save')"
    >
    <span class="time-display"  x-text="display? convertTo12Hour(display): '__:__ __'"></span>
    <i wire:ignore class="fas fa-pen   edit-btn" x-ref="picker_btn" :class="{'active':!loading}"></i>
    <i wire:ignore class="fas fa-trash del-btn"  :class="{'active':(!loading && time)}" @click="loading=true;$wire.call('delete');"></i>
</div>