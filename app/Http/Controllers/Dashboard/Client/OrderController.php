<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Category;
use App\Client;
use App\Http\Controllers\Controller;
use App\order;
use App\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function create(Client $client)
    {
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(5);
        return view('dashboard.clients.orders.create', compact('client', 'orders', 'categories'));
    }

    public function store(Request $request, Client $client)
    {

        $request->validate([
            'products' => 'required|array',
        ]);

        $this->attach_order($request, $client);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('orders.index');

    }


    public function edit(Client $client, order $order)
    {
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(5);
        return view('dashboard.clients.orders.edit', compact('client', 'order', 'categories', 'orders'));
    }


    public function update(Request $request, Client $client, order $order)
    {
        $request->validate([
            'products' => 'required|array',
        ]);

        $this->detach_order($order); // To Delete old order  and create a new One.
        $this->attach_order($request, $client); // Create A new order


        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('orders.index');


    }

    public function destroy(order $order)
    {
        //
    }


    private function attach_order($request, $client)
    {
        $order = $client->orders()->create([]);

        $order->products()->attach($request->products);

        $total_price = 0;

        foreach ($request->products as $id => $quantity) {

            $product = Product::FindOrFail($id);
            $total_price += $product->sale_price * $quantity['quantity'];

            $product->update([
                'stock' => $product->stock - $quantity['quantity']
            ]);

        }//end of foreach

        $order->update([
            'total_price' => $total_price
        ]);

    }//end of attach order


    private function detach_order($order)
    {
        foreach ($order->products as $product) {

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);

        }//end of for each

        $order->delete();

    }


}
