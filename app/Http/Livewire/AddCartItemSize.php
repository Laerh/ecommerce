<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Size;
use Gloudemans\Shoppingcart\Facades\Cart;

class AddCartItemSize extends Component
{
    public $product, $sizes;

    public $sizeSelected = '';

    public $colorSelected = '';

    public $stock = 0;

    public $quantity = 1;

    public $colors = [];

    public $options = [];

    public function mount()
    {
        $this->sizes = $this->product->sizes;
        $this->options['image'] = asset('storage/' . $this->product->images->first()->url);
    }

    public function updatedSizeSelected($value)
    {
        $size = Size::find($value);
        $this->colors = $size->colors;
        $this->options['size'] = $size->name;
    }

    public function updatedColorSelected($value)
    {
        $size = Size::find($this->sizeSelected);
        $color = $size->colors->find($value);
        $this->stock = quantityAvailable($this->product->id, $color->id, $size->id);
        $this->options['color'] = $color->name;
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
        $this->options['size_id'] = $this->sizeSelected;
        $this->options['color_id'] = $this->colorSelected;
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->quantity,
            'price' => $this->product->price,
            'weight' => 550,
            'options' => $this->options
        ]);
        $this->stock = quantityAvailable($this->product->id, $this->colorSelected, $this->sizeSelected);
        $this->reset('quantity');
        $this->emitTo('dropdown-cart', 'render');
    }

    public function render()
    {
        return view('livewire.add-cart-item-size');
    }
}
