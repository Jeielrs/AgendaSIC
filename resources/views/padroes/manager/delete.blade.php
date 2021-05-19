@extends('layouts.templateOne')
@section('title', 'Excuir Padrões')
@section('padroes_ativo', 'active')
@section('content')
    @include('navbar.managerMenu')
    <div class="container">
        <h1>Excluir Padrão</h1>
        <p>A id to padrão é <?php echo $id; ?></p>
    </div>
@endsection