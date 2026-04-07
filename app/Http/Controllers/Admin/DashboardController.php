<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Dashboard view руу орж ирэх функц
    public function index()
    {
        return view('admin.dashboard'); // resources/views/admin/dashboard.blade.php файлыг харуулна
    }
}