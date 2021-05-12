<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\PadraoController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\user\DashboardController as UserDashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VeiculoController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('index');
});

Route::post('painel', [UsuarioController::class, 'login'])->name('usuarios.login');
Route::get('logout', [UsuarioController::class, 'logout'])->name('usuarios.logout');

Route::get('painel', [PainelController::class, 'index']);

Route::get('tecnicos', [TecnicoController::class, 'index']);
Route::get('tecnicos/edit', [TecnicoController::class, 'edit']);
Route::get('tecnicos/create', [TecnicoController::class, 'create']);

Route::get('padroes', [PadraoController::class, 'index']);
Route::get('padroes/edit', [PadraoController::class, 'edit']);
Route::get('padroes/create', [PadraoController::class, 'create']);

Route::get('servicos', [ServicoController::class, 'index']);
Route::get('servicos/edit', [ServicoController::class, 'edit']);
Route::get('servicos/create', [ServicoController::class, 'create']);

Route::get('veiculos', [VeiculoController::class, 'index']);
Route::get('veiculos/edit', [VeiculoController::class, 'edit']);
Route::get('veiculos/create', [VeiculoController::class, 'create']);

