<div  {{ $attributes->merge(['class' => 'bg-white overflow-x-auto border rounded-lg']) }}>
    <table class="min-w-full divide-y divide-gray-200">
        {{$slot}}
    </table>
</div>