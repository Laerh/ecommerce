@props(['color' => 'gray'])
<a
	{{ $attributes->merge(['type' => 'submit', 'class' => "inline-flex items-center px-4 py-2 bg-$color-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-$color-400 active:bg-$color-600 focus:outline-none focus:border-$color-600 focus:ring focus:ring-$color-300 disabled:opacity-25 transition"]) }}>
	{{ $slot }}
</a>
