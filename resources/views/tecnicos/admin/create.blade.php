@extends('layouts.templateOne')
@section('title', 'Cadastrar Técnicos')
@section('tecnicos_ativo', 'active')
@section('content')
<?php
@session_start();
print_r($_SESSION);
if (@$_SESSION['nivel'] != 'admin') {
    echo "lugar errado";
    echo "<script>window.location='./'</script>";
}
?>
    @include('navbar.adminMenu')
    <div class="container">
        <h1>Página para cadastro dos Técnicosss</h1>
    </div>
@endsection