<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Designation;
use App\Models\Employee;


use Illuminate\Support\Str;

class Employees extends Component
{


    use WithPagination;
    
    public string $search_name  = '';

    public string $search_phone = '';

    public array  $search_desig = [];

    public string $search_desig_name = '';

    protected   $queryString = ['search_name', 'search_phone','search_desig.id'];

    public bool $open_desig = false;

    public    $designation_options;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['delete-confirmed' => 'deleteConfirmed'];

    public bool $loading  = true;

    public string $loading_hash = '';

    public function mount(){
            $this->loading_hash = Str::random(10);
            $this->update_designation_options();
            $this->dispatch('on-load');
    }


    public function get_designations(){
        return  
        Designation::where('name','like','%'.$this->search_desig_name.'%')
        ->select('id','name')
        ->orderBy('name','asc')
        ->limit(10)
        ->get();
    }

    public function update_designation_options() {
        $this->designation_options = $this->get_designations();
    }

    public function select_designation( $designation ){
       
        $this->search_desig = $designation;
        $this->reset_designation_search_input();
        $this->resetPage();
    }

    public function clear_designation(){
       
        $this->search_desig = [];
        $this->reset_designation_search_input();
        $this->resetPage();
    }

    public function reset_designation_search_input() 
    {
        $this->search_desig_name = '';
        $this->update_designation_options();
    }
    
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

    public function updatingPage($page)
    {
        $this->loading = true;
    }
 
    public function updatedPage($page)
    {
       $this->dispatch('on-load');// This will run on every search and on paginate
    }

    public function update_search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $employees = Employee::query();
        
        if( $this->search_name){
            $employees->where('name','like','%'. $this->search_name .'%');
        }

        if( $this->search_phone){
            $employees->where('phone','like','%'. $this->search_phone .'%');
        }

        if( 
            isset($this->search_desig['name']) &&
            isset($this->search_desig['id'])
        )
        {
            $employees->where('designation_id',$this->search_desig['id']);
        }

        $employees = $employees->orderBy('id','desc')->paginate(2);

        
        
        return view('livewire.employees',[
            'employees' => $employees
        ])->extends('layouts.app');
    }
}
