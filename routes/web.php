<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

function factorial ($value) {
    if ($value > 0) return factorial($value - 1) * $value;
    return 1;
}

function fibonacci($n) {
    if ($n == 0) {
        return 0;
    } elseif ($n == 1 || $n == 2) {
        return 1;
    } else {
        return fibonacci($n - 1) + fibonacci($n - 2);
    }
}

Route::get('/', function (Request $request) {
    $value = $request->query('value');

    if ($value > 5) return response([
        'error' => 'Max 5'
    ]);
    
    return response([
        'Hello' => 'World',
        'factorial' => factorial($value),
        'fibonacci' => fibonacci($value)
    ]);
});
