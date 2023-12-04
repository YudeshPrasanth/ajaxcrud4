<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/index', EmployeeController::class);
Route::post('/store', [EmployeeController::class, 'store'])->name('store');
Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('edit');
Route::post('/update', [EmployeeController::class, 'update'])->name('update');
Route::delete('/delete/{id}', [EmployeeController::class, 'destroy'])->name('delete');


Route::resource('/detail', ProductController::class);
Route::get('/product-edit/{id}',[ProductController::class,'edit'])->name('edit');
Route::post('/product-store', [ProductController::class, 'store'])->name('save_product');
Route::post('/product-update', [ProductController::class, 'update'])->name('update_product');
Route::delete('/product-delete/{id}',[ProductController::class,'destroy'])->name('delete_product');
