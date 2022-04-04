<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            HENRY FORD
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('registrar.store') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Nombre') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div>
                <x-jet-label for="apellido" value="{{ __('Apellido') }}" />
                <x-jet-input id="apellido" class="block mt-1 w-full" type="text" name="apellido" :value="old('apellido')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="dni" value="{{ __('DNI') }}" />
                <x-jet-input id="dni" class="block mt-1 w-full" type="text" name="dni" :value="old('dni')" required />
            </div>

            <div>
                <x-jet-label for="name" value="{{ __('Nivel') }}" />
                <x-select name="nivel" :value="old('nivel')">
                    @foreach ($niveles as $nivel)
                        <option value="{{$nivel->id}}">{{$nivel->grado}}</option>
                    @endforeach
                </x-select>
            </div>

    

            <div class="flex items-center justify-end mt-4">
                

                <x-jet-button class="ml-4">
                    {{ __('Registrar') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
