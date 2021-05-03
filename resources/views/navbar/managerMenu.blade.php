<nav class="navbar sticky-top navbar-expand-lg navbar-dark" style="background-color: #000000;">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#" style="color: #fffb00">
        <ion-icon name="calendar-outline"></ion-icon>
        Agenda SIC
    </a>  
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item dropdown @yield('servicos_ativo')">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Serviços
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/servicos">Consultar</a>
                  <a class="dropdown-item" href="/servicos/edit">Editar</a>
                  <a class="dropdown-item" href="/servicos/create">Cadastrar</a>
                </div>
            </li>
            <li class="nav-item dropdown @yield('tecnicos_ativo')">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Técnicos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/tecnicos">Consultar</a>
                  <a class="dropdown-item" href="/tecnicos/edit">Editar</a>
                  <a class="dropdown-item" href="/tecnicos/create">Cadastrar</a>
                </div>
            </li>
            <li class="nav-item dropdown @yield('padroes_ativo')">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Padrões
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/padroes">Consultar</a>
                  <a class="dropdown-item" href="/padroes/edit">Editar</a>
                  <a class="dropdown-item" href="/padroes/create">Cadastrar</a>
                </div>
            </li>
            <li class="nav-item dropdown @yield('veiculos_ativo')">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Veículos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/veiculos">Consultar</a>
                  <a class="dropdown-item" href="/veiculos/edit">Editar</a>
                  <a class="dropdown-item" href="/veiculos/create">Cadastrar</a>
                  <!--div class="dropdown-divider"></div-->
                  <a class="dropdown-item" href="#">Cadastrar</a>
                </div>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown active">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{$_SESSION['nome']}}
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" aria-current="page" href="{{route('usuarios.logout')}}">Sair</a>
              </div>
            </li>
          </ul>
    </div>
  </nav>