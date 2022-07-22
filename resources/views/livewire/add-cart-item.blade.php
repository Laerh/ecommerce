<div x-data>
	<p class="text-gray-700 mb-4">
		<span class="font-semibold text-lg">Stock disponible:</span> {{ $stock }}
	</p>
	<div class="flex">
		<div class="mr-4">
			<x-jet-secondary-button disabled x-bind:disabled="$wire.quantity <= 1" wire:loading.attr="disabled"
				wire:target="decrement" wire:click="decrement">
				-
			</x-jet-secondary-button>
			<span class="mx-2 text-gray-700">{{ $quantity }}</span>
			<x-jet-secondary-button x-bind:disabled="$wire.quantity >= $wire.stock" wire:loading.attr="disabled"
				wire:target="increment" wire:click="increment">
				+
			</x-jet-secondary-button>
		</div>
		<div class="flex-1">
			<x-button color="orange" class="w-full" wire:click="addItem" wire:loading.attr="disabled" wire:target="addItem"
				x-bind:disabled="$wire.quantity > $wire.stock">
				Agregar al carrito de compras
			</x-button>
		</div>
	</div>
</div>
