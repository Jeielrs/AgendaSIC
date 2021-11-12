@extends('layouts.templateOne')
@section('title', 'Calendário')
@section('calendario_ativo', 'active')
@section('content')
    @include('navbar.managerMenu')
    <div class="ml-3 mr-3">
      <div class="row color-calendario">
        <div class="col-md-6">
          <h3 class="titulo-rota mt-2">Calendário</h3>
        </div>
        <div class="col-md-6 text-right">
            <a href="/agendamentos/create" type="button" class="mb-2 mt-2 btn btn-primary">Novo Agendamento</a>
        </div>
      </div>
    </div>
    <div class="m-3">

        <div id='calendar' data-route-load-events='{{ route('routeLoadEvents') }}'></div>
        

    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="evento" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Agendamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                                    <label class="labelform mt-2 mb-0">Cliente:</label>
                                    <input type="search" name="cliente" list="cliente" placeholder="Pesquisar clientes..." class="custom-select" required>
                                    <datalist id="cliente">
                                        @foreach ($clientes as $cliente)
                                            <option value="{{$cliente->id." | ".$cliente->nome_fantasia}}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="container">
                                    <label class="labelform mt-2 mb-0">Contato:</label>
                                    <input type="text" name="contato" class="form-control">            
                                </div>

                                <div id="servicos">
                                    <div class="container" id="pergunta_servicos">
                                        <label class="labelform mt-2 mb-0">Serviços:</label>
                                        <div id="form" class="row">
                                            <div class="col-9">
                                                <label class='labelform mt-2 mb-0 text-start'>Quantos serviços diferentes deseja adicionar?</label>
                                            </div>
                                            <div class="col-3">
                                                <select class="form-control ml-16" id="numitens_servicos">
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
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="labelform mt-2 mb-0">Horário Início:</label>
                                            <input type="time" name="horario_inicio_manual" id="horario_inicio_manual" min="06:00" class="form-control" >
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="labelform mt-2 mb-0">Tempo de Serviço:</label>
                                            <input type="time" name="tempo_servico_manual" id="tempo_servico_manual" min="05:00" class="form-control" >
                                        </div>
                                    </div>
                                </div>

                                <div id="tecnicos">
                                    <div class="container" id="pergunta_tecnicos">
                                        <label class="labelform mt-2 mb-0">Técnicos:</label>
                                        <div id="form" class="row">
                                            <div class="col-9">
                                                <label class='labelform mt-2 mb-0 text-start'>Quantos técnicos diferentes deseja adicionar?</label>
                                            </div>
                                            <div class="col-3">
                                                <select class="form-control ml-16" id="numitens_tecnicos">
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
                                            <div class="col-9">
                                                <label class='labelform mt-2 mb-0 text-start'>Quantos padrões diferentes deseja adicionar?</label>
                                            </div>
                                            <div class="col-3">
                                                <select class="form-control ml-16" id="numitens_padroes">
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
                                            <div class="col-9">
                                                <label class='labelform mt-2 mb-0 text-start'>Quantos veículos diferentes deseja adicionar?</label>
                                            </div>
                                            <div class="col-3">
                                                <select class="form-control ml-16" id="numitens_veiculos">
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
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnSalvar">Salvar</button>
                    <button type="button" class="btn btn-warning" id="btnEditar">Editar</button>
                    <button type="button" class="btn btn-danger" id="btnExcluir">Excluir</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            let formulario = document.querySelector("form");
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                navLinks: true, //faz o dia ficar selecionavel e redirecionando dara o botão dias
                dayMaxEvents: true, //define um limite de eventos por dia
                selectable: false, //pode selecionar varios dias
                headerToolbar: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },

                dateClick: function(){
                    $("#evento").modal("show");
                },
                eventDrop: function(event) {
                    alert('event drop');
                },
                eventClick: function(event) {
                    alert('event click');
                },
                eventResize: function(event) {
                    alert('event resize');
                },
                events: routeEvents('routeLoadEvents'),
            });
            calendar.render();

            document.getElementById("btnSalvar").addEventListener("click", function(){
                const dados = new FormData(formulario);
                console.log(dados);
                console.log(formulario.cliente.value);
            });
        });

        
    </script> 

@endsection
