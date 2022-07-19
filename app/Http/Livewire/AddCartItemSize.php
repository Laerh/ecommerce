<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Size;

class AddCartItemSize extends Component
{
    public $product, $sizes;

    public $sizeSelected = '';

    public $colorSelected = '';

    public $stock = 0;

    public $quantity = 1;

    public $colors = [];

    public function updatedSizeSelected($value)
    {
        $size = Size::find($value);
        $this->colors = $size->colors;
    }

    public function updatedColorSelected($value)
    {
        $size = Size::find($this->sizeSelected);
        $this->stock = $size->colors->find($value)->pivot->quantity;
    }

    public function decrement()
    {
        $this->quantity--;
    }

    public function increment()
    {
        $this->quantity++;
    }

    public function mount()
    {
        $this->sizes = $this->product->sizes;
    }

    public function render()
    {
        return view('livewire.add-cart-item-size');
    }
}
