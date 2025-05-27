<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gerenciar Permissões para') }}: {{ $departamento->nome }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('departamentos.update_permissions', $departamento->id) }}">
                    @csrf
                    @method('PUT')
                    <x-permission-manager :departamento="$departamento" :allPermissions="$allPermissions" :currentPermissions="$currentPermissions" />
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
