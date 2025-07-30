<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Models\Employee;

class CreateAttendance extends Component
{

    use WithPagination;
    
    protected     $paginationTheme = 'bootstrap';

    public int $year;

    public int $month;

    public int $week;

    public int $total_weeks;

    public  $periods;

    public $attendances = [];

    public function mount() {
        $this->year     = Carbon::now()->year;
        $this->month    = Carbon::now()->month;
        $this->week     = Carbon::now()->weekOfMonth;
        $this->updateAttendanceChart() ;
    }

    public function updateAttendanceChart() {
        $this->updateFilters();
        $this->updateDaysByWeek();
        $this->dispatch('init-time-picker');
    }

    public function updateFilters() {
        
        // $this->year     = $year??  Carbon::now()->year;
        // $this->month    = $month?? Carbon::now()->month;
        
        $this->total_weeks = $this->getTotalWeeks();
    }

    public function updateDaysByWeek() {
        
        $start_of_month = Carbon::createFromDate((int) $this->year, $this->month, 1)->startOfMonth();
        $end_of_month   = Carbon::createFromDate((int) $this->year, $this->month, 1)->endOfMonth();
        $diff_days      = $start_of_month->diffInDays( $end_of_month );
        
        $start_of_week =  $start_of_month->copy()->startOfWeek()->subDay();
        $end_of_week   =  $start_of_month->copy()->endOfWeek()->subDay();

        for ($i=0; $i < ($this->week - 1); $i++) { 
            $start_of_week->addWeek();
            $end_of_week->addWeek();
        }
        
        $periods       = CarbonPeriod::create( $start_of_week,'1 day',$end_of_week);

        $this->periods = [];

        foreach( $periods as $date){
            $this->periods[] = $date->format('Y-m-d');
        }
    }

    public function getTotalWeeks() {

        $start_of_month = Carbon::createFromDate((int) $this->year, $this->month, 1)->startOfMonth();
        $end_of_month   = Carbon::createFromDate((int) $this->year, $this->month, 1)->endOfMonth();
        return ceil($start_of_month->diffInWeeks($end_of_month));

    }

    // public function getAttendanceData(){
    //      $this->attendances[][]
    // }


    public function updatedPage($page)
    {
        // Runs after the page is updated for this component...
        $this->dispatch('init-time-picker');
    }

    public function render()
    {
        $employees = Employee::paginate(2);
        return view('livewire.create-attendance',compact('employees'))->extends('layouts.app');
    }
}
