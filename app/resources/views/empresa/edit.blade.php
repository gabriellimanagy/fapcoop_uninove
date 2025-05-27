<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Empresa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('empresas.update', $empresa) }}" method="POST" id="empresaForm">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="razao_social" class="block text-gray-700 dark:text-gray-200">Razão Social</label>
                            <input type="text" name="razao_social" id="razao_social" class="form-input mt-1 block w-full rounded-md" value="{{ $empresa->razao_social }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="fantasia" class="block text-gray-700 dark:text-gray-200">Fantasia</label>
                            <input type="text" name="fantasia" id="fantasia" class="form-input mt-1 block w-full rounded-md" value="{{ $empresa->fantasia }}">
                        </div>
                        <div class="mb-4">
                            <label for="cnpj" class="block text-gray-700 dark:text-gray-200">CNPJ</label>
                            <input type="text" name="cnpj" id="cnpj" class="form-input mt-1 block w-full rounded-md" value="{{ $empresa->cnpj }}" required maxlength="18">
                        </div>
                        <div class="mb-4">
                            <label for="insc_estadual" class="block text-gray-700 dark:text-gray-200">Inscrição Estadual</label>
                            <input type="text" name="insc_estadual" id="insc_estadual" class="form-input mt-1 block w-full rounded-md" value="{{ $empresa->insc_estadual }}">
                        </div>
                        <div class="mb-4">
                            <label for="endereco" class="block text-gray-700 dark:text-gray-200">Endereço</label>
                            <input type="text" name="endereco" id="endereco" class="form-input mt-1 block w-full rounded-md" value="{{ $empresa->endereco }}">
                        </div>
                        <div class="mb-4">
                            <label for="numero" class="block text-gray-700 dark:text-gray-200">Número</label>
                            <input type="text" name="numero" id="numero" class="form-input mt-1 block w-full rounded-md" value="{{ $empresa->numero }}">
                        </div>
                        <div class="mb-4">
                            <label for="complemento" class="block text-gray-700 dark:text-gray-200">Complemento</label>
                            <input type="text" name="complemento" id="complemento" class="form-input mt-1 block w-full rounded-md" value="{{ $empresa->complemento }}">
                        </div>
                        <div class="mb-4">
                            <label for="bairro" class="block text-gray-700 dark:text-gray-200">Bairro</label>
                            <input type="text" name="bairro" id="bairro" class="form-input mt-1 block w-full rounded-md" value="{{ $empresa->bairro }}">
                        </div>
                        <div class="mb-4">
                            <label for="cidade" class="block text-gray-700 dark:text-gray-200">Cidade</label>
                            <input type="text" name="cidade" id="cidade" class="form-input mt-1 block w-full rounded-md" value="{{ $empresa->cidade }}">
                        </div>
                        <div class="mb-4">
                            <label for="estado" class="block text-gray-700 dark:text-gray-200">Estado</label>
                            <select name="estado" id="estado" class="form-select mt-1 block w-full rounded-md">
                                <option value="">Selecione o Estado</option>
                                <option value="AC" {{ $empresa->estado == 'AC' ? 'selected' : '' }}>Acre</option>
                                <option value="AL" {{ $empresa->estado == 'AL' ? 'selected' : '' }}>Alagoas</option>
                                <option value="AP" {{ $empresa->estado == 'AP' ? 'selected' : '' }}>Amapá</option>
                                <option value="AM" {{ $empresa->estado == 'AM' ? 'selected' : '' }}>Amazonas</option>
                                <option value="BA" {{ $empresa->estado == 'BA' ? 'selected' : '' }}>Bahia</option>
                                <option value="CE" {{ $empresa->estado == 'CE' ? 'selected' : '' }}>Ceará</option>
                                <option value="DF" {{ $empresa->estado == 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                                <option value="ES" {{ $empresa->estado == 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                                <option value="GO" {{ $empresa->estado == 'GO' ? 'selected' : '' }}>Goiás</option>
                                <option value="MA" {{ $empresa->estado == 'MA' ? 'selected' : '' }}>Maranhão</option>
                                <option value="MT" {{ $empresa->estado == 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                                <option value="MS" {{ $empresa->estado == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                                <option value="MG" {{ $empresa->estado == 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                                <option value="PA" {{ $empresa->estado == 'PA' ? 'selected' : '' }}>Pará</option>
                                <option value="PB" {{ $empresa->estado == 'PB' ? 'selected' : '' }}>Paraíba</option>
                                <option value="PR" {{ $empresa->estado == 'PR' ? 'selected' : '' }}>Paraná</option>
                                <option value="PE" {{ $empresa->estado == 'PE' ? 'selected' : '' }}>Pernambuco</option>
                                <option value="PI" {{ $empresa->estado == 'PI' ? 'selected' : '' }}>Piauí</option>
                                <option value="RJ" {{ $empresa->estado == 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                                <option value="RN" {{ $empresa->estado == 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                                <option value="RS" {{ $empresa->estado == 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                                <option value="RO" {{ $empresa->estado == 'RO' ? 'selected' : '' }}>Rondônia</option>
                                <option value="RR" {{ $empresa->estado == 'RR' ? 'selected' : '' }}>Roraima</option>
                                <option value="SC" {{ $empresa->estado == 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                                <option value="SP" {{ $empresa->estado == 'SP' ? 'selected' : '' }}>São Paulo</option>
                                <option value="SE" {{ $empresa->estado == 'SE' ? 'selected' : '' }}>Sergipe</option>
                                <option value="TO" {{ $empresa->estado == 'TO' ? 'selected' : '' }}>Tocantins</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="cep" class="block text-gray-700 dark:text-gray-200">CEP</label>
                            <input type="text" name="cep" id="cep" class="form-input mt-1 block w-full rounded-md" value="{{ $empresa->cep }}" required maxlength="9">
                        </div>
                        <div class="mb-4">
                            <label for="telefone1" class="block text-gray-700 dark:text-gray-200">Telefone 1</label>
                            <input type="text" name="telefone1" id="telefone1" class="form-input mt-1 block w-full rounded-md" value="{{ $empresa->telefone1 }}" required maxlength="15">
                        </div>
                        <div class="mb-4">
                            <label for="telefone2" class="block text-gray-700 dark:text-gray-200">Telefone 2</label>
                            <input type="text" name="telefone2" id="telefone2" class="form-input mt-1 block w-full rounded-md" value="{{ $empresa->telefone2 }}" maxlength="15">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 dark:text-gray-200">Email</label>
                            <input type="email" name="email" id="email" class="form-input mt-1 block w-full rounded-md" value="{{ $empresa->email }}" required>
                        </div>
                    </div>

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
        });
    </script>
</x-app-layout>
