<div class="space-y-8">
    <!-- Filtros Gerais -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <div>
            <label for="order_by" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Ordenar Por') }}</label>
            <select wire:model.live="order_by" id="order_by" aria-label="{{ __('Ordenar Por') }}"
                    class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100 transition-all">
                <option value="id">{{ __('ID') }}</option>
                <option value="nome">{{ __('Nome') }}</option>
                <option value="zona">{{ __('Zona') }}</option>
            </select>
        </div>
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Status') }}</label>
            <select wire:model.live="status" id="status" aria-label="{{ __('Status') }}"
                    class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100 transition-all">
                <option value="todos">{{ __('Todos') }}</option>
                <option value="Ativo">{{ __('Ativo') }}</option>
                <option value="Inativo">{{ __('Inativo') }}</option>
            </select>
        </div>
        <div>
            <label for="dt_servico" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Dt. Serviço') }}</label>
            <input wire:model.live="dt_servico" type="date" id="dt_servico" aria-label="{{ __('Dt. Serviço') }}"
                   class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100 transition-all">
        </div>
        <div class="flex items-center pt-6">
            <input wire:model.live="disponibilidade" type="checkbox" id="disponibilidade" aria-label="{{ __('Disponíveis para Escala') }}"
                   class="h-5 w-5 text-indigo-600 focus:ring-indigo-600 border-gray-300 rounded dark:bg-gray-800 dark:border-gray-600">
            <label for="disponibilidade" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-200">
                {{ __('Disponíveis para Escala') }}
            </label>
        </div>
    </div>

    <!-- Campos de Pesquisa -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <div>
            <label for="search_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Localizar por ID') }}</label>
            <input wire:model.live="search_id" id="search_id" placeholder="{{ __('Digite o ID') }}"
                   class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100 transition-all">
        </div>
        <div>
            <label for="search_cpf" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Localizar por CPF') }}</label>
            <input wire:model.live="search_cpf" id="search_cpf" placeholder="{{ __('Digite o CPF') }}"
                   class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100 transition-all">
        </div>
        <div>
            <label for="search_nome" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Localizar por Nome') }}</label>
            <input wire:model.live="search_nome" id="search_nome" placeholder="{{ __('Digite o nome parcial') }}"
                   class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100 transition-all">
        </div>
        <div>
            <label for="search_zona" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Localizar por Zona') }}</label>
            <select wire:model.live="search_zona" id="search_zona" aria-label="{{ __('Localizar por Zona') }}"
                    class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100 transition-all">
                <option value="">{{ __('Selecione a Zona') }}</option>
                @foreach(['Sul', 'Norte', 'Leste', 'Oeste'] as $zona)
                    <option value="{{ $zona }}">{{ $zona }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-lg rounded-xl">
        <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-4">{{ __('ID') }}</th>
                    <th scope="col" class="px-6 py-4">{{ __('Nome') }}</th>
                    <th scope="col" class="px-6 py-4">{{ __('Zona') }}</th>
                    <th scope="col" class="px-6 py-4">{{ __('Celular') }}</th>
                    <th scope="col" class="px-6 py-4">{{ __('WhatsApp') }}</th>
                    <th scope="col" class="px-6 py-4">{{ __('Ações') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cooperados as $cooperado)
                    <tr wire:key="cooperado-{{ $cooperado->id }}"
                        class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4">{{ $cooperado->id }}</td>
                        <td class="px-6 py-4">{{ $cooperado->nome }}</td>
                        <td class="px-6 py-4">{{ $cooperado->contato->zona ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $cooperado->contato->celular ?? '-' }}</td>
                        <td class="px-6 py-4 flex items-center space-x-3">
                            @if ($cooperado->contato->whatsapp ?? false)
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                @php
                                    $firstName = ucfirst(strtolower(explode(' ', $cooperado->nome)[0]));
                                    $phoneNumber = '+55' . preg_replace('/[^0-9]/', '', $cooperado->contato->celular);
                                    $message = "Olá%20{$firstName},%20tudo%20bem?";
                                @endphp
                                <a href="https://wa.me/{{ $phoneNumber }}?text={{ $message }}"
                                   target="_blank"
                                   class="flex items-center space-x-2 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.134.56 4.14 1.53 5.894L0 24l6.234-1.53A11.95 11.95 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22.001c-1.92 0-3.69-.497-5.24-1.34l-.37-.22-3.698.91.91-3.698-.22-.37A9.95 9.95 0 012 12c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10zm5.618-5.668c-.31-.155-1.834-.91-2.12-.998-.287-.088-.497-.087-.708.088-.21.175-.81.998-.998 1.208-.187.21-.374.234-.684.079-.31-.155-1.31-.483-2.497-1.54-1.184-1.057-1.987-2.36-2.22-2.67-.234-.31-.024-.48.14-.635.155-.155.31-.364.467-.56.155-.197.21-.31.31-.52.1-.21.05-.39-.024-.54-.075-.15-.684-1.64-.937-2.24-.252-.6-.497-.5-.684-.5-.187 0-.398-.012-.608-.012s-.56.075-.85.374c-.287.3-1.11 1.084-1.11 2.64s1.135 3.064 1.295 3.274c.16.21 2.24 3.414 5.43 4.79 3.19 1.376 3.19.91 3.77.85.58-.06 1.834-.747 2.094-1.47.26-.723.26-1.346.187-1.47-.075-.124-.287-.197-.597-.352z"/>
                                    </svg>
                                    <span class="text-sm font-medium">{{ __('Enviar mensagem') }}</span>
                                </a>
                            @else
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            @endif
                        </td>
                        <td class="px-6 py-4 space-x-3">
                            <a href="{{ route('cooperados.show', $cooperado->id) }}"
                               class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-500 font-medium">
                                {{ __('Ver') }}
                            </a>
                            @if(auth()->user()->permissoes->contains('nome', 'cooperado_btn_edit'))

                                <a href="{{ route('cooperados.edit', $cooperado->id) }}"
                                class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-500 font-medium">
                                    {{ __('Editar') }}
                                </a>
                            @endif
                            @if(auth()->user()->permissoes->contains('nome', 'cooperado_btn_delete'))
                            <form action="{{ route('cooperados.destroy', $cooperado->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('{{ __('Tem certeza que deseja deletar?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-500 font-medium">
                                    {{ __('Deletar') }}
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                            {{ __('Nenhum cooperado encontrado.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Loading Overlay -->
        <div wire:loading
             class="absolute inset-0 flex items-center justify-center bg-gray-100 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75 transition-opacity">
            <span class="text-gray-700 dark:text-gray-200 font-medium animate-pulse">{{ __('Carregando...') }}</span>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $cooperados->links() }}
    </div>
</div>
