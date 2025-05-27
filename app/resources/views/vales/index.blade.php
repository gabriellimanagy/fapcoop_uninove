<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Vales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <a href="{{ route('vales.create') }}" class="btn bg-green-500 text-white hover:bg-green-700 px-4 py-2 rounded-md mb-4">
                    Criar Vale
                </a>

                <livewire:vales-pesquisa />
            </div>
        </div>
    </div>
</x-app-layout>
