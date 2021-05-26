@extends('layouts.templateOne')
@section('title', 'Técnicos')
@section('tecnicos_ativo', 'active')
@section('content')
  @include('navbar.managerMenu')
  <div class="m-2">
    <div class="row">
      <div class="col-md-6">
        <h3 class="titulo-rota">Técnicos</h3>
      </div>
      <div class="col-md-6 text-right">
          <a href="/tecnicos/create" type="button" class="mt-2 mb-2 btn-sm btn-success">Cadastrar Técnico</a>
      </div>
    </div>
  </div>
  <div class="m-2" id="datatable">
    <!-- DataTables Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-sm table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Ações</th>
                <th>ID</th>
                <th class="dont-break" >Situação</th>
                <th class="dont-break" >Nome</th>
                <th class="dont-break" >Nascimento</th>
                <th class="dont-break" >RG</th>
                <th class="dont-break" >CPF</th>
                <th class="dont-break" >CTPS</th>
                <th class="dont-break" >CNH</th>
                <th class="dont-break" >Telefone</th>
                <th class="dont-break" >Validade ASO</th>
                <th class="dont-break" >Validade EPI</th>
                <th class="dont-break" >Validade NR10</th>
                <th class="dont-break" >Validade NR11</th>
                <th class="dont-break" >Validade NR35</th>
                <th class="dont-break" >Criado em</th>
                <th class="dont-break" >Atualizado em</th>
              </tr>
            </thead>    
            <tbody>
              @foreach($tecnicos as $tecnico)            
                <tr>
                  <td>
                    <a href="{{route('tecnicos.show', $tecnico->id)}}"><i class="fas fa-eye text-primary"></i></a>
                    <a href="{{route('tecnicos.edit', $tecnico->id)}}"><i class="fas fa-edit text-warning"></i></a>
                    <a href="{{route('tecnicos.delete', $tecnico->id)}}"><i class="fas fa-trash-alt text-danger"></i><a
>                  </td>
                  <td class="">{{$tecnico->id}}</td>
                  @if ($tecnico->situation == 'Ativo')
                    <td class="dont-break bg-success text-white text-center"><nobr>{{$tecnico->situation}}</nobr></td>
                  @elseif ($tecnico->situation == 'Inativo')
                    <td class="dont-break bg-secondary text-white text-center"><nobr>{{$tecnico->situation}}</nobr></td>
                  @elseif ($tecnico->situation == 'Férias')
                    <td class="dont-break bg-warning text-white text-center"><nobr>{{$tecnico->situation}}</nobr></td>
                  @elseif ($tecnico->situation == 'Afastado')
                    <td class="dont-break bg-danger text-white text-center"><nobr>{{$tecnico->situation}}</nobr></td>
                  @else
                      <td></td>
                  @endif
                  <td class="dont-break"><nobr>{{$tecnico->name}}</nobr></td>
                  <td class="dont-break"><nobr>{{$tecnico->birth}}</nobr></td>
                  <td class="dont-break"><nobr>{{$tecnico->rg}}</nobr></td>
                  <td class="dont-break"><nobr>{{$tecnico->cpf}}</nobr></td>
                  <td class="dont-break"><nobr>{{$tecnico->ctps}}</nobr></td>
                  <td class="dont-break"><nobr>{{$tecnico->cnh}}</nobr></td>
                  <td class="dont-break"><nobr>{{$tecnico->phone}}</nobr></td>
                  <td class="dont-break"><nobr>{{$tecnico->validity_aso}}</nobr></td> 
                  <td class="dont-break"><nobr>{{$tecnico->validity_epi}}</nobr></td>
                  <td class="dont-break"><nobr>{{$tecnico->validity_nr10}}</nobr></td>
                  <td class="dont-break"><nobr>{{$tecnico->validity_nr11}}</nobr></td>
                  <td class="dont-break"><nobr>{{$tecnico->validity_nr35}}</nobr></td>
                  <td class="dont-break"><nobr>{{$tecnico->created_at}}</nobr></td>
                  <td class="dont-break"><nobr>{{$tecnico->updated_at}}</nobr></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!--{{$tecnicos->links()}}-->
  </div>
@endsection