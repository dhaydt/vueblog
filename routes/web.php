<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;

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
//menambah data tag
Route::post('app/create_tag', [AdminController::class, 'addTag']);
Route::post('app/get_tags', [AdminController::class, 'getTag']);
Route::post('app/edit_tag', [AdminController::class, 'editTag']);
Route::post('app/delete_tag', [AdminController::class, 'deleteTag']);
Route::post('app/upload', [AdminController::class, 'upload']);
Route::post('app/delete_image', [AdminController::class, 'deleteImage']);

Route::post('app/create_category', [AdminController::class, 'addCategory']);
Route::post('app/get_category', [AdminController::class, 'getCategory']);








Route::get('/test', function () {
	return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/env', [TestController::class, 'method']);

Route::any('/{slug}', function(){
    return view('welcome');
});
