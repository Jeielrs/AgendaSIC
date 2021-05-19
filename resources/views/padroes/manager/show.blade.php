@extends('layouts.templateOne')
@section('title', 'Exibir Padrões')
@section('padroes_ativo', 'active')
@section('content')
    @include('navbar.managerMenu')
    <div class="container">
        <h1>Exibir Padrão</h1>
        <p>A id do padrão é <?php echo $id; ?></p>
    </div>
@endsection