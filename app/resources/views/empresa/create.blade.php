<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Adicionar Empresa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('empresas.store') }}" method="POST" id="empresaForm" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="razao_social" class="block text-gray-700 dark:text-gray-200">Razão Social</label>
                            <input type="text" name="razao_social" id="razao_social" class="form-input mt-1 block w-full rounded-md" required placeholder="Ex: Empresa XYZ Ltda">
                        </div>
                        <div class="mb-4">
                            <label for="fantasia" class="block text-gray-700 dark:text-gray-200">Fantasia</label>
                            <input type="text" name="fantasia" id="fantasia" class="form-input mt-1 block w-full rounded-md" placeholder="Ex: XYZ">
                        </div>
                        <div class="mb-4">
                            <label for="cnpj" class="block text-gray-700 dark:text-gray-200">CNPJ</label>
                            <input type="text" name="cnpj" id="cnpj" class="form-input mt-1 block w-full rounded-md" required maxlength="18" placeholder="Ex: 00.000.000/0000-00">
                        </div>
                        <div class="mb-4">
                            <label for="insc_estadual" class="block text-gray-700 dark:text-gray-200">Inscrição Estadual</label>
                            <input type="text" name="insc_estadual" id="insc_estadual" class="form-input mt-1 block w-full rounded-md" value="ISENTO" placeholder="Ex: 123456789">
                        </div>
                        <div class="mb-4">
                            <label for="endereco" class="block text-gray-700 dark:text-gray-200">Endereço</label>
                            <input type="text" name="endereco" id="endereco" class="form-input mt-1 block w-full rounded-md" placeholder="Ex: Rua das Flores">
                        </div>
                        <div class="mb-4">
                            <label for="numero" class="block text-gray-700 dark:text-gray-200">Número</label>
                            <input type="text" name="numero" id="numero" class="form-input mt-1 block w-full rounded-md" placeholder="Ex: 123">
                        </div>
                        <div class="mb-4">
                            <label for="complemento" class="block text-gray-700 dark:text-gray-200">Complemento</label>
                            <input type="text" name="complemento" id="complemento" class="form-input mt-1 block w-full rounded-md" placeholder="Ex: Apto 101">
                        </div>
                        <div class="mb-4">
                            <label for="bairro" class="block text-gray-700 dark:text-gray-200">Bairro</label>
                            <input type="text" name="bairro" id="bairro" class="form-input mt-1 block w-full rounded-md" placeholder="Ex: Centro">
                        </div>
                        <div class="mb-4">
                            <label for="cidade" class="block text-gray-700 dark:text-gray-200">Cidade</label>
                            <input type="text" name="cidade" id="cidade" class="form-input mt-1 block w-full rounded-md" placeholder="Ex: São Paulo">
                        </div>
                        <div class="mb-4">
                            <label for="estado" class="block text-gray-700 dark:text-gray-200">Estado</label>
                            <select name="estado" id="estado" class="form-select mt-1 block w-full rounded-md">
                                <option value="">Selecione o Estado</option>
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
                        <div class="mb-4">
                            <label for="cep" class="block text-gray-700 dark:text-gray-200">CEP</label>
                            <input type="text" name="cep" id="cep" class="form-input mt-1 block w-full rounded-md" required maxlength="9" placeholder="Ex: 00000-000">
                        </div>
                        <div class="mb-4">
                            <label for="telefone1" class="block text-gray-700 dark:text-gray-200">Telefone 1</label>
                            <input type="text" name="telefone1" id="telefone1" class="form-input mt-1 block w-full rounded-md" required maxlength="15" placeholder="Ex: (11) 1234-5678">
                        </div>
                        <div class="mb-4">
                            <label for="telefone2" class="block text-gray-700 dark:text-gray-200">Telefone 2</label>
                            <input type="text" name="telefone2" id="telefone2" class="form-input mt-1 block w-full rounded-md" maxlength="15" placeholder="Ex: (11) 98765-4321">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 dark:text-gray-200">Email</label>
                            <input type="email" name="email" id="email" class="form-input mt-1 block w-full rounded-md" required placeholder="Ex: email@empresa.com">
                        </div>
                        <div class="mb-4">
                            <label for="logo" class="block text-gray-700 dark:text-gray-200">Logo</label>
                            <input type="file" name="logo" id="logo" class="form-input mt-1 block w-full rounded-md" accept="image/jpeg,image/png,image/jpg,image/gif">
                        </div>
                    </div>

                    <fieldset class="mt-8 border border-gray-300 rounded-md p-4 bg-gray-100">
                        <legend class="text-lg font-semibold text-gray-800 dark:text-gray-200">Taxas e Configurações</legend>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="taxa_cheque" class="block text-gray-700 dark:text-gray-200">Taxa Cheque</label>
                                <input type="number" step="0.01" name="taxa_cheque" id="taxa_cheque" class="form-input mt-1 block w-full rounded-md bg-gray-200" value="0.00" disabled>
                            </div>
                            <div class="mb-4">
                                <label for="taxa_transf" class="block text-gray-700 dark:text-gray-200">Taxa Transferência</label>
                                <input type="number" step="0.01" name="taxa_transf" id="taxa_transf" class="form-input mt-1 block w-full rounded-md bg-gray-200" value="0.00" disabled>
                            </div>
                            <div class="mb-4">
                                <label for="taxa_pix" class="block text-gray-700 dark:text-gray-200">Taxa Pix</label>
                                <input type="number" step="0.01" name="taxa_pix" id="taxa_pix" class="form-input mt-1 block w-full rounded-md bg-gray-200" value="0.00" disabled>
                            </div>
                            <div class="mb-4">
                                <label for="taxa_adm_cota" class="block text-gray-700 dark:text-gray-200">Taxa Administração de Cota</label>
                                <input type="number" step="0.01" name="taxa_adm_cota" id="taxa_adm_cota" class="form-input mt-1 block w-full rounded-md bg-gray-200" value="0.00" disabled>
                            </div>
                            <div class="mb-4">
                                <label for="lancar_automaticamente" class="block text-gray-700 dark:text-gray-200">Lançar Automaticamente</label>
                                <input type="checkbox" name="lancar_automaticamente" id="lancar_automaticamente" class="form-checkbox mt-1" disabled>
                            </div>
                        </div>
                    </fieldset>

                    <div class="mt-8 flex justify-between">
                        <button type="button" class="btn bg-red-500 text-white hover:bg-red-700 px-4 py-2 rounded-md" onclick="document.getElementById('empresaForm').reset();">Limpar Campos</button>
                        <button type="submit" class="btn bg-green-500 text-white hover:bg-green-700 px-4 py-2 rounded-md">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cnpjInput = document.getElementById('cnpj');
            const cepInput = document.getElementById('cep');
            const telefone1Input = document.getElementById('telefone1');
            const telefone2Input = document.getElementById('telefone2');

            cnpjInput.addEventListener('input', function (e) {
                e.target.value = e.target.value.replace(/\D/g, '')
                    .replace(/^(\d{2})(\d)/, '$1.$2')
                    .replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
                    .replace(/\.(\d{3})(\d)/, '.$1/$2')
                    .replace(/(\d{4})(\d)/, '$1-$2');
            });

            cepInput.addEventListener('input', function (e) {
                e.target.value = e.target.value.replace(/\D/g, '')
                    .replace(/^(\d{5})(\d)/, '$1-$2');
            });

            telefone1Input.addEventListener('input', function (e) {
                e.target.value = e.target.value.replace(/\D/g, '')
                    .replace(/^(\d{2})(\d)/g, '($1) $2')
                    .replace(/(\d{4})(\d)/, '$1-$2');
            });

            telefone2Input.addEventListener('input', function (e) {
                e.target.value = e.target.value.replace(/\D/g, '')
                    .replace(/^(\d{2})(\d)/g, '($1) $2')
                    .replace(/(\d{4})(\d)/, '$1-$2');
            });

            document.getElementById('empresaForm').addEventListener('submit', function () {
                cnpjInput.value = cnpjInput.value.replace(/\D/g, '');
                cepInput.value = cepInput.value.replace(/\D/g, '');
                telefone1Input.value = telefone1Input.value.replace(/\D/g, '');
                telefone2Input.value = telefone2Input.value.replace(/\D/g, '');
            });
        });
    </script>
</x-app-layout>
