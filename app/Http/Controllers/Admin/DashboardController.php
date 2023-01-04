<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:edit role');
    }

    public function __invoke(Request $request)
    {
        return Inertia::render('Admin/Dashboard');
    }
}
