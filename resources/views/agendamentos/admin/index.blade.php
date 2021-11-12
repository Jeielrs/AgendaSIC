@extends('layouts.templateOne')
@section('title', 'Técnicos')
@section('tecnicos_ativo', 'active')
@section('content')
  @include('navbar.adminMenu')
  <div class="ml-3 mr-3">
    <div class="row color-tecnicos">
      <div class="col-md-6">
        <h3 class="titulo-rota mt-2">Técnicos</h3>
      </div>
      <div class="col-md-6 text-right">
          <a href="/tecnicos/create" type="button" class="mb-2 mt-2 btn btn-primary">Cadastrar Técnico</a>
      </div>
    </div>
  </div>
  <div class="m-3">
    <div class="table-responsive">
        <table id="user_table" class="table table-sm table-hover table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>RG</th>
                    <th>Nascimento</th>                    
                    <th>Telefone</th>
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
          <h3>Editar Técnico <span id="edit_id"></span></h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="post" id="edit_form" class="form-horizontal">
             @csrf
            <div class="row form-group">
              <div class="col-lg-8">
                <div class="container">
                  <label class="labelform mt-2 mb-0">Nome Completo:</label>
                  <input type="text" name="name" id="edit_name" class="form-control" required>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="labelform mt-2 mb-0">Nascimento:</label>
                            <input type="date" name="birth" id="edit_birth" class="form-control">
                        </div>
                        <div class="col-lg-6">
                            <label class="labelform mt-2 mb-0">RG:</label>
                            <input type="text" name="rg" id="edit_rg" class="form-control" onkeypress="$(this).mask('00.000.000-A');" required>
                        </div>
                    </div>
                </div>
                <div class="container">
                  <div class="row">
                    <div class="col-lg-6">
                      <label class="labelform mt-2 mb-0">CPF:</label>
                      <input type="text" name="cpf" id="edit_cpf" class="form-control" onkeypress="$(this).mask('000.000.000-00');" required>
                    </div>
                    <div class="col-lg-6">
                      <label class="labelform mt-2 mb-0">CTPS:</label>
                      <input type="text" name="ctps" id="edit_ctps" class="form-control" required>
                    </div>
                  </div>
                </div>
                <div class="container">
                  <div class="row">
                    <div class="col-lg-6">
                      <label class="labelform mt-2 mb-0">Telefone:</label>
                      <input type="tel" name="phone" id="edit_phone" class="form-control" onkeypress="$(this).mask('(00) 00000-0009')" required>
                    </div>
                    <div class="col-lg-6">
                      <label class="labelform mt-2 mb-0">CNH:</label>
                      <input type="text" name="cnh" id="edit_cnh" class="form-control" required>
                    </div>
                  </div>
                </div>
                <div class="container">
                  <label class="labelform mt-2 mb-0">Observação:</label>
                  <textarea name="obs" id="edit_obs" rows="3" class="form-control" pattern="[a-zA-Z0-9]+"></textarea>
                </div>  
              </div>
              <div class="col-lg-4">
                <div class="container">
                  <label class="labelform mt-2 mb-0">Validade EPI:</label>
                  <input type="month" name="validity_epi" id="edit_validity_epi" class="form-control form-control-sm">
                </div>
                <div class="container">
                  <label class="labelform mt-2 mb-0">Validade NR10:</label>
                  <input type="month" name="validity_nr10" id="edit_validity_nr10" class="form-control form-control-sm">
                </div>
                <div class="container">
                  <label class="labelform mt-2 mb-0">Validade NR11:</label>
                  <input type="month" name="validity_nr11" id="edit_validity_nr11" class="form-control form-control-sm">
                </div>
                <div class="container">
                  <label class="labelform mt-2 mb-0">Validade NR35:</label>
                  <input type="month" name="validity_nr35" id="edit_validity_nr35" class="form-control form-control-sm">
                </div>
                <div class="container">
                  <label class="labelform mt-2 mb-0">Situação:</label>
                  <select class="form-control form-control-sm" id="edit_situation" name="situation" required>
                    <option>Ativo</option>
                    <option>Férias</option>
                    <option>Afastado</option>
                    <option>Inativo</option>
                  </select>
                </div>
                <div class="container">
                  <label class="labelform mt-2 mb-0">Validade ASO:</label>
                  <input type="month" name="validity_aso" id="edit_validity_aso" class="form-control form-control-sm">
                </div>
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
                <h3>Técnico <span id="show_id"></span></h3>
                <button type="button" class="close" data-tt="tooltip" data-original-title="Campos vazios indicam registros ainda não cadastrados."><i class="far fa-question-circle text-white"></i></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="divVisu">
                        <div class="divLabelVisu">
                            <span class="labelVisu2">Nome</span>
                        </div>
                        <div class="pVisu">
                            <span id="show_name" class="dont-break-out"></span>
                        </div>
                        </div>
                        <div class="divVisu">
                            <div class="divLabelVisu">
                                <span class="labelVisu2">CPF</span>
                            </div>
                            <div class="pVisu">
                                <span id="show_cpf" class="dont-break-out"></span>
                            </div>
                        </div>
                        <div class="divVisu">
                          <div class="divLabelVisu">
                            <span class="labelVisu2">CTPS</span>
                          </div>
                          <div class="pVisu">
                            <span id="show_ctps" class="dont-break-out"></span>
                          </div>
                        </div>
                        <div class="divVisu">
                          <div class="divLabelVisu">
                            <span class="labelVisu2">Telefone</span>
                          </div>
                          <div class="pVisu">
                              <span id="show_phone" class="dont-break-out"></span>
                          </div>
                        </div>
                        <div class="divVisu">
                            <div class="divLabelVisu">
                                <span class="labelVisu2">Validade ASO</span>
                            </div>
                            <div class="pVisu">
                                <span id="show_validity_aso" class="dont-break-out"></span>
                            </div>
                        </div>
                        <div class="divVisu">
                            <div class="divLabelVisu">
                                <span class="labelVisu2">Validade EPI</span>
                            </div>
                            <div class="pVisu">
                                <span id="show_validity_epi" class="dont-break-out"></span>
                            </div>
                        </div>
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
                            <span class="labelVisu2">Nascimento</span>
                        </div>
                        <div class="pVisu">
                            <span id="show_birth" class="dont-break-out"></span>
                        </div>
                      </div>
                      <div class="divVisu">
                        <div class="divLabelVisu">
                            <span class="labelVisu2">RG</span>
                        </div>
                        <div class="pVisu">
                            <span id="show_rg" class="dont-break-out"></span>
                        </div>
                      </div>
                      <div class="divVisu">
                        <div class="divLabelVisu">
                            <span class="labelVisu2">CNH</span>
                        </div>
                        <div class="pVisu">
                            <span id="show_cnh" class="dont-break-out"></span>
                        </div>
                      </div>
                      <div class="divVisu">
                          <div class="divLabelVisu">
                              <span class="labelVisu2">Validade NR10</span>
                          </div>
                          <div class="pVisu">
                              <span id="show_validity_nr10" class="dont-break-out"></span>
                          </div>
                      </div>
                        <div class="divVisu">
                          <div class="divLabelVisu">
                              <span class="labelVisu2">Validade NR11</span>
                          </div>
                          <div class="pVisu">
                              <span id="show_validity_nr11" class="dont-break-out"></span>
                          </div>
                        </div>
                        <div class="divVisu">
                          <div class="divLabelVisu">
                              <span class="labelVisu2">Validade NR35</span>
                          </div>
                          <div class="pVisu">
                              <span id="show_validity_nr35" class="dont-break-out"></span>
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
          url: "{{ route('tecnicos.index') }}",
        },
        columns: [
          {
            width: "5%",
            className: 'text-center',
            data: 'id',
            name: 'id'
          },
          {
            width: "35%",
            data: 'name',
            name: 'name'
          },
          {
            width: "10%",
            className: 'text-center',
            data: 'cpf',
            name: 'cpf'
          },
          {
            width: "10%",
            className: 'text-center',
            data: 'rg',
            name: 'rg'
          },
          {
            width: "10%",
            className: 'text-center',
            data: 'birth',
            name: 'birth'
          },
          {
            width: "10%",
            className: 'text-center',
            data: 'phone',
            name: 'phone'
          },
          {
            width: "8%",
            className: 'text-center',
            data: 'situation',
            name: 'situation'
          },          
          {
            width: "12%",
            className: 'text-center',
            data: 'action',
            name: 'action',
            orderable: false
          }
        ],
      });

      $('#edit_form').on('submit', function(event){
        event.preventDefault();
        var action_url = '';
        if($('#action').val() == 'Edit')
        {
         action_url = "{{ route('tecnicos.update') }}";
        }
        $.ajax({
          url: action_url,
          method:"POST",
          data:$(this).serialize(),
          dataType:"json",
          success:function(data)
          {
            var html = '';
            if(data.errors)
            {
              console.log(data);
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
        });
      });

      $(document).on('click', '.show', function(){
        var id = $(this).attr('id');
        //$('#form_result').html('');
        $.ajax({
          url :"tecnicos/"+id+"/show",
          dataType:"json",
          success:function(data)
          {                        
            $('#show_id').html(data.result.id);
            $('#show_name').html(data.result.name);
            $('#show_birth').html(DateFormat(data.result.birth));
            $('#show_rg').html(data.result.rg);
            $('#show_cpf').html(data.result.cpf);
            $('#show_situation').html(Situationformat(data.result.situation));
            $('#show_validity_aso').html(DateFormatMonth(data.result.validity_aso));
            $('#show_validity_epi').html(DateFormatMonth(data.result.validity_epi));
            $('#show_validity_nr10').html(DateFormatMonth(data.result.validity_nr10));
            $('#show_validity_nr11').html(DateFormatMonth(data.result.validity_nr11));
            $('#show_validity_nr35').html(DateFormatMonth(data.result.validity_nr35));
            $('#show_ctps').html(data.result.ctps);
            $('#show_cnh').html(data.result.cnh);
            $('#show_phone').html(data.result.phone);
            $('#show_obs').html(data.result.obs);
            $('#show_created_at').html(DateHourFormat(data.result.created_at));
            $('#show_updated_at').html(DateHourFormat(data.result.updated_at));
            $('#showModal').modal('show');
          }
        })
      });

      //Exibe as informações nos campos no modal edit
      $(document).on('click', '.edit', function(){
        var id = $(this).attr('id');
        $.ajax({
          url :"tecnicos/"+id+"/edit",
          dataType:"json",
          success:function(data)
          {
            $('#edit_id').html(data.result.id)
            $('#edit_name').val(data.result.name);
            $('#edit_birth').val(data.result.birth);
            $('#edit_rg').val(data.result.rg);
            $('#edit_cpf').val(data.result.cpf);
            $('#edit_ctps').val(data.result.ctps);
            $('#edit_situation').val(data.result.situation);
            $('#edit_validity_nr35').val(data.result.validity_nr35);
            $('#edit_validity_nr11').val(data.result.validity_nr11);
            $('#edit_validity_nr10').val(data.result.validity_nr10);
            $('#edit_validity_epi').val(data.result.validity_epi);
            $('#edit_validity_aso').val(data.result.validity_aso);
            $('#edit_cnh').val(data.result.cnh);
            $('#edit_phone').val(data.result.phone);
            $('#edit_obs').val(data.result.obs);
            $('#hidden_id').val(id);
            $('#action').val('Edit');
            $('#editModal').modal('show');
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
          url:"tecnicos/destroy/"+user_id,
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
      if (situation == 'em_uso') {
          return 'Em uso';
      }else if (situation == 'inativo') {
          return 'Inativo';
      }else if (situation == 'livre') {
          return 'Livre';
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
    function DateFormatMonth(date) {
        moment.locale('pt-br');
        if (date !== null && date !== '') {
            return moment(date).format('MMMM/YYYY');
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