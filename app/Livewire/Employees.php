<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Designation;
use App\Models\Employee;


use Illuminate\Support\Str;
use Livewire\Attributes\Locked;

class Employees extends Component
{


    use WithPagination;
    
    public string $search_name  = '';

    public string $search_phone = '';

    public string  $search_dsg_id   = '';

    public string  $search_dsg_name = '';

    public string  $search_dsg_text = '';

    protected     $queryString = ['search_name', 'search_phone','search_dsg_id','search_dsg_name'];

    public bool   $open_desig = false;

    public        $designation_options;

    protected     $paginationTheme = 'bootstrap';

    // protected     $listeners = ['delete-confirmed' => 'deleteConfirmed'];

    //public bool    $loading  = true;

    public string  $loading_hash;

    public bool    $filter_applied = false;

    #[Locked] 
    public $old_hash;

    public string $new_hash = 'xx';

    public function mount(){
            $this->loading_hash = Str::random(10);
            //$this->update_designation_options();
            // $this->update_filter_flag();
            // $this->dispatch('on-load');
    }


    // public function get_designations(){
    //     return  
    //     Designation::where('name','like','%'.$this->search_dsg_text.'%')
    //     ->select('id','name')
    //     ->orderBy('name','asc')
    //     ->limit(5)
    //     ->get();
    // }

    // public function update_designation_options() {
    //     $this->designation_options = $this->get_designations();
    // }

    public function select_designation( $designation ){
       
        $this->search_dsg_id   = $designation['id'];
        $this->search_dsg_name = $designation['name'];
        //$this->reset_designation_search_input();
        $this->update_search();
    }

    public function clear_designation(){
       
        $this->search_dsg_id   = '';
        $this->search_dsg_name = '';
       // $this->reset_designation_search_input();
        $this->update_search();
    }

    // public function reset_designation_search_input() 
    // {
    //     $this->search_dsg_text = '';
    //     $this->update_designation_options();
    // }
    
    public function is_filter_applied() {
        if(
            !$this->search_name   && 
            !$this->search_phone  &&
            !$this->search_dsg_id &&
            !$this->search_dsg_name
        ){
            return false;
        }
        return true;
    }

    public function update_filter_flag() 
    {
        if( $this->is_filter_applied() ) {
          return $this->filter_applied = true;
        }
        return $this->filter_applied = false;
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

    public function update_search()
    {
        $this->update_filter_flag();
        $this->resetPage();
    }

    public function clear_search()
    {
        $this->search_phone    = '';
        $this->search_dsg_id   = '';
        $this->search_dsg_name = '';
        $this->search_name     = '';
        $this->update_filter_flag();
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
            $this->search_dsg_id &&
            $this->search_dsg_name
        )
        {
            $employees->where('designation_id',$this->search_dsg_id );
        }

        $employees = $employees->orderBy('id','desc')->paginate(5);
        
        return view('livewire.employees',[
            'employees' => $employees,
            'loading'   => $this->new_hash === 'xx' || $this->old_hash !== $this->new_hash
        ])->extends('layouts.app');
    }
}
