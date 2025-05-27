<!-- Modal de Confirmação -->
<div id="confirm-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-sm w-full p-6">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Confirmar Baixa</h3>
        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">Tem certeza que deseja dar baixa nesta escala? A escala será anexada ao lote descrito.</p>
        <div class="mt-6 flex justify-end">
            <button class="btn bg-gray-300 text-gray-700 hover:bg-gray-500 px-4 py-2 rounded-md mr-2" onclick="closeModal()">Cancelar</button>
            <button id="confirm-btn" class="btn bg-red-500 text-white hover:bg-red-700 px-4 py-2 rounded-md">Confirmar</button>
        </div>
    </div>
</div>

<!-- Modal de Cooperados -->
<div id="cooperados-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-6xl w-full p-6">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Cooperados da Escala</h3>

        <!-- Barra de Pesquisa -->
        <div class="mb-4">
            <input type="text" id="search-cooperados" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300" placeholder="Pesquisar por nome do cooperado...">
        </div>

        <!-- Tabela de Cooperados -->
        <div class="overflow-x-auto mt-4 max-h-96 overflow-y-auto">
            <table class="min-w-full table-auto text-sm text-gray-500 dark:text-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium">ID</th>
                        <th class="px-4 py-2 text-left font-medium">Nome</th>
                        <th class="px-4 py-2 text-left font-medium">Função</th>
                        <th class="px-4 py-2 text-left font-medium">Hora de Entrada</th>
                        <th class="px-4 py-2 text-left font-medium">Hora de Saída</th>
                        <th class="px-4 py-2 text-left font-medium">Hora Extra</th>
                    </tr>
                </thead>
                <tbody id="cooperados-list" class="bg-white dark:bg-gray-800">
                    <!-- Conteúdo será carregado via JavaScript -->
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end">
            <button class="btn bg-gray-300 text-gray-700 hover:bg-gray-500 px-4 py-2 rounded-md" onclick="closeCooperadosModal()">Fechar</button>
        </div>
    </div>
</div>
