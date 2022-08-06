<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class UpdateCartItem extends Component
{
    public $rowId, $quantity, $stock;

    public function mount()
    {
        $item = Cart::get($this->rowId);
        $this->quantity = $item->qty;
        $this->stock = quantityAvailable($item->id);
    }

    public function decrement()
    {
        $this->quantity--;
        Cart::update($this->rowId, $this->quantity);
        $this->emit('render');
    }

    public function increment()
    {
        $this->quantity++;
        Cart::update($this->rowId, $this->quantity);
        $this->emit('render');
    }

    public function render()
    {
        return view('livewire.update-cart-item');
    }
}
