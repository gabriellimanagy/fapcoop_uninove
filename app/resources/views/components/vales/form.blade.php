@props(['vale' => null, 'cooperados'])

<form method="POST" action="{{ $vale ? route('vales.update', $vale) : route('vales.store') }}" class="space-y-4 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
    @csrf
    @if ($vale) @method('PUT') @endif

    <!-- Título -->
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
        {{ $vale ? 'Editar Vale' : 'Novo Vale' }}
    </h2>

    <!-- Cooperado -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cooperado:</label>
        <livewire:select-search model="App\Models\Cooperado" name="cooperado_id" :selected="$vale ? $vale->cooperado_id : null" />
    </div>

    <!-- Valor -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Valor (R$):</label>
        <input type="number" name="valor" class="mt-1 block w-full border border-gray-300 dark:border-gray-700 rounded-md shadow-sm p-2 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200" step="0.01" required value="{{ $vale->valor ?? '' }}">
    </div>

    <!-- Descrição -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição:</label>
        <input type="text" name="descricao" class="mt-1 block w-full border border-gray-300 dark:border-gray-700 rounded-md shadow-sm p-2 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200" required value="{{ $vale->descricao ?? '' }}">
    </div>

    <!-- Datas -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data Solicitação:</label>
            <input type="date" name="data_solicitacao" class="mt-1 block w-full border border-gray-300 dark:border-gray-700 rounded-md shadow-sm p-2 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200" required value="{{ $vale->data_solicitacao ?? '' }}">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data Desconto:</label>
            <input type="date" name="data_desconto" class="mt-1 block w-full border border-gray-300 dark:border-gray-700 rounded-md shadow-sm p-2 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200" required value="{{ $vale->data_desconto ?? '' }}">
        </div>
    </div>

    <!-- Status -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status:</label>
        <select name="status" class="mt-1 block w-full border border-gray-300 dark:border-gray-700 rounded-md shadow-sm p-2 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
            @foreach(['pendente', 'aprovado', 'negado'] as $status)
                <option value="{{ $status }}" {{ ($vale && $vale->status == $status) ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Botão de envio -->
    <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700 transition">
            {{ $vale ? 'Atualizar' : 'Salvar' }}
        </button>
    </div>
</form>
