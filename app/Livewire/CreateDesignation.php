<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

use App\Models\Designation;
use App\Traits\Notifier;
use Illuminate\Validation\ValidationException;

#[Title('Create Designation')] 
class CreateDesignation extends Component
{

    use Notifier;

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
        try {
            $this->validate();
            $designation   = new Designation;
            $designation->name = $this->name;  
            $designation->save();
            $this->notify( true, 'Designation saved successfully.' );
       } catch (ValidationException $e) {
        
            $this->notify( false, 'Validation failure occurred.' );
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
