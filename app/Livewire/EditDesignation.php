<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

use App\Traits\Notifier;
use App\Models\Designation;

use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

#[Title('Edit Designation')] 
class EditDesignation extends Component
{

    // protected Designation $designation;

    use Notifier;

    public  string $name;
    public ?Designation $designation;

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
                $this->notify( true, 'Designation updated successfully.');
           } catch (ValidationException $e) {
                $this->notify( false, 'Validation failure occurred.');
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
