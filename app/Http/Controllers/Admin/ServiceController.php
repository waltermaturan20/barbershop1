<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends AdminController
{
    public function index(Request $request)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        return view('admin.services', [
            'services' => Service::with('category')->latest()->get(),
            'categories' => ServiceCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $data = $request->validate([
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_minutes' => ['required', 'integer', 'min:1'],
        ]);

        Service::create($data);

        return redirect()->route('admin.services')->with('success', 'Service added.');
    }

    public function update(Request $request, Service $service)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $data = $request->validate([
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_minutes' => ['required', 'integer', 'min:1'],
        ]);

        $service->update($data);

        return redirect()->route('admin.services')->with('success', 'Service updated.');
    }

    public function destroy(Request $request, Service $service)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $service->delete();

        return redirect()->route('admin.services')->with('success', 'Service deleted.');
    }
}
