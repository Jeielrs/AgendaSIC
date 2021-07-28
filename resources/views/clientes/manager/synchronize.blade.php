@extends('layouts.templateOne')
@section('title', 'Sincronizar Clientes')
@section('clientes_ativo', 'active')
@section('content')
    @include('navbar.managerMenu')
    <script type="text/javascript">
        $(document).ready(function(){
            // exibe o gif na div #carregando
            $("#carregando").show();

            //iniciando a requisição Ajax    
            $.ajax({
                type: 'GET',
                url: '{{ route('clientes.sync') }}',
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
              $("#goback").hide();
            });
        });
    </script>
    <div class="ml-3 mr-3">
        <div class="row color-clientes">
            <div class="col-md-6">
              <h3 class="titulo-rota mt-2">Clientes > Sincronizar</h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="/clientes" type="button" class="mt-2 mb-2 btn btn-warning" id="goback">Voltar</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="container" id="carregando" style="display: none;">
            <img src="{{URL::asset('img/cubomagico.gif')}}" class="rounded mx-auto d-block">
            <h3 class="text-center">Sincronizando Clientes...</h3>
        </div>
        <div class="container" id="log"></div>
    </div>
@endsection