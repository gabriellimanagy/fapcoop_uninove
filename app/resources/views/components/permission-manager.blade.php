<div class="grid grid-cols-3 gap-4">
    <div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">Não Permitido</h3>
        <select multiple class="mt-1 block w-full h-64 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" id="not-allowed" name="not_allowed[]">
            @foreach($allPermissions as $permission)
                @if(!in_array($permission->id, $currentPermissions))
                    <option value="{{ $permission->id }}">{{ $permission->nome }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="flex flex-col justify-center items-center">
        <button type="button" id="add-permission" class="btn bg-green-500 text-white hover:bg-green-700 px-4 py-2 rounded-md mb-2">Adicionar &gt;&gt;</button>
        <button type="button" id="remove-permission" class="btn bg-red-500 text-white hover:bg-red-700 px-4 py-2 rounded-md">Remover &lt;&lt;</button>
    </div>
    <div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">Permitido</h3>
        <select multiple class="mt-1 block w-full h-64 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" id="allowed" name="allowed[]">
            @foreach($allPermissions as $permission)
                @if(in_array($permission->id, $currentPermissions))
                    <option value="{{ $permission->id }}">{{ $permission->nome }}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>
<div class="flex justify-end mt-6">
    <a href="{{ route('departamentos.index') }}" class="btn bg-gray-500 text-white hover:bg-gray-700 px-4 py-2 rounded-md mr-2">Cancelar</a>
    <button type="submit" class="btn bg-green-500 text-white hover:bg-green-700 px-4 py-2 rounded-md">Salvar</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notAllowedSelect = document.getElementById('not-allowed');
        const allowedSelect = document.getElementById('allowed');
        const form = allowedSelect.closest('form');

        document.getElementById('add-permission').addEventListener('click', function () {
            moveSelectedOptions(notAllowedSelect, allowedSelect);
        });

        document.getElementById('remove-permission').addEventListener('click', function () {
            moveSelectedOptions(allowedSelect, notAllowedSelect);
        });

        function moveSelectedOptions(fromSelect, toSelect) {
            const selectedOptions = Array.from(fromSelect.selectedOptions);
            selectedOptions.forEach(option => {
                toSelect.appendChild(option);
            });
        }

        // Select all options in the "allowed" select before form submission
        form.addEventListener('submit', function() {
            Array.from(allowedSelect.options).forEach(option => {
                option.selected = true;
            });
        });
    });
</script>
