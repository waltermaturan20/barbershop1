<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends AdminController
{
    public function index(Request $request)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        return view('admin.clients', [
            'clients' => Client::withCount('appointments')->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:clients,email'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        Client::create($data);

        return redirect()->route('admin.clients')->with('success', 'Client added.');
    }

    public function update(Request $request, Client $client)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:clients,email,' . $client->id],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $client->update($data);

        return redirect()->route('admin.clients')->with('success', 'Client updated.');
    }

    public function destroy(Request $request, Client $client)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $client->delete();

        return redirect()->route('admin.clients')->with('success', 'Client deleted.');
    }
}
