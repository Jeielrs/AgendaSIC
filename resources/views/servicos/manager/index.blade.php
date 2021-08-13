@extends('layouts.templateOne')
@section('title', 'Serviços')
@section('servicos_ativo', 'active')
@section('content')
@include('navbar.managerMenu')
    <div class="ml-3 mr-3">
        <div class="row color-servicos">
            <div class="col-md-6">
                <h3 class="titulo-rota mt-2">Serviços</h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="/servicos/synchronize" type="button" class="mt-2 mb-2 btn btn-primary">Sincronizar Serviços</a>
            </div>
        </div>
    </div>
    <div class="m-3">
        <div class="table-responsive">
          <table id="user_table" class="table table-sm table-hover table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Local</th>
                    <th>Certificação</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <br />
    </div>

    {{--Modal Visualizar--}}
  <div id="showModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header modal-view">
          <h3>Serviço <span id="show_id"></span></h3>
          <button type="button" class="close" data-tt="tooltip" data-original-title="Campos vazios indicam registros ainda não cadastrados."><i class="far fa-question-circle text-white"></i></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Descrição</span>
                </div>
                <div class="pVisu">
                  <span id="show_descricao" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Local</span>
                </div>
                <div class="pVisu">
                  <span id="show_local" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Escopo</span>
                </div>
                <div class="pVisu">
                  <span id="show_escopo" class="dont-break-out"></span>
                </div>
              </div>            
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Atualizado em</span>
                </div>
                <div class="pVisu">
                  <span id="show_updated_at" class="dont-break-out"></span>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
                <div class="divVisu">
                    <div class="divLabelVisu">
                      <span class="labelVisu2">Código Omie</span>
                    </div>
                    <div class="pVisu">
                      <span id="show_codigo_servico_omie" class="dont-break-out"></span>
                    </div>
                </div>
                <div class="divVisu">
                    <div class="divLabelVisu">
                      <span class="labelVisu2">Certificação</span>
                    </div>
                    <div class="pVisu">
                      <span id="show_certificacao" class="dont-break-out"></span>
                    </div>
                </div>
                <div class="divVisu">
                    <div class="divLabelVisu">
                      <span class="labelVisu2">Status</span>
                    </div>
                    <div class="pVisu">
                      <span id="show_status" class="dont-break-out"></span>
                    </div>
                  </div>
                <div class="divVisu">
                    <div class="divLabelVisu">
                      <span class="labelVisu2">Procedimento</span>
                    </div>
                    <div class="pVisu">
                      <span id="show_procedimento" class="dont-break-out"></span>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="form-group" align="center">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function(){
      $('#user_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('servicos.index') }}",
        },
        columns: [
          {
            width: "10%",
            className: 'text-center',
            data: 'id',
            name: 'id'
          },
          {
            width: "10%",
            className: 'text-center',
            data: 'codigo_servico_omie',
            name: 'codigo_servico_omie'
          },
          {
            width: "40%",
            data: 'descricao',
            name: 'descricao'
          },
          {
            width: "10%",
            data: 'local',
            name: 'local'
          },
          {
            width: "10%",
            data: 'certificacao',
            name: 'certificacao'
          },
          {
            width: "10%",
            className: 'text-center',
            data: 'status',
            name: 'status'
          },
          {
            width: "10%",
            className: 'text-center',
            data: 'action',
            name: 'action',
            orderable: false
          }
        ],
      });

      $(document).on('click', '.show', function(){
        var id = $(this).attr('id');
        $.ajax({
          url :"servicos/"+id+"/show",
          dataType:"json",
          success:function(data)
          {                        
            $('#show_id').html(data.result.id);
            $('#show_status').html(Situationformat(data.result.status));
            $('#show_procedimento').html(data.result.procedimento);
            $('#show_certificacao').html(data.result.certificacao);
            $('#show_escopo').html(data.result.escopo);
            $('#show_local').html(data.result.local);
            $('#show_codigo_servico_omie').html(data.result.codigo_servico_omie);
            $('#show_descricao').html(data.result.descricao);
            $('#show_created_at').html(DateHourFormat(data.result.created_at));
            $('#show_updated_at').html(DateHourFormat(data.result.updated_at));
            $('#showModal').modal('show');
          }
        })
      });

    });

    //funções JS
    function Situationformat(situation){
      if (situation == 'inativo') {
          return 'Inativo';
      }else if (situation == 'ativo') {
          return 'Ativo';
      }
    }
    //function DateFormat(date) {
    //    moment.locale('pt-br');
    //    if (date !== null && date !== '') {
    //        return moment(date).format('DD/MM/YYYY');
    //    } else {
    //        return '';
    //    }            
    //}    
    function DateHourFormat(date) {
        moment.locale('pt-br');
        return moment(date).format('DD/MM/YYYY HH:mm:SS');
    }
    const capitalize = str => {
	    if (typeof str !== 'string') {
		return '';
	    }
	    return str.charAt(0).toUpperCase() + str.substr(1);
    }
  </script>
    
@endsection