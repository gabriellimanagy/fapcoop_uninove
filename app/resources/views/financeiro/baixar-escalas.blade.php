<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Baixar Escalas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-4">
                    <label for="lote" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Número do Lote</label>
                    <input type="text" id="lote" name="lote" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300" placeholder="Digite o número do lote">
                </div>

                <div class="mb-4 text-sm text-gray-500 dark:text-gray-300">
                    <p><strong>Atenção:</strong> Ao dar baixa, a escala será anexada ao nome do lote descrito.</p>
                </div>

                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Nº Solicitação</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Data da Escala</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Setor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Nome do Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($escalas as $escala)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $escala->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-200">
                                    {{ \Carbon\Carbon::parse($escala->data_servico)->format('d/m/Y') ?? 'Data não disponível' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-200">{{ $escala->setor->nome }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-200">{{ $escala->setor->cliente->razao_social }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <button class="btn bg-blue-500 text-white hover:bg-blue-700 px-4 py-2 rounded-md" 
                                        onclick="verCooperados({{ $escala->id }})">
                                        Ver Cooperados
                                    </button>
                                    <button class="btn bg-red-500 text-white hover:bg-red-700 px-4 py-2 rounded-md ml-2" 
                                        onclick="confirmarBaixa({{ $escala->id }})">
                                        Dar Baixa
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-modais.escalas />

    <script>
        let escalas = @json($escalas);
        let escalaIdToBaixar = null;

        function confirmarBaixa(escalaId) {
            escalaIdToBaixar = escalaId; // Atribui corretamente o valor de escalaId à variável
            document.getElementById('confirm-modal').classList.remove('hidden');
        }


        function closeModal() {
            document.getElementById('confirm-modal').classList.add('hidden');
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('confirm-btn').addEventListener('click', function() {
                const lote = document.getElementById('lote').value;
                if (!lote) {
                    alert('Por favor, digite o número do lote.');
                    return;
                }
                baixarEscala(escalaIdToBaixar, lote);
                closeModal();
            });
        });

        function baixarEscala(escalaId, lote) {

            if (!escalaId) {
                alert('Escala ID não fornecido');
                return;
            }

            axios.post('/escalas/baixar', { escala_id: escalaId, lote: lote })
            .then(response => {
                alert('Status da escala alterado com sucesso!');
                location.reload();
            })
            .catch(error => {
                console.error(error);
                alert('Erro ao dar baixa na escala');
            });
        }

        function verCooperados(escalaId) {
            console.log(escalaId);
            const escala = escalas.find(e => e.id == escalaId);
            if (!escala || !escala.servicos) {
                alert("Nenhum cooperado encontrado para esta escala.");
                return;
            }

            const cooperadosList = document.getElementById('cooperados-list');
            cooperadosList.innerHTML = '';  // Limpar lista anterior

            // Barra de pesquisa para cooperados
            const searchInput = document.getElementById('search-cooperados');
            searchInput.addEventListener('input', function() {
                const searchTerm = searchInput.value.toLowerCase();
                filterCooperados(searchTerm, escala);
            });

            // Função para filtrar cooperados por nome
            function filterCooperados(searchTerm, escala) {
                cooperadosList.innerHTML = '';  // Limpar a lista antes de repovoar

                // Filtra cooperados
                const filteredCooperados = escala.servicos.filter(servico => {
                    return servico.cooperado && servico.cooperado.nome.toLowerCase().includes(searchTerm);
                });

                if (filteredCooperados.length > 0) {
                    filteredCooperados.forEach(servico => {
                        // Usando funcao_id e assumindo que você tem os dados da função no seu modelo de Serviço
                        const funcaoNome = servico.funcao ? servico.funcao.nome : 'Sem Função';
                        cooperadosList.innerHTML += `
                            <tr>
                                <td class="px-4 py-2">${servico.cooperado.id}</td>
                                <td class="px-4 py-2">${servico.cooperado.nome}</td>
                                <td class="px-4 py-2">${funcaoNome}</td>
                                <td class="px-4 py-2">${servico.hr_entrada}</td>
                                <td class="px-4 py-2">${servico.hr_saida}</td>
                                <td class="px-4 py-2">${servico.hr_extra || 'Não Aplicável'}</td>
                            </tr>
                        `;
                    });
                } else {
                    cooperadosList.innerHTML = `
                        <tr>
                            <td colspan="6" class="px-4 py-2 text-center text-gray-500 dark:text-gray-300">Nenhum cooperado encontrado.</td>
                        </tr>
                    `;
                }
            }

            // Inicializa a filtragem com todos os cooperados ao abrir o modal
            filterCooperados('', escala);

            // Exibe o modal de cooperados
            document.getElementById('cooperados-modal').classList.remove('hidden');
        }


        function closeCooperadosModal() {
            document.getElementById('cooperados-modal').classList.add('hidden');
        }
    </script>

</x-app-layout>
