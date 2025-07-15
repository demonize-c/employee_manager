<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Designation;

class CreateDesignation extends Component
{

    public string $name = '';

    protected function rules()
    {
        return [
            'name' => [
                'required'
            ],
        ];
    }
    public function save() 
    {
           $this->validate();
           $designation   = new Designation;
           $designation->name = $this->pull('name');  
           $designation->save();
           return redirect()->route('designations.index');
    }

    public function render()
    {
        
        return 
        view('livewire.create-designation')
        ->extends('layouts.app');
    }
}
