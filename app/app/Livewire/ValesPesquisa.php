<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vale;

class ValesPesquisa extends Component
{
    public $search = ''; // Variável para armazenar o termo de pesquisa

    // Função para renderizar a pesquisa
    public function render()
    {
        $vales = Vale::query()
            ->where('descricao', 'like', "%{$this->search}%")
            ->orWhereHas('cooperado', function ($query) {
                $query->where('nome', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'desc')  // Ordena por ID de forma decrescente
            ->paginate(10); // Paginação dos resultados

        return view('livewire.vales-pesquisa', compact('vales'));
    }

    // Função que será chamada pelo botão de busca
    public function buscar()
    {
        // Aqui você pode incluir outras ações que quer realizar quando o botão de busca for clicado
        $this->render(); // Chama a renderização novamente, realizando a pesquisa
    }
}
