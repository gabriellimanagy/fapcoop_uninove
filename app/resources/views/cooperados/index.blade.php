<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center px-4 py-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Cooperados') }}
            </h2>

            @if(auth()->user()->permissoes->contains('nome', 'cooperado_btn_create'))
                <a href="{{ route('cooperados.create') }}"
                class="inline-flex items-center bg-green-600 text-white hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 px-5 py-2.5 rounded-xl shadow-md transition-all duration-300 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="font-medium">{{ __('Criar Cooperado') }}</span>
                </a>
            @endif

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl p-8">
                <livewire:cooperado-search />
            </div>
        </div>
    </div>
</x-app-layout>
