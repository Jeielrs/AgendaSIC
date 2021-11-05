@extends('layouts.templateOne')
@section('title', 'Agendar')
@section('agendamentos_ativo', 'active')
@section('content')
    @include('navbar.managerMenu')
    <div class="m-3">
        <div class="row">
            <div class="col-md-6">
              <h3 class="titulo-rota">Agendamentos > Agendar</h3>
            </div>
            <div class="col-md-6 text-right">
              
            </div>
        </div>
    </div>
    <div class="m-3" id="formulario">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('agendamentos.insert')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row form-group">
                <div class="col-lg-6">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">Tipo de Serviço:</label>
                                <select name="tipo_servico" class="form-control">
                                    <option value="Calibração" selected>Calibração</option>
                                    <option value="Qualificação">Qualificação</option>
                                    <option value="Ensaio">Ensaio</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">Tipo de Contrato:</label>
                                <select name="tipo_contrato" class="form-control" required>
                                    <option selected>Selecionar</option>
                                    <option value="Lote a lote">Lote a lote</option>
                                    <option value="Fixo">Fixo</option>
                                    <option value="LAW">LAW</option>
                                    <option value="LEX">LEX</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">Compromisso:</label>
                                <select name="compromisso" class="form-control" required>
                                    <option selected>Selecionar</option>
                                    <option value="Confirmado">Confirmado</option>
                                    <option value="Ag. Confirmação">Ag. Confirmação</option>
                                    <option value="Cancelado">Cancelado</option>
                                    <option value="Empréstimo">Empréstimo</option>
                                    <option value="Férias">Férias</option>
                                    <option value="Outros">Outros</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">Integração:</label>
                                <select name="integracao" class="form-control" required>
                                    <option selected>Selecionar</option>
                                    <option value="sim">Sim</option>
                                    <option value="nao">Não</option>
                                </select>
                            </div>
                        </div>                        
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-9">
                                <label class="labelform mt-2 mb-0">Cliente:</label>
                                <input type="search" name="cliente" list="cliente" placeholder="Pesquisar clientes..." class="custom-select" required>
                                <datalist id="cliente">
                                    @foreach ($clientes as $cliente)
                                        <option value="{{$cliente->id." | ".$cliente->nome_fantasia}}"></option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-lg-3">
                                <label class="labelform mt-2 mb-0">Contato:</label>
                                <input type="text" name="contato" class="form-control">
                            </div>
                        </div>                        
                    </div>
                    
                    <div id="servicos">
                        <div class="container" id="pergunta_servicos">
                            <label class="labelform mt-2 mb-0">Serviços:</label>
                            <div id="form" class="row">
                                <div class="col-8">
                                    <label class='labelform mt-2 mb-0 text-start'>Quantos serviços diferentes deseja adicionar?</label>
                                </div>
                                <div class="col-2">
                                    <select class="form-control" id="numitens_servicos">
                                        @for ($i = 0; $i <= 10; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                    <input type="hidden" id="numeroitens_servicos" name="numitens_servicos"> <!-- p/ receber name via jquery no ajax.js-->
                                </div>
                            </div>
                        </div>
                        <div class="container" id="loading_servicos" style="display: none;">
                            <img src="{{URL::asset('img/loading2.gif')}}" class="rounded mx-auto d-block">
                        </div>
                        <div class="container" id="content_servicos"></div>
                    </div>                    
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Observação:</label>
                        <textarea name="observacao" rows="1" class="form-control" pattern="[a-zA-Z0-9]+"></textarea>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">Protocolo:</label>
                                <input type="text" name="protocolo" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">Hospedagem:</label>
                                <select name="hospedagem" class="form-control" required>
                                    <option selected>Selecionar</option>
                                    <option value="Hotel">Hotel</option>
                                    <option value="Passagem">Passagem</option>
                                    <option value="Hotel e Passagem">Hotel e Passagem</option>
                                </select>
                            </div>
                        </div>                        
                    </div>
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Tipo de Agendamento:</label>
                        <select name="tipo_agendamento" id="tipo_agendamento" class="form-control">
                            <option selected>Selecionar</option>
                            <option value="manual">Manual</option>
                            <option value="recorrente">Recorrente</option>
                        </select>
                    </div>
                    <div id="agendamento_manual" class="container" style="display: none">
                        <div class="row">
                            <div class="col-lg-4">
                                <label class="labelform mt-2 mb-0">Data:</label>
                                <input type="date" name="data" id="data" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label class="labelform mt-2 mb-0">Horário Início:</label>
                                <input type="time" name="horario_inicio_manual" id="horario_inicio_manual" min="06:00" class="form-control" >
                            </div>
                            <div class="col-lg-4">
                                <label class="labelform mt-2 mb-0">Tempo de Serviço:</label>
                                <input type="time" name="tempo_servico_manual" id="tempo_servico_manual" min="05:00" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <div id="agendamento_recorrente" class="container" style="display: none">
                        <label class="labelform mt-2 mb-0">Selecione a recorrência:</label>
                        <br>
                        <div class="row">                                
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="mon" id="segunda" value="segunda">
                                    <label class="form-check-label" for="segunda">Segunda-feira</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="thu" id="quinta" value="quinta">
                                    <label class="form-check-label" for="quinta">Quinta-feira</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sun" id="domingo" value="domingo">
                                    <label class="form-check-label" for="domingo">Domingo</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tue" id="terca" value="terca">
                                    <label class="form-check-label" for="terca">Terça-feira</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fri" id="sexta" value="sexta">
                                    <label class="form-check-label" for="sexta">Sexta-feira</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="wed" id="quarta" value="quarta">
                                    <label class="form-check-label" for="quarta">Quarta-feira</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sat" id="sabado" value="sabado">
                                    <label class="form-check-label" for="sabado">Sábado</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <label class="labelform mt-2 mb-0">Início:</label>
                                <input type="date" name="inicio_recorrente" id="inicio_recorrente" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label class="labelform mt-2 mb-0">Horario Início:</label>
                                <input type="time" name="horario_inicio_recorrente" id="horario_inicio_recorrente" min="06:00" class="form-control">
                            </div>
                        </div>
                        <div class="row">                            
                            <div class="col-lg-8">
                                <label class="labelform mt-2 mb-0">Fim:</label>
                                <input type="date" name="fim_recorrente" id="fim_recorrente" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label class="labelform mt-2 mb-0">Tempo de Serviço:</label>
                                <input type="time" name="tempo_servico_recorrente" id="tempo_servico_recorrente" min="05:00" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <script type="text/javascript">
                        $("#tipo_agendamento").on('change', function(e){
                            let tipo = $(e.target).val()
                            $("#agendamento_manual").hide();
                            $("#agendamento_recorrente").hide();
                            console.log('fechou todos');
                            console.log(tipo);
                            //e.preventDefault();
                            if (tipo == 'manual') {
                                $("#agendamento_manual").show();

                                $("#inicio_manual").attr("required", "true");
                                $("#horario_inicio_manual").attr("required", "true");
                                $("#fim_manual").attr("required", "true");
                                $("#tempo_servico_manual").attr("required", "true");

                                $("#inicio_recorrente").removeAttr("required", "true");
                                $("#horario_inicio_recorrente").removeAttr("required", "true");
                                $("#fim_recorrente").removeAttr("required", "true");
                                $("#tempo_servico_recorrente").removeAttr("required", "true");

                            }else if (tipo == 'recorrente') {
                                $("#agendamento_recorrente").show();

                                $("#inicio_recorrente").attr("required", "true");
                                $("#horario_inicio_recorrente").attr("required", "true");
                                $("#fim_recorrente").attr("required", "true");
                                $("#tempo_servico_recorrente").attr("required", "true");

                                $("#inicio_manual").removeAttr("required", "true");
                                $("#horario_inicio_manual").removeAttr("required", "true");
                                $("#fim_manual").removeAttr("required", "true");
                                $("#tempo_servico_manual").removeAttr("required", "true");
                            }
                        });
                    </script>

                    <div id="tecnicos">
                        <div class="container" id="pergunta_tecnicos">
                            <label class="labelform mt-2 mb-0">Técnicos:</label>
                            <div id="form" class="row">
                                <div class="col-8">
                                    <label class='labelform mt-2 mb-0 text-start'>Quantos técnicos diferentes deseja adicionar?</label>
                                </div>
                                <div class="col-2">
                                    <select class="form-control" id="numitens_tecnicos">
                                        @for ($i = 0; $i <= 10; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                    <input type="hidden" id="numeroitens_tecnicos" name="numitens_tecnicos"> <!-- p/ receber name via jquery no ajax.js-->
                                </div>
                            </div>
                        </div>
                        <div class="container" id="loading_tecnicos" style="display: none;">
                            <img src="{{URL::asset('img/loading2.gif')}}" class="rounded mx-auto d-block">
                        </div>
                        <div class="container" id="content_tecnicos"></div>
                    </div>
                    <div id="padroes">
                        <div class="container" id="pergunta_padroes">
                            <label class="labelform mt-2 mb-0">Padrões:</label>
                            <div id="form" class="row">
                                <div class="col-8">
                                    <label class='labelform mt-2 mb-0 text-start'>Quantos padrões diferentes deseja adicionar?</label>
                                </div>
                                <div class="col-2">
                                    <select class="form-control" id="numitens_padroes">
                                        @for ($i = 0; $i <= 10; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                    <input type="hidden" id="numeroitens_padroes" name="numitens_padroes"> <!-- p/ receber name via jquery no ajax.js-->
                                </div>
                            </div>
                        </div>
                        <div class="container" id="loading_padroes" style="display: none;">
                            <img src="{{URL::asset('img/loading2.gif')}}" class="rounded mx-auto d-block">
                        </div>
                        <div class="container" id="content_padroes"></div>
                    </div>
                    <div id="veiculos">
                        <div class="container" id="pergunta_veiculos">
                            <label class="labelform mt-2 mb-0">Veículos:</label>
                            <div id="form" class="row">
                                <div class="col-8">
                                    <label class='labelform mt-2 mb-0 text-start'>Quantos veículos diferentes deseja adicionar?</label>
                                </div>
                                <div class="col-2">
                                    <select class="form-control" id="numitens_veiculos">
                                        @for ($i = 0; $i <= 10; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                    <input type="hidden" id="numeroitens_veiculos" name="numitens_veiculos"> <!-- p/ receber name via jquery no ajax.js-->
                                </div>
                            </div>
                        </div>
                        <div class="container" id="loading_veiculos" style="display: none;">
                            <img src="{{URL::asset('img/loading2.gif')}}" class="rounded mx-auto d-block">
                        </div>
                        <div class="container" id="content_veiculos"></div>
                    </div>
                </div>
                <div class="container">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success mt-4" name="">Cadastrar</button>
                    </div>                    
                </div> 
            </div>
        </form>
    </div>
    {{----------------------------MODAL P/ MENSAGEM-----------------------------------}}
    @if(session('mensagem'))
        <div class='modal fade' id='modalmensagem' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel'>
            <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                    <div class='modal-header alert-{{ session('cor') }}'>
                        <p class='modal-title' id='exampleModalLabel'>                            
                            {{session('mensagem')}}
                        </p>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{---------------------------------FIM MODAL-------------------------------}}
    <script type="text/javascript">
        $("#numitens_servicos").on('change', function(e){
            let numitens = $(e.target).val()
            $("#pergunta_servicos").hide();
            console.log('fechou');
            e.preventDefault();  //->ativado pois evita o comportamento padrão
            $("#loading_servicos").show(); // exibe o loading na div #carregando
            //iniciando a requisição Ajax
            $("#numeroitens_servicos").attr('value', numitens) //atribui o value de numitens no input hidden do form
            console.log($('#numeroitens_servicos')[0]['value']);
            $.ajax({
                type: 'GET',
                url: '{{ route('agendamentos.loadservices') }}',
                data:`numitens=${numitens}`,
                dataType: "html"        
            })
            .done(function(data){
                $("#content_servicos").html(data);
                console.log('carregado');
            })
            .fail(function(data){
                alert("Erro na requisição Ajax");
            })
            .always(function(){
                $("#loading_servicos").hide();
            });
        });        
    </script>

    <script type="text/javascript">
        $("#numitens_padroes").on('change', function(e){
            let numitens = $(e.target).val()
            $("#pergunta_padroes").hide();
            console.log('fechou');
            e.preventDefault();  //->ativado pois evita o comportamento padrão
            $("#loading_padroes").show(); // exibe o loading na div #carregando
            //iniciando a requisição Ajax
            $("#numeroitens_padroes").attr('value', numitens) //atribui o value de numitens no input hidden do form
            console.log($('#numeroitens_padroes')[0]['value']);
            $.ajax({
                type: 'GET',
                url: '{{ route('agendamentos.loadpadroes') }}',
                data:`numitens=${numitens}`,
                dataType: "html"        
            })
            .done(function(data){
                $("#content_padroes").html(data);
                console.log('carregado');
            })
            .fail(function(data){
                alert("Erro na requisição Ajax");
            })
            .always(function(){
                $("#loading_padroes").hide();
            });
        });
    </script>

    <script type="text/javascript">
        $("#numitens_tecnicos").on('change', function(e){
            let numitens = $(e.target).val()
            $("#pergunta_tecnicos").hide();
            console.log('fechou');
            e.preventDefault();  //->ativado pois evita o comportamento padrão
            $("#loading_tecnicos").show(); // exibe o loading na div #carregando
            //iniciando a requisição Ajax
            $("#numeroitens_tecnicos").attr('value', numitens) //atribui o value de numitens no input hidden do form
            console.log($('#numeroitens_tecnicos')[0]['value']);
            $.ajax({
                type: 'GET',
                url: '{{ route('agendamentos.loadtecnicos') }}',
                data:`numitens=${numitens}`,
                dataType: "html"        
            })
            .done(function(data){
                $("#content_tecnicos").html(data);
                console.log('carregado');
            })
            .fail(function(data){
                alert("Erro na requisição Ajax");
            })
            .always(function(){
                $("#loading_tecnicos").hide();
            });
        });
    </script>

<script type="text/javascript">
    $("#numitens_veiculos").on('change', function(e){
        let numitens = $(e.target).val()
        $("#pergunta_veiculos").hide();
        console.log('fechou');
        e.preventDefault();  //->ativado pois evita o comportamento padrão
        $("#loading_veiculos").show(); // exibe o loading na div #carregando
        //iniciando a requisição Ajax
        $("#numeroitens_veiculos").attr('value', numitens) //atribui o value de numitens no input hidden do form
        console.log($('#numeroitens_veiculos')[0]['value']);
        $.ajax({
            type: 'GET',
            url: '{{ route('agendamentos.loadveiculos') }}',
            data:`numitens=${numitens}`,
            dataType: "html"        
        })
        .done(function(data){
            $("#content_veiculos").html(data);
            console.log('carregado');
        })
        .fail(function(data){
            alert("Erro na requisição Ajax");
        })
        .always(function(){
            $("#loading_veiculos").hide();
        });
    });
</script>
    
@endsection