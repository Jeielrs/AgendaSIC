@extends('layouts.templateOne')
@section('title', 'Cadastrar Veículo')
@section('veiculos_ativo', 'active')
@section('content')
    @include('navbar.adminMenu')
    <div class="mr-3 ml-3">
        <div class="row">
            <div class="col-md-6">
              <h3 class="titulo-rota mt-2">Veículos > Cadastro</h3>
            </div>
            <div class="col-md-6 text-right">
              
            </div>
        </div>
    </div>
    <div class="m-3" id="formulario">
        <form action="{{route('veiculos.insert')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row form-group">
                <div class="col-lg-3">
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Placa:</label>
                        <input type="text"  name="placa" class="form-control" onkeyup="this.value = this.value.toUpperCase();" required>
                    </div>                    
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Marca:</label>
                        <select name="marca" class="form-control">
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
                        <input type="text" name="modelo" class="form-control" required>
                    </div>
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Data da Locação:</label>
                        <input type="date" name="data_locacao" class="form-control">
                    </div>
                </div>
                <div class="col-lg-3">                   
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Proprietário:</label>
                        <select name="proprietario" class="form-control" required>
                            <option selected>Escolher</option>
                            <option value="aferitec">Aferitec</option>
                            <option value="locadora">Locadora</option>
                        </select>
                    </div>
                    <div class="container">
                        <label class="labelform mt-2 mb-0">KM:</label>
                        <input type="number" name="km" class="form-control" required>
                    </div>
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Situação:</label>
                        <select name="situacao" class="form-control" required>
                            <option value="livre">Livre</option>
                            <option value="em_uso">Em uso</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Prazo da Locação:</label>
                        <input type="date" name="prazo_locacao" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Usuário:</label>
                        <input type="search" name="usuario" list="usuario" class="form-control">
                        <datalist id="usuario">
                            @foreach ($tecnicos as $tecnico)
                                <option value="{{$tecnico->name}}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Observação:</label>
                        <textarea class="form-control" name="obs" rows="7" pattern="[a-zA-Z0-9]+"></textarea>
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