<?php

namespace App\Livewire;

use Livewire\Component;

class ShowPosts extends Component
{

    public int $count=0;

    public function plus(){
        $this->count++;
    }
    
    public function render()
    {
        return view('livewire.show-posts');
    }
}
