<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Novo Departamento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('departamentos.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="nome" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nome</label>
                        <input type="text" name="nome" id="nome" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <div class="flex justify-end mt-6">
                        <a href="{{ route('departamentos.index') }}" class="btn bg-gray-500 text-white hover:bg-gray-700 px-4 py-2 rounded-md mr-2">Cancelar</a>
                        <button type="submit" class="btn bg-green-500 text-white hover:bg-green-700 px-4 py-2 rounded-md">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
