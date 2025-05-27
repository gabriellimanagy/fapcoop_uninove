<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cadastrar Novo Cliente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                {{-- Exibe mensagens de sucesso e erro --}}
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('clientes.store') }}" method="POST">
                    @csrf

                    {{-- INFORMAÇÕES DA EMPRESA --}}
                    <h3 class="text-lg font-semibold mb-2 border-b pb-2">Informações da Empresa</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach (['razao_social' => 'Razão Social / Nome Completo', 'fantasia' => 'Fantasia / Abreviação', 'documento' => 'CNPJ / CPF', 'insc_estadual_rg' => 'Inscrição Estadual / RG'] as $campo => $label)
                            <div>
                                <label for="{{ $campo }}" class="block text-gray-700">{{ $label }}:</label>
                                <input type="text" id="{{ $campo }}" name="{{ $campo }}" 
                                    class="w-full border-gray-300 rounded-md shadow-sm @error($campo) border-red-500 @enderror"
                                    value="{{ old($campo) }}">
                                @error($campo)
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    {{-- ENDEREÇO --}}
                    <h3 class="text-lg font-semibold mt-6 mb-2 border-b pb-2">Endereço</h3>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach (['endereco' => 'Endereço', 'numero' => 'Número', 'complemento' => 'Complemento', 'bairro' => 'Bairro', 'cidade' => 'Cidade', 'estado' => 'Estado', 'cep' => 'CEP'] as $campo => $label)
                            <div class="{{ in_array($campo, ['endereco']) ? 'col-span-2' : '' }}">
                                <label for="{{ $campo }}" class="block text-gray-700">{{ $label }}:</label>
                                <input type="text" id="{{ $campo }}" name="{{ $campo }}" 
                                    class="w-full border-gray-300 rounded-md shadow-sm @error($campo) border-red-500 @enderror"
                                    value="{{ old($campo) }}">
                                @error($campo)
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    {{-- CONTATO --}}
                    <h3 class="text-lg font-semibold mt-6 mb-2 border-b pb-2">Contato</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach (['telefone1' => 'Telefone 1', 'telefone2' => 'Telefone 2', 'email' => 'E-mail'] as $campo => $label)
                            <div class="{{ $campo == 'email' ? 'col-span-2' : '' }}">
                                <label for="{{ $campo }}" class="block text-gray-700">{{ $label }}:</label>
                                <input type="{{ $campo == 'email' ? 'email' : 'text' }}" id="{{ $campo }}" name="{{ $campo }}" 
                                    class="w-full border-gray-300 rounded-md shadow-sm @error($campo) border-red-500 @enderror"
                                    value="{{ old($campo) }}">
                                @error($campo)
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    {{-- FINANCEIRO --}}
                    <h3 class="text-lg font-semibold mt-6 mb-2 border-b pb-2">Financeiro</h3>
                    <div class="grid grid-cols-4 gap-4">
                        @foreach (['pgto_ad_noturno' => 'Pgt. Ad. Noturno (%)', 'inss' => 'INSS (%)', 'aux_uniforme' => 'Vlr. Aux. Uniforme', 'vale_transporte' => 'Vlr. Vale Transp.'] as $campo => $label)
                            <div>
                                <label for="{{ $campo }}" class="block text-gray-700">{{ $label }}:</label>
                                <input type="text" id="{{ $campo }}" name="{{ $campo }}" 
                                    class="w-full border-gray-300 rounded-md shadow-sm @error($campo) border-red-500 @enderror"
                                    value="{{ old($campo) }}">
                                @error($campo)
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    {{-- CHECKBOX --}}
                    <div class="mb-4 flex items-center space-x-2">
                        <input type="checkbox" id="exigir_antecedentes" name="exigir_antecedentes" value="1"
                            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                            {{ old('exigir_antecedentes') ? 'checked' : '' }}>
                        <label for="exigir_antecedentes" class="text-gray-700 font-medium">Exigir Antecedentes?</label>
                    </div>

                    {{-- BOTÃO SUBMIT --}}
                    <div class="mt-6">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                            Cadastrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
