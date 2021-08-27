@extends('layouts.templateOne')
@section('title', 'Painel - AgendaSIC')
@section('content')
@include('navbar.managerMenu')
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1>Painel Gerente</h1>
                <p>Usuário: {{$_SESSION['nome']}}</p>
            </div>
            <div class="col-6">
                <h1>Aprendizado Laravel</h1>
                <p>
                    - No blade, para buscar algum arquivo na public, usar o asset: <?php echo '{{URL::asset()}}'; ?>
                <br>- Para chamar uma rota no blade precisa que ela esteja renomeada e seja chamada assim: <?php echo "{{route('nome.rota')}}"; ?>
                
                </p>

                <a href="/agendar" type="button" class="mt-2 mb-2 btn btn-dark text-white" id="agendar">AGENDAR</a>
            </div>
        </div>

    </div>
@endsection
</body>
</html>