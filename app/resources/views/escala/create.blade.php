<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Criar Escala') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Mensagem de Sucesso -->
        @if (session('success'))
            <div id="success-message" class="fixed top-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-300 flex items-center space-x-2" role="alert" aria-live="polite">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ session('success') }}</span>
                <button type="button" class="ml-2 text-white hover:text-gray-200" onclick="this.parentElement.remove()" aria-label="{{ __('Fechar mensagem de sucesso') }}">
                    ✕
                </button>
            </div>
        @endif

        <!-- Mensagem de Erro -->
        @if ($errors->any())
            <section class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md" role="alert" aria-live="assertive">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <strong class="font-bold">{{ __('Erro!') }}</strong>
                    </div>
                    <p class="mt-2">{{ __('Por favor, corrija os seguintes erros:') }}</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </section>
        @endif

        <section class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow-lg sm:rounded-xl p-6 md:p-8">
                <form method="POST" action="{{ route('escala.store') }}" id="eventForm" class="space-y-8" novalidate>
                    @csrf

                    <!-- Campos Ocultos -->
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="data_servico" id="data_servico">
                    <input type="hidden" id="clienteIdHidden" name="cliente_id">
                    <input type="hidden" id="setorIdHidden" name="setor_id">

                    <!-- Seção 1: Dados do Evento -->
                    <fieldset class="p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <legend class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ __('Dados do Evento') }}
                        </legend>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div>
                                <label for="clienteIdInput" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('ID do Cliente') }}
                                    <span class="text-gray-500 text-xs ml-1" title="{{ __('Digite o ID do cliente para buscar') }}">(?)</span>
                                </label>
                                <input type="number" id="clienteIdInput" placeholder="{{ __('Digite o ID') }}" class="mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" onblur="debouncedUpdateClienteById(this.value)">
                            </div>
                            <div>
                                <label for="cliente_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Cliente') }}</label>
                                <select id="cliente_id" class="mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" onchange="onClienteChange(this)">
                                    <option value="">{{ __('Selecione o Cliente') }}</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->fantasia }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="setorIdInput" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('ID do Setor') }}
                                    <span class="text-gray-500 text-xs ml-1" title="{{ __('Digite o ID do setor para buscar') }}">(?)</span>
                                </label>
                                <input type="number" id="setorIdInput" placeholder="{{ __('Digite o ID') }}" class="mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" onblur="updateSetorById(this.value)">
                            </div>
                            <div>
                                <label for="setor_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Setor') }}</label>
                                <select id="setor_id" class="mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" onchange="onSetorChange(this)" disabled>
                                    <option value="">{{ __('Selecione o Setor') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="nome_evento" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Nome do Evento (Opcional)') }}</label>
                            <input type="text" id="nome_evento" name="nome_evento" class="mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" placeholder="{{ __('Digite o nome do evento') }}">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label for="data_solicitacao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Data da Solicitação') }}</label>
                                <input type="text" id="data_solicitacao" name="data_solicitacao" class="mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-100 dark:bg-gray-600 dark:text-gray-200" readonly>
                            </div>
                            <div>
                                <label for="data_inicio_servico" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Data de Início do Serviço') }} <span class="text-red-500">*</span></label>
                                <input type="text" id="data_inicio_servico" name="data_inicio_servico" class="mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" required>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Seção 2: Observações -->
                    <fieldset class="p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <legend class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            {{ __('Observações') }}
                        </legend>
                        <div>
                            <label for="observacoes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Observações') }}</label>
                            <textarea id="observacoes" name="observacoes" rows="4" class="mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" placeholder="{{ __('Digite suas observações aqui') }}"></textarea>
                        </div>
                    </fieldset>

                    <!-- Seção 3: Cooperados -->
                    <fieldset class="p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <legend class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            {{ __('Cooperados') }}
                        </legend>
                        <div id="cooperadosContainer" class="space-y-4"></div>
                        <button type="button" onclick="adicionaCooperado()" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-lg transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            {{ __('Adicionar Cooperado') }}
                        </button>
                    </fieldset>

                    <!-- Botões de Ação -->
                    <div class="flex justify-end gap-4">
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white hover:bg-gray-600 rounded-lg transition-all duration-200" onclick="confirmCancel()">
                            {{ __('Cancelar') }}
                        </button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white hover:bg-green-700 rounded-lg transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ __('Salvar Escala') }}
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Flatpickr Portuguese Locale -->
    <script src="https://npmcdn.com/flatpickr@4.6.13/dist/l10n/pt.js"></script>

    <!-- Custom CSS -->
    <style>
        .time-input-wrapper {
            position: relative;
        }
        .time-input-wrapper input {
            padding-left: 40px !important;
        }
        .time-input-wrapper input.invalid {
            border-color: #ef4444;
        }
        .error-message {
            display: none;
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        .error-message.visible {
            display: block;
        }
        .flatpickr-calendar {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>

    @verbatim
    <script>
        // Constantes
        const STANDARD_SHIFT_MINUTES = 8 * 60; // 8 horas em minutos
        const DATE_FORMAT = "d/m/Y";
        const TIME_FORMAT = "H:i";
        window.funcoesCliente = []; // Armazena funções do cliente

        // Função de debounce
        function debounce(func, wait) {
            let timeout;
            return (...args) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => func(...args), wait);
            };
        }

        // Inicialização
        document.addEventListener('DOMContentLoaded', () => {
            setDataSolicitacaoToday();
            initializeDatePickers();
            document.getElementById('eventForm').addEventListener('submit', syncServiceDate);

            // Fade out da mensagem de sucesso
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.opacity = '0';
                    setTimeout(() => successMessage.remove(), 300);
                }, 5000);
            }
        });

        // Definir data atual
        function setDataSolicitacaoToday() {
            const today = new Date().toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' });
            document.getElementById('data_solicitacao').value = today;
        }

        // Inicializar Flatpickr
        function initializeDatePickers() {
            flatpickr("#data_inicio_servico", {
                dateFormat: DATE_FORMAT,
                minDate: "today",
                locale: "pt",
                firstDayOfWeek: 1,
                onChange: updateDtServicoFromEvento
            });

            flatpickr(".timepicker", {
                enableTime: true,
                noCalendar: true,
                dateFormat: TIME_FORMAT,
                time_24hr: true,
                minuteIncrement: 1,
                locale: "pt"
            });
        }

        // Sincronizar data_servico
        function syncServiceDate() {
            const [day, month, year] = document.getElementById('data_inicio_servico').value.split('/');
            document.getElementById('data_servico').value = `${year}-${month}-${day}`;
        }

        // Carregar setores
        async function carregarSetores(clienteId) {
            const setorSelect = document.getElementById('setor_id');
            setorSelect.disabled = true;
            setorSelect.innerHTML = '<option value="">Carregando...</option>';

            if (!clienteId) {
                setorSelect.innerHTML = '<option value="">Selecione o Setor</option>';
                return;
            }

            try {
                const response = await fetch(`/clientes/${clienteId}/setores`);
                if (!response.ok) throw new Error(`Erro: ${response.status}`);
                const setores = await response.json();

                setorSelect.innerHTML = '<option value="">Selecione o Setor</option>';
                setores.forEach(setor => {
                    setorSelect.insertAdjacentHTML('beforeend', `<option value="${setor.id}">${setor.nome}</option>`);
                });
                setorSelect.disabled = false;
            } catch (error) {
                console.error("Erro ao carregar setores:", error);
                setorSelect.innerHTML = '<option value="">Erro ao carregar</option>';
            }
        }

        // Carregar funções do cliente
        async function carregarFuncoes(clienteId) {
            if (!clienteId) {
                window.funcoesCliente = [];
                return;
            }
            try {
                const response = await fetch(`/clientes/${clienteId}/funcoes/json`);
                if (!response.ok) throw new Error(`Erro: ${response.status}`);
                window.funcoesCliente = await response.json();
            } catch (error) {
                console.error("Erro ao carregar funções:", error);
                window.funcoesCliente = [];
            }
        }

        // Atualizar lista de funções
        function atualizarListaFuncoes() {
            const optionsHtml = window.funcoesCliente.length > 0
                ? `<option value="">Selecione a Função</option>${window.funcoesCliente.map(f => `<option value="${f.id}">${f.nome}</option>`).join('')}`
                : '<option value="">Nenhuma função disponível</option>';
            document.querySelectorAll('select[name="funcoes_cooperado[]"]').forEach(select => {
                const currentValue = select.value;
                select.innerHTML = optionsHtml;
                if (currentValue) select.value = currentValue;
            });
        }

        // Atualizar cliente por ID com debounce
        const debouncedUpdateClienteById = debounce(async (clienteId) => {
            const clienteSelect = document.getElementById('cliente_id');
            const option = Array.from(clienteSelect.options).find(opt => opt.value === clienteId);
            if (option) {
                clienteSelect.value = clienteId;
                document.getElementById('clienteIdHidden').value = clienteId; // Sincroniza o campo oculto
                document.getElementById('setorIdInput').value = "";
                carregarSetores(clienteId);
                await carregarFuncoes(clienteId);
                atualizarListaFuncoes();
                atualizarBloqueioCliente();
            } else {
                alert("Cliente não encontrado.");
            }
        }, 300);

        // Evento de mudança de cliente
        async function onClienteChange(selectElement) {
            const clienteId = selectElement.value;
            document.getElementById('clienteIdInput').value = clienteId;
            document.getElementById('clienteIdHidden').value = clienteId; // Sincroniza o campo oculto
            document.getElementById('setorIdInput').value = "";
            carregarSetores(clienteId);
            await carregarFuncoes(clienteId);
            atualizarListaFuncoes();
            atualizarBloqueioCliente();
        }

        // Atualizar setor por ID
        function updateSetorById(setorId) {
            const setorSelect = document.getElementById('setor_id');
            const option = Array.from(setorSelect.options).find(opt => opt.value === setorId);
            if (option) {
                setorSelect.value = setorId;
                document.getElementById('setorIdHidden').value = setorId; // Sincroniza o campo oculto
            } else {
                alert("Setor não encontrado.");
            }
        }

        // Evento de mudança de setor
        function onSetorChange(selectElement) {
            document.getElementById('setorIdInput').value = selectElement.value;
            document.getElementById('setorIdHidden').value = selectElement.value; // Sincroniza o campo oculto
        }

        // Validação antes de enviar o formulário
        document.getElementById('eventForm').addEventListener('submit', function (event) {
            const clienteId = document.getElementById('clienteIdHidden').value;
            const setorId = document.getElementById('setorIdHidden').value;

            if (!clienteId || !setorId) {
                event.preventDefault();
                alert('Por favor, selecione um cliente e um setor antes de salvar.');
            }
        });

        // Bloquear campos de cliente
        function atualizarBloqueioCliente() {
            const bloquear = Array.from(document.querySelectorAll('select[name="funcoes_cooperado[]"]')).some(s => s.value !== "");
            document.getElementById('cliente_id').disabled = bloquear;
            document.getElementById('clienteIdInput').disabled = bloquear;
        }

        // Converter horário para minutos
        function timeToMinutes(time) {
            if (!time) return 0;
            const [hours, minutes] = time.split(':').map(Number);
            return hours * 60 + minutes;
        }

        // Converter minutos para horário
        function minutesToTime(minutes) {
            minutes = minutes % (24 * 60);
            if (minutes < 0) minutes += 24 * 60;
            const hours = Math.floor(minutes / 60);
            const mins = minutes % 60;
            return `${hours.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}`;
        }

        // Calcular hora de saída
        function calculaHoraSaida(input) {
            const entrada = input.value;
            if (!entrada) return;
            const entradaMinutes = timeToMinutes(entrada);
            const saidaMinutes = entradaMinutes + STANDARD_SHIFT_MINUTES;
            const grupo = input.closest('.cooperado-wrapper');
            if (grupo) {
                const hrSaida = grupo.querySelector('input[name="hr_saida[]"]');
                if (hrSaida) {
                    hrSaida.value = minutesToTime(saidaMinutes);
                    calcularHoraExtra(hrSaida);
                }
            }
        }

        // Calcular hora extra
        function calcularHoraExtra(input) {
            const grupo = input.closest('.cooperado-wrapper');
            if (!grupo) return;

            const hrEntrada = grupo.querySelector('input[name="hr_entrada[]"]').value;
            const hrSaida = input.value;
            const hrExtraInput = grupo.querySelector('input[name="hr_extra[]"]');

            if (!hrEntrada || !hrSaida) {
                hrExtraInput.value = "00:00";
                return;
            }

            let diffMinutes = timeToMinutes(hrSaida) - timeToMinutes(hrEntrada);
            if (diffMinutes < 0) diffMinutes += 24 * 60;

            if (diffMinutes < 0) {
                input.classList.add('invalid');
                input.nextElementSibling.textContent = "Hora de Saída deve ser posterior à Entrada.";
                input.nextElementSibling.classList.add('visible');
                hrExtraInput.value = "00:00";
            } else {
                input.classList.remove('invalid');
                input.nextElementSibling.classList.remove('visible');
                const extraMinutes = Math.max(diffMinutes - STANDARD_SHIFT_MINUTES, 0);
                hrExtraInput.value = minutesToTime(extraMinutes);
            }
        }

        // Atualizar horas automaticamente
        function atualizarHoras(inputElement) {
            const wrapper = inputElement.closest('.cooperado-wrapper');
            if (!wrapper) return;

            const funcaoSelect = wrapper.querySelector('select[name="funcoes_cooperado[]"]');
            const hrEntradaInput = wrapper.querySelector('input[name="hr_entrada[]"]');
            const hrSaidaInput = wrapper.querySelector('input[name="hr_saida[]"]');
            const hrExtraInput = wrapper.querySelector('input[name="hr_extra[]"]');

            if (funcaoSelect.value && hrEntradaInput.value) {
                calculaHoraSaida(hrEntradaInput);
            } else {
                hrSaidaInput.value = "";
                hrExtraInput.value = "00:00";
            }
        }

        // Marcar data de serviço alterada
        function markDtServicoChanged(input) {
            input.dataset.changed = 'true';
        }

        // Atualizar data de serviço dos cooperados
        function updateDtServicoFromEvento() {
            const dataEvento = document.getElementById('data_inicio_servico').value || '';
            document.querySelectorAll('input[name="dt_servico[]"]').forEach(input => {
                if (input.dataset.changed !== 'true') input.value = dataEvento;
            });
        }

        // Adicionar cooperado
        async function adicionaCooperado() {
            const clienteId = document.getElementById('clienteIdHidden').value || document.getElementById('cliente_id').value;
            if (!clienteId) {
                alert("Selecione um cliente antes de adicionar cooperados.");
                return;
            }

            await carregarFuncoes(clienteId);
            const container = document.getElementById('cooperadosContainer');
            const funcaoOptions = window.funcoesCliente.length > 0
                ? `<option value="">Selecione a Função</option>${window.funcoesCliente.map(f => `<option value="${f.id}">${f.nome}</option>`).join('')}`
                : '<option value="">Nenhuma função disponível</option>';
            const dataEvento = document.getElementById('data_inicio_servico').value || '';
            const uniqueId = Date.now();

            const wrapper = document.createElement('div');
            wrapper.classList.add('cooperado-wrapper', 'bg-gray-100', 'dark:bg-gray-700', 'p-4', 'rounded-lg', 'shadow-sm', 'border', 'border-gray-200', 'dark:border-gray-600', 'relative');
            wrapper.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="cooperado_id_${uniqueId}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID do Cooperado</label>
                        <input id="cooperado_id_${uniqueId}" type="number" name="cooperado_id[]" class="mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" onblur="updateCooperadoById(this)">
                    </div>
                    <div>
                        <label for="cooperado_${uniqueId}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cooperado</label>
                        <select id="cooperado_${uniqueId}" name="cooperados[]" class="mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200">
                            <option value="">Selecione o Cooperado</option>
                            @endverbatim
                            @foreach($cooperados as $cooperado)
                                <option value="{{ $cooperado->id }}">{{ $cooperado->nome }}</option>
                            @endforeach
                            @verbatim
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-4">
                    <div>
                        <label for="funcao_${uniqueId}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Função</label>
                        <select id="funcao_${uniqueId}" name="funcoes_cooperado[]" class="mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" onchange="atualizarBloqueioCliente(); atualizarHoras(this);">
                            ${funcaoOptions}
                        </select>
                    </div>
                    <div class="time-input-wrapper">
                        <label for="hr_entrada_${uniqueId}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hora de Entrada <span class="text-red-500">*</span></label>
                        <input id="hr_entrada_${uniqueId}" type="text" name="hr_entrada[]" class="timepicker mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" required onblur="atualizarHoras(this);">
                        <p class="error-message" aria-live="polite"></p>
                    </div>
                    <div class="time-input-wrapper">
                        <label for="hr_saida_${uniqueId}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hora de Saída <span class="text-red-500">*</span></label>
                        <input id="hr_saida_${uniqueId}" type="text" name="hr_saida[]" class="timepicker mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" required onblur="calcularHoraExtra(this);">
                        <p class="error-message" aria-live="polite"></p>
                    </div>
                    <div class="time-input-wrapper">
                        <label for="hr_extra_${uniqueId}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hora Extra</label>
                        <input id="hr_extra_${uniqueId}" type="text" name="hr_extra[]" class="mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" readonly>
                        <p class="error-message" aria-live="polite"></p>
                    </div>
                    <div>
                        <label for="dt_servico_${uniqueId}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data do Serviço</label>
                        <input id="dt_servico_${uniqueId}" type="text" name="dt_servico[]" value="${dataEvento}" class="date-picker mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" onchange="markDtServicoChanged(this)">
                    </div>
                <div>
    <label for="dias_servico_${uniqueId}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dias de Serviço</label>
    <input id="dias_servico_${uniqueId}" type="number" name="dias_servico[]" class="mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" min="1" value="1">
    <p class="text-xs text-gray-500 mt-1">Número de dias consecutivos a partir da data do serviço.</p>
</div>
                </div>
                <div class="absolute top-2 right-2">
                    <button type="button" onclick="this.closest('.cooperado-wrapper').remove(); atualizarBloqueioCliente();" class="text-red-500 hover:text-red-700" aria-label="Remover Cooperado">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            `;
            container.appendChild(wrapper);

            flatpickr(wrapper.querySelectorAll('.date-picker'), {
                dateFormat: DATE_FORMAT,
                locale: "pt",
                firstDayOfWeek: 1
            });

            flatpickr(wrapper.querySelectorAll('.timepicker'), {
                enableTime: true,
                noCalendar: true,
                dateFormat: TIME_FORMAT,
                time_24hr: true,
                minuteIncrement: 1,
                locale: "pt"
            });
        }

        // Atualizar cooperado por ID
        function updateCooperadoById(inputElement) {
            const cooperadoId = inputElement.value;
            const wrapper = inputElement.closest('.cooperado-wrapper');
            if (wrapper) {
                const cooperadoSelect = wrapper.querySelector('select[name="cooperados[]"]');
                const option = Array.from(cooperadoSelect.options).find(opt => opt.value === cooperadoId);
                if (option) {
                    cooperadoSelect.value = cooperadoId;
                } else {
                    alert("Cooperado não encontrado.");
                }
            }
        }

        // Confirmação de cancelamento
        function confirmCancel() {
            if (confirm("Deseja cancelar? Alterações não salvas serão perdidas.")) {
                window.history.back();
            }
        }
    </script>
    @endverbatim
</x-app-layout>
