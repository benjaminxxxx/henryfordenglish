@props(['value'])

<td {{ $attributes->merge(['class' => 'px-3 py-2 text-sm leading-5 font-medium md:break-all']) }}>
    {{ $value ?? $slot }}
</td>