<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('user/{user}/roles', [UserController::class, 'roles'])->name('user.roles');
Route::put('user/{user}/roles/sync', [UserController::class, 'rolesSync'])->name('user.rolesSync');
Route::resource('user', \App\Http\Controllers\UserController::class);

Route::get('role/{role}/permissions', [RoleController::class, 'permissions'])->name('role.permissions');
Route::put('role/{role}/permissions/sync', [RoleController::class, 'permissionsSync'])->name('role.permissionsSync');
Route::resource('role', \App\Http\Controllers\RoleController::class);

Route::resource('permission', \App\Http\Controllers\PermissionController::class);

Route::get('/post', [PostController::class, 'index'])->name('post.index')->middleware(['role_or_permission:Listagem de Artigos|Administrador']);

Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
Route::post('/post', [PostController::class, 'store'])->name('post.store');

Route::get('/post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
Route::match(['put', 'patch'], '/post/{post}', [PostController::class, 'update'])->name('post.update');

Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');
Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
