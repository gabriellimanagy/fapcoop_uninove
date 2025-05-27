<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Empresas') }}
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
                <x-permission-check permission="empresa_empresa_novo">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('empresas.create') }}" class="btn bg-green-500 text-white hover:bg-green-700 px-4 py-2 rounded-md">Novo</a>
                    </div>
                </x-permission-check>

                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Fantasia</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">CNPJ</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Endereço</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Bairro</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Número</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($empresas as $empresa)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">{{ $empresa->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $empresa->fantasia }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200 cnpj">{{ $empresa->cnpj }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $empresa->endereco }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $empresa->bairro }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $empresa->numero }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('empresas.show', $empresa) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600" onclick="showDetails({{ $empresa }})">Ver</a>
                                    <x-permission-check permission="empresa_editar">
                                        <a href="{{ route('empresas.edit', $empresa) }}" class="ml-4 text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-600">Editar</a>
                                    </x-permission-check>
                                    <x-permission-check permission="empresa_excluir">

                                    <form action="{{ route('empresas.destroy', $empresa) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                            <button type="submit" class="ml-4 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">Excluir</button>
                                    </form>
                                </x-permission-check>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação -->
    <div id="confirm-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Confirmar Exclusão</h2>
            <p class="mt-4 text-gray-600 dark:text-gray-400">Tem certeza de que deseja excluir esta empresa?</p>
            <div class="mt-6 flex justify-end">
                <button id="cancel-button" class="btn bg-gray-500 text-white hover:bg-gray-700 px-4 py-2 rounded-md mr-2">Cancelar</button>
                <button id="confirm-button" class="btn bg-red-500 text-white hover:bg-red-700 px-4 py-2 rounded-md">Excluir</button>
            </div>
        </div>
    </div>

    <!-- Modal de Detalhes -->
    <div id="details-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-1/2">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Detalhes da Empresa</h2>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Fantasia:</strong> <span id="det-fantasia"></span></p>
                    <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>CNPJ:</strong> <span id="det-cnpj"></span></p>
                    <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Endereço:</strong> <span id="det-endereco"></span></p>
                    <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Bairro:</strong> <span id="det-bairro"></span></p>
                    <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Número:</strong> <span id="det-numero"></span></p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Razão Social:</strong> <span id="det-razao-social"></span></p>
                    <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Inscrição Estadual:</strong> <span id="det-insc-estadual"></span></p>
                    <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Complemento:</strong> <span id="det-complemento"></span></p>
                    <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Cidade:</strong> <span id="det-cidade"></span></p>
                    <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Estado:</strong> <span id="det-estado"></span></p>
                    <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>CEP:</strong> <span id="det-cep"></span></p>
                    <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Telefone 1:</strong> <span id="det-telefone1"></span></p>
                    <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Telefone 2:</strong> <span id="det-telefone2"></span></p>
                    <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Email:</strong> <span id="det-email"></span></p>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button id="close-details-button" class="btn bg-gray-500 text-white hover:bg-gray-700 px-4 py-2 rounded-md">Fechar</button>
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
                formToSubmit = event.target;
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
            });

            const detailsModal = document.getElementById('details-modal');
            const closeDetailsButton = document.getElementById('close-details-button');

            function formatCNPJ(cnpj) {
                return cnpj.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, "$1.$2.$3/$4-$5");
            }

            function formatTelefone(telefone) {
                return telefone.length === 10
                    ? telefone.replace(/^(\d{2})(\d{4})(\d{4})$/, "($1) $2-$3")
                    : telefone.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3");
            }

            window.showDetails = function(empresa) {
                document.getElementById('det-razao-social').innerText = empresa.razao_social;
                document.getElementById('det-fantasia').innerText = empresa.fantasia;
                document.getElementById('det-cnpj').innerText = formatCNPJ(empresa.cnpj);
                document.getElementById('det-insc-estadual').innerText = empresa.insc_estadual;
                document.getElementById('det-endereco').innerText = empresa.endereco;
                document.getElementById('det-numero').innerText = empresa.numero;
                document.getElementById('det-complemento').innerText = empresa.complemento;
                document.getElementById('det-bairro').innerText = empresa.bairro;
                document.getElementById('det-cidade').innerText = empresa.cidade;
                document.getElementById('det-estado').innerText = empresa.estado;
                document.getElementById('det-cep').innerText = empresa.cep;
                document.getElementById('det-telefone1').innerText = formatTelefone(empresa.telefone1);
                document.getElementById('det-telefone2').innerText = formatTelefone(empresa.telefone2);
                document.getElementById('det-email').innerText = empresa.email;
                detailsModal.classList.remove('hidden');
            };

            closeDetailsButton.addEventListener('click', function() {
                detailsModal.classList.add('hidden');
            });

            document.querySelectorAll('.cnpj').forEach(function(element) {
                element.innerText = formatCNPJ(element.innerText);
            });
        });
    </script>
</x-app-layout>
