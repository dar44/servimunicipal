<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    /**
     * Worker dashboard
     * 
     */
    public function index()
    {
        return view('worker.dashboard');
    }
}
