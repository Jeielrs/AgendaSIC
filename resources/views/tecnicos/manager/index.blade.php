@extends('layouts.templateOne')
@section('title', 'Técnicos')
@section('tecnicos_ativo', 'active')
@section('content')
  @include('navbar.managerMenu')
  <div class="container">
  <h1>Técnicos</h1>
    <!-- DataTables Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-sm table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
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
                <th class="dont-break" >Situação</th>
                <th class="dont-break" >Criado em</th>
                <th class="dont-break" >Atualizado em</th>
              </tr>
            </thead>    
            <tbody>
              @foreach($tecnicos as $tecnico)            
                <tr>
                  <td class="dont-break"><nobr>{{$tecnico->name}}</nobr></td>
                  <td class="dont-break">{{$tecnico->birth}}</td>
                  <td class="dont-break">{{$tecnico->rg}}</td>
                  <td class="dont-break">{{$tecnico->cpf}}</td>
                  <td class="dont-break">{{$tecnico->ctps}}</td>
                  <td class="dont-break">{{$tecnico->cnh}}</td>
                  <td class="dont-break">{{$tecnico->phone}}</td>
                  <td class="dont-break">{{$tecnico->validity_aso}}</td> 
                  <td class="dont-break">{{$tecnico->validity_epi}}</td>
                  <td class="dont-break">{{$tecnico->validity_nr10}}</td>
                  <td class="dont-break">{{$tecnico->validity_nr11}}</td>
                  <td class="dont-break">{{$tecnico->validity_nr35}}</td>
                  <td class="dont-break">{{$tecnico->situation}}</td>
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