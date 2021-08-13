@extends('layouts.templateOne')
@section('title', 'Cadastrar Padrões')
@section('padroes_ativo', 'active')
@section('content')
    @include('navbar.managerMenu')
    <div class="m-3">
        <div class="row">
            <div class="col-md-6">
              <h3 class="titulo-rota">Padrões > Cadastro</h3>
            </div>
            <div class="col-md-6 text-right">
              
            </div>
        </div>
    </div>
    <div class="m-3" id="formulario">
        <form action="{{route('padroes.insert')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row form-group">
                <div class="col-lg-2">
                    <div class="container">
                        <label class="labelform mt-2 mb-0">TAG:</label>
                        <input type="text" name="tag" class="form-control" required>
                    </div>
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Setor:</label>
                        <select name="setor" class="form-control">
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
                                <input type="number" min="1" name="frequencia" class="form-control" required>
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
                        <input type="date" name="data" class="form-control" required>
                    </div>
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Validade da Calibração:</label>
                        <input type="date" name="validade" class="form-control" required>
                    </div>
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Situação:</label>
                        <select name="situacao" class="form-control" required>
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
                        <textarea class="form-control" name="descricao" rows="1" pattern="[a-zA-Z0-9]+" required></textarea>
                    </div>
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Particularidade:</label>
                        <textarea class="form-control" name="particularidade" rows="1" pattern="[a-zA-Z0-9]+"></textarea>
                    </div>
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Observação:</label>
                        <textarea class="form-control" name="obs" rows="1" pattern="[a-zA-Z0-9]+"></textarea>
                    </div>
                </div>
                <div class="container">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success mt-4" name="">Cadastrar</button>
                    </div>                    
                </div> 
            </div>
        </form>
    </div>
@endsection