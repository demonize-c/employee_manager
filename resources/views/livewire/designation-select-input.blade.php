

<div class="select2 select2-container" x-data="{open:false, cls:''}" >
    <div class="input-group mb-3">
            <input 
                type="text" 
                class="form-control select2-selection" 
                value="{{ $dsg_id && $dsg_name? $dsg_name:'' }}"
                @click = "open=true;"
                readonly
            >
            <div class="input-group-append" x-show="!open">
                <span 
                    class  ="input-group-text" 
                    style  ="cursor:pointer;" 
                    wire:click = "$parent.clear_designation"

                >&times;</span>
            </div>
            <div class="input-group-append" x-show="open">
                <span class="input-group-text" style="cursor:pointer;" x-on:click="open=false;">&#8593;</span>
            </div>
    </div>
    <div 
      class="select2-dropdown" 
      x-show="open" 
      x-transition:enter.duration.500ms
      x-transition:leave.duration.400ms 
    >
          <div >
                <input 
                    type="text" 
                    class="form-control select2-search" 
                    placeholder="Search..."
                    wire:model.live="dsg_text"
                    
                >
    
                <ul class="select2-results animate__animated  animate__fadeIn" wire:loading.class.remove="animate__fadeIn" wire:target="dsg_text">
                    @foreach($designation_options as $option)
                    <li 
                        class = "select2-option" 
                        wire:key   ="user-{{ $option->id }}"
                        x-on:click = "
                          open=false;
                          $wire.$parent.select_designation({'id':{{$option->id}},'name':'{{$option->name}}'});
                        "
                        
                    >
                        {{ $option->name }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
</div>
