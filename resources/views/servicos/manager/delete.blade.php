@extends('layouts.templateOne')
@section('title', 'Excuir Veículo')
@section('veiculos_ativo', 'active')
@section('content')
    @include('navbar.managerMenu')
    <div class="container">
        <h1>Excluir Veículo</h1>
        <p>A id to veículo é <?php echo $id; ?></p>
    </div>
@endsection