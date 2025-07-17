<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Designation;
use Illuminate\Validation\ValidationException;

class CreateDesignation extends Component
{

    public string $name = '';

    public bool $display_error = false;

    public bool $loading = false;

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
        try {
            $this->validate();
            $designation   = new Designation;
            $designation->name = $this->name;  
            $designation->save();
            $this->dispatch('on-save', success: true,  message: 'Designation saved successfully.');
       } catch (ValidationException $e) {
            $this->dispatch('on-save', success: false, message: 'Validation failure occurred.');
            throw $e;
       }
    }

    public function render()
    {
        
        return 
        view('livewire.create-designation')
        ->extends('layouts.app');
    }
}
