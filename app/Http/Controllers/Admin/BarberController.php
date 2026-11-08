<?php

namespace App\Http\Controllers\Admin;

use App\Models\Barber;
use Illuminate\Http\Request;

class BarberController extends AdminController
{
    public function index(Request $request)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        return view('admin.barbers', [
            'barbers' => Barber::withCount('appointments')->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:barbers,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'specialty' => ['nullable', 'string', 'max:100'],
        ]);

        Barber::create($data);

        return redirect()->route('admin.barbers')->with('success', 'Barber added.');
    }

    public function update(Request $request, Barber $barber)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:barbers,email,' . $barber->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'specialty' => ['nullable', 'string', 'max:100'],
        ]);

        $barber->update($data);

        return redirect()->route('admin.barbers')->with('success', 'Barber updated.');
    }

    public function destroy(Request $request, Barber $barber)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $barber->delete();

        return redirect()->route('admin.barbers')->with('success', 'Barber deleted.');
    }
}
