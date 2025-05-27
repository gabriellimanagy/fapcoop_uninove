<!-- filepath: c:\Users\caiol\Desktop\Github\fapcoop\app\resources\views\dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
        </div>
    </div>

    <!-- New Presentation Section -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Apresentação do Sistema Vertex Coop</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Bem-vindo ao Vertex Coop, um sistema inovador projetado para facilitar a gestão de cooperativas.
                    Nosso objetivo é fornecer ferramentas eficientes e intuitivas para ajudar na administração e operação diária.
                </p>
                <p class="text-gray-600 dark:text-gray-400 mt-4">
                    Com o Vertex Coop, você pode gerenciar membros, acompanhar transações financeiras, gerar relatórios detalhados e muito mais.
                    Explore as funcionalidades e descubra como podemos ajudar sua cooperativa a alcançar novos patamares de eficiência e sucesso.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
