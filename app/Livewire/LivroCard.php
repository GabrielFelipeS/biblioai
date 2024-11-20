<?php

namespace App\Livewire;

use App\Models\Livro;
use Livewire\Attributes\On;
use Livewire\Component;

class LivroCard extends Component
{
    public $livros;

    // similar aos construtores das classe do PHP
    public function mount(){
        $this->livros = Livro::all();
    }

    #[On('livros-buscados')]
    public function atualizarLista($livros)
    {
        $this->livros = $livros;
    }

    public function render()
    {
        return view('livewire.livro-card');
    }
}
