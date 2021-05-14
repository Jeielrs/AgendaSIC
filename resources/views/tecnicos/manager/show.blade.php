@extends('layouts.templateOne')
@section('title', 'Editar Técnicos')
@section('tecnicos_ativo', 'active')
@section('content')
    @include('navbar.managerMenu')
    <div class="container">
        <h1>Editar Técnicos</h1>
        <p>A id to técnico é <?php echo $id; ?></p>
    </div>
@endsection