@extends('layouts.templateOne')
@section('title', 'Calendário')
@section('calendario_ativo', 'active')
@section('content')
    @include('navbar.adminMenu')
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

        <div id='calendar' data-route-load-events='{{ route('routeLoadEvents') }}'>
        </div>
        

    </div>
    
    <!-- Modal Calendar-->
    <div class="modal fade" id="modalCalendar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header modal-edit">
                    <h5 class="modal-title mb-3" id="titleModal">Título do modal</h5>
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
                    <form id="form" action="{{route('agendamentos.insert')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row form-group">
                            <div class="col-lg-6">
                                <div class="container bg-light mt-2 pb-2 rounded">
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
                                <div class="container bg-light mt-2 pb-2 rounded">
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
                                <div class="container bg-light mt-2 pb-2 rounded">
                                    <label class="labelform mt-2 mb-0">Cliente:</label>
                                    <input type="text" name="cliente_atual" id="cliente_atual" style="color:rgb(5, 145, 12);outline:0;font-size:12px;width:250px;">
                                    <input type="search" name="cliente" list="cliente" placeholder="Pesquisar clientes..." class="custom-select" required>
                                    <datalist id="cliente">
                                        @foreach ($clientes as $cliente)
                                            <option value="{{$cliente->id." | ".$cliente->nome_fantasia}}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="container bg-light mt-2 pb-2 rounded">
                                    <label class="labelform mt-2 mb-0">Contato:</label>
                                    <input type="text" name="contato" class="form-control">            
                                </div>

                                <div id="servicos" class="container bg-light mt-2 pb-2 rounded">
                                    <label class="labelform mt-2 mb-0">Serviços:</label>
                                    <table class="table table-sm table-bordered table-responsive-sm table-hover" id="tabela-servicos">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="align-middle text-center dont-break">Código do Serviço</th>
                                                <th class="align-middle text-center dont-break">Quantidade</th>
                                                <th class="align-middle text-center dont-break">Excluir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div id="pergunta_servicos" class="row">
                                        <div class="col-7 text-left">
                                            <label class='label mt-2 mb-0'>Deseja incluir Serviços?</label>
                                        </div>
                                        <div class="col-4">
                                            <select class="form-control ml-16" id="numitens_servicos">
                                                @for ($i = 0; $i <= 10; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                            <input type="hidden" id="numeroitens_servicos" name="numitens_servicos"> <!-- p/ receber name via jquery no ajax.js-->
                                        </div>
                                    </div>
                                    <div class="container" id="loading_servicos" style="display: none;">
                                        <img src="{{URL::asset('img/loading2.gif')}}" class="rounded mx-auto d-block">
                                    </div>
                                    <div class="container" id="content_servicos"></div>
                                </div>                    
                                <div class="container bg-light mt-2 pb-2 rounded">
                                    <label class="labelform mt-2 mb-0">Observação:</label>
                                    <textarea name="observacao" rows="1" class="form-control" pattern="[a-zA-Z0-9]+"></textarea>
                                </div>
                            </div>
                        
                            <div class="col-lg-6">
                                <div class="container bg-light mt-2 pb-2 rounded">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="labelform mt-2 mb-0">Protocolo:</label>
                                            <input type="text" name="protocolo" class="form-control" maxlength="20">
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

                                <div class="container bg-light mt-2 pb-2 rounded">
                                    <label class="labelform mt-2 mb-0">Data:</label>
                                    <input type="date" name="data" id="data" class="form-control">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="labelform mt-2 mb-0">Horário Início:</label>
                                            <input type="text" name="horario_inicio" class="horario_inicio form-control">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="labelform mt-2 mb-0">Tempo de Serviço:</label>
                                            <input type="text" name="tempo_servico" class="tempo_servico form-control">
                                        </div>
                                    </div>
                                </div>

                                <div id="tecnicos" class="container bg-light mt-2 pb-2 rounded">
                                    <label class="labelform mt-2 mb-0">Técnicos:</label>
                                    <table class="table table-sm table-bordered table-responsive-sm table-hover" id="tabela-tecnicos">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="align-middle text-center dont-break">Técnico</th>
                                                <th class="align-middle text-center dont-break">Excluir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div id="pergunta_tecnicos" class="row">
                                        <div class="col-7 text-left">
                                            <label class='label mt-2 mb-0'>Deseja incluir Técnicos?</label>
                                        </div>
                                        <div class="col-4">
                                            <select class="form-control ml-16" id="numitens_tecnicos">
                                                @for ($i = 0; $i <= 10; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                            <input type="hidden" id="numeroitens_tecnicos" name="numitens_tecnicos"> <!-- p/ receber name via jquery no ajax.js-->
                                        </div>
                                    </div>
                                    <div class="container" id="loading_tecnicos" style="display: none;">
                                        <img src="{{URL::asset('img/loading2.gif')}}" class="rounded mx-auto d-block">
                                    </div>
                                    <div class="container" id="content_tecnicos"></div>
                                </div>
                                <div id="padroes" class="container bg-light mt-2 pb-2 rounded">
                                    <label class="labelform mt-2 mb-0">Padrões:</label>
                                    <table class="table table-sm table-bordered table-responsive-sm table-hover" id="tabela-padroes">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="align-middle text-center dont-break">Etiqueta</th>
                                                <th class="align-middle text-center dont-break">Descrição</th>
                                                <th class="align-middle text-center dont-break">Excluir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div id="pergunta_padroes" class="row">
                                        <div class="col-7 text-left">
                                            <label class='label mt-2 mb-0'>Deseja Incluir Padrões?</label>
                                        </div>
                                        <div class="col-4">
                                            <select class="form-control ml-16" id="numitens_padroes">
                                                @for ($i = 0; $i <= 10; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                            <input type="hidden" id="numeroitens_padroes" name="numitens_padroes"> <!-- p/ receber name via jquery no ajax.js-->
                                        </div>
                                    </div>
                                    <div class="container" id="loading_padroes" style="display: none;">
                                        <img src="{{URL::asset('img/loading2.gif')}}" class="rounded mx-auto d-block">
                                    </div>
                                    <div class="container" id="content_padroes"></div>
                                </div>
                                <div id="veiculos" class="container bg-light mt-2 pb-2 rounded">
                                    <label class="labelform mt-2 mb-0">Veículos:</label>
                                    <table class="table table-sm table-bordered table-responsive-sm table-hover" id="tabela-veiculos">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="align-middle text-center dont-break">Placa</th>
                                                <th class="align-middle text-center dont-break">Marca - Modelo</th>
                                                <th class="align-middle text-center dont-break">Excluir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div id="pergunta_veiculos" class="row">
                                        <div class="col-7 text-left">
                                            <label class='label mt-2 mb-0'>Deseja incluir Veículos?</label>
                                        </div>
                                        <div class="col-4">
                                            <select class="form-control ml-16" id="numitens_veiculos">
                                                @for ($i = 0; $i <= 10; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                            <input type="hidden" id="numeroitens_veiculos" name="numitens_veiculos"> <!-- p/ receber name via jquery no ajax.js-->
                                        </div>
                                    </div>
                                    <div class="container" id="loading_veiculos" style="display: none;">
                                        <img src="{{URL::asset('img/loading2.gif')}}" class="rounded mx-auto d-block">
                                    </div>
                                    <div class="container" id="content_veiculos"></div>
                                </div>
                                <input type="hidden" name="id">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnSalvar">Salvar</button>
                    <button type="button" class="btn btn-danger" id="btnExcluir">Excluir</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    {{----------------------------MODAL P/ MENSAGEM-----------------------------------}}
        <div class='modal fade' id='mensagemUpdate' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel'>
            <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                    <div class='modal-header alert-success'>
                        <p class='modal-title' id='exampleModalLabel'>                            
                            Agendamento atualizado!
                        </p>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    {{---------------------------------FIM MODAL-------------------------------}}

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
                    $("#modalCalendar").modal("show");
                    $("#modalCalendar #titleModal").text("Novo Agendamento");
                    $("#modalCalendar button.deleteEvent").css("display", "none");
                },
                eventClick: function(element) {
                    //console.log(element);
                    $("#modalCalendar").modal("show");
                    $("#modalCalendar #titleModal").text("Editar Agendamento "+element.event.id);
                    $("#modalCalendar button.deleteEvent").css("display", "flex");
                    let id = element.event.id;
                    $("#modalCalendar input[name='id']").val(id);
                    let tipo_servico = element.event.extendedProps.tipo_servico;
                    $("#modalCalendar select[name='tipo_servico']").val(tipo_servico);
                    let tipo_contrato = element.event.extendedProps.tipo_contrato;
                    $("#modalCalendar select[name='tipo_contrato']").val(tipo_contrato);
                    let compromisso = element.event.extendedProps.compromisso;
                    $("#modalCalendar select[name='compromisso']").val(compromisso);
                    let integracao = element.event.extendedProps.integracao;
                    $("#modalCalendar select[name='integracao']").val(integracao);
                    let cliente = element.event.extendedProps.cliente;
                    $("#modalCalendar input[name='cliente_atual']").val(cliente);
                    let contato = element.event.extendedProps.contato;
                    $("#modalCalendar input[name='contato']").val(contato);
                    //tabela de servicos
                        let servicos = element.event.extendedProps.array_servicos;
                        $("#tabela-servicos tr td").remove();
                        if (servicos.length === 1) {
                            const element = servicos[0];
                            $("#tabela-servicos").append("<tr class='align-middle text-center dont-break-out'><td class='align-middle text-center dont-break'>"
                                +element.codigo_servico_omie+"</td><td>"+element.qtd+"</td><td><a href='#' class='excluirServico' id='"+element.id_agendamento+"|"+element.id_servico+"'><i class='fas fa-trash-alt text-danger'></i></a></td></tr>");
                        } else if (servicos.length > 1){
                            for (let i = 0; i < servicos.length; i++) {
                                const element = servicos[i];
                                //console.log(element);
                                $("#tabela-servicos").append("<tr class='align-middle text-center dont-break-out'><td class='align-middle text-center dont-break'>"
                                +element.codigo_servico_omie+"</td><td>"+element.qtd+"</td><td><a href='#' class='excluirServico' id='"+element.id_agendamento+"|"+element.id_servico+"'><i class='fas fa-trash-alt text-danger'></i></a></td></tr>");                     
                            }
                        } else {
                            $("#tabela-servicos th").remove();
                            $("#tabela-servicos").append("<thead class='thead-dark'><tr class='align-middle text-center dont-break-out'><th class='align-middle text-center dont-break'>Nenhum registro...</th></tr></thead>");
                        }
                    //tabela de tecnicos
                        let tecnicos = element.event.extendedProps.array_tecnicos;
                        $("#tabela-tecnicos tr td").remove();                    
                        if (tecnicos.length === 1) {
                            const element = tecnicos[0];
                            $("#tabela-tecnicos").append("<tr class='align-middle text-center dont-break-out'><td class='align-middle text-center dont-break'>"
                                +element.name+"</td><td><a href='#' class='excluirTecnico' id='"+element.id_agendamento+"|"+element.id_tecnico+"'><i class='fas fa-trash-alt text-danger'></i></a></td></tr>");
                        } else if (tecnicos.length > 1){
                            for (let i = 0; i < tecnicos.length; i++) {
                                const element = tecnicos[i];
                                //console.log(element);
                                $("#tabela-tecnicos").append("<tr class='align-middle text-center dont-break-out'><td class='align-middle text-center dont-break'>"
                                +element.name+"</td><td><a href='#' class='excluirTecnico' id='"+element.id_agendamento+"|"+element.id_tecnico+"'><i class='fas fa-trash-alt text-danger'></i></a></td></tr>");                   
                            }
                        } else {
                            $("#tabela-tecnicos th").remove();
                            $("#tabela-tecnicos").append("<thead class='thead-dark'><tr class='align-middle text-center dont-break-out'><th class='align-middle text-center dont-break'>Nenhum registro...</th></tr></thead>");
                        }                   
                    //tabela de padroes
                        let padroes = element.event.extendedProps.array_padroes;
                        $("#tabela-padroes tr td").remove();
                        if (padroes.length === 1) {
                            const element = padroes[0];
                            $("#tabela-padroes").append("<tr class='align-middle text-center dont-break-out'><td class='align-middle text-center dont-break'>"
                                +element.tag+"</td><td>"+element.description+"</td><td><a href='#' class='excluirPadrao' id='"+element.id_agendamento+"|"+element.id_padrao+"'><i class='fas fa-trash-alt text-danger'></i></a></td></tr>");
                        } else if (padroes.length > 1){
                            for (let i = 0; i < padroes.length; i++) {
                                const element = padroes[i];
                                //console.log(element);
                                $("#tabela-padroes").append("<tr class='align-middle text-center dont-break-out'><td class='align-middle text-center dont-break'>"
                                +element.tag+"</td><td>"+element.description+"</td><td><a href='#' class='excluirPadrao' id='"+element.id_agendamento+"|"+element.id_padrao+"'><i class='fas fa-trash-alt text-danger'></i></a></td></tr>");                     
                            }
                        } else {
                            $("#tabela-padroes th").remove();
                            $("#tabela-padroes").append("<thead class='thead-dark'><tr class='align-middle text-center dont-break-out'><th class='align-middle text-center dont-break'>Nenhum registro...</th></tr></thead>");
                        }
                    //tabela de veiculos
                        let veiculos = element.event.extendedProps.array_veiculos;
                        $("#tabela-veiculos tr td").remove();
                        if (veiculos.length === 1) {
                            const element = veiculos[0];
                            $("#tabela-veiculos").append("<tr class='align-middle text-center dont-break-out'><td class='align-middle text-center dont-break'>"
                                +element.vehicle_plate+"</td><td>"+element.brand+" "+element.model+"</td><td><a href='#' class='excluirVeiculo' id='"+element.id_agendamento+"|"+element.id_veiculo+"'><i class='fas fa-trash-alt text-danger'></i></a></td></tr>");
                        } else if (veiculos.length > 1){
                            for (let i = 0; i < veiculos.length; i++) {
                                const element = veiculos[i];
                                //console.log(element);
                                $("#tabela-veiculos").append("<tr class='align-middle text-center dont-break-out'><td class='align-middle text-center dont-break'>"
                                +element.vehicle_plate+"</td><td>"+element.brand+" "+element.model+"</td><td><a href='#' class='excluirVeiculo' id='"+element.id_agendamento+"|"+element.id_veiculo+"'><i class='fas fa-trash-alt text-danger'></i></a></td></tr>");                     
                            }
                        } else {
                            $("#tabela-veiculos th").remove();
                            $("#tabela-veiculos").append("<thead class='thead-dark'><tr class='align-middle text-center dont-break-out'><th class='align-middle text-center dont-break'>Nenhum registro...</th></tr></thead>");
                        }
                    //
                    let observacao = element.event.extendedProps.obs;
                    $("#modalCalendar textarea[name='observacao']").val(observacao);
                    let protocolo = element.event.extendedProps.protocolo;
                    $("#modalCalendar input[name='protocolo']").val(protocolo);
                    let hospedagem = element.event.extendedProps.hospedagem;
                    $("#modalCalendar select[name='hospedagem']").val(hospedagem);
                    let start = moment(element.event.start).format("HH:mm");
                    $("#modalCalendar input[name='horario_inicio']").val(start);
                    let tempo_servico = formataHora(element.event.extendedProps.tempo_servico);
                    $("#modalCalendar input[name='tempo_servico']").val(tempo_servico);
                    let data = moment(element.event.start).format("YYYY-MM-DD");
                    $("#modalCalendar input[name='data']").val(data);
                    $("btnExcluir data-id").append(element.event.id); //atribui id do agendamento na classe do botao excluir
                },
                events: routeEvents('routeLoadEvents'),
            });
            calendar.render();

            //Salva alterações do agendamento
                $("#btnSalvar").click(function (){
                    let id = $("#modalCalendar input[name='id']").val();
                    let tipo_servico = $("#modalCalendar select[name='tipo_servico']").val();
                    let tipo_contrato = $("#modalCalendar select[name='tipo_contrato']").val();
                    let compromisso = $("#modalCalendar select[name='compromisso']").val();
                    let integracao = $("#modalCalendar select[name='integracao']").val();
                    let cliente = $("#modalCalendar input[name='cliente']").val();
                    let contato = $("#modalCalendar input[name='contato']").val();
                    let numitens_servicos = $("#modalCalendar select[id='numitens_servicos']").val();
                    let servicos = {};
                    servicos.id_servico = [];
                    servicos.qtd = [];
                    for (let i = 0; i < numitens_servicos; i++) {
                        servicos.id_servico[i] = $("#modalCalendar input[name='servico["+i+"]']").val();
                        servicos.qtd[i] = $("#modalCalendar input[name='servico_qtd["+i+"]']").val();
                    }
                    let observacao = $("#modalCalendar textarea[name='observacao']").val();
                    let protocolo = $("#modalCalendar input[name='protocolo']").val();
                    let hospedagem = $("#modalCalendar select[name='hospedagem']").val();
                    let data = $("#modalCalendar input[name='data']").val();
                    let horario_inicio = $("#modalCalendar input[name='horario_inicio']").val();
                    let tempo_servico = $("#modalCalendar input[name='tempo_servico']").val();
                    let numitens_tecnicos = $("#modalCalendar select[id='numitens_tecnicos']").val();
                    let tecnicos = {};
                    tecnicos.id_tecnico = [];
                    for (let i = 0; i < numitens_tecnicos; i++) {
                        tecnicos.id_tecnico[i] = $("#modalCalendar input[name='tecnico["+i+"]']").val();
                    }
                    let numitens_padroes = $("#modalCalendar select[id='numitens_padroes']").val();
                    let padroes = {};
                    padroes.id_padrao = [];
                    for (let i = 0; i < numitens_padroes; i++) {
                        padroes.id_padrao[i] = $("#modalCalendar input[name='padrao["+i+"]']").val();
                    }
                    let numitens_veiculos = $("#modalCalendar select[id='numitens_veiculos']").val();
                    let veiculos = {};
                    veiculos.id_veiculo = [];
                    for (let i = 0; i < numitens_veiculos; i++) {
                        veiculos.id_veiculo[i] = $("#modalCalendar input[name='veiculo["+i+"]']").val();
                    }
                    let Event = {
                        id: id,
                        tipo_servico: tipo_servico,
                        tipo_contrato: tipo_contrato,
                        compromisso: compromisso,
                        integracao: integracao,
                        cliente: cliente,
                        contato: contato,
                        servicos: servicos,
                        observacao: observacao,
                        protocolo: protocolo,
                        hospedagem: hospedagem,
                        data: data,
                        horario_inicio: horario_inicio,
                        tempo_servico: tempo_servico,
                        tecnicos: tecnicos,
                        padroes: padroes,
                        veiculos: veiculos,
                    };
                    console.log(Event);
                    $.ajax({
                        url:"{{ route('agendamentos.update') }}",
                        method: 'POST',
                        data: Event,
                        success: function(response){
                            $(document).ready(function() {
                                $('#mensagemUpdate').modal('show');
                            });
                            location.reload();
                        },
                        error: function(response){
                            alert("Erro na requisição Ajax");
                        }
                    });                       

                });
            //Exclui agendamento
                document.getElementById("btnExcluir").addEventListener("click", function(){
                    const id = $(this).attr('class');
                    console.log(id);
                });
            //exclui servico do agendamento
                $(document).on('click', '.excluirServico', function(){
                    codigos = $(this).attr('id');
                    $.ajax({
                        url:"calendario/excluirServico/"+codigos,
                        success:function(data)
                        {
                            setTimeout(function(){
                              alert('Registro excluído!');
                            }, 0);
                        }
                    })
                    var self = $(this);
                    var linha = self.closest("tr");
                    linha.remove();
                    return false;;

                });
            //exclui tecnico do agendamento
                $(document).on('click', '.excluirTecnico', function(){
                    codigos = $(this).attr('id');
                    $.ajax({
                        url:"calendario/excluirTecnico/"+codigos,
                        beforeSend:function(){
                            $('#ok_button').text('Excluindo...');
                        },
                        success:function(data)
                        {
                            setTimeout(function(){
                              alert('Registro excluído!');
                            }, 0);
                        }
                    })
                    var self = $(this);
                    var linha = self.closest("tr");
                    linha.remove();
                    return false;;

                });
            //exclui padrao do agendamento
                $(document).on('click', '.excluirPadrao', function(){
                    codigos = $(this).attr('id');
                    $.ajax({
                        url:"calendario/excluirPadrao/"+codigos,
                        beforeSend:function(){
                            $('#ok_button').text('Excluindo...');
                        },
                        success:function(data)
                        {
                            setTimeout(function(){
                              alert('Registro excluído!');
                            }, 0);
                        }
                    })
                    var self = $(this);
                    var linha = self.closest("tr");
                    linha.remove();
                    return false;;

                });
            //exclui veiculo do agendamento
                $(document).on('click', '.excluirVeiculo', function(){
                    codigos = $(this).attr('id');
                    $.ajax({
                        url:"calendario/excluirVeiculo/"+codigos,
                        beforeSend:function(){
                            $('#ok_button').text('Excluindo...');
                        },
                        success:function(data)
                        {
                            setTimeout(function(){
                              alert('Registro excluído!');
                            }, 0);
                        }
                    })
                    var self = $(this);
                    var linha = self.closest("tr");
                    linha.remove();
                    return false;;

                });
            //
            //carrega servicos
                $("#numitens_servicos").on('change', function(e){
                    let numitens = $(e.target).val()
                    $("#pergunta_servicos").hide();
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
            //carrega padroes
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
            //carrega tecnicos
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
            //carrega veiculos
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
            //
            //Atualiza a página pai ao fechar ou clicar fora do modal
                //$('#modalCalendar').on('hidden.bs.modal', function () {  
                //    location.reload();  
                //});
            //
            //Formata os campos de hora
                    $('.horario_inicio').mask('00:00',  {reverse: true});
                    $('.tempo_servico').mask('00:00',  {reverse: true});
                    function formataHora(str){
                        hora = str.substring(0, str.length - 3);
                        return hora
                    }
            //
            //reseta o modal ao ser fechado, clicado fora
            $("#modalCalendar").on("hidden.bs.modal", function(){
                $('#form').each (function(){
                    this.reset();
                });
                $('#linha').remove();
            });
            
        });

        
    </script> 

@endsection
