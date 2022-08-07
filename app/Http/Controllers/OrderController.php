<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index()
    {
        $countStatus = [];
        $orders = Order::query()->where('user_id', auth()->user()->id);
        $orders = $orders->get();
        $countStatus['pendiente'] = $orders->where('status', 1)->count();
        $countStatus['pagado'] = $orders->where('status', 2)->count();
        $countStatus['enviado'] = $orders->where('status', 3)->count();
        $countStatus['entregado'] = $orders->where('status', 4)->count();
        $countStatus['anulado'] = $orders->where('status', 5)->count();
        if (request('status')) {
            $orders = Order::query()->where('user_id', auth()->user()->id);
            $orders->where('status', request('status'));
            $orders = $orders->get();
        }

        return view('orders.index', compact('orders', 'countStatus'));
    }

    public function show(Order $order)
    {
        $this->authorize('author', $order);
        $items = json_decode($order->content);
        return view('orders.show', compact('order', 'items'));
    }

    public function pay(Order $order, Request $request)
    {
        $this->authorize('author', $order);
        $payment_id = $request->get('payment_id');
        $response = Http::get("https://api.mercadopago.com/v1/payments/$payment_id" . "?access_token=" . env('MP_ACCESS_TOKEN'));
        $response = json_decode($response);
        $status = $response->status;
        if ($status == 'approve') {
            $order->status = 2;
            $order->save();
        }
        return redirect()->route('orders.show', $order);
    }
}
