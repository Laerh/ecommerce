<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddCartItemColor extends Component
{
    public $product, $colors;

    public $colorSelected = '';

    public $stock = 0;

    public $quantity = 1;

    public function mount()
    {
        $this->colors = $this->product->colors;
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
        $this->stock = $this->product->colors->find($value)->pivot->quantity;
    }

    public function render()
    {
        return view('livewire.add-cart-item-color');
    }
}
