<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Designation;
use Illuminate\Validation\Rule;

class EditDesignation extends Component
{

    // protected Designation $designation;

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
           $this->validate();
           $designation = $this->designation;
           $designation->name = $this->pull('name');  
           $designation->save();
           return redirect()->route('designations.index');
    }

    public function render()
    {
        return 
        view('livewire.edit-designation')
        ->extends('layouts.app');
    }
}
