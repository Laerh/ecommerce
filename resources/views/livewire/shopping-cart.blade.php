<div class="container py-8">
	<section class="bg-white rounded-lg shadow-lg p-6 text-gray-700">
		@if (Cart::count())
			<h1 class="text-lg font-semibold mb-6">CARRO DE COMPRAS</h1>
			<table class="table-auto w-full">
				<thead>
					<tr>
						<th></th>
						<th>Precio</th>
						<th>Cant</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					@foreach (Cart::content() as $item)
						<tr>
							<td>
								<div class="flex">
									<img class="h-15 w-20 object-cover mr-4" src="{{ $item->options->image }}" alt="">
									<div>
										<p class="font-bold">{{ $item->name }}</p>
										@if ($item->options->color)
											<span class="capitalize">
												Color: {{ __($item->options->color) }}
											</span>
										@endif
										@if ($item->options->size)
											<span>
												- {{ $item->options->size }}
											</span>
										@endif
									</div>
								</div>
							</td>
							<td class="text-center">
								<span>U$S {{ $item->price }}</span>
								<a class="ml-6 cursor-pointer hover:text-red-600" wire:click="deleteItem('{{ $item->rowId }}')"
									wire:loading.class="opacity-25 cursor-not-allowed" wire:target="deleteItem">
									<i class="fas fa-trash"></i>
								</a>
							</td>
							<td class="text-center">
								@if ($item->options->size)
									@livewire('update-cart-item-size', ['rowId' => $item->rowId], key($item->rowId))
								@elseif ($item->options->color)
									@livewire('update-cart-item-color', ['rowId' => $item->rowId], key($item->rowId))
								@else
									@livewire('update-cart-item', ['rowId' => $item->rowId], key($item->rowId))
								@endif
							</td>
							<td class="text-center">
								U$S {{ $item->price * $item->qty }}
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<a class="text-sm cursor-pointer hover:underline inline-block mt-4" wire:click="destroy"><i class="fas fa-trash"></i>
				Borrar carrito de
				compras</a>
		@else
			<div class="flex flex-col items-center">
				<div class="w-2/4 h-2/4">
					<x-empty-shopping-cart-svg />
				</div>
				<p class="text-lg text-gray-700 font-semibold">TU CARRO DE COMPRAS ESTÁ VACÍO</p>
				<x-danger-link href="/" class="mt-4 px-16">
					Ir al inicio
				</x-danger-link>
			</div>
		@endif
	</section>
	@if (Cart::count())
		<div class="bg-white rounded-lg shadow-lg px-6 py-4 mt-4">
			<div class="flex justify-between items-center">
				<div>
					<p class="text-gray-700">
						<span class="font-bold text-lg">Total: </span>
						U$S {{ Cart::subTotal() }}
					</p>
				</div>
				<div>
					<x-danger-link href="{{ route('orders.create') }}" class="px-12 cursor-pointer">
						Continuar
					</x-danger-link>
				</div>
			</div>
		</div>
	@endif
</div>
