<!-- filepath: c:\Users\caiol\Desktop\Github\fapcoop\app\resources\views\livewire\funcao-manager.blade.php -->
<div>
    <!-- Regular Function Modal -->
    @if($isOpen)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg max-w-lg w-full max-h-[80vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold dark:text-white">Adicionar Função</h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700 dark:text-gray-300">
                        <span class="text-xl">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="storeNewFunction">
                    <div>
                        <x-label for="nome" :value="__('Nome')" />
                        <x-input id="nome" class="block mt-1 w-full" type="text" wire:model="nome" required autofocus />
                        @error('nome') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-4 flex justify-end">
                        <x-button class="ml-4">
                            {{ __('Salvar') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Button to create new function -->
    <button wire:click="createNewFunction" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
        Criar Nova Função
    </button>

    <!-- Add this if you want to show success messages in this component -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Button to test method -->
    <button wire:click="testMethod" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Test Method
    </button>
</div>
