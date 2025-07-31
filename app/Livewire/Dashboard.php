<?php

namespace App\Livewire;

use Carbon\Carbon;

use Livewire\Component;
use Livewire\Attributes\Title;

use App\Models\Employee;
use App\Models\Designation;
use App\Models\Attendance;

#[Title('Dashboard')] 
class Dashboard extends Component
{
    public function render()
    {
        $total_employees    = Employee::count();
        $total_designations = Designation::count();
        $total_attendances  = Attendance::whereDate('date',Carbon::now())->count();
        return view('livewire.dashboard',compact('total_employees','total_designations','total_attendances'))->extends('layouts.app');
    }
}
