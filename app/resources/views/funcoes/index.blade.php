<!-- filepath: c:\Users\caiol\Desktop\Github\fapcoop\app\resources\views\clientes\funcoes\index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Funções do Cliente: {{ $cliente->fantasia }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Seção de Gerenciamento de Funções -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Aqui o componente Livewire gerencia funções -->
                @livewire('cliente-funcao-manager', ['cliente' => $cliente])
            </div>
        </div>
    </div>
</x-app-layout>
