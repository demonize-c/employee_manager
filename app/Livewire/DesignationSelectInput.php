<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;

use App\Models\Designation;

class DesignationSelectInput extends Component
{

    #[Reactive] 
    public string $dsg_id;

    #[Reactive] 
    public string $dsg_name;

    public string $dsg_text = '';

    public function render()
    {
        $designations = Designation::where('name','like','%'.$this->dsg_text.'%')
        ->select('id','name')
        ->orderBy('name','asc')
        ->limit(5)
        ->get();

        return view('livewire.designation-select-input',[
            'designation_options' => $designations
        ]);
    }
}
