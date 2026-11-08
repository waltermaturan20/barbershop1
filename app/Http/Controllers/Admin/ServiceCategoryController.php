<?php

namespace App\Http\Controllers\Admin;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends AdminController
{
    public function index(Request $request)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        return view('admin.service-categories', [
            'categories' => ServiceCategory::withCount('services')->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:service_categories,name'],
        ]);

        ServiceCategory::create($data);

        return redirect()->route('admin.service-categories')->with('success', 'Category added.');
    }

    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:service_categories,name,' . $serviceCategory->id],
        ]);

        $serviceCategory->update($data);

        return redirect()->route('admin.service-categories')->with('success', 'Category updated.');
    }

    public function destroy(Request $request, ServiceCategory $serviceCategory)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $serviceCategory->delete();

        return redirect()->route('admin.service-categories')->with('success', 'Category deleted.');
    }
}
