<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Designation;

class Designations extends Component
{



    public function render()
    {
        return view('livewire.designations',[
            'designations' => Designation::paginate(10)
        ]);
    }
}
