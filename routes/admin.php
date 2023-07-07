<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'index'])->name('dashboard');
Route::resource('users', UserController::class)->except(['create', 'store']);
Route::resource('roles', RoleController::class);
Route::resource('products', ProductController::class)->except(['index', 'show']);
Route::get('products', [ProductController::class, 'admin'])->name('products.admin');
Route::resource('categories', CategoryController::class)->except(['show']);
Route::resource('pages', PageController::class)->except('show');
Route::resource('navigations', NavigationController::class)->except(['show']);
//todo Route::resource('settings', SettingController::class)->only(['index', 'update']);
