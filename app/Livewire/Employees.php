<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;

class Employees extends Component
{


    public function render()
    {
        return view('livewire.employees',[
            'employees' => Employee::paginate(10)
        ])->extends('layouts.app');
    }
}
