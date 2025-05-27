<!-- resources/views/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

                <x-application-logo class="block h-12 w-auto" />
                @if(auth()->user()->permissoes->contains('nome', 'dashboard_ver_ativar'))
                    <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-gray-100">
                        Relatório Mensal - {{ now()->format('F/Y') }}
                    </h1>

                <!-- Resumo -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">Total de Cooperados</h4>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $totalCooperados }}</p>
                        <p class="text-sm {{ $cooperadosGrowth >= 0 ? 'text-green-500' : 'text-red-500' }}">
                            {{ $cooperadosGrowth >= 0 ? '+' : '' }}{{ $cooperadosGrowth }}% em relação ao último mês
                        </p>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">Receita Mensal</h4>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">R$ {{ number_format($currentMonthRevenue, 2, ',', '.') }}</p>
                        <p class="text-sm {{ $revenueGrowth >= 0 ? 'text-green-500' : 'text-red-500' }}">
                            {{ $revenueGrowth >= 0 ? '+' : '' }}{{ $revenueGrowth }}% em relação ao último mês
                        </p>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">Serviços</h4>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $currentMonthTransactions }}</p>
                        <p class="text-sm {{ $transactionsGrowth >= 0 ? 'text-green-500' : 'text-red-500' }}">
                            {{ $transactionsGrowth >= 0 ? '+' : '' }}{{ $transactionsGrowth }}% em relação ao último mês
                        </p>
                    </div>
                </div>
@endif
                <!-- Duas seções lado a lado -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Cooperados recentes -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                Cooperados Recentes
                            </h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Membro
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Data de Adesão
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($recentCooperados as $cooperado)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $cooperado->nome }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($cooperado->dt_cadastro)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                {{ ucfirst($cooperado->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 text-center">
                                            Nenhum cooperado recente encontrado
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                Próximas Escalas
                            </h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Cliente
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Data do Serviço
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($upcomingEscalas as $escala)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $escala->cliente->fantasia ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($escala->data_servico)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $escala->status == 'confirmado' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' :
                                                   ($escala->status == 'pendente' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' :
                                                   'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                                                @if($escala->status == 'ativa')
                                                    Aberto
                                                @else
                                                    {{ ucfirst($escala->status) }}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 text-center">
                                            Nenhuma escala próxima encontrada
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Gráficos -->
                @if(auth()->user()->permissoes->contains('nome', 'dashboard_ver_ativar'))

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">Clientes Ativos</h4>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $activeClientes }}</p>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">Taxa de Crescimento</h4>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $cooperadosGrowth }}%</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Novos membros este mês</p>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">Acesso Rápido</h4>
                        <div class="mt-2 space-y-2">
                            <a href="{{ route('dashboard') }}" class="block text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                Gerenciar Cooperados
                            </a>
                            <a href="{{ route('dashboard') }}" class="block text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                Criar Nova Escala
                            </a>
                            <a href="{{ route('dashboard') }}" class="block text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                Relatório Financeiro
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Observações -->
                <div class="mt-8">
                    <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Observações</h4>
                    <p class="text-gray-600 dark:text-gray-400">
                        Este relatório reflete os dados do mês de {{ now()->format('F/Y') }}. Para mais detalhes ou relatórios específicos, utilize o menu de navegação.
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
