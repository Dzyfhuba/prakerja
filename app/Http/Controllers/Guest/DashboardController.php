<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
      return inertia('Dashboard');
    }
    public function test()
    {
      return inertia('Test');
    }
}
