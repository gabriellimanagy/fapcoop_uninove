
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Usuários') }}
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
                <div class="flex justify-end mb-4">
                    @if(auth()->user()->permissoes->contains('nome', 'funcionarios_btn_create'))
                        <a href="{{ route('users.create') }}" class="btn bg-green-500 text-white hover:bg-green-700 px-4 py-2 rounded-md">Novo</a>
                    @endif
                    </div>
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Nome</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Celular</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Departamento</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $user->celular }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $user->departamento->nome }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('users.show', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">Ver</a>
                                    @if(auth()->user()->permissoes->contains('nome', 'funcionarios_btn_edit'))
                                        <a href="{{ route('users.edit', $user->id) }}" class="ml-4 text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-600">Editar</a>
                                    @endif
                                    @if(auth()->user()->permissoes->contains('nome', 'funcionarios_btn_delete'))
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ml-4 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">Excluir</button>
                                        </form>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação para exclusão -->
    <div id="confirm-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Confirmar Exclusão</h2>
            <p class="mt-4 text-gray-600 dark:text-gray-400">Tem certeza de que deseja excluir este usuário?</p>
            <div class="mt-6 flex justify-end">
                <button id="cancel-button" class="btn bg-gray-500 text-white hover:bg-gray-700 px-4 py-2 rounded-md mr-2">Cancelar</button>
                <button id="confirm-button" class="btn bg-red-500 text-white hover:bg-red-700 px-4 py-2 rounded-md">Excluir</button>
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

            const confirmModal = document.getElementById('confirm-modal');
            const cancelButton = document.getElementById('cancel-button');
            const confirmButton = document.getElementById('confirm-button');
            let formToSubmit = null;

            window.confirmDelete = function(event) {
                event.preventDefault();
                formToSubmit = event.target.closest('form'); // Usar closest para encontrar o formulário pai
                confirmModal.classList.remove('hidden');
            };

            cancelButton.addEventListener('click', function() {
                confirmModal.classList.add('hidden');
                formToSubmit = null;
            });

            confirmButton.addEventListener('click', function() {
                if (formToSubmit) {
                    formToSubmit.submit();
                }
                confirmModal.classList.add('hidden');
            });

            // Fecha o modal se clicar fora dele
            window.addEventListener('click', function(event) {
                if (event.target === confirmModal) {
                    confirmModal.classList.add('hidden');
                    formToSubmit = null;
                }
            });
        });
    </script>
</x-app-layout>
