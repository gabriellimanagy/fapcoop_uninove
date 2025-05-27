<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Cooperado;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class CooperadoSearch extends Component
{
    use WithPagination;

    public $search_id = '';
    public $search_cpf = '';
    public $search_nome = '';
    public $search_zona = '';
    public $order_by = 'id';
    public $status = 'todos';
    public $dt_servico = '';
    public $disponibilidade = false;

    protected $queryString = [
        'search_id' => ['except' => '', 'as' => 'id'],
        'search_cpf' => ['except' => '', 'as' => 'cpf'],
        'search_nome' => ['except' => '', 'as' => 'nome'],
        'search_zona' => ['except' => '', 'as' => 'zona'],
        'order_by' => ['except' => 'id', 'as' => 'ordem'],
        'status' => ['except' => 'todos'],
        'dt_servico' => ['except' => '', 'as' => 'data'],
        'disponibilidade' => ['except' => false, 'as' => 'disp'],
    ];

    public function updatedSearchCpf($value)
    {
        $this->search_cpf = preg_replace('/[^0-9]/', '', $value);
    }

    public function render()
    {
        $cooperados = $this->getCooperadosQuery()->paginate(10);

        return view('livewire.cooperado-search', [
            'cooperados' => $cooperados,
        ]);
    }

    private function getCooperadosQuery(): Builder
    {
        $query = Cooperado::with(['contato', 'dadosPessoais', 'documentos', 'financeiro', 'disponibilidade'])
            ->select('cooperados.*');

        $this->applyFilters($query);
        $this->applySorting($query);

        return $query;
    }

    private function applyFilters(Builder $query): void
    {
        $query->when($this->search_id, fn($q) => $q->where('id', $this->search_id))
              ->when($this->search_cpf, fn($q) => $q->whereHas('documentos', fn($q) =>
                  $q->whereRaw("REPLACE(REPLACE(cpf, '.', ''), '-', '') LIKE ?", ["%{$this->search_cpf}%"])))
              ->when($this->search_nome, fn($q) => $q->where('nome', 'like', "%{$this->search_nome}%"))
              ->when($this->search_zona, fn($q) => $q->whereHas('contato', fn($q) =>
                  $q->where('zona', $this->search_zona)))
              ->when($this->status !== 'todos', fn($q) => $q->where('status', $this->status)) // Corrigido
              ->when($this->dt_servico, fn($q) => $q->whereDate('dt_servico', $this->dt_servico))
              ->when($this->disponibilidade, fn($q) => $q->whereHas('disponibilidade', fn($q) =>
                  $q->whereIn('id', function ($subQuery) {
                      $subQuery->select('cooperado_id')
                          ->from('disponibilidade')
                          ->where(1)
                          ->where(function ($q) {
                              $days = ['segunda_feira', 'terca_feira', 'quarta_feira',
                                     'quinta_feira', 'sexta_feira', 'sabado', 'domingo'];
                              foreach ($days as $day) {
                                  $q->orWhere($day, 1);
                              }
                          });
                  })));
    }

    private function applySorting(Builder $query): void
    {
        if ($this->order_by === 'zona') {
            $query->leftJoin('cooperado_contatos', 'cooperados.id', '=', 'cooperado_contatos.cooperado_id')
                  ->orderBy('cooperado_contatos.zona');
        } else {
            $query->orderBy("cooperados.{$this->order_by}");
        }
    }

    public function updating($property)
    {
        if (in_array($property, array_keys($this->queryString))) {
            $this->resetPage();
        }
    }
}
