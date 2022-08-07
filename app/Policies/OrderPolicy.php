<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    //politica para saber el autor de la orden, controla que un autor pueda ver ordenes de otros usuarios.
    public function author(User $user, Order $order)
    {
        if ($order->user_id == $user->id) {
            return true;
        } else {
            return false;
        }
    }

    //restringir acceso a las ordenes ya pagadas
    public function payment(User $user, Order $order)
    {
        if ($order->status == 1) {
            return true;
        } else {
            return false;
        }
    }
}
