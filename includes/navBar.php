<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com -->
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!----======== CSS ======== -->

  <!----===== Boxicons CSS ===== -->
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <!--<title>Dashboard Sidebar Menu</title>-->
</head>

<body>

  <nav class="sidebar close">

    <header>
      <div class="image-text">
        <span class="image">
          <img src="../img/logomaxdata_z-300x300.png" alt="">
        </span>

        <div class="text logo-text">
          <span class="name">MAXDATA</span>
        </div>
      </div>

    </header>

    <div class="menu-bar">
      <div class="menu">

        <ul class="menu-links">
          <li class="nav-link">
            <a aria-current="page" href="../index/index.php">
              <i class='bx bx-home-alt icon'></i>
              <span class="text nav-text">Início</span>
            </a>
          </li>

          <?php
          if (
            isset($_SESSION["logado"]) and $_SESSION["permissao"] >=
            1
          ) { ?>

            <li class="nav-link">
              <a aria-current="page" href="../listar/acompanhar.php">
                <i class='bx bx-bar-chart-alt-2 icon'></i>
                <span class="text nav-text">Acompanhar</span>
              </a>
            </li>

          <?php
          }
          ?>
          <li class="nav-link">
            <a href="#">
              <i class='bx bx-table icon'></i>
              <span class="text nav-text">Tabelas</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="#">
              <i class='bx bx-bell icon'></i>
              <span class="text nav-text">Notificações</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="#">
              <i class='bx bx-pie-chart-alt icon'></i>
              <span class="text nav-text">Horas Marcadas</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="#">
              <i class='bx bx-heart icon'></i>
              <span class="text nav-text">Assinadas</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="#">
              <i class='bx bx-wallet icon'></i>
              <span class="text nav-text">Restantes</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="#">
              <i class='bx bx-extension icon'></i>
              <span class="text nav-text">Extras</span>
            </a>
          </li>

        </ul>
      </div>

      <?php
      if (!isset($_SESSION["logado"])) {
      ?>

      <?php
      } else {

      ?>

        <div class="bottom-content">
          <li class="">
            <a href="../login/sair.php">
              <i class='bx bx-log-out icon'></i>
              <span class="text nav-text">Sair</span>
            </a>
          </li>
        </div>

      <?php
      }
      ?>

    </div>

  </nav>

  <section class="home">

    <div class="container">

      <ul class="nav justify-content-end">

      <li class="search-box">
          <i class='bx bx-search icon'></i>
          <input type="text" placeholder="Buscar...">
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#"><i class="bx bx-book-open icon"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="bx bx-chat icon"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="bx bx-cog icon"></i></a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Perfil</a>

          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Ação</a>
            <a class="dropdown-item" href="#">Outra ação</a>
            <a class="dropdown-item" href="#">Algo mais aqui</a>
            <a class="dropdown-item" href="#">Link isolado</a>
          </div>

        </li>

        <li class="nav-item">
          <img class="img-user" src="../img/11.avif" alt="">
        </li>

      </ul>


      <!--
    <header>
      <nav class="navbar navbar-expand-lg navegacao">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Max</a>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="../index/index.php">Inicio</a>
              </li>
//
//            <?php
              //              if (!isset($_SESSION["logado"])) {
              //             
              ?>

           <li class="nav-item" style="background:red;">
              <a class="nav-link active" aria-current="page" href="../login/login.php">Login</a>
            </li> 

//              <?php
                //              } else {
                //              
                ?>
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="../login/sair.php">Sair</a>
                </li>
//              <?php
                //              }
                //              
                ?>

//              <?php
                //              if (
                //                isset($_SESSION["logado"]) and $_SESSION["permissao"] >=
                //                1
                //              ) { 
                ?>
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="../listar/acompanhar.php">Fazer acompanhamento</a>
                </li>
//              <?php
                //              }
                //              
                ?>

            </ul>
          </div>
        </div>
      </nav>
    </header> -->

    </div>
  </section>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>