<?php

namespace App\Http\Controllers\Dashboard;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// use App\Order;


class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:read_orders'])->only('index');
        $this->middleware(['permission:create_orders'])->only('create');
        $this->middleware(['permission:update_orders'])->only('edit');
        $this->middleware(['permission:delete_orders'])->only('destroy');

    }

    public function index(Request $request)
    {

        $orders = Order::whereHas('client', function ($q) use ($request) {
            return $q->where('name', 'LIKE', '%' . $request->search . '%');

        })->paginate(5);

        return view('dashboard.orders.index', compact('orders'));
//        return view('dashboard.orders.index', compact('orders'));
    }

    public function products(Order $order)
    {
        $products = $order->products;

//        dd($products);
        return view('dashboard.orders._products', compact('order', 'products'));
    }


    public function destroy(Order $order)
    {
//        To Increase Ordered Quantity In this Product
        foreach ($order->products as $product) {
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);
        }// end foreach


        $order->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('orders.index');

    }


}
