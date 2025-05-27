<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
    <!-- Campo de pesquisa com o botão de buscar -->
    <div class="mb-4 flex space-x-4">
        <input 
            type="text" 
            wire:model="search" 
            wire:keydown.enter="buscar" placeholder="Pesquisar por descrição ou cooperado..." 
            class="px-4 py-2 border border-gray-300 rounded-md w-full"
        />
        <button 
            wire:click="buscar" 
            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700"
        >
            Buscar
        </button>
    </div>

    <!-- Tabela de Vales -->
    <table class="min-w-full table-auto">
        <thead>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <th class="px-4 py-2 text-sm font-medium text-left text-gray-500 dark:text-gray-200">{{ __('ID') }}</th>
                <th class="px-4 py-2 text-sm font-medium text-left text-gray-500 dark:text-gray-200">{{ __('Status') }}</th>
                <th class="px-4 py-2 text-sm font-medium text-left text-gray-500 dark:text-gray-200">{{ __('Valor') }}</th>
                <th class="px-4 py-2 text-sm font-medium text-left text-gray-500 dark:text-gray-200">{{ __('Descrição') }}</th>
                <th class="px-4 py-2 text-sm font-medium text-left text-gray-500 dark:text-gray-200">{{ __('Nome do Cooperado') }}</th>
                <th class="px-4 py-2 text-sm font-medium text-left text-gray-500 dark:text-gray-200">{{ __('Data de Solicitação') }}</th>
                <th class="px-4 py-2 text-sm font-medium text-left text-gray-500 dark:text-gray-200">{{ __('Data de Desconto') }}</th>
                <th class="px-4 py-2 text-sm font-medium text-left text-gray-500 dark:text-gray-200">{{ __('Ações') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vales as $vale)
                <tr class="border-b dark:border-gray-700">
                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $vale->id }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ ucfirst($vale->status) }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ number_format($vale->valor, 2, ',', '.') }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $vale->descricao }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $vale->cooperado->nome ?? 'N/A' }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($vale->data_solicitacao)->format('d/m/Y') }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($vale->data_desconto)->format('d/m/Y') }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">
                        <a href="{{ route('vales.edit', $vale->id) }}" class="text-blue-500 hover:text-blue-700">{{ __('Editar') }}</a>
                        <form action="{{ route('vales.destroy', $vale->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">{{ __('Excluir') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="mt-4">
        {{ $vales->links() }} <!-- Paginação do Livewire -->
    </div>
</div>
