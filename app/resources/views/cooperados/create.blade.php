<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Criar Cooperado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('cooperados.store') }}" method="POST" id="cooperadoForm">
                    @csrf
                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <strong>Atenção!</strong> Verifique os seguintes erros:
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                 <!-- Dados básicos do cooperado -->
<div class="mb-6">
    <h3 class="text-lg font-medium mb-4 text-gray-700 dark:text-gray-300 border-b pb-2">Dados Básicos</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

<!-- Para os campos disabled, adicione campos hidden correspondentes -->
<div class="mb-4">
    <label for="matricula" class="block text-gray-700 dark:text-gray-200">Matrícula</label>
    <input type="text" id="matricula_display" class="form-input mt-1 block w-full rounded-md bg-gray-100 text-gray-500 cursor-not-allowed" value="{{ $matricula }}" disabled>
    <input type="hidden" name="matricula" value="{{ $matricula }}">
</div>
<div class="mb-4">
    <label for="dt_cadastro" class="block text-gray-700 dark:text-gray-200">Data de Cadastro</label>
    <input type="date" id="dt_cadastro_display" class="form-input mt-1 block w-full rounded-md bg-gray-100 text-gray-500 cursor-not-allowed" value="{{ date('Y-m-d') }}" disabled>
    <input type="hidden" name="dt_cadastro" value="{{ date('Y-m-d') }}">
</div>
<div class="mb-4">
    <label for="dt_ultima_escala" class="block text-gray-700 dark:text-gray-200">Data da Última Escala</label>
    <input type="date" id="dt_ultima_escala_display" class="form-input mt-1 block w-full rounded-md bg-gray-100 text-gray-500 cursor-not-allowed" disabled>
    <input type="hidden" name="dt_ultima_escala" value="{{ old('dt_ultima_escala') }}">
</div>
<div class="mb-4">
    <label for="dt_desligamento" class="block text-gray-700 dark:text-gray-200">Data de Desligamento</label>
    <input type="date" id="dt_desligamento_display" class="form-input mt-1 block w-full rounded-md bg-gray-100 text-gray-500 cursor-not-allowed" disabled>
    <input type="hidden" name="dt_desligamento" value="{{ old('dt_desligamento') }}">
</div>
        <div class="mb-4">
            <label for="sexo" class="block text-gray-700 dark:text-gray-200">Sexo</label>
            <select name="sexo" id="sexo" class="form-select mt-1 block w-full rounded-md" required>
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="nome" class="block text-gray-700 dark:text-gray-200">Nome</label>
            <input type="text" name="nome" id="nome" class="form-input mt-1 block w-full rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="status" class="block text-gray-700 dark:text-gray-200">Status</label>
            <select name="status" id="status" class="form-select mt-1 block w-full rounded-md" required>
                <option value="Ativo">Ativo</option>
                <option value="Inativo">Inativo</option>
                <option value="Suspenso">Suspenso</option>
                <option value="Desligado">Desligado</option>
            </select>
        </div>
    </div>
