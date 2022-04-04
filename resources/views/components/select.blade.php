<select {{ $attributes->merge(['class' => ' border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1 shadow-sm']) }}>
    {{$slot}}
</select>
