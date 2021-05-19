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

Route::get('tecnicos', [TecnicoController::class, 'index'])->name('tecnicos');
Route::get('tecnicos/edit', [TecnicoController::class, 'edit']);
Route::get('tecnicos/create', [TecnicoController::class, 'create']);
Route::post('tecnicos', [TecnicoController::class, 'insert'])->name('tecnicos.insert');
//Route::get('tecnicos/{id}/{valor}', [TecnicoController::class, 'show'])->name('tecnicos.show');
Route::get('tecnicos/show/{id}', [TecnicoController::class, 'show'])->name('tecnicos.show');
Route::get('tecnicos/edit/{id}', [TecnicoController::class, 'edit'])->name('tecnicos.edit');
Route::get('tecnicos/delete/{id}', [TecnicoController::class, 'delete'])->name('tecnicos.delete');
//Route::get('tecnicos/edit', [TecnicoController::class, 'edit'])->name('tecnicos.edit');
//Route::get('tecnicos/delete', [TecnicoController::class, 'delete'])->name('tecnicos.delete');

Route::get('padroes', [PadraoController::class, 'index'])->name('padroes');
Route::get('padroes/create', [PadraoController::class, 'create']);
Route::post('padroes', [PadraoController::class, 'insert'])->name('padroes.insert');
Route::get('padroes/show/{id}', [PadraoController::class, 'show'])->name('padroes.show');
Route::get('padroes/edit/{id}', [PadraoController::class, 'edit'])->name('padroes.edit');
Route::get('padroes/delete/{id}', [PadraoController::class, 'delete'])->name('padroes.delete');

Route::get('servicos', [ServicoController::class, 'index']);
Route::get('servicos/create', [ServicoController::class, 'create']);
Route::post('servicos', [ServicoController::class, 'insert'])->name('servicos.insert');
Route::get('servicos/show/{id}', [ServicoController::class, 'show'])->name('servicos.show');
Route::get('servicos/edit/{id}', [ServicoController::class, 'edit'])->name('servicos.edit');
Route::get('servicos/delete/{id}', [ServicoController::class, 'delete'])->name('servicos.delete');

Route::get('veiculos', [VeiculoController::class, 'index']);
Route::get('veiculos/create', [VeiculoController::class, 'create']);
Route::post('veiculos', [VeiculoController::class, 'insert'])->name('veiculos.insert');
Route::get('veiculos/show/{id}', [VeiculoController::class, 'show'])->name('veiculos.show');
Route::get('veiculos/edit/{id}', [VeiculoController::class, 'edit'])->name('veiculos.edit');
Route::get('veiculos/delete/{id}', [VeiculoController::class, 'delete'])->name('veiculos.delete');

