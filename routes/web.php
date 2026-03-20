<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelToPdfController;
use App\Http\Controllers\PdfToWordController;
use App\Http\Controllers\ToolController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('signup', [AuthController::class, 'signup'])->name('signup');

Route::get('blog', [BlogController::class, 'index']);


Route::get('tools', [ToolController::class, 'index']);

Route::get('blog/{blog:slug}', [BlogController::class, 'show']);

Route::post('/signup', [AuthController::class, 'store'])->name('signup.store');
Route::post('login', [AuthController::class, 'loginStore'])->name('login.store');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');



// Route::get('/', [ExcelToPdfController::class, 'index'])->name('excel.index');
Route::post('/convert', [ExcelToPdfController::class, 'convert'])->name('excel.convert');



Route::prefix('tools/pdf-to-word')->name('tools.pdf-to-word.')->group(function () {
    Route::get('/',                 [PdfToWordController::class, 'index'])->name('index');
    Route::post('/convert',         [PdfToWordController::class, 'convert'])->name('convert');
    Route::get('/download/{id}',    [PdfToWordController::class, 'download'])->name('download');
});
