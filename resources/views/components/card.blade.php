<div {{ $attributes->merge(['class' => 'max-w-7xl mx-auto']) }}>
    <div class="bg-white shadow-xl sm:rounded-lg">
        {{$slot}}
    </div>
</div>
