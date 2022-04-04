<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-pink-600 text-white hover:bg-pink-700 focus:border-pink-800 focus:ring-pink-300 inline-flex items-center px-4 py-2  border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest active:bg-pink-900 focus:outline-none focus:ring  disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
