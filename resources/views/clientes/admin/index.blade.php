@extends('layouts.templateOne')
@section('title', 'Clientes')
@section('clientes_ativo', 'active')
@section('content')
  @include('navbar.adminMenu')
  <div class="ml-3 mr-3">
    <div class="row color-clientes">
      <div class="col-md-6">
        <h3 class="titulo-rota mt-2">Clientes</h3>
      </div>
      <div class="col-md-6 text-right">
          <a href="/clientes/synchronize" type="button" class="mt-2 mb-2 btn btn-primary">Sincronizar Clientes</a>
      </div>
    </div>
  </div>
  <div class="m-3">
    <div class="table-responsive">
      <table id="user_table" class="table table-sm table-hover table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Razão Social</th>
                <th>CNPJ / CPF</th>
                <th>E-mail</th>
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
          <h3>Cliente <span id="show_id"></span></h3>
          <button type="button" class="close" data-tt="tooltip" data-original-title="Campos vazios indicam registros ainda não cadastrados."><i class="far fa-question-circle text-white"></i></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Razão Social</span>
                </div>
                <div class="pVisu">
                  <span id="show_razao_social" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Código Omie</span>
                </div>
                <div class="pVisu">
                  <span id="show_codigo_cliente_omie" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Segmento</span>
                </div>
                <div class="pVisu">
                  <span id="show_segmento" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Nome Fantasia</span>
                </div>
                <div class="pVisu">
                  <span id="show_nome_fantasia" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Cidade</span>
                </div>
                <div class="pVisu">
                  <span id="show_cidade" class="dont-break-out"></span>
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
                  <span class="labelVisu2">Criado em</span>
                </div>
                <div class="pVisu">
                  <span id="show_created_at" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Observação</span>
                </div>
                <div class="pVisu">
                  <span id="show_observacao" class="dont-break-out"></span>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">CNPJ / CPF</span>
                </div>
                <div class="pVisu">
                  <span id="show_cnpj_cpf" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">E-mail</span>
                </div>
                <div class="pVisu">
                  <span id="show_email" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Telefone</span>
                </div>
                <div class="pVisu">
                  <span id="show_telefone" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Endereço</span>
                </div>
                <div class="pVisu">
                  <span id="show_endereco" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Estado</span>
                </div>
                <div class="pVisu">
                  <span id="show_estado" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">CEP</span>
                </div>
                <div class="pVisu">
                  <span id="show_cep" class="dont-break-out"></span>
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
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Pessoa Física?</span>
                </div>
                <div class="pVisu">
                  <span id="show_pessoa_fisica" class="dont-break-out"></span>
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
            url: "{{ route('clientes.index') }}",
        },
        columns: [
          {
            width: "5%",
            className: 'text-center',
            data: 'id',
            name: 'id'
          },
          {
            width: "25%",
            className: 'text-center',
            data: 'razao_social',
            name: 'razao_social'
          },
          {
            width: "25%",
            data: 'cnpj_cpf',
            name: 'cnpj_cpf'
          },
          {
            width: "25%",
            data: 'email',
            name: 'email'
          },
          {
            width: "10%",
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
          url :"clientes/"+id+"/show",
          dataType:"json",
          success:function(data)
          {                        
            $('#show_id').html(data.result.id);
            $('#show_status').html(Situationformat(data.result.status));
            $('#show_segmento').html(data.result.segmento);
            $('#show_codigo_cliente_omie').html(data.result.codigo_cliente_omie);
            $('#show_razao_social').html(data.result.razao_social);
            $('#show_cnpj_cpf').html(data.result.cnpj_cpf);
            $('#show_nome_fantasia').html(data.result.nome_fantasia);
            $('#show_telefone').html(data.result.telefone);
            $('#show_endereco').html(data.result.endereco);
            $('#show_estado').html(data.result.estado);
            $('#show_cidade').html(data.result.cidade);
            $('#show_cep').html(data.result.cep);
            $('#show_email').html(data.result.email);
            $('#show_observacao').html(data.result.observacao);
            $('#show_pessoa_fisica').html(Pessoa_fisica(data.result.pessoa_fisica));
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
    function Pessoa_fisica(pf){
      if (pf == 'S') {
          return 'Sim';
      }else if (pf == 'N') {
          return 'Não';
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