</div>

                    <!-- Sistema de abas -->
                    <div class="mt-8" x-data="{ activeTab: 'contatos' }">
                        <!-- Navegação das abas -->
                        <div class="border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px">
                                <li class="mr-2">
                                    <button type="button"
                                            @click="activeTab = 'contatos'"
                                            class="inline-block p-4 rounded-t-lg"
                                            :class="activeTab === 'contatos' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300'">
                                        Contatos
                                    </button>
                                </li>
                                <li class="mr-2">
                                    <button type="button"
                                            @click="activeTab = 'pessoais'"
                                            class="inline-block p-4 rounded-t-lg"
                                            :class="activeTab === 'pessoais' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300'">
                                        Dados Pessoais
                                    </button>
                                </li>
                                <li class="mr-2">
                                    <button type="button"
                                            @click="activeTab = 'documentos'"
                                            class="inline-block p-4 rounded-t-lg"
                                            :class="activeTab === 'documentos' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300'">
                                        Documentos
                                    </button>
                                </li>
                                <li class="mr-2">
                                    <button type="button"
                                            @click="activeTab = 'financeiro'"
                                            class="inline-block p-4 rounded-t-lg"
                                            :class="activeTab === 'financeiro' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300'">
                                        Financeiro
                                    </button>
                                </li>
                                <li>
                                    <button type="button"
                                            @click="activeTab = 'disponibilidade'"
                                            class="inline-block p-4 rounded-t-lg"
                                            :class="activeTab === 'disponibilidade' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300'">
                                        Disponibilidade
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Conteúdo das abas -->
                        <div class="p-4 border border-t-0 rounded-b-lg">
                            <!-- Aba de Contatos -->
                            <div x-show="activeTab === 'contatos'">
                                <h3 class="text-lg font-medium mb-4 text-gray-700 dark:text-gray-300">Informações de Contato</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="mb-4">
                                        <label for="celular" class="block text-gray-700 dark:text-gray-200">Celular</label>
                                        <input type="text" name="celular" id="celular" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4 flex items-center">
                                        <input type="checkbox" name="whatsapp" id="whatsapp" class="form-checkbox mr-2">
                                        <label for="whatsapp" class="text-gray-700 dark:text-gray-200">WhatsApp</label>
                                    </div>
                                    <div class="mb-4">
                                        <label for="telefone1" class="block text-gray-700 dark:text-gray-200">Telefone 1</label>
                                        <input type="text" name="telefone1" id="telefone1" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="telefone2" class="block text-gray-700 dark:text-gray-200">Telefone 2</label>
                                        <input type="text" name="telefone2" id="telefone2" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="email" class="block text-gray-700 dark:text-gray-200">E-mail</label>
                                        <input type="email" name="email" id="email" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="cep" class="block text-gray-700 dark:text-gray-200">CEP</label>
                                        <input type="text" name="cep" id="cep" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="endereco" class="block text-gray-700 dark:text-gray-200">Endereço</label>
                                        <input type="text" name="endereco" id="endereco" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="zona" class="block text-gray-700 dark:text-gray-200">Zona</label>
                                        <input type="text" name="zona" id="zona" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="bairro" class="block text-gray-700 dark:text-gray-200">Bairro</label>
                                        <input type="text" name="bairro" id="bairro" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="cidade" class="block text-gray-700 dark:text-gray-200">Cidade</label>
                                        <input type="text" name="cidade" id="cidade" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="uf" class="block text-gray-700 dark:text-gray-200">UF</label>
                                        <select name="uf" id="uf" class="form-select mt-1 block w-full rounded-md">
                                            <option value="">Selecione...</option>
                                            <option value="AC">Acre</option>
                                            <option value="AL">Alagoas</option>
                                            <option value="AP">Amapá</option>
                                            <option value="AM">Amazonas</option>
                                            <option value="BA">Bahia</option>
                                            <option value="CE">Ceará</option>
                                            <option value="DF">Distrito Federal</option>
                                            <option value="ES">Espírito Santo</option>
                                            <option value="GO">Goiás</option>
                                            <option value="MA">Maranhão</option>
                                            <option value="MT">Mato Grosso</option>
                                            <option value="MS">Mato Grosso do Sul</option>
                                            <option value="MG">Minas Gerais</option>
                                            <option value="PA">Pará</option>
                                            <option value="PB">Paraíba</option>
                                            <option value="PR">Paraná</option>
                                            <option value="PE">Pernambuco</option>
                                            <option value="PI">Piauí</option>
                                            <option value="RJ">Rio de Janeiro</option>
                                            <option value="RN">Rio Grande do Norte</option>
                                            <option value="RS">Rio Grande do Sul</option>
                                            <option value="RO">Rondônia</option>
                                            <option value="RR">Roraima</option>
                                            <option value="SC">Santa Catarina</option>
                                            <option value="SP">São Paulo</option>
                                            <option value="SE">Sergipe</option>
                                            <option value="TO">Tocantins</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Aba de Dados Pessoais -->
                            <div x-show="activeTab === 'pessoais'">
                                <h3 class="text-lg font-medium mb-4 text-gray-700 dark:text-gray-300">Dados Pessoais</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="mb-4">
                                        <label for="dt_nascimento" class="block text-gray-700 dark:text-gray-200">Data de Nascimento</label>
                                        <input type="date" name="dt_nascimento" id="dt_nascimento" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="nacionalidade" class="block text-gray-700 dark:text-gray-200">Nacionalidade</label>
                                        <input type="text" name="nacionalidade" id="nacionalidade" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="nome_mae" class="block text-gray-700 dark:text-gray-200">Nome da Mãe</label>
                                        <input type="text" name="nome_mae" id="nome_mae" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="nome_pai" class="block text-gray-700 dark:text-gray-200">Nome do Pai</label>
                                        <input type="text" name="nome_pai" id="nome_pai" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="est_civil" class="block text-gray-700 dark:text-gray-200">Estado Civil</label>
                                        <select name="est_civil" id="est_civil" class="form-select mt-1 block w-full rounded-md">
                                            <option value="">Selecione...</option>
                                            <option value="Solteiro(a)">Solteiro(a)</option>
                                            <option value="Casado(a)">Casado(a)</option>
                                            <option value="Divorciado(a)">Divorciado(a)</option>
                                            <option value="Viúvo(a)">Viúvo(a)</option>
                                            <option value="União Estável">União Estável</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="escolaridade" class="block text-gray-700 dark:text-gray-200">Escolaridade</label>
                                        <select name="escolaridade" id="escolaridade" class="form-select mt-1 block w-full rounded-md">
                                            <option value="">Selecione...</option>
                                            <option value="Analfabeto">Analfabeto</option>
                                            <option value="Fundamental Incompleto">Fundamental Incompleto</option>
                                            <option value="Fundamental Completo">Fundamental Completo</option>
                                            <option value="Médio Incompleto">Médio Incompleto</option>
                                            <option value="Médio Completo">Médio Completo</option>
                                            <option value="Superior Incompleto">Superior Incompleto</option>
                                            <option value="Superior Completo">Superior Completo</option>
                                            <option value="Pós-Graduação">Pós-Graduação</option>
                                            <option value="Mestrado">Mestrado</option>
                                            <option value="Doutorado">Doutorado</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="qualificacao" class="block text-gray-700 dark:text-gray-200">Qualificação (1-5)</label>
                                        <input type="number" name="qualificacao" id="qualificacao" class="form-input mt-1 block w-full rounded-md" min="1" max="5">
                                    </div>
                                    <div class="mb-4 md:col-span-2">
                                        <label for="qualificacao_justificativa" class="block text-gray-700 dark:text-gray-200">Justificativa da Qualificação</label>
                                        <textarea name="qualificacao_justificativa" id="qualificacao_justificativa" class="form-textarea mt-1 block w-full rounded-md" rows="3"></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label for="indicado_por" class="block text-gray-700 dark:text-gray-200">Indicado por</label>
                                        <input type="text" name="indicado_por" id="indicado_por" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                </div>
                            </div>

                            <!-- Aba de Documentos -->
                            <div x-show="activeTab === 'documentos'">
                                <h3 class="text-lg font-medium mb-4 text-gray-700 dark:text-gray-300">Documentação</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="mb-4">
                                        <label for="cpf" class="block text-gray-700 dark:text-gray-200">CPF</label>
                                        <input type="text" name="cpf" id="cpf" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="ccm" class="block text-gray-700 dark:text-gray-200">CCM</label>
                                        <input type="text" name="ccm" id="ccm" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="num_pis_inss" class="block text-gray-700 dark:text-gray-200">Número PIS/INSS</label>
                                        <input type="text" name="num_pis_inss" id="num_pis_inss" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="rg" class="block text-gray-700 dark:text-gray-200">RG</label>
                                        <input type="text" name="rg" id="rg" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="dt_emissao" class="block text-gray-700 dark:text-gray-200">Data de Emissão</label>
                                        <input type="date" name="dt_emissao" id="dt_emissao" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="orgao_emissor" class="block text-gray-700 dark:text-gray-200">Órgão Emissor</label>
                                        <input type="text" name="orgao_emissor" id="orgao_emissor" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="cidade_natal" class="block text-gray-700 dark:text-gray-200">Cidade Natal</label>
                                        <input type="text" name="cidade_natal" id="cidade_natal" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="dt_entrega_at_saude" class="block text-gray-700 dark:text-gray-200">Data de Entrega AT Saúde</label>
                                        <input type="date" name="dt_entrega_at_saude" id="dt_entrega_at_saude" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="carteira_trab" class="block text-gray-700 dark:text-gray-200">Carteira de Trabalho</label>
                                        <input type="text" name="carteira_trab" id="carteira_trab" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="serie" class="block text-gray-700 dark:text-gray-200">Série</label>
                                        <input type="text" name="serie" id="serie" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="titulo_eleitor" class="block text-gray-700 dark:text-gray-200">Título de Eleitor</label>
                                        <input type="text" name="titulo_eleitor" id="titulo_eleitor" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="zona_eleitoral" class="block text-gray-700 dark:text-gray-200">Zona Eleitoral</label>
                                        <input type="text" name="zona_eleitoral" id="zona_eleitoral" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="num_cracha_carteirinha" class="block text-gray-700 dark:text-gray-200">Número do Crachá/Carteirinha</label>
                                        <input type="text" name="num_cracha_carteirinha" id="num_cracha_carteirinha" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4 flex items-center">
                                        <input type="checkbox" name="cracha_cart_possui" id="cracha_cart_possui" class="form-checkbox mr-2">
                                        <label for="cracha_cart_possui" class="text-gray-700 dark:text-gray-200">Possui Crachá/Carteirinha</label>
                                    </div>
                                    <div class="mb-4">
                                        <label for="antecedentes_criminais_dt_consulta" class="block text-gray-700 dark:text-gray-200">Data de Consulta de Antecedentes Criminais</label>
                                        <input type="date" name="antecedentes_criminais_dt_consulta" id="antecedentes_criminais_dt_consulta" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="antecedentes_consultado_por" class="block text-gray-700 dark:text-gray-200">Consultado por</label>
                                        <input type="text" name="antecedentes_consultado_por" id="antecedentes_consultado_por" class="form-input mt-1 block w-full rounded-md">
                                    </div>


                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-200 mb-2">Status da Consulta</label>
                                        <div class="flex space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="status_antecedentes" value="não consultado" class="form-radio text-blue-600">
                                                <span class="ml-2 text-gray-700 dark:text-gray-200">Não consultado</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="status_antecedentes" value="nada consta" class="form-radio text-blue-600">
                                                <span class="ml-2 text-gray-700 dark:text-gray-200">Nada consta</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="status_antecedentes" value="com apontamento" class="form-radio text-blue-600">
                                                <span class="ml-2 text-gray-700 dark:text-gray-200">Com apontamento</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Aba de Financeiro -->
                            <div x-show="activeTab === 'financeiro'">
                                <h3 class="text-lg font-medium mb-4 text-gray-700 dark:text-gray-300">Dados Financeiros</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="mb-4 flex items-center">
                                        <input type="checkbox" name="descontar_inss" id="descontar_inss" class="form-checkbox mr-2">
                                        <label for="descontar_inss" class="text-gray-700 dark:text-gray-200">Descontar INSS</label>
                                    </div>
                                    <div class="mb-4 flex items-center">
                                        <input type="checkbox" name="descontar_ir" id="descontar_ir" class="form-checkbox mr-2">
                                        <label for="descontar_ir" class="text-gray-700 dark:text-gray-200">Descontar IR</label>
                                    </div>
                                    <div class="mb-4">
                                        <label for="receber_por" class="block text-gray-700 dark:text-gray-200">Forma de Recebimento</label>
                                        <select name="receber_por" id="receber_por" class="form-select mt-1 block w-full rounded-md">
                                            <option value="">Selecione...</option>
                                            <option value="Transferência Bancária">Transferência Bancária</option>
                                            <option value="PIX">PIX</option>
                                            <option value="Cheque">Cheque</option>
                                            <option value="Dinheiro">Dinheiro</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="banco_agencia" class="block text-gray-700 dark:text-gray-200">Agência Bancária</label>
                                        <input type="text" name="banco_agencia" id="banco_agencia" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="banco_conta" class="block text-gray-700 dark:text-gray-200">Conta Bancária</label>
                                        <input type="text" name="banco_conta" id="banco_conta" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="banco_tipo_conta" class="block text-gray-700 dark:text-gray-200">Tipo de Conta</label>
                                        <select name="banco_tipo_conta" id="banco_tipo_conta" class="form-select mt-1 block w-full rounded-md">
                                            <option value="">Selecione...</option>
                                            <option value="Corrente">Corrente</option>
                                            <option value="Poupança">Poupança</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="pix_tipo_chave" class="block text-gray-700 dark:text-gray-200">Tipo de Chave Pix</label>
                                        <select name="pix_tipo_chave" id="pix_tipo_chave" class="form-select mt-1 block w-full rounded-md">
                                            <option value="">Selecione...</option>
                                            <option value="CPF">CPF</option>
                                            <option value="E-mail">E-mail</option>
                                            <option value="Telefone">Telefone</option>
                                            <option value="Chave Aleatória">Chave Aleatória</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="chave_pix" class="block text-gray-700 dark:text-gray-200">Chave Pix</label>
                                        <input type="text" name="chave_pix" id="chave_pix" class="form-input mt-1 block w-full rounded-md">
                                    </div>
                                </div>
                            </div>

                            <!-- Aba de Disponibilidade -->
                            <div x-show="activeTab === 'disponibilidade'">
                                <h3 class="text-lg font-medium mb-4 text-gray-700 dark:text-gray-300">Disponibilidade para Trabalho</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="mb-4 flex items-center">
                                        <input type="checkbox" name="segunda_feira" id="segunda_feira" class="form-checkbox mr-2">
                                        <label for="segunda_feira" class="text-gray-700 dark:text-gray-200">Segunda-Feira</label>
                                    </div>
                                    <div class="mb-4 flex items-center">
                                        <input type="checkbox" name="terca_feira" id="terca_feira" class="form-checkbox mr-2">
                                        <label for="terca_feira" class="text-gray-700 dark:text-gray-200">Terça-Feira</label>
                                    </div>
                                    <div class="mb-4 flex items-center">
                                        <input type="checkbox" name="quarta_feira" id="quarta_feira" class="form-checkbox mr-2">
                                        <label for="quarta_feira" class="text-gray-700 dark:text-gray-200">Quarta-Feira</label>
                                    </div>
                                    <div class="mb-4 flex items-center">
                                        <input type="checkbox" name="quinta_feira" id="quinta_feira" class="form-checkbox mr-2">
                                        <label for="quinta_feira" class="text-gray-700 dark:text-gray-200">Quinta-Feira</label>
                                    </div>
                                    <div class="mb-4 flex items-center">
                                        <input type="checkbox" name="sexta_feira" id="sexta_feira" class="form-checkbox mr-2">
                                        <label for="sexta_feira" class="text-gray-700 dark:text-gray-200">Sexta-Feira</label>
                                    </div>
                                    <div class="mb-4 flex items-center">
                                        <input type="checkbox" name="sabado" id="sabado" class="form-checkbox mr-2">
                                        <label for="sabado" class="text-gray-700 dark:text-gray-200">Sábado</label>
                                    </div>
                                    <div class="mb-4 flex items-center">
                                        <input type="checkbox" name="domingo" id="domingo" class="form-checkbox mr-2">
                                        <label for="domingo" class="text-gray-700 dark:text-gray-200">Domingo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between">
                        <button type="button" class="btn bg-red-500 text-white hover:bg-red-700 px-4 py-2 rounded-md" onclick="document.getElementById('cooperadoForm').reset();">Limpar Campos</button>
                        <button type="submit" class="btn bg-green-500 text-white hover:bg-green-700 px-4 py-2 rounded-md">Salvar</button>
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
