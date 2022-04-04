<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-yellow-600 text-white hover:bg-yellow-700 active:bg-yellow-800 focus:border-yellow-800 focus:ring-yellow-300 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring  disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
