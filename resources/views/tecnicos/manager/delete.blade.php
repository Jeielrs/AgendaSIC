@extends('layouts.templateOne')
@section('title', 'Excuir Técnicos')
@section('tecnicos_ativo', 'active')
@section('content')
    @include('navbar.managerMenu')
    <div class="container">
        <h1>Excluir Técnico</h1>
        <p>A id to técnico é <?php echo $id; ?></p>
    </div>
@endsection