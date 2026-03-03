<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelToPdfController;
use App\Http\Controllers\ToolController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('login', [AuthController::class, 'login']);
Route::get('signup', [AuthController::class, 'signup']);

Route::get('blog', [BlogController::class, 'index']);


Route::get('tools', [ToolController::class, 'index']);

Route::get('blog/{blog:slug}', [BlogController::class, 'show']);



// Route::get('/', [ExcelToPdfController::class, 'index'])->name('excel.index');
Route::post('/convert', [ExcelToPdfController::class, 'convert'])->name('excel.convert');
