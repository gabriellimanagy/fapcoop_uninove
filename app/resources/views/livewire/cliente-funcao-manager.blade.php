<!-- filepath: c:\Users\caiol\Desktop\Github\fapcoop\app\resources\views\livewire\cliente-funcao-manager.blade.php -->
<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between mb-6">
                        <h3 class="text-lg font-semibold">Funções do Cliente: {{ $cliente->fantasia }}</h3>

                        <div class="space-x-2 flex">
                            <!-- Button to create new function -->
                            @if(auth()->user()->permissoes->contains('nome', 'cliente_btn_create_funcao'))
                                <button wire:click="createNewFunction" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Criar Nova Função
                                </button>
                            @endif
                            <!-- Existing button for adding function to client -->
                            @if(auth()->user()->permissoes->contains('nome', 'cliente_btn_add_funcao'))
                                <button wire:click="create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Adicionar Função
                                </button>
                            @endif
                        </div>
                    </div>

                    @if (session()->has('message'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('message') }}
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Função</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hora (Repasse)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hora Extra (Repasse)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hora (Faturamento)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hora Extra (Faturamento)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Horas Trabalhadas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($cliente->funcoes as $funcao)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $funcao->nome }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">R$ {{ number_format($funcao->pivot->valor_hora_repasse, 2, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">R$ {{ number_format($funcao->pivot->valor_hora_extra_repasse, 2, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">R$ {{ number_format($funcao->pivot->valor_hora_faturamento, 2, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">R$ {{ number_format($funcao->pivot->valor_hora_extra_faturamento, 2, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $funcao->pivot->qtd_horas_trabalhadas }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button wire:click="edit({{ $funcao->id }})" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-600">
                                            Editar
                                        </button>
                                        @if(auth()->user()->permissoes->contains('nome', 'cliente_btn_remove_funcao'))
                                            <button wire:click="confirmDelete({{ $funcao->id }})" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-600 ml-4">
                                                Remover
                                            </button>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                        Este cliente não possui funções atribuídas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Nova seção para listar todas as funções cadastradas -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Todas as Funções Cadastradas</h3>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nome</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($todasFuncoes as $funcao)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $funcao->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $funcao->nome }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <hr>
                    <hr>
                    <hr>
                    <hr> <hr>
                    <hr>
                    <hr>
                    <hr> <hr>
                    <hr>
                    <hr>
                    <hr>
                </div>
                  <!-- Nova seção para Gerenciar Setores -->
       <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h3 class="text-lg font-semibold mb-4">Setores do Cliente: {{ $cliente->fantasia }}</h3>

            <!-- Formulário para adicionar um novo setor -->
            @if(auth()->user()->permissoes->contains('nome', 'cliente_btn_create_setor'))

            <div class="flex items-center space-x-4 mb-4">
                <input type="text" wire:model="setor_nome" placeholder="Nome do Setor"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                <button wire:click="createSetor" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Criar Setor
                </button>
                @error('setor_nome') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            @endif

            <!-- Lista de setores associados ao cliente -->
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Setor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($cliente->setores as $setor)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $setor->nome }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if(auth()->user()->permissoes->contains('nome', 'cliente_btn_remove_setor'))
                                <button wire:click="removeSetor({{ $setor->id }})" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-600">
                                    Remover
                                </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                Este cliente não possui setores atribuídos.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
            </div>
        </div>
    </div>

    <!-- Form Modal -->
    <x-dialog-modal wire:model="isOpen">
        <x-slot name="title">
            {{ $editing ? 'Editar Valores da Função' : 'Adicionar Função' }}
        </x-slot>

        <x-slot name="content">
            @if(!$editing)
                <div class="mt-4">
                    <x-label for="funcao_id" value="Função" />
                    <select id="funcao_id" wire:model="funcao_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Selecione uma função</option>
                        @foreach($funcoesDisponiveis as $funcao)
                            <option value="{{ $funcao->id }}">{{ $funcao->nome }}</option>
                        @endforeach
                    </select>
                    @error('funcao_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <x-label for="valor_hora_repasse" value="Valor Hora (Repasse)" />
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400">R$</span>
                        <x-input id="valor_hora_repasse" type="number" step="0.01" min="0" class="rounded-none rounded-r-md block w-full" wire:model="valor_hora_repasse" />
                    </div>
                    @error('valor_hora_repasse') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-label for="valor_hora_extra_repasse" value="Valor Hora Extra (Repasse)" />
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400">R$</span>
                        <x-input id="valor_hora_extra_repasse" type="number" step="0.01" min="0" class="rounded-none rounded-r-md block w-full" wire:model="valor_hora_extra_repasse" />
                    </div>
                    @error('valor_hora_extra_repasse') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-label for="valor_hora_faturamento" value="Valor Hora (Faturamento)" />
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400">R$</span>
                        <x-input id="valor_hora_faturamento" type="number" step="0.01" min="0" class="rounded-none rounded-r-md block w-full" wire:model="valor_hora_faturamento" />
                    </div>
                    @error('valor_hora_faturamento') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-label for="valor_hora_extra_faturamento" value="Valor Hora Extra (Faturamento)" />
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400">R$</span>
                        <x-input id="valor_hora_extra_faturamento" type="number" step="0.01" min="0" class="rounded-none rounded-r-md block w-full" wire:model="valor_hora_extra_faturamento" />
                    </div>
                    @error('valor_hora_extra_faturamento') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-4">
                <x-label for="qtd_horas_trabalhadas" value="Quantidade de Horas Trabalhadas" />
                <x-input id="qtd_horas_trabalhadas" type="number" min="0" class="mt-1 block w-full" wire:model="qtd_horas_trabalhadas" />
                @error('qtd_horas_trabalhadas') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal" class="mr-2">
                Cancelar
            </x-secondary-button>

            <x-button wire:click="store">
                {{ $editing ? 'Atualizar' : 'Adicionar' }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Delete Confirmation Modal -->
    <x-dialog-modal wire:model="confirmingDelete">
        <x-slot name="title">
            Remover Função
        </x-slot>

        <x-slot name="content">
            Tem certeza que deseja remover esta função do cliente?
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingDelete')" class="mr-2">
                Cancelar
            </x-secondary-button>

            <x-danger-button wire:click="delete">
                Remover
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>

    <!-- New Function Modal -->
    <x-dialog-modal wire:model="showNewFunctionModal">
        <x-slot name="title">
            Criar Nova Função
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="newFunctionName" value="Nome da Função" />
                <x-input id="newFunctionName" type="text" class="mt-1 block w-full" wire:model="newFunctionName" />
                @error('newFunctionName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showNewFunctionModal')" class="mr-2">
                Cancelar
            </x-secondary-button>

            <x-button wire:click="storeNewFunction">
                Criar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    </div>
</div>
</div>
