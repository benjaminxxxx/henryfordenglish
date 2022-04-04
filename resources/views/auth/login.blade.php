<x-guest-layout>
    <x-authentication-card>
        

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="block md:flex">
                <a href="#">
                    <img src="{{asset('image/logo.png')}}" class="max-full md:w-60 w-52 m-auto" alt="">
                </a>
                <div class="px-10">
                    <div>
                        <x-jet-label for="dni" value="DNI" />
                        <x-jet-input id="dni" class="block mt-1 w-full" type="text" name="dni" :value="old('dni')" required autofocus />
                    </div>
        
                    <div class="mt-4">
                        <x-jet-label for="password" value="CLAVE" />
                        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>
        
                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-jet-checkbox id="remember_me" name="remember" />
                            <span class="ml-2 text-sm text-gray-600">Mantenerme conectado</span>
                        </label>
                    </div>
        
                    <div class="flex items-center justify-end mt-4">
                       
                        <a href="{{route('registrar')}}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">
                            Crear cuenta
                        </a>
        
                        <x-jet-button class="ml-4">
                            Ingresar
                        </x-jet-button>
                    </div>
                </div>
            </div>
            
        </form>
    </x-authentication-card>
</x-guest-layout>
