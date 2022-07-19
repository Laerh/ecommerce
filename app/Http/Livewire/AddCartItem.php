<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddCartItem extends Component
{
    public $product;

    public $quantity = 1;

    public $stock;

    public function mount()
    {
        $this->stock = $this->product->quantity;
    }

    public function decrement()
    {
        $this->quantity--;
    }

    public function increment()
    {
        $this->quantity++;
    }

    public function render()
    {
        return view('livewire.add-cart-item');
    }
}
