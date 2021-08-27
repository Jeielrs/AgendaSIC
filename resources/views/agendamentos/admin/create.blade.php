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
                        <label class="labelform mt-2 mb-0">Cliente:</label>
                        <input type="search" name="cliente" list="cliente" placeholder="Pesquisar clientes..." class="custom-select" required>
                        <datalist id="cliente">
                            @foreach ($clientes as $cliente)
                                <option value="{{$cliente->id." - ".$cliente->nome_fantasia}}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="container" id="pergunta"> {{--serviços---}}
                        <div id="form">
                              <label class='labelform mt-2 mb-0 text-start'>Quantos serviços diferentes deseja adicionar?</label>
                            
                              <select class="form-control col-2" id="numitens">
                                @for ($i = 0; $i <= 10; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                              </select>
                              <input type="hidden" id="numeroitens" name="numitens"> <!-- p/ receber name via jquery no ajax.js-->
                        </div>
                    </div>
                    <div class="container" id="loading" style="display: none;">
                        <img src="{{URL::asset('img/loading2.gif')}}" class="rounded mx-auto d-block">
                        <h3 class="text-center">Carregando Serviços...</h3>
                    </div>
                    <div class="container" id="content"></div>
                    <script type="text/javascript">
                        $("#numitens").on('change', function(e){
                            let numitens = $(e.target).val()
                            $("#pergunta").hide();
                            console.log('fechou');
                            e.preventDefault();  //->ativado pois evita o comportamento padrão
                            $("#loading").show(); // exibe o loading na div #carregando
                            //iniciando a requisição Ajax
                            $("#numeroitens").attr('value', numitens) //atribui o value de numitens no input hidden do form
                            console.log($('#numeroitens')[0]['value']);
                            $.ajax({
                                type: 'GET',
                                url: '{{ route('agendamentos.loadservices') }}',
                                data:`numitens=${numitens}`,
                                dataType: "html"        
                            })
                            .done(function(data){
                                $("#content").html(data);
                                console.log('carregado');
                            })
                            .fail(function(data){
                                alert("Erro na requisição Ajax");
                            })
                            .always(function(){
                                $("#loading").hide();
                            });
                        });
                    </script>

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
                                <input type="text" name="protocolo" class="form-control" required>
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
                        <select name="tipo_agendamento" id="tipo_agendamento" class="form-control" required>
                            <option selected>Selecionar</option>
                            <option value="manual">Manual</option>
                            <option value="recorrente">Recorrente</option>
                        </select>
                    </div>
                    <div id="agendamento_manual" class="container" style="display: none">
                        <div class="row">
                            <div class="col-lg-4">
                                <label class="labelform mt-2 mb-0">Início:</label>
                                <input type="date" name="inicio" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label class="labelform mt-2 mb-0">Fim:</label>
                                <input type="date" name="fim" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label class="labelform mt-2 mb-0">Tempo de Serviço:</label>
                                <input type="time" name="tempo_servico" min="05:00" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div id="agendamento_recorrente" class="container" style="display: none">
                        <label class="labelform mt-2 mb-0">Selecione a recorrência:</label>
                        <br>
                        <div class="row">                                
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="segunda" value="segunda">
                                    <label class="form-check-label" for="segunda">Segunda-feira</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="quarta" value="quarta">
                                    <label class="form-check-label" for="quarta">Quarta-feira</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sexta" value="sexta">
                                    <label class="form-check-label" for="sexta">Sexta-feira</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="domingo" value="domingo">
                                    <label class="form-check-label" for="domingo">Domingo</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terca" value="terca">
                                    <label class="form-check-label" for="terca">Terça-feira</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="quinta" value="quinta">
                                    <label class="form-check-label" for="quinta">Quinta-feira</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sabado" value="sabado">
                                    <label class="form-check-label" for="sabado">Sábado</label>
                                </div>
                            </div>
                        </div>                            
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4">
                                <label class="labelform mt-2 mb-0">Início:</label>
                                <input type="date" name="inicio" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label class="labelform mt-2 mb-0">Fim:</label>
                                <input type="date" name="fim" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label class="labelform mt-2 mb-0">Tempo de Serviço:</label>
                                <input type="time" name="tempo_servico" min="05:00" class="form-control" required>
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
                            }else if (tipo == 'recorrente') {
                                $("#agendamento_recorrente").show();
                            }
                        });
                    </script>
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Padrões:</label>
                        <input type="search" name="padrao" list="padrao" placeholder="Pesquisar padrões..." class="custom-select" required>
                        <datalist id="padrao">
                            @foreach ($padroes as $padroes)
                                <option value="{{$padroes->id." - ".$padroes->tag}}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Técnicos:</label>
                        <input type="search" name="tecnico" list="tecnico" placeholder="Pesquisar técnicos..." class="custom-select" required>
                        <datalist id="tecnico">
                            @foreach ($tecnicos as $tecnico)
                                <option value="{{$tecnico->id." - ".$tecnico->name}}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">Contato:</label>
                                <input type="text" name="contato" class="form-control" required>
                            </div>
                            <div class=" col-lg-6 text-center">
                                <label class="labelform mt-2 mb-0">Veículo:</label>
                                <input type="search" name="veiculo" list="veiculo" placeholder="Pesquisar veículos..." class="custom-select" required>
                                <datalist id="veiculo">
                                    {{--@foreach ($veiculos as $veiculo)
                                        <option value="{{$veiculo->vehicle_plate." - ".$veiculo->brand. " ".$veiculo->model}}"></option>
                                    @endforeach--}}
                                </datalist>
                            </div> 
                        </div>                        
                    </div>
                </div>
            </div>
        </form>
    </div>
    
@endsection