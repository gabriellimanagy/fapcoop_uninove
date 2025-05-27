<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cadastrar Novo Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nome</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label for="cpf" class="block text-sm font-medium text-gray-700 dark:text-gray-200">CPF</label>
                        <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label for="celular" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Celular</label>
                        <input type="text" name="celular" id="celular" value="{{ old('celular') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label for="departamento_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Departamento</label>
                        <select name="departamento_id" id="departamento_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                            <option value="">Selecione um departamento</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                                    {{ $departamento->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Senha</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Confirmar Senha</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('users.index') }}" class="btn bg-gray-500 text-white hover:bg-gray-700 px-4 py-2 rounded-md mr-2">Cancelar</a>
                        <button type="submit" class="btn bg-green-500 text-white hover:bg-green-700 px-4 py-2 rounded-md">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cpfInput = document.getElementById('cpf');
            cpfInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) {
                    value = value.slice(0, 11);
                }
                if (value.length > 9) {
                    value = value.replace(/(\d{3})(\d{3})(\d{3})/, '$1.$2.$3-');
                } else if (value.length > 6) {
                    value = value.replace(/(\d{3})(\d{3})/, '$1.$2.');
                } else if (value.length > 3) {
                    value = value.replace(/(\d{3})/, '$1.');
                }
                e.target.value = value;
            });

            const celularInput = document.getElementById('celular');
            celularInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) {
                    value = value.slice(0, 11);
                }
                if (value.length > 6) {
                    value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
                } else if (value.length > 2) {
                    value = value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
                }
                e.target.value = value;
            });
        });
    </script>
</x-app-layout>
