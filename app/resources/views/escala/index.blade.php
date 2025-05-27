<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Escalas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if (session('success'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <!-- Botão para excluir escalas selecionadas
                        <button id="delete-selected"
                                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled
                                onclick="deleteSelectedItems()">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4M4 7h16"/>
                            </svg>
                            {{ __('Excluir Selecionados') }}
                        </button>
                        -->
                    </div>
                    @if(auth()->user()->permissoes->contains('nome', 'escala_btn_create_escala'))
                    <a href="{{ route('escala.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('Nova Escala') }}
                    </a>
                    @endif
                </div>

                <!-- Seção para exibir os totais -->
                @if(auth()->user()->permissoes->contains('nome', 'escala_ver_total_faturamento'))

                <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-md">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-200">
                        Total Faturamento: <span id="total-faturamento" class="font-bold">0,00</span>
                    </p>

                </div>
                @endif
                @if(auth()->user()->permissoes->contains('nome', 'escala_ver_total_repasse'))
                <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-md">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-200">
                        Total Repasse: <span id="total-repasse" class="font-bold">0,00</span>
                    </p>
                </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" aria-label="{{ __('Tabela de Escalas') }}">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left">
                                    <input type="checkbox" id="select-all"
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                           aria-label="{{ __('Selecionar todos') }}">
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">{{ __('Status') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">{{ __('Pagamento') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">{{ __('Responsável') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">{{ __('Dt. Serviço') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">{{ __('Nº Sol.') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">{{ __('Cliente') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">{{ __('Setor') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">{{ __('Lote') }}</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider w-24">{{ __('Ações') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($escalas as $escala)

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150 cursor-pointer"
                                    onclick="toggleCheckbox(event, '{{ $escala->id }}')"
                                    data-financial='@json($financialData[$escala->id] ?? [])'>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox"
                                               name="selected_items[]"
                                               value="{{ $escala->id }}"
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 item-checkbox"
                                               aria-label="{{ __('Selecionar escala') . ' ' . $escala->id }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        @if($escala->lote === '-')
                                            <svg class="inline-block w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" aria-label="{{ __('Status: Aberto') }}">
                                                <path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 015.905-.75 1 1 0 001.937-.5A5.002 5.002 0 0010 2z"/>
                                            </svg>
                                        @else
                                            <svg class="inline-block w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20" aria-label="{{ __('Status: Fechado') }}">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <span class="text-red-500 font-bold">X</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $escala->user->name ?? __('N/A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $escala->data_servico }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $escala->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $escala->cliente->razao_social ?? __('N/A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $escala->setor->nome ?? __('N/A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $escala->lote ?? __('N/A') }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            @if(auth()->user()->permissoes->contains('nome', 'escala_puxar_lista'))
                                            <a href="{{ route('escala.download', $escala) }}"
                                               class="p-1 text-blue-600 hover:bg-blue-100 rounded"
                                               onclick="event.stopPropagation()"
                                               title="{{ __('Lista') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </a>
                                            @endif

                                            @if(auth()->user()->permissoes->contains('nome', 'escala_btn_edit'))
                                                @if($escala->lote === '-')
                                                <a href="{{ route('escala.edit', $escala) }}"
                                                   class="p-1 text-yellow-600 hover:bg-yellow-100 rounded"
                                                   onclick="event.stopPropagation()"
                                                   title="{{ __('Editar') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                @else
                                                <span class="p-1 text-gray-400 cursor-not-allowed" title="{{ __('Não é possível editar') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </span>
                                                @endif
                                            @endif

                                            @if(auth()->user()->permissoes->contains('nome', 'escala_btn_delete_escala'))
                                                @if($escala->lote === '-')
                                                <form action="{{ route('escala.destroy', $escala) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('Confirma a exclusão desta escala?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="p-1 text-red-600 hover:bg-red-100 rounded"
                                                            onclick="event.stopPropagation()"
                                                            title="{{ __('Excluir') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                @else
                                                <span class="p-1 text-gray-400 cursor-not-allowed" title="{{ __('Não é possível excluir') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-200">
                                        {{ __('Nenhuma escala cadastrada.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const deleteButton = document.getElementById('delete-selected');
            const totalRepasseSpan = document.getElementById('total-repasse');
            const totalFaturamentoSpan = document.getElementById('total-faturamento');

            selectAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateButtonAndTotals();
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateButtonAndTotals);
            });

            function updateButtonAndTotals() {
                const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
                let isDeletable = false;
                let totalRepasse = 0;
                let totalFaturamento = 0;

                checkedBoxes.forEach(checkbox => {
                    const row = checkbox.closest('tr');
                    const lockIcon = row.querySelector('svg.text-red-500');
                    if (!lockIcon) {
                        isDeletable = true;
                    }

                    try {
                        const financialDataStr = row.getAttribute('data-financial') || '[]';
                        const financialData = JSON.parse(financialDataStr);

                        if (Array.isArray(financialData)) {
                            financialData.forEach(data => {
                                // Converter para número e garantir que é um número válido
                                totalRepasse += parseFloat(data.valor_repasse || 0);
                                totalFaturamento += parseFloat(data.valor_faturamento || 0);
                            });
                        } else {
                            console.error('data-financial não é um array:', financialDataStr);
                        }
                    } catch (error) {
                        console.error('Erro ao processar dados financeiros:', error);
                    }
                });

                if (deleteButton) {
                    deleteButton.disabled = checkedBoxes.length === 0 || !isDeletable;
                }

                if (totalRepasseSpan) {
                    totalRepasseSpan.textContent = totalRepasse.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }

                if (totalFaturamentoSpan) {
                    totalFaturamentoSpan.textContent = totalFaturamento.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }

                // Log para debug
                console.log('Total Repasse:', totalRepasse);
                console.log('Total Faturamento:', totalFaturamento);
            }

            window.toggleCheckbox = function(event, id) {
                if (event.target.tagName === 'A' || event.target.tagName === 'BUTTON' || event.target.closest('form')) {
                    return;
                }

                const checkbox = document.querySelector(`input[value="${id}"]`);
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    updateButtonAndTotals();
                }
            };

            window.deleteSelectedItems = function() {
                const selectedIds = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (selectedIds.length === 0) return;

                const hasLockedItem = Array.from(checkboxes).some(cb => {
                    if (cb.checked) {
                        const row = cb.closest('tr');
                        return row.querySelector('svg.text-red-500');
                    }
                    return false;
                });

                if (hasLockedItem) {
                    alert("{{ __('Não é possível excluir escalas com status fechado.') }}");
                    return;
                }

                if (confirm(`{{ __('.ErrorsConfirma a exclusão de') }} ${selectedIds.length} {{ __('escala(s)?') }}`)) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("escala.destroy.multiple") }}';

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);

                    const ids = document.createElement('input');
                    ids.type = 'hidden';
                    ids.name = 'ids';
                    ids.value = JSON.stringify(selectedIds);
                    form.appendChild(ids);

                    document.body.appendChild(form);
                    form.submit();
                }
            };
        });
    </script>
</x-app-layout>
