<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000000;">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#" style="color: #fffb00">
      <ion-icon name="calendar-outline"></ion-icon>
      Agenda SIC
  </a>  
  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item dropdown active">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Serviços
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Consultar</a>
                <a class="dropdown-item" href="#">Editar</a>
                <a class="dropdown-item" href="#">Cadastrar</a>
              </div>
          </li>
          <li class="nav-item dropdown active">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Técnicos
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Consultar</a>
                <a class="dropdown-item" href="#">Editar</a>
                <a class="dropdown-item" href="#">Cadastrar</a>
              </div>
          </li>
          <li class="nav-item dropdown active">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Padrões
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Consultar</a>
                <a class="dropdown-item" href="#">Editar</a>
                <a class="dropdown-item" href="#">Cadastrar</a>
              </div>
          </li>
          <li class="nav-item dropdown active">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Veículos
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Consultar</a>
                <a class="dropdown-item" href="#">Editar</a>
                <!--div class="dropdown-divider"></div-->
                <a class="dropdown-item" href="#">Cadastrar</a>
              </div>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" aria-current="page" href="{{route('usuarios.logout')}}">Sair</a>
          </li>
        </ul>
  </div>
</nav>