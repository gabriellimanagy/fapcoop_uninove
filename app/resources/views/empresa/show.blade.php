<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes da Empresa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Razão Social</label>
                        <p class="form-input mt-1 block w-full rounded-md bg-gray-200">{{ $empresa->razao_social }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Fantasia</label>
                        <p class="form-input mt-1 block w-full rounded-md bg-gray-200">{{ $empresa->fantasia ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">CNPJ</label>
                        <p class="form-input mt-1 block w-full rounded-md bg-gray-200">{{ $empresa->cnpj }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Inscrição Estadual</label>
                        <p class="form-input mt-1 block w-full rounded-md bg-gray-200">{{ $empresa->insc_estadual ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Endereço</label>
                        <p class="form-input mt-1 block w-full rounded-md bg-gray-200">{{ $empresa->endereco ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Número</label>
                        <p class="form-input mt-1 block w-full rounded-md bg-gray-200">{{ $empresa->numero ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Complemento</label>
                        <p class="form-input mt-1 block w-full rounded-md bg-gray-200">{{ $empresa->complemento ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Bairro</label>
                        <p class="form-input mt-1 block w-full rounded-md bg-gray-200">{{ $empresa->bairro ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Cidade</label>
                        <p class="form-input mt-1 block w-full rounded-md bg-gray-200">{{ $empresa->cidade ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Estado</label>
                        <p class="form-input mt-1 block w-full rounded-md bg-gray-200">{{ $empresa->estado ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">CEP</label>
                        <p class="form-input mt-1 block w-full rounded-md bg-gray-200">{{ $empresa->cep }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Telefone 1</label>
                        <p class="form-input mt-1 block w-full rounded-md bg-gray-200">{{ $empresa->telefone1 }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Telefone 2</label>
                        <p class="form-input mt-1 block w-full rounded-md bg-gray-200">{{ $empresa->telefone2 ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Email</label>
                        <p class="form-input mt-1 block w-full rounded-md bg-gray-200">{{ $empresa->email }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Logo</label>
                        @if($empresa->logo)
                            <img src="{{ Storage::url($empresa->logo) }}" alt="Logo da empresa" class="mt-1 max-w-xs rounded-md">
                        @else
                            <p class="form-input mt-1 block w-full rounded-md bg-gray-200">Nenhuma logo cadastrada</p>
                        @endif
                    </div>
                </div>
                <div class="mt-8 flex justify-between">
                    <a href="{{ route('empresas.index') }}" class="btn bg-gray-500 text-white hover:bg-gray-700 px-4 py-2 rounded-md">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
