<?php

namespace App\Livewire;

use Livewire\Component;

class SelectSearch extends Component
{
    public $model;
    public $name;
    public $selected = null;
    public $options = [];
    public $displayField;

    public function mount($model, $name, $selected = null, $displayField = 'nome')
    {
        $this->model = $model;
        $this->name = $name;
        $this->selected = $selected;
        $this->displayField = $displayField;
        $this->loadOptions();
    }

    public function loadOptions($customOptions = null)
    {
        if ($customOptions !== null) {
            $this->options = collect($customOptions)->pluck('nome', 'id')->toArray();
        } else {
            $this->options = app($this->model)::all(['id', $this->displayField])
                ->pluck($this->displayField, 'id')
                ->toArray();
        }
    }

    public function updatedSelected($value)
    {
        $this->selected = $value;
        // Usa $this->dispatch() em vez de dispatchBrowserEvent no Livewire v3
        $this->dispatch('selection-changed', name: $this->name, value: $value);
    }

    public function render()
    {
        return view('livewire.select-search');
    }
}