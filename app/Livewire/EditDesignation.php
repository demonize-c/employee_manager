<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Designation;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class EditDesignation extends Component
{

    // protected Designation $designation;

    public  string $name;
    public ?Designation $designation;

    public bool $display_error = false;

    public bool $loading = false;

    public function mount(Designation $designation) 
    {
        $this->designation = $designation;
        $this->name = $designation->name;
    }

    protected function rules()
    {
        return [
            'name' => [
                'required',
                 Rule::unique('designations','name')->ignore($this->designation)
            ],
        ];
    }

    public function update() 
    {
          
           try {
                $this->validate();
                $designation = $this->designation;
                $designation->name = $this->name;  
                $designation->save();
                $this->dispatch('on-update', success: true,  message: 'Designation updated successfully.');
           } catch (ValidationException $e) {
                $this->dispatch('on-update', success: false, message: 'Validation failure occurred.');
                throw $e;
           }
    }

    public function render()
    {
        return 
        view('livewire.edit-designation')
        ->extends('layouts.app');
    }
}
