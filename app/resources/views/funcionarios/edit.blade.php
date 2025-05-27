
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if (session('success'))
            <div id="success-message" class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg" role="alert">
                <strong class="font-bold">Sucesso!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" onclick="document.getElementById('success-message').remove();" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.172 7.066 4.238a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 12.828l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934z"/></svg>
                </span>
                <div id="progress-bar" class="absolute bottom-0 left-0 h-1 bg-green-500" style="width: 100%;"></div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nome</label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                        <input type="email" name="email" id="email" value="{{ $user->email }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    </div>

                    <div class="mb-4">
                        <label for="celular" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Celular</label>
                        <input type="text" name="celular" id="celular" value="{{ $user->celular }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    </div>

                    <div class="mb-4">
                        <label for="cpf" class="block text-sm font-medium text-gray-700 dark:text-gray-200">CPF</label>
                        <input type="text" name="cpf" id="cpf" value="{{ $user->cpf }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    </div>

                    <div class="mb-4">
                        <label for="departamento_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Departamento</label>
                        <select name="departamento_id" id="departamento_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}" {{ $user->departamento_id == $departamento->id ? 'selected' : '' }}>
                                    {{ $departamento->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn bg-green-500 text-white hover:bg-green-700 px-4 py-2 rounded-md">Salvar</button>
                    </div>
                </form>

                <form action="{{ route('users.reset_password', $user->id) }}" method="POST" class="mt-8 border-t pt-4">
                    @csrf
                    @method('PUT')
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Senha padrão: <strong>"2SCJ^vMRp!"</strong></span>
                        </div>
                        <button type="submit" class="btn bg-red-500 text-white hover:bg-red-700 px-4 py-2 rounded-md ml-4">Redefinir Senha</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.remove();
                }, 5000);

                const progressBar = document.getElementById('progress-bar');
                let width = 100;
                const interval = setInterval(() => {
                    width -= 2;
                    progressBar.style.width = width + '%';
                    if (width <= 0) {
                        clearInterval(interval);
                    }
                }, 100);
            }
        });
    </script>
</x-app-layout>
