@props(['value'])

<th {{ $attributes->merge(['class' => 'px-3 py-2 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider']) }}>
    {{ mb_strtoupper($value) }}
</th>