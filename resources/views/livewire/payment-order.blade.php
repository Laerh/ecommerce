<div>
	@php
		// SDK de Mercado Pago
		require base_path('vendor/autoload.php');
		// Agrega credenciales
		MercadoPago\SDK::setAccessToken(config('services.mercadopago.access_token'));
		
		// Crea un objeto de preferencia
		$preference = new MercadoPago\Preference();
		
		$shipments = new MercadoPago\Shipments();
		$shipments->cost = $order->shipping_cost;
		$shipments->mode = 'not_specified';
		$preference->shipments = $shipments;
		
		// Crea un ítem en la preferencia
		foreach ($items as $product) {
		$item = new MercadoPago\Item();
		$item->title = $product->name;
		$item->quantity = $product->qty;
		$item->unit_price = $product->price;
		$products[] = $item;
		}
		$preference->back_urls = [
		'success' => route('orders.pay', $order),
		'failure' => 'http://www.tu-sitio/failure',
		'pending' => 'http://www.tu-sitio/pending',
		];
		$preference->auto_return = 'approved';
		$preference->items = $products;
		$preference->save();
	@endphp
	<div class="grid grid-cols-5 gap-6 container py-8">
		<div class="col-span-3">
			<div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6">
				<p class="text-gray-700 uppercase">
					<span class="font-semibold">Número de orden:</span> Orden-{{ $order->id }}
				</p>
			</div>
			<div class="bg-white rounded-lg shadow-lg p-6 mb-6 text-gray-700">
				<div class="grid grid-cols-2 gap-6 text-gray-700">
					<div>
						<p class="text-lg font-semibold uppercase">Envío</p>
						@if ($order->envio_type == 1)
							<p class="text-sm">Los productos se deben retirar en la tienda</p>
							<p class="text-sm">Calle falsa 123</p>
						@else
							<p class="text-sm">Los productos serán enviados a:</p>
							<p class="text-sm">{{ $order->address }}</p>
							<p>{{ $order->department->name }} - {{ $order->city->name }} - {{ $order->district->name }}</p>
						@endif
					</div>
					<div>
						<p class="text-lg font-semibold uppercase">Datos de contacto:</p>
						<p class="text-sm">Persona que recibira el producto: {{ $order->contact }}</p>
						<p class="text-sm">Teléfono de contacto: {{ $order->phone }}</p>
					</div>
				</div>
			</div>
			<div class="bg-white rounded-lg shadow-lg p-6 mb-6 text-gray-700">
				<p class="text-xl font-semibold mb-4 uppercase">Resumen:</p>
				<table class="table-auto w-full">
					<thead>
						<tr>
							<th></th>
							<th>Precio</th>
							<th>Cantidad</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-200">
						@foreach ($items as $item)
							<tr>
								<td>
									<div class="flex">
										<img class="h-15 w-20 object-cover mr-4" src="{{ $item->options->image }}" alt="">
										<article>
											<h1 class="font-bold">{{ $item->name }}</h1>
											<div class="flex text-xs">
												@isset($item->options->color)
													Color: {{ __($item->options->color) }}
												@endisset
												@isset($item->options->size)
													- {{ __($item->options->size) }}
												@endisset
											</div>
										</article>
									</div>
								</td>
								<td class="text-center">U$S {{ $item->price }}</td>
								<td class="text-center">{{ $item->qty }}</td>
								<td class="text-center">U$S {{ $item->price * $item->qty }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-span-2">
			{{-- MERCADO PAGO --}}
			<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
				<div class=" text-gray-700 flex justify-between items-center">
					<img class="h-28" src="{{ asset('vendor/images/mp_payment.png') }}" alt="">
					<div>
						<p class="text-sm font-semibold flex justify-between items-center">
							<span>Subtotal: </span>
							<span>U$S {{ $order->total - $order->shipping_cost }}</span>
						</p>
						<p class="text-sm font-semibold flex justify-between items-center">
							<span>Envío: </span>
							<span>U$S {{ $order->shipping_cost }}</span>
						</p>
						<hr>
						<p class="text-lg font-semibold uppercase mb-3">
							Total: U$S {{ $order->total }}
						</p>
						<div class="cho-container">
						</div>
					</div>
				</div>
			</div>
			{{-- PAYPAL --}}
			<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
				<div class=" text-gray-700 flex justify-between items-center">
					<img class="h-24" src="{{ asset('vendor/images/metodos_de_pago.png') }}" alt="">
					<div>
						<p class="text-sm font-semibold flex justify-between items-center">
							<span>Subtotal: </span>
							<span>U$S {{ $order->total - $order->shipping_cost }}</span>
						</p>
						<p class="text-sm font-semibold flex justify-between items-center">
							<span>Envío: </span>
							<span>U$S {{ $order->shipping_cost }}</span>
						</p>
						<hr>
						<p class="text-lg font-semibold uppercase">
							Total: U$S {{ $order->total }}
						</p>
					</div>
				</div>
				<div id="paypal-button-container">

				</div>
			</div>
		</div>
	</div>
	@push('script')
		<!-- Replace "test" with your own sandbox Business account app client ID -->
		<script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=USD"></script>
		{{-- SDK MercadoPago.js V2 --}}
		<script src="https://sdk.mercadopago.com/js/v2"></script>
		<script>
		 const mp = new MercadoPago("{{ config('services.mercadopago.public_key') }}", {
		  locale: 'es-AR'
		 });

		 mp.checkout({
		  preference: {
		   id: '{{ $preference->id }}'
		  },
		  render: {
		   container: '.cho-container',
		   label: 'Pagar',
		  }
		 });
		</script>
		<script>
		 paypal.Buttons({
		  // Sets up the transaction when a payment button is clicked
		  createOrder: (data, actions) => {
		   return actions.order.create({
		    purchase_units: [{
		     amount: {
		      value: "{{ $order->total }}" // Can also reference a variable or function
		     }
		    }]
		   });
		  },
		  // Finalize the transaction after payer approval
		  onApprove: (data, actions) => {
		   return actions.order.capture().then(function(orderData) {
		    // Successful capture! For dev/demo purposes:
		    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
		    const transaction = orderData.purchase_units[0].payments.captures[0];
		    //emitimos un evento Livewire
		    Livewire.emit('payOrder');
		    // alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);

		    // When ready to go live, remove the alert and show a success message within this page. For example:
		    // const element = document.getElementById('paypal-button-container');
		    // element.innerHTML = '<h3>Thank you for your payment!</h3>';
		    // Or go to another URL:  actions.redirect('thank_you.html');
		   });
		  }
		 }).render('#paypal-button-container');
		</script>
	@endpush
</div>
