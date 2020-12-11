<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminCheck;

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
Route::prefix('app')->middleware([AdminCheck::class])->group(function(){
    Route::post('/create_tag', [AdminController::class, 'addTag']);
    Route::post('/get_tags', [AdminController::class, 'getTag']);
    Route::post('/edit_tag', [AdminController::class, 'editTag']);
    Route::post('/delete_tag', [AdminController::class, 'deleteTag']);
    Route::post('/upload', [AdminController::class, 'upload']);
    Route::post('/delete_image', [AdminController::class, 'deleteImage']);

    Route::post('/create_category', [AdminController::class, 'addCategory']);
    Route::post('/get_category', [AdminController::class, 'getCategory']);
    Route::post('/delete_category', [AdminController::class, 'deleteCategory']);
    Route::post('/edit_category', [AdminController::class, 'editCategory']);

    Route::post('/get_users', [AdminController::class, 'getUser']);
    Route::post('/edit_user', [AdminController::class, 'editUser']);
    Route::post('/delete_user', [AdminController::class, 'deleteUser']);
    Route::post('/admin_login', [AdminController::class, 'adminLogin']);

    Route::post('/create_role', [AdminController::class, 'addRole']);
    Route::post('/edit_role', [AdminController::class, 'editRole']);
    Route::post('/delete_role', [AdminController::class, 'deleteRole']);
    Route::post('/assign_roles', [AdminController::class, 'assignRole']);
    Route::post('/create-blog', [AdminController::class, 'createBlog']);
});

Route::post('/get_roles', [AdminController::class, 'getRoles']);
Route::post('/create_user', [AdminController::class, 'createUser']);

Route::post('createblog', [AdminController::class, 'uploadEditorImage']);
Route::get('slug', [AdminController::class, 'slug']);

Route::get('/', [AdminController::class, 'index']);
Route::get('/logout', [AdminController::class, 'logout']);
Route::any('{slug}', [AdminController::class, 'index']);








// Route::get('/test', function () {
// 	return view('welcome');
// });

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/env', [TestController::class, 'method']);

// Route::any('/{slug}', function(){
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
