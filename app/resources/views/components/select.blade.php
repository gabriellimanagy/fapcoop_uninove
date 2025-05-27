@props(['id'])

<select {{ $attributes->merge(['id' => $id, 'class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200']) }}>
    {{ $slot }}
</select>
