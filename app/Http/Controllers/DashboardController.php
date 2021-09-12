<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('owner')) {
            return view('owner.dashboard');
        } elseif (Auth::user()->hasRole('gudang')) {
            return view('gudang.dashboard');
        } else {
            return view('kasir.dashboard');
        }
    }
}
