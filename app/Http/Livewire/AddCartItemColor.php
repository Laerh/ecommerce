<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class AddCartItemColor extends Component
{
    public $product, $colors;

    public $colorSelected = '';

    public $stock = 0;

    public $quantity = 1;

    public $options = [
        'size_id' => null
    ];

    public function mount()
    {
        $this->colors = $this->product->colors;
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

    public function updatedColorSelected($value)
    {
        $color = $this->product->colors->find($value);
        $this->stock = quantityAvailable($this->product->id, $color->id);
        $this->options['color'] = $color->name;
    }

    public function addItem()
    {
        $this->options['color_id'] = $this->colorSelected;
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->quantity,
            'price' => $this->product->price,
            'weight' => 550,
            'options' => $this->options
        ]);
        $this->stock = quantityAvailable($this->product->id, $this->colorSelected);
        $this->reset('quantity');
        $this->emitTo('dropdown-cart', 'render');
    }

    public function render()
    {
        return view('livewire.add-cart-item-color');
    }
}
