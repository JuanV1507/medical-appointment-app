<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Vista de gestion de usuarios
    Route::get('/admin/users', [UserController::class,'index'])
            ->name('users.index');

    Route::get('/users/create', [UserController::class,'create'])->name('users.create');

});
