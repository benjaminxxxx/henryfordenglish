<div {{ $attributes->merge(['class' => 'max-w-7xl mx-auto']) }}>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2 md:p-7">
        {{$slot}}
    </div>
</div>