@extends('layouts.templateOne')
@section('title', 'Exibição de Técnicos')
@section('tecnicos_ativo', 'active')
@section('content')
@include('navbar.managerMenu')
<div class="container">
<h1>Página dos Técnicos</h1>
   <!-- DataTables Example -->
   <div class="card shadow mb-4">

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Nascimento</th>
              <th>RG</th>
              <th>CPF</th>
              <th>CTPS</th>
              <th>CNH</th>
              <th>Telefone</th>
              <th>Validade ASO</th>
              <th>Validade EPI</th>
              <th>Validade NR10</th>
              <th>Validade NR11</th>
              <th>Validade NR35</th>
              <th>Situação</th>
              <th>Criado em</th>
              <th>Atualizado em</th>
            </tr>
          </thead>
    
          <tbody>
            @foreach($tecnicos as $tecnico)
            
            <tr>
                <td><p>{{$tecnico->name}}</p></td>
                <td><p>{{$tecnico->birth}}</p></td>
                <td><p>{{$tecnico->rg}}</p></td>
                <td><p>{{$tecnico->cpf}}</p></td>
                <td><p>{{$tecnico->ctps}}</p></td>
                <td><p>{{$tecnico->cnh}}</p></td>
                <td><p>{{$tecnico->phone}}</p></td>
                <td><p>{{$tecnico->validity_aso}}</p></td>
                <td><p>{{$tecnico->validity_epi}}</p></td>
                <td><p>{{$tecnico->validity_nr10}}</p></td>
                <td><p>{{$tecnico->validity_nr11}}</p></td>
                <td><p>{{$tecnico->validity_nr35}}</p></td>
                <td><p>{{$tecnico->situation}}</p></td>
                <td><p>{{$tecnico->created_at}}</p></td>
                <td><p>{{$tecnico->updated_at}}</p></td>
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