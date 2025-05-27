<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Departamentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('departamentos.create') }}" class="btn bg-green-500 text-white hover:bg-green-700 px-4 py-2 rounded-md">Novo Departamento</a>
                </div>
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Nome</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($departamentos as $departamento)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">{{ $departamento->nome }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('departamentos.edit', $departamento->id) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-600">Editar</a>
                                    <a href="{{ route('departamentos.permissions', $departamento->id) }}" class="ml-4 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">Gerenciar Permissões</a>
                                    <form action="{{ route('departamentos.destroy', $departamento->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir este departamento?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ml-4 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-permission-check permission="acessar_pagina">
        <p>Este conteúdo só é visível para usuários com permissão para acessar a página.</p>
    </x-permission-check>

    <x-permission-check permission="baixar_relatorio">
        <button class="btn bg-blue-500 text-white hover:bg-blue-700 px-4 py-2 rounded-md">Baixar Relatório</button>
    </x-permission-check>

    <x-permission-check permission="gerar_relatorio">
        <button class="btn bg-green-500 text-white hover:bg-green-700 px-4 py-2 rounded-md">Gerar Novo Relatório</button>
    </x-permission-check>
</x-app-layout>
