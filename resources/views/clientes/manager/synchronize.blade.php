@extends('layouts.templateOne')
@section('title', 'Sincronizar Clientes')
@section('clientes_ativo', 'active')
@section('content')
    @include('navbar.managerMenu')
    <div class="m-2">
        <div class="row">
            <div class="col-md-6">
              <h3 class="titulo-rota">Clientes > Sincronizar</h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="/clientes" type="button" class="mt-2 mb-2 btn btn-primary">Voltar</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="container" id="loading">

        </div>
        <div class="container" id="log">

        </div>
    </div>
@endsection