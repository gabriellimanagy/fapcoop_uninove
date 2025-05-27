<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Funcao;
use App\Models\Setor;
use Livewire\Component;

class ClienteFuncaoManager extends Component
{
    public $cliente_id;
    public $funcao_id;
    public $setor_id;
    public $setor_nome; // Para armazenar o nome do setor ao criar um novo setor
    public $valor_hora_repasse = 0;
    public $valor_hora_extra_repasse = 0;
    public $valor_hora_faturamento = 0;
    public $valor_hora_extra_faturamento = 0;
    public $qtd_horas_trabalhadas = 0;
    public $isOpen = false;
    public $editing = false;
    public $confirmingDelete = false;
    public $deleteId;
    public $showNewFunctionModal = false;
    public $newFunctionName;
    public $newFunctionDescription;

    protected function rules()
    {
        return [
            'funcao_id' => 'required|exists:funcoes,id',
            'valor_hora_repasse' => 'required|numeric|min:0',
            'valor_hora_extra_repasse' => 'required|numeric|min:0',
            'valor_hora_faturamento' => 'required|numeric|min:0',
            'valor_hora_extra_faturamento' => 'required|numeric|min:0',
            'qtd_horas_trabalhadas' => 'required|integer|min:0',
            'setor_nome' => 'required|string|max:255',
        ];
    }

    public function mount($cliente)
    {
        $this->cliente_id = $cliente;
    }

    public function createNewFunction()
    {
        $this->openNewFunctionModal();
    }

    public function render()
    {
        $cliente = Cliente::with(['funcoes', 'setores'])->findOrFail($this->cliente_id);
        $funcoesDisponiveis = Funcao::where('ativo', true)
                                ->whereNotIn('id', $cliente->funcoes->pluck('id'))
                                ->get();
        $todasFuncoes = Funcao::all();

        return view('livewire.cliente-funcao-manager', [
            'cliente' => $cliente,
            'funcoesDisponiveis' => $funcoesDisponiveis,
            'todasFuncoes' => $todasFuncoes,
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->editing = false;
        $this->openModal();
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

    public function store()
    {
        $cliente = Cliente::findOrFail($this->cliente_id);

        if ($this->editing) {
            $cliente->funcoes()->updateExistingPivot($this->funcao_id, [
                'valor_hora_repasse' => $this->valor_hora_repasse,
                'valor_hora_extra_repasse' => $this->valor_hora_extra_repasse,
                'valor_hora_faturamento' => $this->valor_hora_faturamento,
                'valor_hora_extra_faturamento' => $this->valor_hora_extra_faturamento,
                'qtd_horas_trabalhadas' => $this->qtd_horas_trabalhadas,
            ]);

            session()->flash('message', 'Valores da função atualizados com sucesso!');
        } else {
            $cliente->funcoes()->attach($this->funcao_id, [
                'valor_hora_repasse' => $this->valor_hora_repasse,
                'valor_hora_extra_repasse' => $this->valor_hora_extra_repasse,
                'valor_hora_faturamento' => $this->valor_hora_faturamento,
                'valor_hora_extra_faturamento' => $this->valor_hora_extra_faturamento,
                'qtd_horas_trabalhadas' => $this->qtd_horas_trabalhadas,
            ]);

            session()->flash('message', 'Função atribuída com sucesso!');
        }

        $this->closeModal();
    }

    public function edit($funcaoId)
    {
        $this->editing = true;
        $this->funcao_id = $funcaoId;

        $cliente = Cliente::findOrFail($this->cliente_id);
        $pivot = $cliente->funcoes()->where('funcao_id', $funcaoId)->first()->pivot;

        $this->valor_hora_repasse = $pivot->valor_hora_repasse;
        $this->valor_hora_extra_repasse = $pivot->valor_hora_extra_repasse;
        $this->valor_hora_faturamento = $pivot->valor_hora_faturamento;
        $this->valor_hora_extra_faturamento = $pivot->valor_hora_extra_faturamento;
        $this->qtd_horas_trabalhadas = $pivot->qtd_horas_trabalhadas;

        $this->openModal();
    }

    public function confirmDelete($funcaoId)
    {
        $this->confirmingDelete = true;
        $this->deleteId = $funcaoId;
    }

    public function delete()
    {
        $cliente = Cliente::findOrFail($this->cliente_id);
        $cliente->funcoes()->detach($this->deleteId);

        session()->flash('message', 'Função removida com sucesso!');
        $this->confirmingDelete = false;
    }

    private function resetInputFields()
    {
        if (!$this->editing) {
            $this->funcao_id = '';
        }

        $this->valor_hora_repasse = 0;
        $this->valor_hora_extra_repasse = 0;
        $this->valor_hora_faturamento = 0;
        $this->valor_hora_extra_faturamento = 0;
        $this->qtd_horas_trabalhadas = 0;
    }

    public function openNewFunctionModal()
    {
        $this->resetNewFunctionFields();
        $this->showNewFunctionModal = true;
    }

    public function closeNewFunctionModal()
    {
        $this->showNewFunctionModal = false;
    }

    public function removeSetor($setorId)
    {
        $cliente = Cliente::findOrFail($this->cliente_id);
        $cliente->setores()->detach($setorId);

        session()->flash('message', 'Setor removido com sucesso!');
    }

    public function createSetor()
    {
        $this->validate([
            'setor_nome' => 'required|string|max:255',
        ]);

        $cliente = Cliente::findOrFail($this->cliente_id);
        $setor = $cliente->setores()->create(['nome' => $this->setor_nome]);

        session()->flash('message', 'Setor criado e associado ao cliente com sucesso!');
        $this->setor_nome = null;
    }

    public function storeNewFunction()
    {
        $this->validate([
            'newFunctionName' => 'required|string|max:255|unique:funcoes,nome',
            'newFunctionDescription' => 'nullable|string',
        ]);

        Funcao::create([
            'nome' => $this->newFunctionName,
        ]);

        session()->flash('message', 'Nova função criada com sucesso!');
        $this->closeNewFunctionModal();
    }

    private function resetNewFunctionFields()
    {
        $this->newFunctionName = '';
        $this->newFunctionDescription = '';
    }
}
