<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\user\DashboardController as UserDashboardController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('index');
});

Route::post('painel', [UsuarioController::class, 'login'])->name('usuarios.login');
Route::get('logout', [UsuarioController::class, 'logout'])->name('usuarios.logout');

Route::get('admin/dashboard', [AdminDashboardController::class, 'index']);
Route::get('manager/dashboard', [ManagerDashboardController::class, 'index']);
Route::get('user/dashboard', [UserDashboardController::class, 'index']);

Route::get('tecnicos', [TecnicoController::class, 'index']);
Route::get('tecnicos/edit', [TecnicoController::class, 'edit']);
Route::get('tecnicos/create', [TecnicoController::class, 'create']);


