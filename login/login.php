<?php
session_start();
ob_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <title>Login</title>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>
<body id="body">

    <?php
    //        include_once "../includes/navBar.php";  
    //  
    ?>

    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">

                <a class="navbar-brand" href="https://maxdatasistemas.com.br/">
                    <img src="../img/logo-maxdata.png" class="Logo">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" style="color: #fff;" href="https://maxdatasistemas.com.br/"><i class='bx bx-home-alt icon' style="color: #fff;" aria-hidden="true"></i> Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://maxdatasistemas.com.br/solucoes/"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Soluções</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://maxdatasistemas.com.br/contato/"><i class="fa fa-address-book" aria-hidden="true"></i> Contato</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://maxdatasistemas.com.br/noticias/"><i class="fa fa-plus-square" aria-hidden="true"></i> Notícias</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!--

    <div class="navb-bg">
        <div class="container">
            <nav class="navbar">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="../img/logo-maxdata.png" class="Logo">
                    </a>
                </div>
            </nav>
        </div>
    </div> -->

    <div class="backgroud-fundo">
        <div class="container">
            <div class="container-bg">
                <div class="container-one">
                <?php
                if (isset($_SESSION["msgErro"])) {
                    echo '<div class="alert fa fa-exclamation-triangle alert-danger d-flex" role="alert">'. $_SESSION["msgErro"] . '</div>';
                    unset($_SESSION["msgErro"]);
                }
                ?>
                    <div class="content"> 
                        <div class="image-box">
                            <img src="../img/3.png" alt="">
                        </div>
                        <form action="logar.php" method="post">
                            <div class="topic">Hora de fazer o login</div>
                            <div class="input-box">
                                <input type="number" id="usuario" name="usuario" required>
                                <label>ID de usuário</label>
                            </div>
                            <div class="input-box">
                                <input type="password" id="password" name="senha" required>
                                <label>Senha</label>
                            </div>
                            <label>Esqueceu a senha ?</label>
                            <div class="input-box">
                                <input type="submit" value="Acessar">
                            </div>
                        </form>
                    </div>
                </div>


         <!-- <div class="formulario">
            <div class="form-img">
                <img src="../img/icon-servicos.svg">
            </div>

            <form class="row g-3" action="logar.php" method="post">
                <div class="">
                    <div class="col-md-12">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="number" class="form-control" id="usuario" name="usuario" placeholder="Digite o número do usuario" required>
                    </div>

                    <div class="col-md-12">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="senha" placeholder="Digite a senha" required>
                    </div>

                    <div class="enviar">
                        <button type="submit" class="btn btn-primary">Acessar</button>
                    </div>
                </div>
            </form>
        </div> -->

            </div>
        </div>
    </div>


    <footer class="bg-light text-center text-lg-start">
        <div class="text-center text-dark p-3">
            © 2023 - MaxData -
            <a class="text-dark" href="#">Direitos reservados</a>
        </div>
    </footer>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>