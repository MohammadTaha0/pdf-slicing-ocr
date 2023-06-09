<?php

use App\Http\Controllers\Home\HomeController;
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

Route::get('/k', function () {
    return view('welcome');
});
Route::get('/', [HomeController::class,'ocr']);
Route::post('/', [HomeController::class,'ocr_edit']);
Route::get('/1', [HomeController::class,'index']);
Route::get('/2', [HomeController::class,'op']);
