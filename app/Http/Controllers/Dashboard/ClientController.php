<?php

namespace App\Http\Controllers\Dashboard;

use App\client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{

    public function index(Request $request)
    {
        $clients = Client::when($request->search, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%')
                ->orWhere('address', 'like', '%' . $request->search . '%');

        })->latest()->paginate(5);

        return view('dashboard.clients.index', compact('clients'));

    }//end of index

    public function create()
    {
        return view('dashboard.clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|array|min:1',
            'phone.0' => 'required',
            'address' => 'required',
        ]);

        $data = $request->all();
        $data['phone'] = array_filter($request->phone);

        Client::create($data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('clients.index');
    }


    public function edit(client $client)
    {
        return view('dashboard.clients.edit', compact('client'));
    }


    public function update(Request $request, client $client)
    {

        $request->validate([
            'name' => 'required',
            'phone' => 'required|array|min:1',
            'phone.0' => 'required',
            'address' => 'required',
        ]);

        $data = $request->all();
        $data['phone'] = array_filter($request->phone);

        $client->update($data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('clients.index');
    }

    public function destroy(client $client)
    {
        $client->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('clients.index');
    }
}
