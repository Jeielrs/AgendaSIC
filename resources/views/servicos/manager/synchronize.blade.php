@extends('layouts.templateOne')
@section('title', 'Sincronizar Serviços')
@section('servicos_ativo', 'active')
@section('content')
    @include('navbar.managerMenu')
    <script type="text/javascript">
        $(document).ready(function(){
            // exibe o gif na div #carregando
            $("#carregando").show();
            //esconde o botão voltar
            $("#goback").hide();

            //iniciando a requisição Ajax    
            $.ajax({
                type: 'GET',
                url: '{{ route('servicos.sync') }}',
                dataType: "html"       
            })
            .done(function(data){
            
                $("#log").html(data);
                console.log('carregado');
            })
            .fail(function(data){
                alert("Erro na requisição Ajax");
            })
            .always(function(){
              $("#carregando").hide();
              $("#goback").show();
            });
        });
    </script>
    <div class="ml-3 mr-3">
        <div class="row color-servicos">
            <div class="col-md-6">
              <h3 class="titulo-rota mt-2">Serviços > Sincronizar</h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="/servicos" type="button" class="mt-2 mb-2 btn btn-dark text-white" id="goback">Voltar</a>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="container" id="carregando" style="display: none;">
            <h3 class="text-center">Sincronizando Serviços</h3>
            <br>
            <img src="{{URL::asset('img/cubomagico.gif')}}" class="rounded mx-auto d-block">
            <div class="container-progress-bar">
                <div class="progress-bar-servicos"></div>
            </div>
            <br>
            <p class="text-center text-danger">Por favor, aguarde a barra de progresso chegar ao fim para sair dessa página!</p>
        </div>
        <div class="container" id="log"></div>
    </div>
@endsection