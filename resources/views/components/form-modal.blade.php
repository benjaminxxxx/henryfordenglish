@props(['id' => null, 'maxWidth' => null,'submit'])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>

    <form wire:submit.prevent="{{ $submit }}">
        
        <div class="px-4 py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
            <div class="text-lg mb-5">
                {{ $title }}
            </div>

            <div class="">
                {{ $content }}
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-100 text-right">
            {{ $footer }}
        </div>

    </form>

    
</x-modal>
