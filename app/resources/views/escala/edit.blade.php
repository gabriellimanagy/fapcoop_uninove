<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Escala') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if (session('success'))
            <div id="success-message" class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg transition-opacity duration-300" role="alert" aria-live="polite">
                {{ session('success') }}
                <button type="button" class="ml-2 text-green-700 hover:text-green-900" onclick="this.parentElement.remove()" aria-label="Fechar mensagem">✕</button>
            </div>
        @endif

        @if ($errors->any())
            <section class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert" aria-live="assertive">
                    <strong class="font-bold">Erro!</strong>
                    <p class="block sm:inline">Por favor, corrija os seguintes erros:</p>
                    <ul class="list-disc pl-5 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </section>
        @endif

        <section class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6 md:p-10">
                <form method="POST" action="{{ route('escala.update', $escala->id) }}" id="escalaForm" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Hidden Fields -->
                    <input type="hidden" name="user_id" value="{{ $escala->user_id }}">
                    <input type="hidden" name="data_servico" id="data_servico" value="{{ $escala->data_servico }}">
                    <input type="hidden" name="cliente_id" id="cliente_id_hidden" value="{{ $escala->cliente_id }}">

                    <!-- Section 1: Event Data -->
                    <fieldset class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow border border-gray-200 dark:border-gray-600">
                        <legend class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Dados do Evento</legend>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                            <div>
                                <label for="cliente_id_input" class="block text-gray-700 dark:text-gray-300 text-sm font-medium">ID Cliente</label>
                                <input type="number" id="cliente_id_input" name="cliente_id" placeholder="ID" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" value="{{ $escala->cliente_id }}" onblur="atualizarClientePorId(this.value)" min="1" required>
                            </div>
                            <div>
                                <label for="cliente_id" class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Cliente</label>
                                <select id="cliente_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" onchange="aoMudarCliente(this)" required>
                                    <option value="">Selecione o Cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ $cliente->id == $escala->cliente_id ? 'selected' : '' }}>
                                            {{ $cliente->fantasia }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="setor_id_input" class="block text-gray-700 dark:text-gray-300 text-sm font-medium">ID Setor</label>
                                <input type="number" id="setor_id_input" name="setor_id" placeholder="ID" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" value="{{ $escala->setor_id }}" onblur="atualizarSetorPorId(this.value)" min="1" required>
                            </div>
                            <div>
                                <label for="setor_id" class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Setor</label>
                                <select id="setor_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" onchange="aoMudarSetor(this)" required>
                                    <option value="">Selecione o Setor</option>
                                    @foreach($setores as $setor)
                                        <option value="{{ $setor->id }}" {{ $setor->id == $escala->setor_id ? 'selected' : '' }}>
                                            {{ $setor->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="nome_evento" class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Nome do Evento (Opcional)</label>
                            <input type="text" id="nome_evento" name="nome_evento" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" value="{{ $escala->nome_evento }}" placeholder="Digite o nome do evento">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                            <div>
                                <label for="data_solicitacao" class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Data da Solicitação</label>
                                <input type="text" id="data_solicitacao" name="data_solicitacao" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300 date-picker" value="{{ \Carbon\Carbon::parse($escala->data_solicitacao)->format('d/m/Y') }}" required>
                            </div>
                            <div>
                                <label for="data_inicio_servico" class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Data Início Serviço</label>
                                <input type="text" id="data_inicio_servico" name="data_inicio_servico" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300 date-picker" value="{{ \Carbon\Carbon::parse($escala->data_inicio_servico)->format('d/m/Y') }}" required>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Section 2: Observations -->
                    <fieldset class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow border border-gray-200 dark:border-gray-600">
                        <legend class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Observações</legend>
                        <div>
                            <label for="observacoes" class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Observações</label>
                            <textarea id="observacoes" name="observacoes" rows="3" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" placeholder="Digite suas observações aqui">{{ $escala->observacoes }}</textarea>
                        </div>
                    </fieldset>

                    <!-- Section 3: Cooperados -->
                    <fieldset class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow border border-gray-200 dark:border-gray-600">
                        <legend class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Cooperados</legend>
                        <div id="cooperados_container" class="space-y-4">
                            @php
                                // Ordenar cooperados por ID e data de serviço
                                $cooperadosOrdenados = $escala->cooperados->sortBy([
                                    ['id', 'asc'],
                                    [function($cooperado) {
                                        return $cooperado->pivot->dt_servico;
                                    }, 'asc']
                                ]);
                            @endphp
                            @foreach($cooperadosOrdenados as $index => $cooperado)
                                @php
                                    $servico = $servicos->firstWhere(function ($s) use ($cooperado) {
                                        return $s->cooperado_id === $cooperado->id && $s->dt_servico === $cooperado->pivot->dt_servico;
                                    });
                                @endphp
                                <div class="cooperado-item bg-gray-100 dark:bg-gray-700 p-4 rounded shadow" data-id="{{ $index }}">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">ID Cooperado</label>
                                            <input type="number" name="cooperados[{{ $index }}][cooperado_id]" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" value="{{ $cooperado->id }}" onblur="selecionarCooperadoPorId(this)">
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Cooperado</label>
                                            <select name="cooperados[{{ $index }}][id]" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" required>
                                                <option value="">Selecione o Cooperado</option>
                                                @foreach($cooperados as $coop)
                                                    <option value="{{ $coop->id }}" {{ $coop->id == $cooperado->id ? 'selected' : '' }}>
                                                        {{ $coop->nome }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-4 mt-4">
                                        <div>
                                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Função</label>
                                            <select name="cooperados[{{ $index }}][funcao_id]" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300">
                                                <option value="">Selecione a Função</option>
                                                @foreach($funcoes as $funcao)
                                                    <option value="{{ $funcao->id }}" {{ $funcao->id == $cooperado->pivot->funcao_id ? 'selected' : '' }}>
                                                        {{ $funcao->nome }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Hora de Entrada</label>
                                            <input type="text" name="cooperados[{{ $index }}][hr_entrada]" class="timepicker mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" value="{{ $cooperado->pivot->hr_entrada }}" required>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Hora de Saída</label>
                                            <input type="text" name="cooperados[{{ $index }}][hr_saida]" class="timepicker mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" value="{{ $cooperado->pivot->hr_saida }}" required>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Hora Extra</label>
                                            <input type="text" name="cooperados[{{ $index }}][hr_extra]" class="timepicker mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" value="{{ $cooperado->pivot->hr_extra }}">
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Data do Serviço</label>
                                            <input type="text" name="cooperados[{{ $index }}][dt_servico]" class="date-picker mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" value="{{ \Carbon\Carbon::parse($cooperado->pivot->dt_servico)->format('d/m/Y') }}" required>
                                        </div>
                                    </div>
                                    @if($servico)
                                        <div>
                                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">ID Serviço</label>
                                            <input type="text" name="cooperados[{{ $index }}][servico_id]" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm bg-gray-100 cursor-not-allowed" value="{{ $servico->id }}" readonly>
                                        </div>
                                    @endif
                                    <div class="flex justify-end mt-4">
                                        <button type="button" onclick="removerCooperado(this)" class="btn bg-red-500 text-white hover:bg-red-600 px-3 py-1 rounded-md transition-all duration-200">Remover</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="adicionarCooperado()" class="btn bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 rounded-md transition-all duration-200 mt-4">Adicionar Cooperado</button>
                    </fieldset>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-4">
                        <button type="button" class="btn bg-gray-500 text-white hover:bg-gray-600 px-4 py-2 rounded-md transition-all duration-200" onclick="window.history.back()">Cancelar</button>
                        <button type="submit" class="btn bg-green-500 text-white hover:bg-green-600 px-4 py-2 rounded-md transition-all duration-200">Atualizar Escala</button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <!-- External Dependencies -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>

    <!-- Passar cooperados para o JavaScript -->
    <script>
        // Global variable for client functions
        window.cooperados = @json($cooperados);
        window.funcoesCliente = @json($funcoes);

        // Sort cooperados by ID
        if (window.cooperados) {
            window.cooperados.sort((a, b) => a.id - b.id);
        }

        // Format date to DD/MM/YYYY
        const formatarData = (date) => {
            const dia = String(date.getDate()).padStart(2, '0');
            const mes = String(date.getMonth() + 1).padStart(2, '0');
            const ano = date.getFullYear();
            return `${dia}/${mes}/${ano}`;
        };

        // Initialize Flatpickr
        const inicializarFlatpickr = () => {
            flatpickr(".date-picker", {
                dateFormat: "d/m/Y",
                locale: "pt",
                allowInput: true,
            });

            flatpickr(".timepicker", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                minuteIncrement: 1,
            });
        };

        // Carregar funções do cliente
        async function carregarFuncoes(clienteId) {
            if (!clienteId) {
                window.funcoesCliente = [];
                return [];
            }
            try {
                const response = await fetch(`/clientes/${clienteId}/funcoes/json`);
                if (!response.ok) throw new Error(`Erro: ${response.status}`);
                const funcoes = await response.json();
                window.funcoesCliente = funcoes;
                return funcoes;
            } catch (error) {
                console.error("Erro ao carregar funções:", error);
                window.funcoesCliente = [];
                return [];
            }
        }

        // Atualizar lista de funções
        function atualizarListaFuncoes() {
            const optionsHtml = window.funcoesCliente.length > 0
                ? `<option value="">Selecione a Função</option>${window.funcoesCliente.map(f => `<option value="${f.id}">${f.nome}</option>`).join('')}`
                : '<option value="">Nenhuma função disponível</option>';

            document.querySelectorAll('select[name$="[funcao_id]"]').forEach(select => {
                const currentValue = select.value;
                select.innerHTML = optionsHtml;
                if (currentValue) select.value = currentValue;
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', async () => {
            inicializarFlatpickr();
            document.getElementById('escalaForm').addEventListener('submit', (event) => {
                sincronizarDataServico(event);
                document.querySelectorAll('input[name$="[hr_entrada]"]').forEach(input => {
                    calcularHoraSaida(input);
                });
            });

            // Carregar funções do cliente atual
            const clienteId = document.getElementById('cliente_id_input').value;
            await carregarFuncoes(clienteId);
            atualizarListaFuncoes();

            ordenarCooperados(); // Ordenar cooperados no carregamento da página

            // Add onblur event to existing cooperado ID fields
            document.querySelectorAll('input[name$="[cooperado_id]"]').forEach(input => {
                input.removeAttribute('readonly');
                input.setAttribute('onblur', 'selecionarCooperadoPorId(this)');
            });

            // Ensure client fields are disabled as they should be
            aplicarDesativacaoCampos();
        });

        // Aplicar desativação aos campos que não devem ser editados
        function aplicarDesativacaoCampos() {
            // Disable Cliente ID and Cliente fields
            const clienteIdInput = document.getElementById('cliente_id_input');
            const clienteSelect = document.getElementById('cliente_id');

            // Disable Setor ID and Setor fields
            const setorIdInput = document.getElementById('setor_id_input');
            const setorSelect = document.getElementById('setor_id');

            // Disable Data da Solicitação field
            const dataSolicitacaoInput = document.getElementById('data_solicitacao');

            // Apply readonly and visual styling attributes for inputs - but allow form submission
            [clienteIdInput, setorIdInput, dataSolicitacaoInput].forEach(field => {
                if (field) {
                    field.setAttribute('readonly', true);
                    field.classList.add('disabled-field');
                }
            });

            // For select elements, we make them appear disabled but keep them submittable
            [clienteSelect, setorSelect].forEach(field => {
                if (field) {
                    // Add disabled-looking style but keep it functional
                    field.classList.add('disabled-field');
                    // Prevent user interaction with pointer-events
                    field.style.pointerEvents = 'none';
                    // Ensure the currently selected option remains selected
                    const currentValue = field.value;
                    field.addEventListener('mousedown', function(e) {
                        e.preventDefault();
                        this.blur();
                        return false;
                    });
                    field.addEventListener('change', function() {
                        // Reset to original value if somehow changed
                        this.value = currentValue;
                    });
                }
            });
        }

        // Função para ordenar os cooperados na interface
        const ordenarCooperados = () => {
            const container = document.getElementById('cooperados_container');
            if (!container) return;

            const items = Array.from(container.querySelectorAll('.cooperado-item'));
            if (items.length <= 1) return;

            items.sort((a, b) => {
                // Ordenar por ID do cooperado (principal critério)
                const idA = parseInt(a.querySelector('input[name$="[cooperado_id]"]')?.value || 0);
                const idB = parseInt(b.querySelector('input[name$="[cooperado_id]"]')?.value || 0);

                if (idA !== idB) {
                    return idA - idB;
                }

                // Se IDs iguais, ordenar por data (segundo critério)
                const dataA = a.querySelector('input[name$="[dt_servico]"]')?.value || '';
                const dataB = b.querySelector('input[name$="[dt_servico]"]')?.value || '';

                if (dataA && dataB) {
                    // Converter de DD/MM/YYYY para formato comparável
                    const [diaA, mesA, anoA] = dataA.split('/');
                    const [diaB, mesB, anoB] = dataB.split('/');
                    const dateA = new Date(`${anoA}-${mesA}-${diaA}`);
                    const dateB = new Date(`${anoB}-${mesB}-${diaB}`);
                    return dateA - dateB;
                }
                return 0;
            });

            // Reordenar os elementos no DOM
            items.forEach(item => container.appendChild(item));

            // Reindexar após ordenar
            reindexarCooperados();
        };

        // Add cooperado dynamically
        const adicionarCooperado = () => {
            const container = document.getElementById('cooperados_container');
            const index = document.querySelectorAll('.cooperado-item').length;
            const wrapper = document.createElement('div');
            wrapper.className = 'cooperado-item bg-gray-100 dark:bg-gray-700 p-4 rounded shadow fade-in';
            wrapper.setAttribute('data-id', index);

            const hoje = formatarData(new Date());

            // Criar opções de funções do cliente atual
            const funcaoOptions = window.funcoesCliente.length > 0
                ? window.funcoesCliente.map(f => `<option value="${f.id}">${f.nome}</option>`).join('')
                : '';

            wrapper.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">ID Cooperado</label>
                        <input type="number" name="cooperados[${index}][cooperado_id]" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" onblur="selecionarCooperadoPorId(this)">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Cooperado</label>
                        <select name="cooperados[${index}][id]" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" required onchange="atualizarIdCooperado(this)">
                            <option value="">Selecione o Cooperado</option>
                            ${window.cooperados.map(coop => `<option value="${coop.id}">${coop.nome}</option>`).join('')}
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-4 mt-4">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Função</label>
                        <select name="cooperados[${index}][funcao_id]" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300">
                            <option value="">Selecione a Função</option>
                            ${funcaoOptions}
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Hora de Entrada</label>
                        <input type="text" name="cooperados[${index}][hr_entrada]" class="timepicker mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Hora de Saída</label>
                        <input type="text" name="cooperados[${index}][hr_saida]" class="timepicker mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Hora Extra</label>
                        <input type="text" name="cooperados[${index}][hr_extra]" class="timepicker mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Data do Serviço</label>
                        <input type="text" name="cooperados[${index}][dt_servico]" class="date-picker mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" value="${hoje}" required>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Dias de Serviço</label>
                        <input type="number" name="cooperados[${index}][dias_servico]" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-300" value="1" min="1" max="30">
                        <p class="text-sm text-gray-500 mt-1">Número de dias consecutivos para este serviço</p>
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="button" onclick="removerCooperado(this)" class="btn bg-red-500 text-white hover:bg-red-600 px-3 py-1 rounded-md transition-all duration-200">Remover</button>
                </div>
            `;

            container.appendChild(wrapper);
            inicializarFlatpickr();
            inicializarEventosOrdenacao();
            reindexarCooperados();
            ordenarCooperados(); // Ordenar após adicionar um novo cooperado

            // Apply highlight effect that fades out after a moment
            wrapper.classList.add('highlight');
            setTimeout(() => {
                wrapper.classList.remove('highlight');
            }, 1500);

            // Scroll to the newly added element
            setTimeout(() => {
                wrapper.scrollIntoView({ behavior: 'smooth', block: 'end' });
            }, 100);
        };

        // Atualizar ID do cooperado quando o select mudar
        function atualizarIdCooperado(select) {
            const cooperadoId = select.value;
            const wrapper = select.closest('.cooperado-item');
            if (wrapper) {
                const idInput = wrapper.querySelector('input[name$="[cooperado_id]"]');
                if (idInput) {
                    idInput.value = cooperadoId;
                    setTimeout(ordenarCooperados, 100); // Ordenar após mudar o ID
                }
            }
        }

        // Remove cooperado
        const removerCooperado = (button) => {
            const cooperadoItem = button.closest('.cooperado-item');
            cooperadoItem.remove();
            atualizarBloqueioCliente();
            reindexarCooperados();
        };

        // Function to select cooperado by ID
        const selecionarCooperadoPorId = (input) => {
            const cooperados = window.cooperados;
            if (!cooperados || cooperados.length === 0) return;

            const cooperadoSelect = input.closest('.cooperado-item').querySelector('select[name$="[id]"]');
            if (!cooperadoSelect) return;

            const id = parseInt(input.value);
            if (isNaN(id)) return;

            const cooperado = cooperados.find(c => c.id === id);
            if (cooperado) {
                cooperadoSelect.value = cooperado.id;
                setTimeout(ordenarCooperados, 100); // Ordenar após selecionar por ID
            } else {
                alert("Cooperado com ID " + id + " não encontrado.");
                input.value = '';
            }
        };

        // Function to reindex cooperados after sorting or removing
        const reindexarCooperados = () => {
            const items = document.querySelectorAll('.cooperado-item');
            items.forEach((item, idx) => {
                item.setAttribute('data-id', idx);

                // Update all input and select names
                item.querySelectorAll('input, select').forEach(el => {
                    if (el.name) {
                        el.name = el.name.replace(/cooperados\[\d+\]/, `cooperados[${idx}]`);
                    }
                });
            });
        };

        // Atualizar bloqueio de cliente
        const atualizarBloqueioCliente = () => {
            // Esta função não precisa fazer nada na edição, pois os campos já estão bloqueados
        };

        // Add this function if it doesn't exist
        function inicializarEventosOrdenacao() {
            // Implementation for sorting events if needed
        }

        // Add empty function to prevent errors
        function sincronizarDataServico(event) {
            // Implementation if needed
        }

        // Add empty function to prevent errors
        function calcularHoraSaida(input) {
            // Implementation if needed
        }
    </script>

    <!-- Custom Styles -->
    <style>
        .btn {
            transition: all 0.2s ease-in-out;
        }
        .form-section {
            border: 1px solid #e5e7eb;
        }
        @media (max-width: 640px) {
            .grid-cols-4, .grid-cols-5 {
                grid-template-columns: 1fr;
            }
        }
        /* Style for disabled fields */
        .disabled-field {
            background-color: #f3f4f6;
            cursor: not-allowed;
        }
        /* Animation for new cooperado */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        /* Highlight effect */
        .highlight {
            background-color: #fbf8cc !important;
            transition: background-color 1s ease;
        }
    </style>
</x-app-layout>
