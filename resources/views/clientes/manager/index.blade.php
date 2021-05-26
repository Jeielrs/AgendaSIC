@extends('layouts.templateOne')
@section('title', 'Clientes')
@section('clientes_ativo', 'active')
@section('content')
  @include('navbar.managerMenu')
  <div class="m-2">
    <div class="row">
      <div class="col-md-6">
        <h3 class="titulo-rota">Clientes</h3>
      </div>
      <div class="col-md-6 text-right">
          <a href="/clientes/synchronize" type="button" class="mt-2 mb-2 btn-sm btn-success">Sincronizar Clientes</a>
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
                <th class="dont-break"><i class="fas fa-eye text-primary"></i></th>
                <th class="dont-break">ID</th>
                <th class="dont-break">Razão Social</th>
                <th class="dont-break">CNPJ / CPF</th>
                <th class="dont-break">Nome Fantasia</th>
                <th class="dont-break">Telefone</th>
                <th class="dont-break">Endereço</th>
                <th class="dont-break">UF</th>
                <th class="dont-break">Cidade</th>
                <th class="dont-break">CEP</th>
                <th class="dont-break">E-mail</th>
                <th class="dont-break">Observação</th>
                <th class="dont-break">PF</th>
                <th class="dont-break">Código no Omie</th>
                <th class="dont-break">Criado em</th>
                <th class="dont-break">Atualizado em</th>
              </tr>
            </thead>    
            <tbody>
              @foreach($clientes as $cliente)            
                <tr>
                    <td class="dont-break"><nobr>{{$cliente->id}}</nobr></td>
                    <td class="dont-break"><nobr>{{$cliente->razao_social}}</nobr></td>
                    <td class="dont-break"><nobr>{{$cliente->cnpj_cpf}}</nobr></td>
                    <td class="dont-break"><nobr>{{$cliente->nome_fantasia}}</nobr></td>
                    <td class="dont-break"><nobr>{{$cliente->telefone}}</nobr></td>
                    <td class="dont-break"><nobr>{{$cliente->endereco}}</nobr></td>
                    <td class="dont-break"><nobr>{{$cliente->estado}}</nobr></td>
                    <td class="dont-break"><nobr>{{$cliente->cidade}}</nobr></td>
                    <td class="dont-break"><nobr>{{$cliente->cep}}</nobr></td>
                    <td class="dont-break"><nobr>{{$cliente->email}}</nobr></td>
                    <td class="dont-break"><nobr>{{$cliente->observacao}}</nobr></td>
                    <td class="dont-break"><nobr>{{$cliente->pessoa_fisica}}</nobr></td>
                    <td class="dont-break"><nobr>{{$cliente->codigo_cliente_omie}}</nobr></td>
                    <td class="dont-break"><nobr>{{$cliente->created_at}}</nobr></td>
                    <td class="dont-break"><nobr>{{$cliente->updated_at}}</nobr></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
  </div>
@endsection