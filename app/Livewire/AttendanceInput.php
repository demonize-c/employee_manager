<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;

class AttendanceInput extends Component
{


    use \App\Traits\DatabaseRestrictionHelper;
    
    public ?Attendance $attendance;

    public string $date;

    public int $employee_id;

    public string $type;

    public string $time;

    public bool   $synced = false;

    public function mount( $date, $employee_id, $type ) {
        
        $this->date = $date;
        $this->employee_id = $employee_id;
        $this->type = $type;
    }

    public function load_data() {

        $attendance = Attendance::where('date', $this->date)->where('employee_id', $this->employee_id)->first();
        if( $attendance ){
            if( $attendance->{ $this->type } ) {
                $this->time = $attendance->{ $this->type };
                $this->synced = true;
            }
        }
    }
    

    public function save() {
          
          try {
             
            $attendance = Attendance::where('date', $this->date)
                            ->where('employee_id', $this->employee_id)
                            ->first();
                            
            if( !$attendance ) {

                $this->can_save( Attendance::class ); 

                $attendance = new Attendance;
                $attendance->date          = $this->date;
                $attendance->employee_id   = $this->employee_id;
            }

            $attendance->{$this->type} = $this->time;
            $attendance->save();
            $this->time   = $attendance->{ $this->type };
            $this->synced = true;
            $this->notify( true, 'Attendance saved successfully' );

          }catch(\Exception $e) {
               $this->notify( false, $e->getMessage()?? 'Error occured' );
          }
    }

    public function notify(bool $success, ?string $message) {
        $this->dispatch(
          'attendance' . '.' . $this->date. '.' . $this->employee_id,
           success: $success, 
           message: $message
        );
    }

    public function render()
    {
        return view('livewire.attendance-input');
    }
}
