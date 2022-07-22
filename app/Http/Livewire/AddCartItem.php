<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class AddCartItem extends Component
{
    public $product;

    public $quantity = 1;

    public $stock;

    public $options = [
        'color_id' => null,
        'size_id' => null
    ];

    public function mount()
    {
        $this->stock = quantityAvailable($this->product->id);
        $this->options['image'] = asset('storage/' . $this->product->images->first()->url);
    }

    public function decrement()
    {
        $this->quantity--;
    }

    public function increment()
    {
        $this->quantity++;
    }

    public function addItem()
    {
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->quantity,
            'price' => $this->product->price,
            'weight' => 550,
            'options' => $this->options
        ]);
        $this->stock = quantityAvailable($this->product->id);
        $this->reset('quantity');
        $this->emitTo('dropdown-cart', 'render');
    }

    public function render()
    {
        return view('livewire.add-cart-item');
    }
}
