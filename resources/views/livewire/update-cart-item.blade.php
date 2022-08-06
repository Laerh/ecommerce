<div x-data>
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
