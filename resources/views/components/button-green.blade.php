<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-green-600 text-white hover:bg-green-700 focus:border-green-800 focus:ring-green-300 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring  disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
