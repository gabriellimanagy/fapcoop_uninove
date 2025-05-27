<!-- filepath: c:\Users\caiol\Desktop\Github\fapcoop\app\resources\views\clientes\index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Clientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Seção de Clientes -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium mb-4">Lista de Clientes</h3>

                <!-- Formulário de Pesquisa -->
                <form method="GET" action="{{ route('clientes.index') }}" class="mb-4 flex space-x-2">
                    <input type="text" name="search" placeholder="Buscar clientes..." value="{{ request('search') }}"
                           class="border border-gray-300 p-2 rounded-md w-full dark:bg-gray-700 dark:text-white">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Buscar</button>
                </form>
                <!-- Botão para Adicionar Novo Cliente -->
                @if(auth()->user()->permissoes->contains('nome', 'cliente_btn_create'))
                <div class="flex justify-end mb-4">
                    <a href="{{ route('clientes.create') }}" class="inline-flex items-center bg-green-600 text-white hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 px-5 py-2.5 rounded-xl shadow-md transition-all duration-300 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="font-medium">{{ __('Criar Cliente') }}</span>
                    </a>
                </div>

                @endif


                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase">CNPJ/RG</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase">Telefone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($clientes as $cliente)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $cliente->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $cliente->fantasia }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $cliente->documento }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $cliente->telefone1 }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $cliente->email }}</td>
                                <td class="px-6 py-4 text-sm font-medium flex flex-col sm:flex-row sm:items-center gap-2">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400" onclick="showDetails({{ $cliente }})">Ver</a>
                                    @if(auth()->user()->permissoes->contains('nome', 'cliente_btn_edit'))
                                        <a href="{{ route('clientes.edit', $cliente) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400">Editar</a>
                                    @endif
                                    <!-- Link para a página de Gerenciar Funções -->
                                    @if(auth()->user()->permissoes->contains('nome', 'cliente_btn_funcoes'))
                                        <a href="{{ route('clientes.funcoes.index', $cliente->id) }}" class="text-green-600 hover:text-green-900 dark:text-green-400">Gerenciar Funções</a>
                                    @endif
                                    <!-- Formulário para Exclusão -->
                                    @if(auth()->user()->permissoes->contains('nome', 'cliente_btn_delete'))
                                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">Excluir</button>
                                        </form>
                                    @endif
                                    <!-- Formulário para Exclusão -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Paginação -->
                <div class="mt-4">
                    {{ $clientes->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
