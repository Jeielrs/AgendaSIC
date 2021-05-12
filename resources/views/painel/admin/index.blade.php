@extends('layouts.templateOne')
@section('title', 'Dashboard - AgendaSIC')
@section('content')
    @include('navbar.adminMenu')
    {{ $_SESSION['nome'] }}
    Painel Admin
@endsection
</body>
</html>