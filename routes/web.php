<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PadraoController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\user\DashboardController as UserDashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VeiculoController;
use App\Models\Cliente;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('index');
});

Route::post('painel', [UsuarioController::class, 'login'])->name('usuarios.login');
Route::get('logout', [UsuarioController::class, 'logout'])->name('usuarios.logout');

Route::get('painel', [PainelController::class, 'index']);

Route::resource('tecnicos', TecnicoController::class);
Route::get('tecnicos', [TecnicoController::class, 'index'])->name('tecnicos.index');
Route::get('tecnicos/{id}/show', [TecnicoController::class, 'show']);
Route::get('tecnicos/create', [TecnicoController::class, 'create']);
Route::post('tecnicos/create', [TecnicoController::class, 'insert'])->name('tecnicos.insert');
Route::post('tecnicos/update', [TecnicoController::class, 'update'])->name('tecnicos.update');
Route::get('tecnicos/destroy/{id}', [TecnicoController::class, 'destroy']);

Route::resource('padroes', PadraoController::class);
Route::get('padroes', [PadraoController::class, 'index'])->name('padroes.index');
Route::get('padroes/{id}/show', [PadraoController::class, 'show']);
Route::get('padroes/create', [PadraoController::class, 'create']);
Route::post('padroes/create', [PadraoController::class, 'insert'])->name('padroes.insert');
Route::post('padroes/update', [PadraoController::class, 'update'])->name('padroes.update');
Route::get('padroes/destroy/{id}', [PadraoController::class, 'destroy']);

Route::get('servicos', [ServicoController::class, 'index'])->name('servicos.index');
Route::get('servicos/{id}/show', [ServicoController::class, 'show']);
Route::get('servicos/synchronize', [ServicoController::class, 'synchronize']);
Route::get('servicos/sync', [ServicoController::class, 'sync'])->name('servicos.sync');
Route::resource('servicos', ServicoController::class);

Route::resource('veiculos', VeiculoController::class);
Route::get('veiculos', [VeiculoController::class, 'index'])->name('veiculos.index');
Route::get('veiculos/{id}/show', [VeiculoController::class, 'show']);
Route::get('veiculos/create', [VeiculoController::class, 'create']);
Route::post('veiculos/create', [VeiculoController::class, 'insert'])->name('veiculos.insert');
Route::post('veiculos/update', [VeiculoController::class, 'update'])->name('veiculos.update');
Route::get('veiculos/destroy/{id}', [VeiculoController::class, 'destroy']);

Route::get('clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::get('clientes/{id}/show', [ClienteController::class, 'show']);
Route::get('clientes/synchronize', [ClienteController::class, 'synchronize']);
Route::get('clientes/sync', [ClienteController::class, 'sync'])->name('clientes.sync');
Route::resource('clientes', ClienteController::class);

