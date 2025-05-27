<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Relatorio de Faturamento') }}
        </h2>
    </x-slot>

<div class="container">
    <h1>Relatório de Faturamento</h1>
    <form method="GET" action="{{ route('relatorio-faturamento.index') }}">
        <div class="row">
            <div class="col-md-4">
                <label for="periodo">Período</label>
                <input type="date" name="data_inicio" class="form-control" value="{{ request('data_inicio') }}" required>
                <input type="date" name="data_fim" class="form-control" value="{{ request('data_fim') }}" required>
            </div>
            <div class="col-md-4">
                <label for="cliente">Cliente</label>
                <select name="cliente_id" class="form-control">
                    <option value="">Todos</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="funcao">Função</label>
                <select name="funcao_id" class="form-control">
                    <option value="">Todos</option>
                    @foreach($funcoes as $funcao)
                        <option value="{{ $funcao->id }}" {{ request('funcao_id') == $funcao->id ? 'selected' : '' }}>
                            {{ $funcao->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Gerar Relatório</button>
    </form>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID Cooperado</th>
                <th>Cooperado</th>
                <th>Função</th>
                <th>Hr. Entrada</th>
                <th>Hr. Saída</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dados as $dado)
                <tr>
                    <td>{{ $dado->cooperado_id }}</td>
                    <td>{{ $dado->cooperado_nome }}</td>
                    <td>{{ $dado->funcao_nome }}</td>
                    <td>{{ $dado->hr_entrada }}</td>
                    <td>{{ $dado->hr_saida }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Nenhum dado encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</x-app-layout>
