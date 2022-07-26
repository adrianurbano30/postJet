<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Publicacion;

class Perfil extends Component
{
    public $usuario;

    public $aux_imgs=0;

    public function mount(){
        $this->usuario=Auth::user();
    }

    public function cant_imagenes($imagen){
        return  count($imagen);
    }

    public function cantidad_caracteres($texto){
        return strlen($texto);
    }

    public function render()
    {
        return view('livewire.perfil',[
            'publicaciones'=> Publicacion::select('*')->where('user_id',$this->usuario->id)->orderBy('created_at','desc')->get()
        ])
        ->layout(\App\View\Components\AppLayout::class)
        ->slot('slot');
    }
}
