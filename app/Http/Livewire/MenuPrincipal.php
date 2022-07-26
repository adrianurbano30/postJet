<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MenuPrincipal extends Component
{

    public $suario;

    public function mount(){
        $this->usuario=Auth::user();
    }

    public function render()
    {
        return view('livewire.menu-principal');
    }
}
