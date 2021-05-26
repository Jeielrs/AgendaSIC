@extends('layouts.templateOne')
@section('title', 'Veículos')
@section('veiculos_ativo', 'active')
@section('content')
  @include('navbar.managerMenu')
  <div class="m-2">
    <div class="row">
      <div class="col-md-6">
        <h3 class="titulo-rota">Veículos</h3>
      </div>
      <div class="col-md-6 text-right">
          <a href="/veiculos/create" type="button" class="mt-2 mb-2 btn-sm btn-success">Cadastrar Veículo</a>
      </div>
    </div>
  </div>
  <div class="m-2" id="data-table">
    <!-- DataTables Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-sm table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th class="dont-break">Ações</th>
                <th class="dont-break">ID</th>
                <th class="dont-break">Situação</th>
                <th class="dont-break">Placa</th>
                <th class="dont-break">Usuário</th>
                <th class="dont-break">Marca</th>
                <th class="dont-break">Modelo</th>
                <th class="dont-break">Km</th>
                <th class="dont-break">Proprietário</th>
                <th class="dont-break">Data Locação</th>
                <th class="dont-break">Prazo Locação</th>
                <th class="dont-break">Observação</th>
                <th class="dont-break">Criado em</th>
                <th class="dont-break">Atualizado em</th>
              </tr>
            </thead>    
            <tbody>
              @foreach($veiculos as $veiculo)            
                <tr>
                    <td>
                      <a href="{{route('veiculos.show', $veiculo->id)}}"><i class="fas fa-eye text-primary"></i></a>
                      <a href="{{route('veiculos.edit', $veiculo->id)}}"><i class="fas fa-edit text-warning"></i></a>
                      <a href="{{route('veiculos.delete', $veiculo->id)}}"><i class="fas fa-trash-alt text-danger"></i><a
  >                 </td>
                    <td class="dont-break"><nobr>{{$veiculo->id}}</nobr></td>
                    @if ($veiculo->situation == "livre")
                        <td class="dont-break bg-success text-white text-center"><nobr>Livre</nobr></td>
                    @elseif ($veiculo->situation == "em_uso")
                        <td class="dont-break bg-warning text-white text-center"><nobr>Em uso</nobr></td>
                    @elseif ($veiculo->situation == "inativo")
                        <td class="dont-break bg-secondary text-white text-center"><nobr>Inativo</nobr></td>
                    @else
                        <td></td>
                    @endif
                    <td class="dont-break"><nobr>{{$veiculo->vehicle_plate}}</nobr></td>
                    @if ($veiculo->vehicle_user != null)
                        <td class="dont-break"><nobr>{{$veiculo->vehicle_user}}</nobr></td>
                    @else
                        <td class="dont-break"><nobr>Nenhum</nobr></td>
                    @endif
                    <td class="dont-break"><nobr>{{$veiculo->brand}}</nobr></td>
                    <td class="dont-break"><nobr>{{$veiculo->model}}</nobr></td>
                    <td class="dont-break"><nobr>{{$veiculo->km}}</nobr></td>                    
                    <td class="dont-break"><nobr>{{$veiculo->owner}}</nobr></td>
                    <td class="dont-break"><nobr>{{$veiculo->rent_date}}</nobr></td>
                    <td class="dont-break"><nobr>{{$veiculo->rental_term}}</nobr></td>
                    <td class="dont-break"><nobr>{{$veiculo->obs}}</nobr></td>
                    <td class="dont-break"><nobr>{{$veiculo->created_at}}</nobr></td>
                    <td class="dont-break"><nobr>{{$veiculo->updated_at}}</nobr></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
  </div>
@endsection