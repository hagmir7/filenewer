<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelToPdfController;
use App\Http\Controllers\PdfToWordController;
use App\Http\Controllers\ToolController;


use App\Http\Controllers\Auth\GithubAuthController;

use App\Http\Controllers\Auth\GoogleAuthController;

use App\Http\Controllers\Auth\FacebookAuthController;
use App\Http\Controllers\PageController;

Route::get('/auth/facebook', [FacebookAuthController::class, 'redirect'])
    ->name('facebook.login');

Route::get('/auth/facebook/callback', [FacebookAuthController::class, 'callback']);

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])
    ->name('google.login');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);




Route::get('/auth/github', [GithubAuthController::class, 'redirect'])->name('github.login');

Route::get('/auth/github/callback', [GithubAuthController::class, 'callback']);

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('signup', [AuthController::class, 'signup'])->name('signup');



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


Route::controller(ToolController::class)->prefix('tools')->group(function () {
    Route::get('csv-to-sql', 'csvToSql');
    Route::get('invoice-generator', 'invoiceGenerator');
    Route::get('image-compressor', 'ImageCompressor');
    Route::get('pdf-merge', 'pdfMerge');
    Route::get('csv-to-json', 'csvToJson');

    Route::get('', 'index');
    Route::get('{slug}', 'show');
});


Route::controller(ContactController::class)->prefix('contact')->group(function () {
    Route::get('', 'index')->name('contact');
    Route::post('', 'store')->name('contact.store');
});



Route::get('blog', [BlogController::class, 'index']);
Route::get('blog/{blog:slug}', [BlogController::class, 'show']);

// Pages
Route::get('pages/{slug}', [PageController::class, 'show']);
