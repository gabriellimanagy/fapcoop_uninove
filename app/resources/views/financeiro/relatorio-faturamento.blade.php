<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Relatório de Faturamento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Mensagens de Sucesso ou Erro -->
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
                <!-- Formulário de Filtros -->
                <form method="GET" action="{{ route('relatorios.faturamento') }}" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Filtro de Lote -->
                        <div>
                            <label for="lote" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Filtrar Por Lote</label>
                            <select name="lote" id="lote" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <option value="">TODOS</option>
                                @foreach($lotes as $loteOption)
                                    <option value="{{ $loteOption }}" {{ $loteOption == $lote ? 'selected' : '' }}>{{ $loteOption }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filtro de Período -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Período</label>
                            <div class="flex items-center space-x-2">
                                <div>
                                    <label for="data_inicio" class="block text-xs text-gray-600 dark:text-gray-400">De</label>
                                    <input type="date" name="data_inicio" id="data_inicio" value="{{ $data_inicio }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                </div>
                                <div>
                                    <label for="data_fim" class="block text-xs text-gray-600 dark:text-gray-400">Até</label>
                                    <input type="date" name="data_fim" id="data_fim" value="{{ $data_fim }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                </div>
                            </div>
                        </div>

                        <!-- Filtro de Cliente -->
                        <div>
                            <label for="cliente_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Cliente / Tomador</label>
                            <select name="cliente_id" id="cliente_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <option value="">TODOS</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ $cliente->id == $cliente_id ? 'selected' : '' }}>{{ $cliente->fantasia }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filtro de Setor -->
                        <div>
                            <label for="setor_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Setor</label>
                            <select name="setor_id" id="setor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <option value="">TODOS</option>
                                @foreach($setores as $setor)
                                    <option value="{{ $setor->id }}" {{ $setor->id == $setor_id ? 'selected' : '' }}>{{ $setor->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filtro de Função -->
                        <div>
                            <label for="funcao_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Função</label>
                            <select name="funcao_id" id="funcao_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <option value="">TODOS</option>
                                @foreach($funcoes as $funcao)
                                    <option value="{{ $funcao->id }}" {{ $funcao->id == $funcao_id ? 'selected' : '' }}>{{ $funcao->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Novo Filtro: Antes da Baixa -->
                        <div>
                            <label for="antes_da_baixa" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
                            <select name="antes_da_baixa" id="antes_da_baixa" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <option value="">TODOS</option>
                                <option value="1" {{ $antes_da_baixa == '1' ? 'selected' : '' }}>Antes da Baixa</option>
                                <option value="0" {{ $antes_da_baixa == '0' ? 'selected' : '' }}>Baixados</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="btn bg-blue-500 text-white hover:bg-blue-700 px-4 py-2 rounded-md">Filtrar</button>
                    </div>
                </form>

                <!-- Tabela de Resultados com Rolagem Horizontal -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">ID Escala</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Data</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Setor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Prestador</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Função</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Hr. Entrada</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Hr. Saída</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Hr. Extra</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Qtd. Horas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Valor/Hora Fat.</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($dados as $dado)
                                @php
                                    $hrExtraHours = 0;
                                    if ($dado->hr_extra && $dado->hr_extra !== '00:00:00') {
                                        list($hours, $minutes) = array_pad(explode(':', $dado->hr_extra), 2, '00');
                                        $hrExtraHours = (int)$hours + ((int)$minutes / 60);
                                    }
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $dado->escala_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ \Carbon\Carbon::parse($dado->dt_servico)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $dado->cliente_fantasia }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $dado->setor_nome }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $dado->cooperado_nome }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $dado->funcao_nome }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $dado->hr_entrada ? substr($dado->hr_entrada, 0, 5) : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $dado->hr_saida ? substr($dado->hr_saida, 0, 5) : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $hrExtraHours > 0 ? substr($dado->hr_extra, 0, 5) : '00:00' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        {{ $dado->qtd_horas_trabalhadas }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                        R$ {{ number_format($dado->valor_hora_faturamento, 2, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-200">
                                        Nenhum registro encontrado para os filtros selecionados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Botões de Ação -->
                <div class="mt-6 flex space-x-4">
                    <button type="button" onclick="document.getElementById('exportModal').classList.remove('hidden')" class="btn bg-green-500 text-white hover:bg-green-700 px-4 py-2 rounded-md flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Exportar para Excel
                    </button>
                    <button type="button" onclick="document.getElementById('exportPdfModal').classList.remove('hidden')" class="btn bg-red-500 text-white hover:bg-red-700 px-4 py-2 rounded-md flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Exportar para PDF
                    </button>
                    <a href="{{ route('relatorios.faturamento', array_merge(request()->query(), ['print' => 1])) }}" class="btn bg-blue-500 text-white hover:bg-blue-700 px-4 py-2 rounded-md flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Imprimir
                    </a>
                </div>

                <!-- Modal para Exportar XLS -->
                <div id="exportModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Digite a senha do arquivo</h3>
                        <form method="GET" action="{{ route('relatorios.faturamento') }}">
                            <input type="hidden" name="lote" value="{{ $lote }}">
                            <input type="hidden" name="data_inicio" value="{{ $data_inicio }}">
                            <input type="hidden" name="data_fim" value="{{ $data_fim }}">
                            <input type="hidden" name="cliente_id" value="{{ $cliente_id }}">
                            <input type="hidden" name="setor_id" value="{{ $setor_id }}">
                            <input type="hidden" name="funcao_id" value="{{ $funcao_id }}">
                            <input type="hidden" name="antes_da_baixa" value="{{ $antes_da_baixa }}">
                            <input type="hidden" name="export" value="1">
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Senha</label>
                                <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="document.getElementById('exportModal').classList.add('hidden')" class="btn bg-gray-500 text-white hover:bg-gray-700 px-4 py-2 rounded-md">Cancelar</button>
                                <button type="submit" class="btn bg-green-500 text-white hover:bg-green-700 px-4 py-2 rounded-md">Exportar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal para Exportar PDF -->
                <div id="exportPdfModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Exportar para PDF</h3>
                        <form method="GET" action="{{ route('relatorios.faturamento') }}">
                            <input type="hidden" name="lote" value="{{ $lote }}">
                            <input type="hidden" name="data_inicio" value="{{ $data_inicio }}">
                            <input type="hidden" name="data_fim" value="{{ $data_fim }}">
                            <input type="hidden" name="cliente_id" value="{{ $cliente_id }}">
                            <input type="hidden" name="setor_id" value="{{ $setor_id }}">
                            <input type="hidden" name="funcao_id" value="{{ $funcao_id }}">
                            <input type="hidden" name="antes_da_baixa" value="{{ $antes_da_baixa }}">
                            <input type="hidden" name="export_pdf" value="1">
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="document.getElementById('exportPdfModal').classList.add('hidden')" class="btn bg-gray-500 text-white hover:bg-gray-700 px-4 py-2 rounded-md">Cancelar</button>
                                <button type="submit" class="btn bg-red-500 text-white hover:bg-red-700 px-4 py-2 rounded-md">Exportar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>