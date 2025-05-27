<?php

namespace App\Livewire;

use App\Models\Funcao;
use Livewire\Component;

class FuncaoManager extends Component
{
    public $nome;
    public $descricao;
    public $ativo = true;
    public $funcao_id;
    public $isOpen = false;
    public $editing = false;

    protected $listeners = [
        'childMethod' => 'testMethod',
    ];

    protected $rules = [
        'nome' => 'required|string|max:255|unique:funcoes,nome'
    ];

    public function render()
    {
        $funcoes = Funcao::orderBy('nome')->get();
        return view('livewire.funcao-manager', compact('funcoes'));
    }

    public function createNewFunction()
    {
        return redirect()->route('funcoes.create');
    }

    public function storeNewFunction()
    {
        $this->validate();
        Funcao::create([
            'nome'  => $this->nome,
            'ativo' => true,
        ]);
        session()->flash('message', 'Função criada com sucesso!');
        $this->closeModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->nome = '';
        $this->descricao = '';
        $this->ativo = true;
        $this->funcao_id = null;
    }

    // Método de teste para o listener
    public function testMethod()
    {
        session()->flash('message', 'Test method worked!');
    }
}
