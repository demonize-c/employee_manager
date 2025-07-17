<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Designation;

use App\Models\Employee;


use Illuminate\Support\Str;

class Designations extends Component
{


    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    protected   $queryString = ['search_name'];

    public bool   $loading = true;

    public string $loading_hash = '';

    public string $search_name = '';

    public function mount()
    {
        $this->loading_hash = Str::random(10);
        $this->dispatch('on-load');
    }

    public function delete_confirmed( $deleteableId  ){

        try{
          $designation = Designation::find( $deleteableId );
          
          if( !$designation ) {
              throw new \Exception("Designation not found.");
          }

          if( Employee::where('designation_id', $designation->id)->exists()) {
              throw new \Exception("Deletion is prohibited.");
          }

          $designation->delete();
          $this->dispatch('on-delete', success: true, message: 'Designation deleted successfully.');

        }catch(\Exception $e){
            
            $this->dispatch('on-delete', success: false, message: $e->getMessage()?? 'Operation failed.');
        }
    }

    public function update_search()
    {
        $this->resetPage();
    }

    public function updatingPage($page)
    {
        $this->loading = true;
    }
 
    public function updatedPage($page)
    {
       $this->dispatch('on-load');// This will run on every search and on paginate
    }

    public function render()
    {
        $designations = Designation::query();

        if( $this->search_name){
            $designations->where('name','like','%'. $this->search_name .'%');
        }

        $designations = $designations->paginate(5);

        return view('livewire.designations',[
            'designations' => $designations
        ])
        ->extends('layouts.app');
    }
}
