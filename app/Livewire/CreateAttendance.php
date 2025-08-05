<?php

namespace App\Livewire;

use Illuminate\Validation\ValidationException;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Models\Employee;
use Livewire\Attributes\Validate;


#[Title('Attendances')] 
class CreateAttendance extends Component
{

    use WithPagination;
    
    protected     $paginationTheme = 'bootstrap';

    #[Validate('required|numeric|gte:2000|lte:3000')]
    public int $year;

    #[Validate('required|numeric|gte:0|lte:12')]
    public int $month;

    #[Validate('required|numeric|gte:1|lte:6')]
    public int $week;

    public int $total_weeks;

    public  $periods;

    public $attendances = [];

    public string $search = '';

    public function mount() {
        $this->year     = Carbon::now()->year;
        $this->month    = Carbon::now()->month;
        $this->week     = Carbon::now()->weekOfMonth;
        $this->updateAttendanceChart() ;
    }

    // protected $rules = [
    //     'year'  => 'required|max:4',
    //     'month' => 'required|between:1,12',
    // ];
 
    // public function updatingYear( $name, $value )
    // {
    //     // $this->validateOnly('year');
    //     // dd();
    // }

    public function updateAttendanceChart() {
        $this->validate();
        // $this->validateOnly('year',[]);
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

        if( $this->week > $this->total_weeks ) {
            $this->week = $this->total_weeks;
        }

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

        $date  = Carbon::createFromDate((int) $this->year, $this->month, 1)->startOfMonth();
        // $end_of_month   = Carbon::createFromDate((int) $this->year, $this->month, 1)->endOfMonth();
        $total_week = 0;

        if( !$date->isSunday() ) {
            $total_week++;
        }
        $iter_count = Carbon::now()->month( $this->month )->daysInMonth;
        for ( $i=0; $i < ($iter_count - 1); $i++) { 

            // $date = Carbon::createFromDate((int) $this->year, $this->month, $i);
            $date->addDay();
            if( $date->isSunday() ) {
                $total_week++;
            }
        }
        return $total_week;
        // return ceil($start_of_month->diffInWeeks($end_of_month));

    }

    public function updateSearch() {
        
        $this->resetPage();
    }


    // public function updatedPage($page)
    // {
    //     // Runs after the page is updated for this component...
    //     $this->dispatch('init-time-picker');
    // }

    public function render()
    {
        $employees = Employee::query();
        
        if( $this->search ){
             
            $employees->whereLike('name', '%'. $this->search.'%');

            $employees->orWhereLike('email','%'. $this->search.'%');

            $employees->orWhereLike('phone','%'. $this->search.'%');

            $employees->orWhereHas('designation',function ($query)  {
                
                $query->whereLike('name','%'. $this->search.'%');
            });
        }

        $employees = $employees->orderBy('id','desc')->paginate(10);

        return view('livewire.create-attendance',compact('employees'))->extends('layouts.app');
    }
}
