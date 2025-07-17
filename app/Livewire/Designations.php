<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Designation;
use Livewire\WithPagination;


class Designations extends Component
{


    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.designations',[
            'designations' => Designation::paginate(5)
        ])
        ->extends('layouts.app');
    }
}
