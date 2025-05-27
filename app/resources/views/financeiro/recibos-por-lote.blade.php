<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Recibos por Lote') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if (session('success'))
            <div id="success-message" class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg" role="alert">
                <strong class="font-bold">Sucesso!</strong> <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" onclick="document.getElementById('success-message').remove();" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.172 7.066 4.238a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 12.828l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934z"/>
                    </svg>
                </span>
                <div id="progress-bar" class="absolute bottom-0 left-0 h-1 bg-green-500" style="width: 100%;"></div>
            </div>
        @endif

        @if (session('error'))
            <div id="error-message" class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg" role="alert">
                <strong class="font-bold">Erro!</strong> <span class="block sm:inline">{{ session('error') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" onclick="document.getElementById('error-message').remove();" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.172 7.066 4.238a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 12.828l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934z"/>
                    </svg>
                </span>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Formulário de Seleção de Lote -->
                <form method="GET" action="{{ route('financeiro.recibos-por-lote') }}" class="mb-6">
                    <div class="flex items-center space-x-4">
                        <div>
                            <label for="lote" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Lote</label>
                            <select name="lote" id="lote" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <option value="">Selecione um lote</option>
                                @foreach($lotes as $loteOption)
                                    <option value="{{ $loteOption }}" {{ $loteOption == $lote ? 'selected' : '' }}>{{ $loteOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="btn bg-blue-500 text-white hover:bg-blue-700 px-4 py-2 rounded-md">Selecionar</button>
                        </div>
                    </div>
                </form>

                <!-- Exibir Lote e Status -->
                @if($lote)
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>Lote:</strong> {{ $lote }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Clique duas vezes para alterar o Status do Pagamento
                        </p>
                    </div>

                    <!-- Tabela -->
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">ID Cooperado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Nome Cooperado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Valor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Dt. Pagamento</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recibos as $recibo)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        <!-- Placeholder para o Status (você pode ajustar conforme necessário) -->
                                        <span class="text-red-500">Pendente</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $recibo['cooperado_id'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $recibo['cooperado']->nome ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ number_format($recibo['total_valor'], 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $dtPagamento }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-200">
                                        Nenhum recibo encontrado para este lote.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Valor Total -->
                    <div class="mt-4">
                        <p class="text-sm font-bold text-gray-600 dark:text-gray-400">
                            Valor Total do Lote: {{ number_format($valorTotalLote, 2, ',', '.') }}
                        </p>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="mt-6 flex space-x-4">
                        <button class="btn bg-blue-500 text-white hover:bg-blue-700 px-4 py-2 rounded-md">Imprimir TODOS Recibos</button>
                        <button class="btn bg-green-500 text-white hover:bg-green-700 px-4 py-2 rounded-md">Enviar Recibos (WhatsApp)</button>
                        <!-- Botão para abrir o modal -->
                        <button type="button" onclick="document.getElementById('passwordModal').classList.remove('hidden')" class="btn bg-yellow-500 text-white hover:bg-yellow-700 px-4 py-2 rounded-md">Exportar para Excel</button>
                    </div>

                    <!-- Modal para digitar a senha -->
                    <div id="passwordModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Digite a senha do arquivo</h3>
                            <form method="GET" action="{{ route('financeiro.recibos-por-lote') }}">
                                <input type="hidden" name="lote" value="{{ $lote }}">
                                <input type="hidden" name="export" value="1">
                                <div class="mb-4">
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Senha</label>
                                    <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                </div>
                                <div class="flex justify-end space-x-3">
                                    <button type="button" onclick="document.getElementById('passwordModal').classList.add('hidden')" class="btn bg-gray-500 text-white hover:bg-gray-700 px-4 py-2 rounded-md">Cancelar</button>
                                    <button type="submit" class="btn bg-yellow-500 text-white hover:bg-yellow-700 px-4 py-2 rounded-md">Exportar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Por favor, selecione um lote para visualizar os recibos.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>