<div class="relative">
    <select class="select2 w-full border px-3 py-2 rounded" 
            name="{{ $name }}" 
            wire:model="selected">
        <option value="">Selecione uma opção</option>
        @foreach($options as $id => $displayValue)
            <option value="{{ $id }}" {{ $selected == $id ? 'selected' : '' }}>
                {{ $displayValue }}
            </option>
        @endforeach
    </select>
</div>