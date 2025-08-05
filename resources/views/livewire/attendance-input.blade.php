<div class="py-3 px-4 text-center" 
    x-ref="box"
    x-data="{
    open:false,
    time: @entangle('time'),
    synced: @entangle('synced'),
    hasRun:false,
    loadingStart() {
            $refs.box.classList.remove('bg-honeydew2');
            $refs.deleteButton.classList.remove('active');
            $refs.pickerButton.classList.remove('active');
    },
    loadingEnd( update = true ) {

            if( this.time && this.synced ) {
               $refs.box.classList.add('bg-honeydew2');
               $refs.deleteButton.classList.add('active');
               if( update ) {
                  $refs.display.textContent = this.time;
               }
            } 
            if( !this.time && !this.synced ) {
               $refs.box.classList.remove('bg-honeydew2');
               $refs.deleteButton.classList.remove('active');
               $refs.display.textContent =  '__:__ __';
            } 
            $refs.pickerButton.classList.add('active');
        }
    }" 
    x-init="
       

        $($refs.picker).timepicker({
            timeFormat: 'H:i:s',
            interval: 30,
            dropdown: true,
            scrollbar: true,
            className:'form-select mobile-resize'
        });

        $($refs.pickerButton).on('click', function () {
            $($refs.picker).timepicker('show');
        });

        $($refs.picker).on('changeTime', function () {
           $(this).trigger('change');
        });

        $wire.on('attendance.{{$date}}.{{$employee_id}}', function({ success, message }) {
              setTimeout(() =>  {
                    loadingEnd(success);
                    if( !success ) {
                        notify({ type: ('error'), message });
                    }
            }, 1000);
        });
    "
    x-effect="
      if( time && !hasRun){
        setTimeout(() => { 
            loadingEnd();
            hasRun=true;
        }, 500);
      }
    "
    wire:init="load_data"

    >
    <input
     wire:ignore 
     x-ref="picker" 
     type="time" 
     class="form-control timepicker no-focus opacity-0 zero-dimension" 
     @change="loadingStart(); time=$event.target.value; $wire.call('save')"
    >
    <span wire:ignore class="time-display"  x-ref="display" >__:__ __</span>
    <i class="fas fa-pen   edit-btn" x-ref="pickerButton" ></i>
    <i class="fas fa-trash del-btn"  x-ref="deleteButton" @click="loadingStart(); $wire.call('delete');"></i>
</div>

