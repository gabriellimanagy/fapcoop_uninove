<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 leading-tight tracking-tight">
            {{ __('Editar Cooperado') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-xl p-8">
                <form action="{{ route('cooperados.update', $cooperado) }}" method="POST" id="cooperadoForm">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-md">
                            <strong class="font-semibold">Atenção!</strong> Verifique os seguintes erros:
                            <ul class="list-disc ml-6 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Dados básicos do cooperado -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b-2 border-gray-200 dark:border-gray-700 pb-2">Dados Básicos</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="matricula" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Matrícula</label>
                                <input type="text" id="matricula_display" class="mt-1 block w-full rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed border border-gray-300 dark:border-gray-600 py-2 px-3" value="{{ $cooperado->matricula }}" disabled>
                                <input type="hidden" name="matricula" value="{{ $cooperado->matricula }}">
                            </div>
                            <div>
                                <label for="dt_cadastro" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data de Cadastro</label>
                                <input type="date" id="dt_cadastro_display" class="mt-1 block w-full rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed border border-gray-300 dark:border-gray-600 py-2 px-3" value="{{ $cooperado->dt_cadastro }}" disabled>
                                <input type="hidden" name="dt_cadastro" value="{{ $cooperado->dt_cadastro }}">
                            </div>
                            <div>
                                <label for="dt_ultima_escala" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data da Última Escala</label>
                                <input type="date" id="dt_ultima_escala_display" class="mt-1 block w-full rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed border border-gray-300 dark:border-gray-600 py-2 px-3" value="{{ $cooperado->dt_ultima_escala }}" disabled>
                                <input type="hidden" name="dt_ultima_escala" value="{{ $cooperado->dt_ultima_escala }}">
                            </div>
                            <div>
                                <label for="nome" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                                <input type="text" name="nome" id="nome" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->nome }}" required>
                            </div>
                            <div>
                                <label for="sexo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sexo</label>
                                <select name="sexo" id="sexo" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" required>
                                    <option value="M" {{ $cooperado->sexo == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ $cooperado->sexo == 'F' ? 'selected' : '' }}>Feminino</option>
                                </select>
                            </div>
                            <div>
                                <label for="dt_desligamento" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data de Desligamento</label>
                                <input type="date" id="dt_desligamento_display" class="mt-1 block w-full rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed border border-gray-300 dark:border-gray-600 py-2 px-3" value="{{ $cooperado->dt_desligamento }}" disabled>
                                <input type="hidden" name="dt_desligamento" value="{{ $cooperado->dt_desligamento }}">
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" required>
                                    <option value="Ativo" {{ $cooperado->status == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                                    <option value="Inativo" {{ $cooperado->status == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                                    <option value="Suspenso" {{ $cooperado->status == 'Suspenso' ? 'selected' : '' }}>Suspenso</option>
                                    <option value="Desligado" {{ $cooperado->status == 'Desligado' ? 'selected' : '' }}>Desligado</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Sistema de abas -->
                    <div class="mt-10" x-data="{ activeTab: 'contatos' }">
                        <!-- Navegação das abas -->
                        <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                                <li class="mr-2">
                                    <button type="button" @click="activeTab = 'contatos'" class="inline-block p-4 rounded-t-lg transition-all duration-200" :class="activeTab === 'contatos' ? 'border-b-2 border-blue-600 text-blue-600 dark:text-blue-400 bg-gray-50 dark:bg-gray-700' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700'">Contatos</button>
                                </li>
                                <li class="mr-2">
                                    <button type="button" @click="activeTab = 'pessoais'" class="inline-block p-4 rounded-t-lg transition-all duration-200" :class="activeTab === 'pessoais' ? 'border-b-2 border-blue-600 text-blue-600 dark:text-blue-400 bg-gray-50 dark:bg-gray-700' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700'">Dados Pessoais</button>
                                </li>
                                <li class="mr-2">
                                    <button type="button" @click="activeTab = 'documentos'" class="inline-block p-4 rounded-t-lg transition-all duration-200" :class="activeTab === 'documentos' ? 'border-b-2 border-blue-600 text-blue-600 dark:text-blue-400 bg-gray-50 dark:bg-gray-700' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700'">Documentos</button>
                                </li>
                                <li class="mr-2">
                                    <button type="button" @click="activeTab = 'financeiro'" class="inline-block p-4 rounded-t-lg transition-all duration-200" :class="activeTab === 'financeiro' ? 'border-b-2 border-blue-600 text-blue-600 dark:text-blue-400 bg-gray-50 dark:bg-gray-700' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700'">Financeiro</button>
                                </li>
                                <li>
                                    <button type="button" @click="activeTab = 'disponibilidade'" class="inline-block p-4 rounded-t-lg transition-all duration-200" :class="activeTab === 'disponibilidade' ? 'border-b-2 border-blue-600 text-blue-600 dark:text-blue-400 bg-gray-50 dark:bg-gray-700' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700'">Disponibilidade</button>
                                </li>
                            </ul>
                        </div>

                        <!-- Conteúdo das abas -->
                        <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-b-lg shadow-inner">
                            <!-- Aba de Contatos -->
                            <div x-show="activeTab === 'contatos'" class="space-y-6">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Informações de Contato</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="celular" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Celular</label>
                                        <input type="text" name="celular" id="celular" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->contato->celular ?? '' }}">
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="whatsapp" id="whatsapp" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" {{ isset($cooperado->contato->whatsapp) && $cooperado->contato->whatsapp ? 'checked' : '' }}>
                                        <label for="whatsapp" class="ml-2 text-sm text-gray-700 dark:text-gray-300">WhatsApp</label>
                                    </div>
                                    <div>
                                        <label for="telefone1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telefone 1</label>
                                        <input type="text" name="telefone1" id="telefone1" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->contato->telefone1 ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="telefone2" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telefone 2</label>
                                        <input type="text" name="telefone2" id="telefone2" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->contato->telefone2 ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                                        <input type="email" name="email" id="email" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->contato->email ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="cep" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CEP</label>
                                        <input type="text" name="cep" id="cep" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->contato->cep ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="endereco" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Endereço</label>
                                        <input type="text" name="endereco" id="endereco" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->contato->endereco ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="zona" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Zona</label>
                                        <input type="text" name="zona" id="zona" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->contato->zona ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="bairro" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bairro</label>
                                        <input type="text" name="bairro" id="bairro" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->contato->bairro ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="cidade" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cidade</label>
                                        <input type="text" name="cidade" id="cidade" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->contato->cidade ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="uf" class="block text-sm font-medium text-gray-700 dark:text-gray-300">UF</label>
                                        <select name="uf" id="uf" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all">
                                            <option value="">Selecione...</option>
                                            @foreach(['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'] as $uf)
                                                <option value="{{ $uf }}" {{ (isset($cooperado->contato->uf) && $cooperado->contato->uf == $uf) ? 'selected' : '' }}>{{ $uf }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Aba de Dados Pessoais -->
                            <div x-show="activeTab === 'pessoais'" class="space-y-6">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Dados Pessoais</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="dt_nascimento" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data de Nascimento</label>
                                        <input type="date" name="dt_nascimento" id="dt_nascimento" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->dadosPessoais->dt_nascimento ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="nacionalidade" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nacionalidade</label>
                                        <input type="text" name="nacionalidade" id="nacionalidade" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->dadosPessoais->nacionalidade ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="nome_mae" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome da Mãe</label>
                                        <input type="text" name="nome_mae" id="nome_mae" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->dadosPessoais->nome_mae ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="nome_pai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome do Pai</label>
                                        <input type="text" name="nome_pai" id="nome_pai" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->dadosPessoais->nome_pai ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="est_civil" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado Civil</label>
                                        <select name="est_civil" id="est_civil" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all">
                                            <option value="">Selecione...</option>
                                            <option value="Solteiro(a)" {{ (isset($cooperado->dadosPessoais->est_civil) && $cooperado->dadosPessoais->est_civil == 'Solteiro(a)') ? 'selected' : '' }}>Solteiro(a)</option>
                                            <option value="Casado(a)" {{ (isset($cooperado->dadosPessoais->est_civil) && $cooperado->dadosPessoais->est_civil == 'Casado(a)') ? 'selected' : '' }}>Casado(a)</option>
                                            <option value="Divorciado(a)" {{ (isset($cooperado->dadosPessoais->est_civil) && $cooperado->dadosPessoais->est_civil == 'Divorciado(a)') ? 'selected' : '' }}>Divorciado(a)</option>
                                            <option value="Viúvo(a)" {{ (isset($cooperado->dadosPessoais->est_civil) && $cooperado->dadosPessoais->est_civil == 'Viúvo(a)') ? 'selected' : '' }}>Viúvo(a)</option>
                                            <option value="União Estável" {{ (isset($cooperado->dadosPessoais->est_civil) && $cooperado->dadosPessoais->est_civil == 'União Estável') ? 'selected' : '' }}>União Estável</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="escolaridade" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Escolaridade</label>
                                        <select name="escolaridade" id="escolaridade" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all">
                                            <option value="">Selecione...</option>
                                            <option value="Analfabeto" {{ (isset($cooperado->dadosPessoais->escolaridade) && $cooperado->dadosPessoais->escolaridade == 'Analfabeto') ? 'selected' : '' }}>Analfabeto</option>
                                            <option value="Fundamental Incompleto" {{ (isset($cooperado->dadosPessoais->escolaridade) && $cooperado->dadosPessoais->escolaridade == 'Fundamental Incompleto') ? 'selected' : '' }}>Fundamental Incompleto</option>
                                            <option value="Fundamental Completo" {{ (isset($cooperado->dadosPessoais->escolaridade) && $cooperado->dadosPessoais->escolaridade == 'Fundamental Completo') ? 'selected' : '' }}>Fundamental Completo</option>
                                            <option value="Médio Incompleto" {{ (isset($cooperado->dadosPessoais->escolaridade) && $cooperado->dadosPessoais->escolaridade == 'Médio Incompleto') ? 'selected' : '' }}>Médio Incompleto</option>
                                            <option value="Médio Completo" {{ (isset($cooperado->dadosPessoais->escolaridade) && $cooperado->dadosPessoais->escolaridade == 'Médio Completo') ? 'selected' : '' }}>Médio Completo</option>
                                            <option value="Superior Incompleto" {{ (isset($cooperado->dadosPessoais->escolaridade) && $cooperado->dadosPessoais->escolaridade == 'Superior Incompleto') ? 'selected' : '' }}>Superior Incompleto</option>
                                            <option value="Superior Completo" {{ (isset($cooperado->dadosPessoais->escolaridade) && $cooperado->dadosPessoais->escolaridade == 'Superior Completo') ? 'selected' : '' }}>Superior Completo</option>
                                            <option value="Pós-Graduação" {{ (isset($cooperado->dadosPessoais->escolaridade) && $cooperado->dadosPessoais->escolaridade == 'Pós-Graduação') ? 'selected' : '' }}>Pós-Graduação</option>
                                            <option value="Mestrado" {{ (isset($cooperado->dadosPessoais->escolaridade) && $cooperado->dadosPessoais->escolaridade == 'Mestrado') ? 'selected' : '' }}>Mestrado</option>
                                            <option value="Doutorado" {{ (isset($cooperado->dadosPessoais->escolaridade) && $cooperado->dadosPessoais->escolaridade == 'Doutorado') ? 'selected' : '' }}>Doutorado</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="qualificacao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Qualificação (1-5)</label>
                                        <input type="number" name="qualificacao" id="qualificacao" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" min="1" max="5" value="{{ $cooperado->dadosPessoais->qualificacao ?? '' }}">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="qualificacao_justificativa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Justificativa da Qualificação</label>
                                        <textarea name="qualificacao_justificativa" id="qualificacao_justificativa" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" rows="3">{{ $cooperado->dadosPessoais->qualificacao_justificativa ?? '' }}</textarea>
                                    </div>
                                    <div>
                                        <label for="indicado_por" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Indicado por</label>
                                        <input type="text" name="indicado_por" id="indicado_por" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->dadosPessoais->indicado_por ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Aba de Documentos -->
                            <div x-show="activeTab === 'documentos'" class="space-y-6">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Documentação</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="cpf" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CPF</label>
                                        <input type="text" name="cpf" id="cpf" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->documentos->cpf ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="ccm" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CCM</label>
                                        <input type="text" name="ccm" id="ccm" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->documentos->ccm ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="num_pis_inss" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número PIS/INSS</label>
                                        <input type="text" name="num_pis_inss" id="num_pis_inss" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->documentos->num_pis_inss ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="rg" class="block text-sm font-medium text-gray-700 dark:text-gray-300">RG</label>
                                        <input type="text" name="rg" id="rg" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->documentos->rg ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="dt_emissao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data de Emissão</label>
                                        <input type="date" name="dt_emissao" id="dt_emissao" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->documentos->dt_emissao ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="orgao_emissor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Órgão Emissor</label>
                                        <input type="text" name="orgao_emissor" id="orgao_emissor" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->documentos->orgao_emissor ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="cidade_natal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cidade Natal</label>
                                        <input type="text" name="cidade_natal" id="cidade_natal" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->documentos->cidade_natal ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="dt_entrega_at_saude" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data de Entrega AT Saúde</label>
                                        <input type="date" name="dt_entrega_at_saude" id="dt_entrega_at_saude" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->documentos->dt_entrega_at_saude ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="carteira_trab" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Carteira de Trabalho</label>
                                        <input type="text" name="carteira_trab" id="carteira_trab" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->documentos->carteira_trab ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="serie" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Série</label>
                                        <input type="text" name="serie" id="serie" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->documentos->serie ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="titulo_eleitor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título de Eleitor</label>
                                        <input type="text" name="titulo_eleitor" id="titulo_eleitor" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->documentos->titulo_eleitor ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="zona_eleitoral" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Zona Eleitoral</label>
                                        <input type="text" name="zona_eleitoral" id="zona_eleitoral" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->documentos->zona_eleitoral ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="num_cracha_carteirinha" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número do Crachá/Carteirinha</label>
                                        <input type="text" name="num_cracha_carteirinha" id="num_cracha_carteirinha" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->documentos->num_cracha_carteirinha ?? '' }}">
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="cracha_cart_possui" id="cracha_cart_possui" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" {{ isset($cooperado->documentos->cracha_cart_possui) && $cooperado->documentos->cracha_cart_possui ? 'checked' : '' }}>
                                        <label for="cracha_cart_possui" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Possui Crachá/Carteirinha</label>
                                    </div>
                                    <div>
                                        <label for="antecedentes_criminais_dt_consulta" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data de Consulta de Antecedentes Criminais</label>
                                        <input type="date" name="antecedentes_criminais_dt_consulta" id="antecedentes_criminais_dt_consulta" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->documentos->antecedentes_criminais_dt_consulta ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="antecedentes_consultado_por" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Consultado por</label>
                                        <input type="text" name="antecedentes_consultado_por" id="antecedentes_consultado_por" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->documentos->antecedentes_consultado_por ?? '' }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status da Consulta</label>
                                        <div class="flex space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="status_antecedentes" value="não consultado" class="form-radio text-blue-600 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" {{ (isset($cooperado->documentos->status) && $cooperado->documentos->status == 'não consultado') ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Não consultado</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="status_antecedentes" value="nada consta" class="form-radio text-blue-600 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" {{ (isset($cooperado->documentos->status) && $cooperado->documentos->status == 'nada consta') ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Nada consta</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="status_antecedentes" value="com apontamento" class="form-radio text-blue-600 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" {{ (isset($cooperado->documentos->status) && $cooperado->documentos->status == 'com apontamento') ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Com apontamento</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Aba de Financeiro -->
                            <div x-show="activeTab === 'financeiro'" class="space-y-6">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Dados Financeiros</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="descontar_inss" id="descontar_inss" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" {{ isset($cooperado->financeiro->descontar_inss) && $cooperado->financeiro->descontar_inss ? 'checked' : '' }}>
                                        <label for="descontar_inss" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Descontar INSS</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="descontar_ir" id="descontar_ir" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" {{ isset($cooperado->financeiro->descontar_ir) && $cooperado->financeiro->descontar_ir ? 'checked' : '' }}>
                                        <label for="descontar_ir" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Descontar IR</label>
                                    </div>
                                    <div>
                                        <label for="receber_por" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Forma de Recebimento</label>
                                        <select name="receber_por" id="receber_por" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all">
                                            <option value="">Selecione...</option>
                                            <option value="Transferência Bancária" {{ (isset($cooperado->financeiro->receber_por) && $cooperado->financeiro->receber_por == 'Transferência Bancária') ? 'selected' : '' }}>Transferência Bancária</option>
                                            <option value="PIX" {{ (isset($cooperado->financeiro->receber_por) && $cooperado->financeiro->receber_por == 'PIX') ? 'selected' : '' }}>PIX</option>
                                            <option value="Cheque" {{ (isset($cooperado->financeiro->receber_por) && $cooperado->financeiro->receber_por == 'Cheque') ? 'selected' : '' }}>Cheque</option>
                                            <option value="Dinheiro" {{ (isset($cooperado->financeiro->receber_por) && $cooperado->financeiro->receber_por == 'Dinheiro') ? 'selected' : '' }}>Dinheiro</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="banco_agencia" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Agência Bancária</label>
                                        <input type="text" name="banco_agencia" id="banco_agencia" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->financeiro->banco_agencia ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="banco_conta" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Conta Bancária</label>
                                        <input type="text" name="banco_conta" id="banco_conta" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->financeiro->banco_conta ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="banco_tipo_conta" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Conta</label>
                                        <select name="banco_tipo_conta" id="banco_tipo_conta" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all">
                                            <option value="">Selecione...</option>
                                            <option value="Corrente" {{ (isset($cooperado->financeiro->banco_tipo_conta) && $cooperado->financeiro->banco_tipo_conta == 'Corrente') ? 'selected' : '' }}>Corrente</option>
                                            <option value="Poupança" {{ (isset($cooperado->financeiro->banco_tipo_conta) && $cooperado->financeiro->banco_tipo_conta == 'Poupança') ? 'selected' : '' }}>Poupança</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="pix_tipo_chave" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Chave Pix</label>
                                        <select name="pix_tipo_chave" id="pix_tipo_chave" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all">
                                            <option value="">Selecione...</option>
                                            <option value="CPF" {{ (isset($cooperado->financeiro->pix_tipo_chave) && $cooperado->financeiro->pix_tipo_chave == 'CPF') ? 'selected' : '' }}>CPF</option>
                                            <option value="E-mail" {{ (isset($cooperado->financeiro->pix_tipo_chave) && $cooperado->financeiro->pix_tipo_chave == 'E-mail') ? 'selected' : '' }}>E-mail</option>
                                            <option value="Telefone" {{ (isset($cooperado->financeiro->pix_tipo_chave) && $cooperado->financeiro->pix_tipo_chave == 'Telefone') ? 'selected' : '' }}>Telefone</option>
                                            <option value="Chave Aleatória" {{ (isset($cooperado->financeiro->pix_tipo_chave) && $cooperado->financeiro->pix_tipo_chave == 'Chave Aleatória') ? 'selected' : '' }}>Chave Aleatória</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="chave_pix" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Chave Pix</label>
                                        <input type="text" name="chave_pix" id="chave_pix" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 transition-all" value="{{ $cooperado->financeiro->chave_pix ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Aba de Disponibilidade -->
                            <div x-show="activeTab === 'disponibilidade'" class="space-y-6">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Disponibilidade para Trabalho</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="segunda_feira" id="segunda_feira" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" {{ isset($cooperado->disponibilidade->segunda_feira) && $cooperado->disponibilidade->segunda_feira ? 'checked' : '' }}>
                                        <label for="segunda_feira" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Segunda-Feira</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="terca_feira" id="terca_feira" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" {{ isset($cooperado->disponibilidade->terca_feira) && $cooperado->disponibilidade->terca_feira ? 'checked' : '' }}>
                                        <label for="terca_feira" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Terça-Feira</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="quarta_feira" id="quarta_feira" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" {{ isset($cooperado->disponibilidade->quarta_feira) && $cooperado->disponibilidade->quarta_feira ? 'checked' : '' }}>
                                        <label for="quarta_feira" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Quarta-Feira</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="quinta_feira" id="quinta_feira" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" {{ isset($cooperado->disponibilidade->quinta_feira) && $cooperado->disponibilidade->quinta_feira ? 'checked' : '' }}>
                                        <label for="quinta_feira" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Quinta-Feira</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="sexta_feira" id="sexta_feira" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" {{ isset($cooperado->disponibilidade->sexta_feira) && $cooperado->disponibilidade->sexta_feira ? 'checked' : '' }}>
                                        <label for="sexta_feira" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Sexta-Feira</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="sabado" id="sabado" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" {{ isset($cooperado->disponibilidade->sabado) && $cooperado->disponibilidade->sabado ? 'checked' : '' }}>
                                        <label for="sabado" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Sábado</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="domingo" id="domingo" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" {{ isset($cooperado->disponibilidade->domingo) && $cooperado->disponibilidade->domingo ? 'checked' : '' }}>
                                        <label for="domingo" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Domingo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex justify-between">
                        <a href="{{ route('cooperados.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 transition-all duration-200">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition-all duration-200">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para máscaras de campos -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Máscara para CPF
            const cpfInput = document.getElementById('cpf');
            if (cpfInput) {
                cpfInput.addEventListener('input', function (e) {
                    e.target.value = e.target.value.replace(/\D/g, '')
                        .replace(/(\d{3})(\d)/, '$1.$2')
                        .replace(/(\d{3})(\d)/, '$1.$2')
                        .replace(/(\d{3})(\d{1,2})/, '$1-$2')
                        .replace(/(-\d{2})\d+?$/, '$1');
                });
            }

            // Máscara para CEP
            const cepInput = document.getElementById('cep');
            if (cepInput) {
                cepInput.addEventListener('input', function (e) {
                    e.target.value = e.target.value.replace(/\D/g, '')
                        .replace(/^(\d{5})(\d)/, '$1-$2')
                        .replace(/(-\d{3})\d+?$/, '$1');
                });
            }

            // Máscara para telefones
            const telefoneInputs = [
                document.getElementById('celular'),
                document.getElementById('telefone1'),
                document.getElementById('telefone2')
            ];

            telefoneInputs.forEach(input => {
                if (input) {
                    input.addEventListener('input', function (e) {
                        e.target.value = e.target.value.replace(/\D/g, '')
                            .replace(/^(\d{2})(\d)/, '($1) $2')
                            .replace(/(\d)(\d{4})$/, '$1-$2');
                    });
                }
            });
        });
    </script>
</x-app-layout>
