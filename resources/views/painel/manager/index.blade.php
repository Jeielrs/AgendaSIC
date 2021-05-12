@extends('layouts.templateOne')
@section('title', 'Painel - AgendaSIC')
@section('content')
@include('navbar.managerMenu')
    {{ $_SESSION['nome'] }}
    Painel Gerente
@endsection
</body>
</html>