<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Nivel;

class Practica extends Component
{
    public $idpractica;
    public $titulo;
    public $maximo=5;

    public function mount($idpractica)
    {
        $this->idpractica = $idpractica;
        $this->titulo = 'Sin título';
    }
    
    public function render()
    {
        $niveles = Nivel::get();

        return view('livewire.practica',[
            'niveles'=>$niveles
        ]);
    }
}
