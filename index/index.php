<?php
session_start();
ob_start();

date_default_timezone_set("America/Sao_paulo");

if (isset($_SESSION["logado"])) {
    $nome = $_SESSION["nome"];
} else {
    header('location: ../login/login.php');
};

include_once "../conexao/conexao.php";

// Comando para verificar se o usuario está trabalhando
$sql_usuario = "SELECT * FROM usuario WHERE usuarioId = :idUser";
$result_usuario = $conn->prepare($sql_usuario);
$result_usuario->bindParam(':idUser', $_SESSION["usuarioId"]);
$result_usuario->execute();
$row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);

// Comando para verificar se o usuario está no de descanso
$sql_ponto = "SELECT inicioIntervalo, fimIntervalo FROM ponto WHERE usuarioFk = :usuarioId ORDER BY pontoId DESC LIMIT 1";
$result_ponto = $conn->prepare($sql_ponto);
$result_ponto->bindParam(':usuarioId', $_SESSION["usuarioId"]);
$result_ponto->execute();
$row_ponto = $result_ponto->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->

    <link rel="stylesheet" href="../css/miriam.css">
    <title>Sistema de Pontos</title>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawVisualization);

        function drawVisualization() {
            // Some raw data (not necessarily accurate)
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
                ['2004/05', 165, 938, 522, 998, 450, 614.6],
                ['2005/06', 135, 1120, 599, 1268, 288, 682],
                ['2006/07', 157, 1167, 587, 807, 397, 623],
                ['2007/08', 139, 1110, 615, 968, 215, 609.4],
                ['2008/09', 136, 691, 629, 1026, 366, 569.6]
            ]);

            var options = {
                title: 'Monthly Coffee Production by Country',
                vAxis: {
                    title: 'Cups'
                },
                hAxis: {
                    title: 'Month'
                },
                seriesType: 'bars',
                series: {
                    5: {
                        type: 'line'
                    }
                }
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>


</head>

<body>

    <?php
    include_once "../includes/navBar.php";
    ?>

    <div class="container">

        <div class="container-bg">


            <div class="dashboard-uniq">
                <div class="text-dashboard">
                    <span>Deshboard</span>
                </div>

                <div class="dashboard-box">
                    <a href="#">
                        <i class='bx bx-star icon'>
                            <?php echo "Olá " . $_SESSION["nome"] . ", seja bem vindo(a) ao Max Ponto" ?>
                        </i>
                        <i class="bx bx-right-arrow-circle icon"></i>
                    </a>
                </div>
            </div>

            <div class="container-fluid">
                <center>

                    <?php
                    if (isset($_SESSION["msgPonto"])) {
                        echo '<div class="alert alert-warning d-flex align-items-center" role="alert" style="background:red;">' . $_SESSION["msgPonto"] . '</div>';
                        unset($_SESSION["msgPonto"]);
                    }
                    ?>

                    <div class="row">
                        <div class="card">
                            <div class="cad-box">
                                <i class='bx bx-bar-chart-alt-2 icon'></i>
                                <h2>Registrar Ponto</h2>
                            </div>
                        </div>

                        <div class="card">
                            <div class="cad-box">
                                <i class='bx bx-pie-chart-alt icon'></i>
                                <p class="hours" id="horario"><?php echo date("d/m/Y H:i:s") ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                                <?php
                                if ($row_usuario["trabalhando"] == 0 and $row_usuario["intervalo"] == 0) {

                                    // Inserção dos cards que indicam o inicio e fim do expediente

                                    // Verificar o que farer com btn Danger e Success
                                    echo '
                                        <div class="card green btn" data-bs-target="#exampleModal" onclick = verificar("entrada")>
                                            <div class="cad-box">
                                                <i class="bx bx-log-in icon" style="color:#fff;"></i>

                                                <h2 class = "h2_btn">
                                                    Registrar Entrada
                                                </h2>
                                            </div>
                                        </div>
                                        <i class="bx bx-log-in icon" style="color:#fff;"></i>
                                    ';
                                } elseif ($row_usuario["trabalhando"] == 1 and $row_usuario["intervalo"] == 0 and $row_ponto["inicioIntervalo"] == null) {


                                    echo '
                                    <div class="card red btn" onclick = verificar("saida")>

                                        <div class="cad-box">
                                
                                            <i class="bx bx-log-out icon" style="color:#fff;"></i>
                                            <h2 class="h2_btn">
                                                    Registrar Saida                                    
                                            </h2>
    
                                        </div>
                                    </div>

                                    <div class="card yellow btn" onclick = verificar("intervalo")>

                                        <div class="cad-box">
                                
                                            <i class="bx bx-log-out icon" style="color:#fff;"></i>
                                            <h2 class="h2_btn">
                                                Entrada do intervalo                                  
                                            </h2>
    
                                        </div>
                                    </div>   
                                ';
                                } elseif ($row_usuario["trabalhando"] == 0 and $row_usuario["intervalo"] == 1 and $row_ponto["fimIntervalo"] == null) {
                                    echo $row_ponto["fimIntervalo"];


                                    echo '
                                    <div class="card yellow btn" onclick = verificar("intervalo")>

                                    <div class="cad-box">
                            
                                        <i class="bx bx-log-in icon" style="color:#fff;"></i>
                                        <h2 class="h2_btn">
                                            Finalizar intervalo                                 
                                        </h2>

                                        </div>
                                    </div>  
                                    ';
                                } elseif ($row_ponto["inicioIntervalo"] != null and $row_ponto["fimIntervalo"] != null) {


                                    echo '
                                    <div class="card red btn" onclick = verificar("saida")>

                                    <div class="cad-box">
                            
                                        <i class="bx bx-log-out icon" style="color:#fff;"></i>
                                        <h2 class="h2_btn">
                                                Registrar Saida                                    
                                        </h2>

                                        </div>
                                    </div>
                                    ';
                                }
                                ?>
                            
                        

                    </div>
                </center>

                <!-- Modal -->

                <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
        
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Digite a sua senha para confirmar!</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick = fecharModal()></button>
                            </div>
                            <div class="modal-body">
                                <input type="password" class="form-control" id="password" placeholder="Digite a senha">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" aria-label="Close" onclick = fecharModal()>Cancelar</button>
                                <button type="button" class="btn btn-primary" id="comparar">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <div class="text-dashboard">
                    <span>Gráficos</span>
                </div>


                <div class="charts">
                    <div id="chart_div" style="width: 900px; height: 500px;"></div>

                    <div id="donutchart" style="width: 900px; height: 500px;"></div>               
                </div>




            </div>
        </div>
    </div>



    <script>
        var horario = document.getElementById("horario")

        setInterval(() => {
            var data = new Date().toLocaleString("pt-br", {
                timeZone: "America/Sao_Paulo"
            })

            var formatarData = data.replace(" , ", " - ")
            horario.innerHTML = formatarData
        }, 1000)

        const myModal = new bootstrap.Modal(document.getElementById('modal'))
        var senha = document.getElementById("password")

        function fecharModal(){
           myModal.hide()
        }

        function verificar(tipo) {
            myModal.show()

            var comparar = document.getElementById("comparar")

            comparar.addEventListener("click", e => {

                if (senha.value == <?php echo $row_usuario["senha"] ?>) {

                    if (tipo == "entrada") {
                        window.location.replace("../registrar/entrada.php")
                    } else if (tipo == "saida") {
                        window.location.replace("../registrar/saida.php");
                    } else {
                        window.location.replace("../registrar/intervalo.php");
                    }
                } else {
                    myModal.hide()
                    alert("Senha incorreta")

                }
            })
        }

   
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>