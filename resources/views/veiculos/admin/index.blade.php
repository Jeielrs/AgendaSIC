@extends('layouts.templateOne')
@section('title', 'Veículos')
@section('veiculos_ativo', 'active')
@section('content')
@include('navbar.managerMenu')
    <div class="ml-3 mr-3">
        <div class="row color-veiculos">
            <div class="col-md-6">
                <h3 class="titulo-rota mt-2">Veículos</h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="/veiculos/create" type="button" class="btn mb-2 mt-2 btn-primary">Cadastrar Veículo</a>
            </div>
        </div>
    </div>
    <div class="m-3">
        <div class="table-responsive">
            <table id="user_table" class="table table-sm table-hover table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Placa</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Situação</th>
                        <th>Usuário</th>
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
                    <h3>Editar Veículo <span id="edit_id"></span></h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" id="edit_form" class="form-horizontal">
                        @csrf
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <div class="container">
                                    <label class="labelform mt-2 mb-0">Placa:</label>
                                    <input type="text" name="vehicle_plate" id="edit_vehicle_plate" class="form-control" required>
                                </div>
                                <div class="container">
                                    <label class="labelform mt-2 mb-0">Marca:</label>
                                    <select name="brand" id="edit_brand" class="form-control" required>
                                        <option selected>Escolher</option>
                                        <option value="Volkswagen">Volkswagen</option>
                                        <option value="GM - Chevrolet">GM - Chevrolet</option>
                                        <option value="Fiat">Fiat</option>
                                        <option value="Ford">Ford</option>
                                        <option value="Citroen">Citroën</option>
                                        <option value="Honda">Honda</option>
                                        <option value="Hyundai">Hyundai</option>
                                        <option value="Toyota">Toyota</option>
                                        <option value="Nissan">Nissan</option>
                                        <option value="Renault">Renault</option>
                                        <option value="Peugeot">Peugeot</option>
                                    </select>
                                </div>
                                <div class="container">
                                    <label class="labelform mt-2 mb-0">Modelo:</label>
                                    <input type="text" name="model" id="edit_model" class="form-control">
                                </div>
                                <div class="container">
                                    <label class="labelform mt-2 mb-0">KM:</label>
                                    <input type="number" name="km" id="edit_km" class="form-control" required>
                                </div>                                    
                            </div>
                            <div class="col-lg-4">
                                <div class="container">
                                    <label class="labelform mt-2 mb-0">Proprietário:</label>
                                    <select name="owner" id="edit_owner" class="form-control" required>
                                        <option value="aferitec">Aferitec</option>
                                        <option value="locadora">Locadora</option>
                                    </select>
                                </div>
                                <div class="container">
                                    <label class="labelform mt-2 mb-0">Situação:</label>
                                    <select  name="situation" id="edit_situation" class="form-control" required>
                                        <option value="livre">Livre</option>
                                        <option value="em_uso">Em uso</option>
                                        <option value="inativo">Inativo</option>
                                    </select>
                                </div>
                                <div class="container">
                                    <label class="labelform mt-2 mb-0">Data da Locação:</label>
                                    <input type="date" name="rent_date" id="edit_rent_date" class="form-control">
                                </div>
                                <div class="container">
                                    <label class="labelform mt-2 mb-0">Prazo da Locação:</label>
                                    <input type="date" name="rental_term" id="edit_rental_term" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="container">
                                    <label class="labelform mt-2 mb-0">Usuário:</label>
                                    <select  name="vehicle_user" id="edit_vehicle_user" class="form-control">
                                        @foreach ($tecnicos as $tecnico)
                                            <option value="{{$tecnico->name}}">{{$tecnico->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="container">
                                    <label class="labelform mt-2 mb-0">Observação:</label>
                                    <textarea class="form-control" name="obs" id="edit_obs" rows="7" pattern="[a-zA-Z0-9]+"></textarea>
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
                    <h3>Veículo <span id="show_id"></span></h3>
                    <button type="button" class="close" data-tt="tooltip" data-original-title="Campos vazios indicam registros ainda não cadastrados."><i class="far fa-question-circle text-white"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="divVisu">
                                <div class="divLabelVisu">
                                    <span class="labelVisu2">Marca</span>
                                </div>
                                <div class="pVisu">
                                    <span id="show_brand" class="dont-break-out"></span>
                                </div>
                            </div>
                            <div class="divVisu">
                                <div class="divLabelVisu">
                                    <span class="labelVisu2">Placa</span>
                                </div>
                                <div class="pVisu">
                                    <span id="show_vehicle_plate" class="dont-break-out"></span>
                                </div>
                            </div>
                            <div class="divVisu">
                                <div class="divLabelVisu">
                                    <span class="labelVisu2">Usuário</span>
                                </div>
                                <div class="pVisu">
                                    <span id="show_vehicle_user" class="dont-break-out"></span>
                                </div>
                            </div>
                            <div class="divVisu">
                                <div class="divLabelVisu">
                                    <span class="labelVisu2">Data da Locação</span>
                                </div>
                                <div class="pVisu">
                                    <span id="show_rent_date" class="dont-break-out"></span>
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
                                    <span class="labelVisu2">Proprietário</span>
                                </div>
                                <div class="pVisu">
                                    <span id="show_owner" class="dont-break-out"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="divVisu">
                                <div class="divLabelVisu">
                                    <span class="labelVisu2">Modelo</span>
                                </div>
                                <div class="pVisu">
                                    <span id="show_model" class="dont-break-out"></span>
                                </div>
                            </div>
                            <div class="divVisu">
                                <div class="divLabelVisu">
                                    <span class="labelVisu2">Kilômetros</span>
                                </div>
                                <div class="pVisu">
                                    <span id="show_km" class="dont-break-out"></span>
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
                                    <span class="labelVisu2">Prazo da Locação</span>
                                </div>
                                <div class="pVisu">
                                    <span id="show_rental_term" class="dont-break-out"></span>
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
                                    <span class="labelVisu2">Observação</span>
                                </div>
                                <div class="pVisu">
                                    <span id="show_obs" class="dont-break-out"></span>
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
                    url: "{{ route('veiculos.index') }}",
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
                        data: 'vehicle_plate',
                        name: 'vehicle_plate'
                    },
                    {
                        width: "15%",
                        data: 'brand',
                        name: 'brand'
                    },
                    {
                        width: "15%",
                        data: 'model',
                        name: 'model'
                    },
                    {
                        width: "10%",
                        className: 'text-center',
                        data: 'situation',
                        name: 'situation'
                    },
                    {
                        width: "30%",
                        data: 'vehicle_user',
                        name: 'vehicle_user'
                    },
                    {
                        width: "15%",
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
                 action_url = "{{ route('veiculos.update') }}";
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
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.errors.length; count++)
                            {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if(data.success)
                        {
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
                    url :"veiculos/"+id+"/show",
                    dataType:"json",
                    success:function(data)
                    {                        
                        $('#show_id').html(data.result.id);
                        $('#show_vehicle_plate').html(data.result.vehicle_plate);
                        $('#show_vehicle_user').html(data.result.vehicle_user);
                        $('#show_brand').html(data.result.brand);
                        $('#show_km').html(data.result.km);
                        $('#show_situation').html(Situationformat(data.result.situation));
                        $('#show_owner').html(capitalize(data.result.owner));
                        $('#show_rent_date').html(DateFormat(data.result.rent_date));
                        $('#show_rental_term').html(DateFormat(data.result.rental_term));
                        $('#show_obs').html(data.result.obs);
                        $('#show_created_at').html(DateHourFormat(data.result.created_at));
                        $('#show_updated_at').html(DateHourFormat(data.result.updated_at));
                        $('#show_model').html(capitalize(data.result.model));
                        $('#showModal').modal('show');
                    }
                })
            });
            
            //Exibe as informações nos campos no modal edit
            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $.ajax({
                    url :"veiculos/"+id+"/edit",
                    dataType:"json",
                    success:function(data)
                    {
                        $('#edit_id').html(data.result.id)
                        $('#edit_vehicle_plate').val(data.result.vehicle_plate);
                        $('#edit_vehicle_user').val(data.result.vehicle_user);
                        $('#edit_brand').val(data.result.brand);
                        $('#edit_model').val(data.result.model);
                        $('#edit_km').val(data.result.km);
                        $('#edit_situation').val(data.result.situation);
                        $('#edit_owner').val(data.result.owner);
                        $('#edit_rent_date').val(data.result.rent_date);
                        $('#edit_rental_term').val(data.result.rental_term);
                        $('#edit_obs').val(data.result.obs);
                        $('#hidden_id').val(id);
                        //$('.modal-title').text('Edit Record');
                        //$('#action_button').val('Edit');
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
                    url:"veiculos/destroy/"+user_id,
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