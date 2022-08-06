<x-app-layout>
	<div class="container py-8">
		<ul>
			@forelse ($products as $product)
				<x-product-list :product="$product" />
			@empty
				<li class="bg-white rounded-lg shadow-2xl ">
					<div class="p-4 flex flex-col items-center">
						<x-searching-svg />
						<p class="text-lg text-gray-700 font-semibold">
							Ningún producto coincide con esos parametros
						</p>
					</div>
				</li>
			@endforelse
		</ul>
		<div class="pt-4">
			{{ $products->links() }}
		</div>
	</div>
</x-app-layout>
