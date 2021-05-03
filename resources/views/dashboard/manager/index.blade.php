@extends('layouts.templateOne')
@section('title', 'Dashboard - AgendaSIC')
@section('content')
@include('navbar.managerMenu')
    {{ $_SESSION['nome'] }}
@endsection
</body>
</html>