<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

use App\Traits\Notifier;
use App\Models\Designation;
use App\Models\Employee;


#[Title('Designations')] 
class Designations extends Component
{


    use WithPagination;

    use Notifier;
    
    protected     $paginationTheme = 'bootstrap';

    protected     $queryString = ['search_name'];

    public string $search_name = '';

    public function mount()
    {
        
    }

    public function delete( $deleteableId  ){

        try{
          $designation = Designation::find( $deleteableId );
          
          if( !$designation ) {
              throw new \Exception("Designation not found.");
          }

          if( Employee::where('designation_id', $designation->id)->exists()) {
              throw new \Exception("Deletion is prohibited.");
          }

          $designation->delete();
          $this->notify( true, 'Designation deleted successfully.');

        }catch(\Exception $e){
           
            $this->notify( false, $e->getMessage()?? 'Operation failed.');
        }
    }

    public function updateSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $designations = Designation::query();

        if( $this->search_name){
            $designations->where('name','like','%'. $this->search_name .'%');
        }

        $designations = $designations->orderBy('id','desc')->paginate(5);

        return view('livewire.designations',[
            'designations' => $designations
        ])
        ->extends('layouts.app');
    }
    
}
