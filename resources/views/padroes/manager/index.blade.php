@extends('layouts.templateOne')
@section('title', 'Padrões')
@section('padroes_ativo', 'active')
@section('content')
  @include('navbar.managerMenu')
  <div class="container">
  <h1>Padrões</h1>
    <!-- DataTables Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-sm table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th class="dont-break" >Código</th>
                <th class="dont-break" >Situação</th>
                <th class="dont-break" >Descrição</th>
                <th class="dont-break" >Setor</th>
                <th class="dont-break" >Particularidade</th>
                <th class="dont-break" >Frequência Calibração</th>
                <th class="dont-break" >Data de Calibração</th>
                <th class="dont-break" >Validade Calibração</th>
                <th class="dont-break" >Criado em</th>
                <th class="dont-break" >Atualizado em</th>
              </tr>
            </thead>    
            <tbody>
              foreach($padroes as $padrao)            
                <tr>
                    <td class="dont-break"><nobr>CTM-4043</nobr></td>
                    <td class="dont-break">Ativo</td>
                    <td class="dont-break"><nobr>Braço de Dinamômetro</nobr></td>
                    <td class="dont-break"><nobr>LEX - Mahle (Jundiaí)</nobr></td>
                    <td class="dont-break"><nobr>1020 mm | LC / LOC</nobr></td>
                    <td class="dont-break">$36 meses</td>
                    <td class="dont-break">ago/20</td>
                    <td class="dont-break">dez/21</td>
                    <td class="dont-break"><nobr>padrao->created_at</nobr></td>
                    <td class="dont-break"><nobr>padrao->updated_at</nobr></td>
                </tr>
              endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
  </div>
@endsection