<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class AdminController extends Controller
{
    protected function checkAuth(Request $request)
    {
        if (!$request->session()->get('is_admin')) {
            return redirect()->route('login');
        }

        return null;
    }
}
