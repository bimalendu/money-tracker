<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Expense;
use App\Http\Livewire\Income;
use App\Http\Livewire\Dashboard;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard',Dashboard::class)->name('dashboard');

    Route::get('/expenses', Expense::class)->name('expenses');
    Route::get('/income', Income::class)->name('income');
});