@extends('layouts.templateOne')
@section('title', 'Cadastrar Técnicos')
@section('tecnicos_ativo', 'active')
@section('content')    
    @include('navbar.adminMenu')
    <div class="m-3">
        <div class="row">
            <div class="col-md-6">
              <h3 class="titulo-rota">Técnicos > Cadastro</h3>
            </div>
            <div class="col-md-6 text-right">
              
            </div>
        </div>
    </div>
    <div class="m-3" id="formulario">
        <form action="{{route('tecnicos.insert')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row form-group">
                <div class="col-lg-6">
                    <div class="container">
                        <label class="labelform mt-2 mb-0">Nome Completo:</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">Nascimento:</label>
                                <input type="date" name="nascimento" class="form-control" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">RG:</label>
                                <input type="text" name="rg" class="form-control" onkeypress="$(this).mask('00.000.000-A');" required>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">CPF:</label>
                                <input type="text" name="cpf" class="form-control" onkeypress="$(this).mask('000.000.000-00');" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">CTPS:</label>
                                <input type="text" name="ctps" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">Telefone:</label>
                                <input type="tel" name="telefone" class="form-control" onkeypress="$(this).mask('(00) 00000-0009')" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">CNH:</label>
                                <input type="text" name="cnh" class="form-control" required>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">Validade EPI:</label>
                                <input type="month" name="validade_epi" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">Validade NR10:</label>
                                <input type="month" name="validade_nr10" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">Validade NR11:</label>
                                <input type="month" name="validade_nr11" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">Validade NR35:</label>
                                <input type="month" name="validade_nr35" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">Situação:</label>
                                <select class="form-control" id="situacao" name="situacao">
                                    <option>Ativo</option>
                                    <option>Férias</option>
                                    <option>Afastado</option>
                                    <option>Inativo</option>
                                  </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">Validade ASO:</label>
                                <input type="month" name="validade_aso" class="form-control">                             
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="labelform mt-2 mb-0">Observação:</label>
                                <textarea name="observacao" rows="1" class="form-control" pattern="[a-zA-Z0-9]+"></textarea>
                            </div>
                            <div class=" col-lg-6 text-center">
                                <button type="submit" class="btn btn-success mt-4" name="">Cadastrar</button>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection