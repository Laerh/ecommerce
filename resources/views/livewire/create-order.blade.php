<div class="container py-8 grid grid-cols-5 gap-6">
	<div class="col-span-3">
		<div class="bg-white rounded-lg shadow p-6">
			<div class="mb-4">
				<x-jet-label value="Nombre de contacto" />
				<x-jet-input type="text" class="w-full" placeholder="Ingrese el nombre de la persona que recibirá el producto"
					wire:model.defer="contact" />
				<x-jet-input-error for="contact" />
			</div>
			<div>
				<x-jet-label value="Teléfono de contacto" />
				<x-jet-input type="text" class="w-full" placeholder="Ingrese un número de teléfono para contactarlo"
					wire:model.defer="phone" />
				<x-jet-input-error for="phone" />
			</div>
		</div>
		<div x-data="{ envio_type: @entangle('envio_type') }">
			<p class="mt-6 mb-3 text-lg text-gray-700 font-semibold">Envíos</p>
			<label class="bg-white rounded-lg shadow px-6 py-4 flex items-center mb-4">
				<input type="radio" value="1" name="envio_type" class="text-gray-600" x-model="envio_type">
				<span class="ml-2 text-gray-700">
					Retiralo en la tienda (Calle prueba 123)
				</span>
				<span class="font-semibold text-gray-700 ml-auto">
					Gratis
				</span>
			</label>
			<div class="bg-white rounded-lg shadow">
				<label class="px-6 py-4 flex items-center">
					<input type="radio" value="2" name="envio_type" class="text-gray-600" x-model="envio_type">
					<span class="ml-2 text-gray-700">
						Envío a domicilio
					</span>
				</label>
				<div class="px-6 pb-6 grid grid-cols-2 gap-6" :class="{ 'hidden': envio_type != 2 }">
					{{-- DEPARTAMENTOS --}}
					<div>
						<x-jet-label value="Departamento" />
						<select class="form-control w-full" wire:model="department_id" name="" id="">
							<option value="" disabled selected>Seleccione un Departamento</option>
							@foreach ($departments as $department)
								<option value="{{ $department->id }}">{{ $department->name }}</option>
							@endforeach
						</select>
						<x-jet-input-error for="department_id" />
					</div>
					{{-- CIUDADES --}}
					<div>
						<x-jet-label value="Ciudad" />
						<select class="form-control w-full" wire:model="city_id" name="" id="">
							<option value="" disabled selected>Seleccione una Ciudad</option>
							@foreach ($cities as $city)
								<option value="{{ $city->id }}">{{ $city->name }}</option>
							@endforeach
						</select>
						<x-jet-input-error for="city_id" />
					</div>
					{{-- DISTRITOS --}}
					<div>
						<x-jet-label value="Distrito" />
						<select class="form-control w-full" wire:model="district_id" name="" id="">
							<option value="" disabled selected>Seleccione un Distrito</option>
							@foreach ($districts as $district)
								<option value="{{ $district->id }}">{{ $district->name }}</option>
							@endforeach
						</select>
						<x-jet-input-error for="district_id" />
					</div>
					{{-- DIRECCION --}}
					<div>
						<x-jet-label value="Dirección" />
						<x-jet-input type="text" class="w-full" wire:model="address" />
						<x-jet-input-error for="address" />
					</div>
					{{-- REFERENCIA --}}
					<div class="col-span-2">
						<x-jet-label value="Referencias" />
						<x-jet-input type="text" class="w-full" wire:model="references" />
						<x-jet-input-error for="references" />
					</div>
				</div>
			</div>
			<div>
				<x-jet-button class="mt-6 mb-4" wire:click="create_order" wire:loading.attr="disabled" wire:target="create_order">
					Continuar con la compra
				</x-jet-button>
				<hr>
				<p class="text-sm text text-gray-700 mt-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam, nam
					beatae! Reprehenderit delectus
					accusantium dolorem, maiores quibusdam suscipit. Reprehenderit, recusandae deserunt esse accusamus minima
					consectetur dolorum ratione error natus eos? <a class="font-semibold text-orange-500" href="">Políticas y
						privacidad</a></p>
			</div>
		</div>
	</div>
	<div class="col-span-2">
		<div class="bg-white rounded-lg shadow p-6">
			<ul>
				@forelse (Cart::content() as $item)
					<li class="flex p-2 border-gray-200">
						<img class="h-15 w-20 object-cover mr-4" src="{{ $item->options->image }}">
						<article class="flex-1">
							<h1 class="font-bold">{{ $item->name }}</h1>
							<div class="flex">
								<p>Cantidad: {{ $item->qty }}</p>
								@isset($item->options['color'])
									<p class="mx-2 capitalize">- Color: {{ __($item->options['color']) }}</p>
								@endisset
								@isset($item->options['size'])
									<p>{{ __($item->options['size']) }}</p>
								@endisset
							</div>
							<p>U$S {{ $item->price }}</p>
						</article>
					</li>
				@empty
					<li class="py-6 px-4">
						<p class="text-center text-gray-700">
							No tiene agregado ningún producto en el carrito de compras.
						</p>
					</li>
				@endforelse
			</ul>
			<hr class="mt-4 mb-3">
			<div class="text-gray-700">
				<p class="flex justify-between items-center">
					Subtotal <span class="font-semibold">U$S {{ Cart::subtotal() }}</span>
				</p>
				<p class="flex justify-between items-center">
					Envío <span class="font-semibold">
						@if ($envio_type == 1 || $shipping_cost == 0)
							Gratis
						@else
							U$S {{ $shipping_cost }}
						@endif
					</span>
				</p>
				<hr class="mt-4 mb-3">
				<p class="flex justify-between items-center font-semibold">
					<span class="text-lg">Total</span>
					@if ($envio_type == 1)
						U$S {{ Cart::Subtotal() }}
					@else
						U$S {{ Cart::Subtotal() + $shipping_cost }}
					@endif
				</p>
			</div>
		</div>
	</div>
</div>
