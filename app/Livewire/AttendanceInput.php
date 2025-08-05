<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Isolate;

use App\Models\Attendance;
use Carbon\Carbon;

#[Isolate]
class AttendanceInput extends Component
{


    use \App\Traits\DatabaseRestrictionHelper;
    
    public ?Attendance $attendance;

    public string $date;

    public int $employee_id;

    public string $type;

    public ?string $time;

    public ?bool $synced;

    public function mount( $date, $employee_id, $type ) {
        
        $this->date = $date;
        $this->employee_id = $employee_id;
        $this->type = $type;
    }

    public function load_data() {

        $attendance = Attendance::where('date', $this->date)->where('employee_id', $this->employee_id)->first();
        if( !$attendance ){
            $this->time   = '__:__ __';
            $this->synced = false;
            return;
        }
        if( !$attendance->{ $this->type } ) {
            $this->time   = '__:__ __';
            $this->synced = false;
            return;
        }
            
        $this->time = $attendance->{ $this->type };
        $this->synced = true;
         
    }
    

    public function save() {
          
          try {
            $attendance = Attendance::where('date', $this->date)
                            ->where('employee_id', $this->employee_id)
                            ->first();
            if( $attendance ) { 
               $check_in = $check_out = null;
               if($this->type === 'check_in' && $attendance->check_out ) {
                   $check_in  = Carbon::parse($attendance->date .' '. $this->time);
                   $check_out = Carbon::parse($attendance->date .' '. $attendance->check_out);
               }
               if($this->type === 'check_out' && $attendance->check_in) {
                  $check_in  = Carbon::parse($attendance->date .' '. $attendance->check_in );
                  $check_out = Carbon::parse($attendance->date .' '. $this->time);
               }
               if( $check_in && $check_out ) {
                   if( !$check_in->isBefore( $check_out ) ){
                        throw new \Exception('Invalid '. join(' ',explode('_',$this->type)).' time.');
                   }
               }
            }
                            
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

    public function delete() {
         
        try {
            $attendance = Attendance::where('date', $this->date)
                            ->where('employee_id', $this->employee_id)
                            ->first();
                            
            if( !$attendance ) {
                $this->notify( false, 'Attendance not found.');
                return;
            }

            $attendance->{$this->type}  = null;
            $attendance->save();
            if( 
               !$attendance->check_in && 
               !$attendance->check_out
            ){
                $attendance->delete();
            }

            $this->time   = null;
            $this->synced = false;
            $this->notify( true, 'Attendance deleted successfully' );

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
