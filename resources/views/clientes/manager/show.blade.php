@extends('layouts.templateOne')
@section('title', 'Exibir Veículo')
@section('veiculos_ativo', 'active')
@section('content')
    @include('navbar.managerMenu')
    <div class="container">
        <h1>Exibir Veículo</h1>
        <p>A id do veículo é <?php echo $id; ?></p>
    </div>
@endsection