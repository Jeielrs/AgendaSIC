@extends('layouts.templateOne')
@section('title', 'Padrões')
@section('padroes_ativo', 'active')
@section('content')
  @include('navbar.managerMenu')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h3 class="titulo-rota">Padrões</h3>
      </div>
      <div class="col-md-6 text-right">
          <a href="/padroes/create" type="button" class="mt-2 mb-2 btn-sm btn-success btn-inserir">Cadastrar Padrão</a>
      </div>
    </div>
  </div>
  <div class="container" id="data-table">
    <!-- DataTables Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-sm table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th class="dont-break">Ações</th>
                <th class="dont-break">ID</th>
                <th class="dont-break">TAG</th>
                <th class="dont-break">Descrição</th>
                <th class="dont-break">Setor</th>
                <th class="dont-break">Particularidade</th>
                <th class="dont-break">Frequência Calibração</th>
                <th class="dont-break">Data de Calibração</th>
                <th class="dont-break">Validade Calibração</th>
                <th class="dont-break">Situação</th>
                <th class="dont-break">Observação</th>
                <th class="dont-break">Criado em</th>
                <th class="dont-break">Atualizado em</th>
              </tr>
            </thead>    
            <tbody>
              @foreach($padroes as $padrao)            
                <tr>
                    <td>
                      <a href="{{route('padroes.show', $padrao->id)}}"><i class="fas fa-eye text-primary"></i></a>
                      <a href="{{route('padroes.edit', $padrao->id)}}"><i class="fas fa-edit text-warning"></i></a>
                      <a href="{{route('padroes.delete', $padrao->id)}}"><i class="fas fa-trash-alt text-danger"></i><a
  >                  </td>
                    <td class="dont-break"><nobr>{{$padrao->id}}</nobr></td>
                    @if ($padrao->situation == 'ativo')
                      <td class="dont-break bg-success text-white text-center"><nobr>Ativo</nobr></td>
                    @elseif ($padrao->situation == 'inativo')
                      <td class="dont-break bg-secondary text-white text-center"><nobr>Inativo</nobr></td>
                    @elseif ($padrao->situation == 'manutencao')
                      <td class="dont-break bg-warning text-white text-center"><nobr>Em manutenção</nobr></td>
                    @endif
                    <td class="dont-break"><nobr>{{$padrao->tag}}</nobr></td>
                    <td class="dont-break"><nobr>{{$padrao->description}}</nobr></td>
                    <td class="dont-break"><nobr>{{$padrao->sector}}</nobr></td>
                    <td class="dont-break"><nobr>{{$padrao->particularity}}</nobr></td>
                    <td class="dont-break"><nobr>{{$padrao->calibration_frequency}} meses</nobr></td>
                    <td class="dont-break"><nobr>{{$padrao->calibration_date}}</nobr></td>
                    <td class="dont-break"><nobr>{{$padrao->calibration_validity}}</nobr></td>
                    <td class="dont-break"><nobr>{{$padrao->situation}}</nobr></td>
                    <td class="dont-break"><nobr>{{$padrao->obs}}</nobr></td>
                    <td class="dont-break"><nobr>{{$padrao->created_at}}</nobr></td>
                    <td class="dont-break"><nobr>{{$padrao->updated_at}}</nobr></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
  </div>
@endsection