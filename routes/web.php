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

    // Módulo de Citas
    Route::get('/admin/appointments', \App\Livewire\Admin\AppointmentsManager::class)
        ->name('admin.appointments');
    
    Route::get('/admin/appointments/{appointment}/consultation', \App\Livewire\Admin\ConsultationManager::class)
        ->name('admin.appointments.consultation');

    // Doctores y Horarios (Básicos para UI)
    Route::get('/admin/doctors', \App\Livewire\Admin\DoctorsManager::class)
        ->name('admin.doctors.index');
        
    Route::get('/admin/doctors/{doctor}/schedules', \App\Livewire\Admin\SchedulesManager::class)
        ->name('admin.doctors.schedules');

});
