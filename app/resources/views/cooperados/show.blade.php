<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes do Cooperado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Matrícula</label>
                        <p class="form-input mt-1 block w-full rounded-md">{{ $cooperado->matricula }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Nome</label>
                        <p class="form-input mt-1 block w-full rounded-md">{{ $cooperado->nome }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Sexo</label>
                        <p class="form-input mt-1 block w-full rounded-md">{{ $cooperado->sexo }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Status</label>
                        <p class="form-input mt-1 block w-full rounded-md">{{ $cooperado->status }}</p>
                    </div>
                </div>
                <a href="{{ route('cooperados.index') }}" class="btn bg-gray-500 text-white hover:bg-gray-700 px-4 py-2 rounded-md">Voltar</a>
            </div>
        </div>
    </div>
</x-app-layout>
