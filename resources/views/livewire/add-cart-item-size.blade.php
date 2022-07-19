<div x-data>
	<p class="text-gray-700 mb-4">
		<span class="font-semibold text-lg">Stock disponible:</span> {{ $stock }}
	</p>
	<div>
		<p class="text-xl text-gray-700">Talle:</p>
		<select class="form-control w-full" wire:model="sizeSelected">
			<option value="" selected disabled>Seleccione un talle</option>
			@foreach ($sizes as $size)
				<option value="{{ $size->id }}">{{ $size->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="mt-2">
		<p class="text-xl text-gray-700">Color:</p>
		<select class="form-control w-full capitalize" wire:model="colorSelected">
			<option value="" selected disabled>Seleccione un color</option>
			@foreach ($colors as $color)
				<option class="capitalize" value="{{ $color->id }}">{{ __($color->name) }}</option>
			@endforeach
		</select>
	</div>
	<div class="flex mt-4">
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
			<x-button color="orange" class="w-full" x-bind:disabled="!$wire.stock">
				Agregar al carrito de compras
			</x-button>
		</div>
	</div>
</div>
