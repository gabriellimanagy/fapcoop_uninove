{{-- filepath: c:\Users\caiol\Desktop\Github\fapcoop\app\resources\views\funcionarios\show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes do Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">Informações do Usuário</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nome</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Celular</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $user->celular }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Departamento</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $user->departamento->nome }}</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('users.index') }}" class="btn bg-gray-500 text-white hover:bg-gray-700 px-4 py-2 rounded-md">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
