<?php

use App\Http\Controllers\Admin\AttachPermissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DetachPermissionController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DeleteImageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UploadImagesController;
use App\Http\Controllers\ProfileController;
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


Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::resource('roles', RolesController::class);
    Route::post('roles/attach-permission', AttachPermissionController::class)->name('roles.attach-permission');
    Route::post('roles/detach-permission', DetachPermissionController::class)->name('roles.detach-permission');

    Route::resource('permissions', PermissionsController::class);
    Route::resource('users', UsersController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::post('upload-images', UploadImagesController::class)->name('images.upload');
    Route::post('delete-images', DeleteImageController::class)->name('images.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
