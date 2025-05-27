<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes do Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-4">
                    <strong>Nome:</strong> {{ $cliente->nome }}
                </div>
                <div class="mb-4">
                    <strong>CPF:</strong> {{ $cliente->cpf }}
                </div>
                <div class="mb-4">
                    <strong>Email:</strong> {{ $cliente->email }}
                </div>
                <div class="mb-4">
                    <strong>Telefone:</strong> {{ $cliente->telefone }}
                </div>
                <div class="mb-4">
                    <strong>Endereço:</strong> {{ $cliente->endereco }}
                </div>
                <div class="mb-4">
                    <strong>Cidade:</strong> {{ $cliente->cidade }}
                </div>
                <div class="mb-4">
                    <strong>Estado:</strong> {{ $cliente->estado }}
                </div>
                <div class="mt-6 flex justify-between">
                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-700">Editar</a>
                    <a href="{{ route('clientes.index') }}" class="btn bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
