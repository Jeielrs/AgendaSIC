@extends('layouts.templateOne')
@section('title', 'Padrões')
@section('padroes_ativo', 'active')
@section('content')
  @include('navbar.managerMenu')
  <div class="ml-3 mr-3">
    <div class="row color-padroes">
      <div class="col-md-6">
        <h3 class="titulo-rota mt-2">Padrões</h3>
      </div>
      <div class="col-md-6 text-right">
          <a href="/padroes/create" type="button" class="mb-2 mt-2 btn btn-primary btn-inserir">Cadastrar Padrão</a>
      </div>
    </div>
  </div>
  <div class="m-3">
    <div class="table-responsive">
        <table id="user_table" class="table table-sm table-hover table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TAG</th>
                    <th>Descrição</th>
                    <th>Particularidade</th>
                    <th>Setor</th>
                    <th>Validade Calibração</th>
                    <th>Situação</th>
                    <th>Ações</th>
                </tr>
            </thead>
        </table>
    </div>
    <br />
  </div>
  {{--Modal Edit--}}        
  <div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header modal-edit">
          <h3>Editar Padrão <span id="edit_id"></span></h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" id="edit_form" enctype="multipart/form-data" class="form-horizontal">
            @csrf
            <div class="row form-group">
              <div class="col-lg-6">
                <div class="container">
                  <label class="labelform mt-2 mb-0">TAG:</label>
                  <input type="text" name="tag" id="edit_tag" class="form-control" required>
                </div>
                <div class="container">
                  <label class="labelform mt-2 mb-0">Setor:</label>
                  <select name="sector" id="edit_sector" class="form-control" required>
                    <option selected>Escolher</option>
                    <option value="LIN">LIN</option>
                    <option value="SIC/LAW">SIC/LAW</option>
                    <option value="LEX">LEX</option>
                  </select>
                </div>
                <div class="container">
                  <label class="labelform mt-2 mb-0">Freq. Calibração:</label>
                  <div class="row">
                    <div class="col-7">
                      <input type="number" min="1" name="calibration_frequency"  id="edit_calibration_frequency" class="form-control" required>
                    </div>
                    <div class="col-3">
                      <p class="mt-2" style="margin-right: 8px;">Meses</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3">                   
                <div class="container">
                  <label class="labelform mt-2 mb-0">Data da Calibração:</label>
                  <input type="date" name="calibration_date" id="edit_calibration_date" class="form-control" required>
                </div>
                <div class="container">
                  <label class="labelform mt-2 mb-0">Validade da Calibração:</label>
                  <input type="date" name="calibration_validity" id="edit_calibration_validity" class="form-control" required>
                </div>
                <div class="container">
                  <label class="labelform mt-2 mb-0">Situação:</label>
                  <select name="situation" id="edit_situation" class="form-control" required>
                    <option selected>Escolher</option>
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                    <option value="manutencao">Em manutenção</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-7">
                <div class="container">
                  <label class="labelform mt-2 mb-0">Descrição:</label>
                  <textarea class="form-control" name="description" id="edit_description" rows="1" pattern="[a-zA-Z0-9]+" required></textarea>
                </div>
                <div class="container">
                  <label class="labelform mt-2 mb-0">Particularidade:</label>
                  <textarea class="form-control" name="particularity" id="edit_particularity" rows="1" pattern="[a-zA-Z0-9]+"></textarea>
                </div>
                <div class="container">
                  <label class="labelform mt-2 mb-0">Observação:</label>
                  <textarea class="form-control" name="obs" id="edit_obs" rows="1" pattern="[a-zA-Z0-9]+"></textarea>
                </div>
              </div>
              <br />
              <span class="text-center" id="form_result"></span>
              <div class="form-group" align="center">
                <input type="hidden" name="action" id="action" value="Add" />
                <input type="hidden" name="hidden_id" id="hidden_id" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <input type="submit" name="action_button" id="action_button" class="btn btn-warning text-white" value="Confirmar Edições" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{--Modal Visualizar--}}
  <div id="showModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header modal-view">
          <h3>Padrão <span id="show_id"></span></h3>
          <button type="button" class="close" data-tt="tooltip" data-original-title="Campos vazios indicam registros ainda não cadastrados."><i class="far fa-question-circle text-white"></i></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">TAG</span>
                </div>
                <div class="pVisu">
                  <span id="show_tag" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Descrição</span>
                </div>
                <div class="pVisu">
                  <span id="show_description" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Setor</span>
                </div>
                <div class="pVisu">
                  <span id="show_sector" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Particularidade</span>
                </div>
                <div class="pVisu">
                  <span id="show_particularity" class="dont-break-out"></span>
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
            </div>
            <div class="col-lg-6">
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Situação</span>
                </div>
                <div class="pVisu">
                  <span id="show_situation" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Frequencia de Calibração</span>
                </div>
                <div class="pVisu">
                  <span id="show_calibration_frequency" class="dont-break-out"></span>meses
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Data da Calibração</span>
                </div>
                <div class="pVisu">
                  <span id="show_calibration_date" class="dont-break-out"></span>
                </div>
              </div>
              <div class="divVisu">
                <div class="divLabelVisu">
                  <span class="labelVisu2">Validade da Calibração</span>
                </div>
                <div class="pVisu">
                  <span id="show_calibration_validity" class="dont-break-out"></span>
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
          </div>
          <div class="divVisu">
            <div class="divLabelVisu">
              <span class="labelVisu2">Observação</span>
            </div>
            <div class="pVisu">
              <span id="show_obs" class="dont-break-out"></span>
            </div>
          </div>
        </div>
        <div class="form-group" align="center">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  {{--Modal delete/excluir--}}
  <div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header modal-delete">
          <h3>Confirmação</h3>
          <button type="button" class="close" data-tt="tooltip" data-original-title="Essa Ação é irreversível!"><i class="far fa-question-circle text-white"></i></button>
        </div>
        <div class="modal-body">
          <h3>Você tem certeza que deseja excluir esse registro?</h3>
        </div>
        <div class="form-group" align="center">
          <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Desistir</button>
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
            url: "{{ route('padroes.index') }}",
        },
        columns: [
          {
            width: "5%",
            className: 'text-center',
            data: 'id',
            name: 'id'
          },
          {
            width: "10%",
            className: 'text-center',
            data: 'tag',
            name: 'tag'
          },
          {
            width: "25%",
            data: 'description',
            name: 'description'
          },
          {
            width: "18%",
            data: 'particularity',
            name: 'particularity'
          },
          {
            width: "10%",
            data: 'sector',
            name: 'sector'
          },
          {
            width: "10%",
            data: 'calibration_validity',
            name: 'calibration_validity'
          },
          {
            width: "8%",
            data: 'situation',
            name: 'situation'
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

      $('#edit_form').on('submit', function(event){
        console.log('ola');
        event.preventDefault();
        var action_url = ''
        if($('#action').val() == 'Edit')
        {
         action_url = "{{ route('padroes.update') }}";
        }
        $.ajax({
          url: action_url,
          method:"POST",
          data:$(this).serialize(),
          dataType:"json",
          success:function(data)
          {
            console.log('ola2');
            var html = '';
            if(data.errors)
            {
                html = '<div class="alert alert-danger">';
                for(var count = 0; count < data.errors.length; count++)
                {
                    html += '<p>' + data.errors[count] + '</p>';
                }
                html += '</div>';
            }
            if(data.success)
            {
              console.log(data);
                html = '<div class="alert alert-success">' + data.success + '</div>';
                $('#edit_form')[0].reset();
                $('#user_table').DataTable().ajax.reload();
            }
            $('#form_result').html(html);
          }
        })
      });

      //Exibe as informações nos campos no modal edit
      $(document).on('click', '.edit', function(){
        var id = $(this).attr('id');
        $.ajax({
          url :"padroes/"+id+"/edit",
          dataType:"json",
          success:function(data)
          {
            $('#edit_id').html(data.result.id)
            $('#edit_tag').val(data.result.tag);
            $('#edit_description').val(data.result.description);
            $('#edit_sector').val(data.result.sector);
            $('#edit_particularity').val(data.result.particularity);
            $('#edit_calibration_frequency').val(data.result.calibration_frequency);
            $('#edit_calibration_date').val(data.result.calibration_date);
            $('#edit_calibration_validity').val(data.result.calibration_validity);  
            $('#edit_situation').val(data.result.situation);          
            $('#edit_obs').val(data.result.obs);            
            $('#hidden_id').val(id);
            //$('.modal-title').text('Edit Record');
            //$('#action_button').val('Edit');
            $('#action').val('Edit');
            $('#editModal').modal('show');
          }
        })
      });

      $(document).on('click', '.show', function(){
        var id = $(this).attr('id');
        //$('#form_result').html('');
        $.ajax({
          url :"padroes/"+id+"/show",
          dataType:"json",
          success:function(data)
          {                        
            $('#show_id').html(data.result.id);
            $('#show_tag').html(data.result.tag);
            $('#show_description').html(capitalize(data.result.description));
            $('#show_sector').html(data.result.sector);
            $('#show_particularity').html(capitalize(data.result.particularity));
            $('#show_calibration_frequency').html(data.result.calibration_frequency);
            $('#show_calibration_date').html(DateFormat(data.result.calibration_date));
            $('#show_calibration_validity').html(DateFormat(data.result.calibration_validity));
            $('#show_situation').html(Situationformat(data.result.situation));
            $('#show_obs').html(data.result.obs);
            $('#show_created_at').html(DateHourFormat(data.result.created_at));
            $('#show_updated_at').html(DateHourFormat(data.result.updated_at));
            $('#showModal').modal('show');
          }
        })
      });

      var user_id;
   
      $(document).on('click', '.delete', function(){
        user_id = $(this).attr('id');
        $('#deleteModal').modal('show');
      });

      $('#ok_button').click(function(){
        $.ajax({
          url:"padroes/destroy/"+user_id,
          beforeSend:function(){
              $('#ok_button').text('Excluindo...');
          },
          success:function(data)
          {
            setTimeout(function(){
              $('#deleteModal').modal('hide');
              $('#user_table').DataTable().ajax.reload();
              alert('Registro excluído!');
            }, 2000);
          }
        })
      });
    });

    //funções JS
    function Situationformat(situation){
      if (situation == 'manutencao') {
          return 'Em manutenção';
      }else if (situation == 'inativo') {
          return 'Inativo';
      }else if (situation == 'ativo') {
          return 'Ativo';
      }
    }
    function DateFormat(date) {
        moment.locale('pt-br');
        if (date !== null && date !== '') {
            return moment(date).format('DD/MM/YYYY');
        } else {
            return '';
        }            
    }    
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