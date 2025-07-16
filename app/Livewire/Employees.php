<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;

class Employees extends Component
{


    protected $listeners = ['delete-confirmed' => 'deleteConfirmed'];

    public bool $loading  = false;

    public bool $ready    = true;
    
    public function deleteConfirmed( $deleteableId  ){

        try{
          $employee = Employee::find( $deleteableId );
          
          if( !$employee ) {
              throw new \Exception("Employee not found.");
          }
          $employee->delete();
          $this->dispatch('on-delete', success: true, message: 'Employee deleted successfully.');

        }catch(\Exception $e){
            
            $this->dispatch('on-delete', success: false, message: $e->getMessage()?? 'Operation failed.');
        }
    }

    public function ready_reset()
    {
        $this->ready = false;

    }

    public function render()
    {
        
        return view('livewire.employees',[
            'employees' => Employee::paginate(10)
        ])->extends('layouts.app');
    }
}
