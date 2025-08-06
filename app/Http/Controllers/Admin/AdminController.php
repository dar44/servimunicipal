<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Admin dashboard
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index() 
    {
        return view('admin.dashboard');
    }
}
